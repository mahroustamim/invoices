<?php

namespace App\Http\Controllers;

use App\Models\InvoiceAttachment;
use Illuminate\Http\Request;

class InvoiceAttachmentController extends Controller
{

    function __construct()
    {
        $this->middleware(['permission:إضافة فاتورة'], ['only' => ['store']]);
    }

    public function store(Request $request)
    {
            // Proceed with your validation and file handling
            $request->validate([
                'attachment' => 'required|file|mimes:pdf,jpeg,png,jpg|max:10000',
            ], [
                'attachment.required' => 'يجب إختيار ملف',
                'attachment.mimes' => 'خطأ لم يتم حفظ المرفق',
                'attachment.max'  => 'يجب ألا يتعدي 10 ميجا '
            ]);
            
            $invoice_number = $request->invoice_number;
            $path = $request->file('attachment')->store($invoice_number, 'mahrous');
        
            InvoiceAttachment::create([
                'file_name' => basename($path), 
                'invoice_number' => $invoice_number,
                'created_by' => auth()->user()->name,
                'invoice_id' => $request->id,
            ]);
        
            return back()->with('success', 'تم إضافة المرفق بنجاح');
       
    }




    public function show(InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    public function edit(InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    public function update(Request $request, InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    public function destroy(InvoiceAttachment $invoiceAttachment)
    {
        //
    }
}
