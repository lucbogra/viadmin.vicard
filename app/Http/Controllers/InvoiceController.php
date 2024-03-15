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
use App\Notifications\InvoiceBankTransferProcessNotification;
use Barryvdh\DomPDF\Facade\Pdf;

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
                ->with('customer', 'card')
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
        // if (request()->pdf == 1) {
        //     $pdf = PDF::loadView('pdf.template', $data);

        //     // Enregistrer le PDF temporairement
        //     $filePath = storage_path('app/temp/mypdf.pdf');
        //     $pdf->save($filePath);
    
        //     // Télécharger le PDF
        //     return response()->download($filePath)->deleteFileAfterSend(true);
        // }

        $breadcrumbs = Breadcrumbs::generate("invoices.show", $invoice);

        $invoice->load('customer', 'card');

        $invoice = new InvoiceResource($invoice);
        
        return Inertia::render("Invoices/Show", compact("invoice", "breadcrumbs"));

    } 

    /**
     * Handle the incoming request.
     */
    public function update(Request $request, Invoice $invoice)
    {
        if ($invoice->status == 'processing') {

            if (in_array($request->action, ['paid', 'reject'])) {

                $invoice->update([
                    "paid_at" => now(),
                    "status" => $request->action,
                ]);

                $invoice->customer->notify(new InvoiceBankTransferProcessNotification($invoice));

                return redirect()->back()->with('success', __('Operation completed successfully'));
            }
            
            return redirect()->back()->with('warning', __('An error has occurred'));
        }

        return redirect()->back()->with('warning', __('You cannot continue this action'));
    }

}
