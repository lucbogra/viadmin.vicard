<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Card;
use App\Models\User;
use Inertia\Inertia;
use App\Models\CardRequest;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Objects\FilterObject;
use App\Mail\UserLoginInfoMail;
use App\Http\Requests\BankRequest;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CustomerRequest;
use Diglactic\Breadcrumbs\Breadcrumbs;
use App\Http\Resources\CustomerResource;
use App\Http\Repositories\BankRepository;
use App\Http\Requests\CardRequestRequest;

class BankController extends Controller
{
    public function __construct(private BankRepository $bankRepository) { }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate("settings.banks.index");
        
        $filter = new FilterObject;

        $banks = $this->bankRepository->all($filter);

        return Inertia::render("Settings/Banks/Index", compact("banks", "filter", "breadcrumbs"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = Breadcrumbs::generate("settings.banks.create");

        $bank = new Bank();

        return Inertia::render("Settings/Banks/Create", compact("breadcrumbs", "bank"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BankRequest $request)
    {
        Bank::create([
            'owner_name' => $request->owner_name,
            'bank_name' => $request->bank_name,
            'iban' => $request->iban,
            'address' => $request->address,
            'meta' => [
                'owner_account' => $request->owner_account,
                'swift_address' => $request->swift_address,
                'bank_branch' => $request->bank_branch,
                'reference_number' => $request->reference_number,
            ]
        ]);

        return redirect()->route('settings.banks.index')->with('success', __('The Bank has been created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $customer)
    {
        $breadcrumbs = Breadcrumbs::generate("settings.banks.show", $customer);

        $customer = $this->bankRepository->show($customer);

        return Inertia::render("Settings/Banks/Show", compact("customer", "breadcrumbs"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank)
    {
        $breadcrumbs = Breadcrumbs::generate("settings.banks.edit", $bank);

        return Inertia::render("Settings/Banks/Create", compact("breadcrumbs", "bank"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BankRequest $request, Bank $bank)
    {
        $bank->update([
            'owner_name' => $request->owner_name,
            'bank_name' => $request->bank_name,
            'iban' => $request->iban,
            'address' => $request->address,
            'meta' => [
                'owner_account' => $request->owner_account,
                'swift_address' => $request->swift_address,
                'bank_branch' => $request->bank_branch,
                'reference_number' => $request->reference_number,
            ]
        ]);

        return redirect()->route('settings.banks.index')->with('success', __('The Bank has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        $bank->delete();

        return redirect()->back()->with('success', __('The Bank has been deleted successfully'));
    }

}
