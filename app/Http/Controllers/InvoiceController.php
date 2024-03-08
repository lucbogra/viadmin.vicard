<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Invoice;
use App\Services\AppService;
use Illuminate\Http\Request;
use App\Objects\FilterObject;
use Diglactic\Breadcrumbs\Breadcrumbs;
use App\Http\Resources\InvoiceResource;
use Illuminate\Support\Facades\Notification;

class InvoiceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate("invoices.index");

        $filter = new FilterObject;
        
        $invoices = InvoiceResource::collection(
            Invoice::when($filter->status, function($query) use ($filter) {
                    $query->status($filter->status);
                })->when($filter->term, function($query) use ($filter) {
                    $query->search($filter->term);
                })
                ->with('customer')
                ->orderBy($filter->sort ?? 'created_at', $filter->order ?? 'desc')
                ->paginate($filter->perPage)
                ->withQueryString()
        );

        return Inertia::render("Invoices/Index", compact("invoices", "breadcrumbs", "filter"));

    }
    
    /**
     * Handle the incoming request.
     */
    public function show(Invoice $invoice)
    {
        $breadcrumbs = Breadcrumbs::generate("invoices.show", $invoice);

        $invoice->load('customer');

        $invoice = new InvoiceResource($invoice);
        
        return Inertia::render("Invoices/Show", compact("invoice", "breadcrumbs"));

    }

}
