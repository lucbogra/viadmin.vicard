<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use Inertia\Inertia;
use App\Models\CardRequest;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Objects\FilterObject;
use App\Mail\UserLoginInfoMail;
use App\Models\CardTopUpRequest;
use App\Http\Resources\CardResource;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CustomerRequest;
use Diglactic\Breadcrumbs\Breadcrumbs;
use App\Http\Resources\CustomerResource;
use App\Objects\TransactionFilterObject;
use App\Http\Requests\CardRequestRequest;
use App\Http\Requests\CardWithdrawRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Repositories\CustomerRepository;
use App\Http\Requests\CardTopupRequestRequest;

class CustomerController extends Controller
{
    public function __construct(private CustomerRepository $customerRepository) { }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate("customers.index");
        
        $filter = new FilterObject;

        $customers = $this->customerRepository->all($filter);

        return Inertia::render("Customers/Index", compact("customers", "filter", "breadcrumbs"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = Breadcrumbs::generate("customers.create");

        return Inertia::render("Customers/Create", compact("breadcrumbs"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $newCustomer = Arr::except($request->validated(), 'password_copied');

        $newCustomer['password'] = bcrypt($request->password);

        $customer = User::create($newCustomer);

        $customer->assignRole('Account Owner');

        Mail::to($customer)->send(new UserLoginInfoMail(user: $customer, password: $request->password));

        return redirect()->route('customers.index')->with('success', __('Customer has been created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $customer)
    {
        return $this->cards($customer);

        // $breadcrumbs = Breadcrumbs::generate("customers.show", $customer);

        // $customer = $this->customerRepository->show($customer);

        // return Inertia::render("Customers/Show", compact("customer", "breadcrumbs"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function cards(User $customer)
    {
        $breadcrumbs = Breadcrumbs::generate("customers.cards.index", $customer);
        
        $filter = new FilterObject;

        $cards = $this->customerRepository->allCards($customer, $filter);

        $customer = New CustomerResource($customer);

        return Inertia::render("Customers/Cards/Index", compact("cards", "customer", "filter", "breadcrumbs"));
    }

    /**
     * Handle the incoming request.
     */
    public function cardShow(User $customer, Card $card)
    {
        $breadcrumbs = Breadcrumbs::generate("customers.cards.show", $customer, $card);

        $filter = new FilterObject;

        $customer = new CustomerResource($customer);
        
        $card->load('owner');

        $card = new CardResource($card);

        return Inertia::render("Customers/Cards/Show", compact("customer", "card", "breadcrumbs", "filter"));

    }

    /**
     * Handle the incoming request.
     */
    public function cardTransactions(User $customer, Card $card)
    {
        $breadcrumbs = Breadcrumbs::generate("customers.cards.transactions", $customer, $card);

        $filter = new TransactionFilterObject;

        $customer = new CustomerResource($customer);
        
        $card = new CardResource($card);
        
        $transactions = TransactionResource::collection(
            $card->transactions()
                ->when($filter->type, function($query) use ($filter) {
                    $query->type($filter->type);
                })
                ->when($filter->method, function($query) use ($filter) {
                    $query->method($filter->method);
                })
                ->when($filter->term, function($query) use ($filter) {
                    $query->search($filter->term);
                })
                ->with('user')
                ->orderBy($filter->sort ?? 'created_at', $filter->order ?? 'desc')
                ->paginate($filter->perPage)
                ->withQueryString()
        );

        return Inertia::render("Customers/Cards/Transactions", compact("customer", "card", "transactions", "breadcrumbs", "filter"));

    }

    /**
     * Handle the incoming request.
     */
    public function cardWithdraw(User $customer, Card $card, CardWithdrawRequest $cardWithdrawRequest)
    {
        $transaction = $card->transactions()->create([
            'user_id' => auth()->id(),
            'type' => 'withdraw',
            'method' => 'bank transfer',
            'confirmed' => true,
            'date' => today(),
            'amount' => $cardWithdrawRequest->amount,
            'currency' => 'USD',
        ]);

        return redirect()->back()->with('success', __('The card has been recharged successfully'));
    }

    /**
     * Display a listing of the resource.
     */
    public function cardRequests(User $customer)
    {
        $breadcrumbs = Breadcrumbs::generate("customers.card-requests.index", $customer);
        
        $filter = new FilterObject;

        $cardRequests = $this->customerRepository->allCardRequests($customer, $filter);

        $customer = New CustomerResource($customer);

        return Inertia::render("Customers/CardRequests/Index", compact("cardRequests", "customer", "filter", "breadcrumbs"));
    }

    /**
     * Display a listing of the resource.
     */
    public function cardRequestValidation(User $customer, CardRequest $cardRequest, CardRequestRequest $cardRequestRequest)
    {
        if ($cardRequestRequest->status == 'validated') {

            $card = Card::create([
                'owner_id' => $cardRequest->user_id,
                'card_request_id' => $cardRequest->id,
                'card_number' => $cardRequestRequest->card_number,
                'card_validity' => $cardRequestRequest->card_validity,
                'card_limit' => $cardRequestRequest->card_limit,
                'card_fees' => 25,
                'card_balance' => 0,
                'daily_limit' => $cardRequestRequest->daily_limit,
                'per_transaction_limit' => $cardRequestRequest->per_transaction_limit,
                'card_status' => $cardRequestRequest->card_status,
                'card_type' => $cardRequestRequest->card_type,
            ]);

            $customer->cards()->attach($card, attributes: [
                'owner' => true,
                'permissions' => json_encode(['all'])
            ]);

        }

        $cardRequest->status = $cardRequestRequest->status;
        $cardRequest->save();

        $message = $cardRequestRequest->status == 'validated' ? __('The card has been created successfully') : __('The card has been rejected successfully');

        return redirect()->back()->with('sucess', $message);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function cardTopupRequests(User $customer)
    {
        $breadcrumbs = Breadcrumbs::generate("customers.topup-requests.index", $customer);
        
        $filter = new FilterObject;

        $cardTopupRequests = $this->customerRepository->allCardTopupRequests($customer, $filter);

        $customer = New CustomerResource($customer);

        return Inertia::render("Customers/CardTopupRequests/Index", compact("cardTopupRequests", "customer", "filter", "breadcrumbs"));
    }

    
    /**
     * Display a listing of the resource.
     */
    public function cardTopupRequestValidation(User $customer, CardTopUpRequest $cardRequest, CardTopupRequestRequest $cardTopupRequestRequest)
    {
        if ($cardTopupRequestRequest->status == 'validated') {

            $transaction = $cardRequest->card->transactions()->create([
                'user_id' => auth()->id(),
                'type' => 'deposit',
                'method' => 'bank transfer',
                'confirmed' => true,
                'date' => today(),
                'amount' => $cardTopupRequestRequest->amount,
                'currency' => 'USD',
            ]);

            $cardRequest->update([
                'transaction_id' => $transaction->id
            ]);

        }

        $cardRequest->status = $cardTopupRequestRequest->status;
        $cardRequest->save();

        $message = $cardTopupRequestRequest->status == 'validated' ? __('The card has been recharged successfully') : __('The card has been rejected successfully');

        return redirect()->back()->with('success', $message);
    }
}
