<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailController extends Controller
{

    function __construct()
    {
        $this->middleware(['permission:حذف الفاتورة'], ['only' => ['destroy']]);
    }

    public function edit($id) 
    {
        $invoice = Invoice::where('id',$id)->first();
        $user = InvoiceDetail::where('invoice_id',$id)->first();
        $details  = InvoiceDetail::where('invoice_id',$id)->get();
        $attachments  = InvoiceAttachment::where('invoice_id',$id)->get();

        return view('invoices.invoices_details',compact('invoice','details','attachments', 'user'));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $file_name = $request->file_name;
        $invoice_number = $request->invoice_number;
        InvoiceAttachment::find($id)->delete();

        // one way 
        // $filePath = public_path('attachments' . DIRECTORY_SEPARATOR . $invoice_number . DIRECTORY_SEPARATOR . $file_name);
        // unlink($filePath);

        // two way
        $filePath = $invoice_number . DIRECTORY_SEPARATOR . $file_name;
        Storage::disk('mahrous')->delete($filePath);
        return back()->with('success', 'تم حذف المرفق بنجاح');
    }

    public function open_file($invoice_number, $file_name)
    {
        $filePath = public_path('attachments\\' . $invoice_number . '\\' . $file_name);
        return response()->file($filePath);
    }

    public function get_file($invoice_number, $file_name)
    {
        $filePath = public_path('attachments\\' . $invoice_number . '\\' . $file_name);
        return response()->download($filePath);
    }
}



