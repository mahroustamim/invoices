<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceEport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetail;
use App\Models\Section;
use App\Models\User;
use App\Notifications\CreateInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:الفوتير'], ['only' => ['index']]);
        $this->middleware(['permission:إضافة فاتورة'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:تعديل الفاتورة'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:حذف الفاتورة'], ['only' => ['destroy']]);
        $this->middleware(['permission:تصدير إكسيل'], ['only' => ['export']]);
        $this->middleware(['permission:تغير حالة الدفع'], ['only' => ['change_status']]);
    }

    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.invoices', compact('invoices'));
    }

    public function create()
    {
        $sections = Section::all();
        return view('invoices.create_invoice', compact('sections'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'invoice_number' => 'required|string|max:50',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'product' => 'required|max:50',
            'section' => 'required|integer|exists:sections,id',
            'amount_collection' => 'required',
            'amount_commission' => 'required',
        ], [
            'invoice_number.required' => 'يجب إدخال رقم الفاتورة',
            'invoice_date.required' => 'يجب إدخال تاريخ الفاتورة',
            'due_date.required' => 'يجب إدخال تاريخ الاستحقاق',
            'product.required' => 'يجب إختيار المنتج',
            'section.required' => 'يجب إختيار القسم ',
            'amount_collection.required' => 'يجب إدخال مبلغ التحصيل',
            'amount_commission.required' => 'يجب إدخال مبلغ العمولة',
        ]);        

        Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'value_status' => 2,
            'note' => $request->note,
        ]);

        $id_invoice = Invoice::latest()->first()->id;

        InvoiceDetail::create([
            'invoice_id' => $id_invoice,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->section,
            'value_status' => 2,
            'note' => $request->note,
            'created_by' => auth()->user()->name,
        ]);

        // ============= first method =====================
        if ($request->hasFile('attachment')) {

            $request->validate([
                'attachment' => 'file|mimes:pdf,jpeg,png,jpg|max:10000',
            ], [
                'attachment.mimes' => 'خطأ لم يتم حفظ المرفق',
                'attachment.max'  => 'يجب ألا يتعدي 10 ميجا '
            ]);
            
            
            $id_invoice = Invoice::latest()->first()->id;
            $invoice_number = $request->invoice_number;
            $path = $request->file('attachment')->store($invoice_number, 'mahrous');
        

            InvoiceAttachment::create([
                'file_name' => basename($path), 
                'invoice_number' => $invoice_number, 
                'created_by' => auth()->user()->name, 
                'invoice_id' => $id_invoice,
            ]);
        }

        $invoice_id = $id_invoice;
        $users = User::where('id', '!=', auth()->user()->id)->get();
        Notification::send($users, new CreateInvoice($invoice_id));

        return back()->with('success', 'تم أضافة الفاتورة بنجاح');

        // =============== second mehtod ====================

        // if ($request->hasFile('attachment')) {
        //     $id_invoice = Invoice::latest()->first()->id;
        //     $file = $request->file('attachment');
            // $file_name = $file->getClientOriginalName();
        //     $invoice_number = $request->invoice_number;

        //     InvoiceAttachment::create([
        //         'file_name' => $file_name, 
        //         'invoice_number' => $invoice_number, 
        //         'created_by' => auth()->user()->name, 
        //         'invoice_id' => $id_invoice,
        //     ]);

        //     $request->attachment->move(public_path('Attachments/' . $invoice_number), $file_name);
        // }
    
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);
        return view('invoices.change_status', compact('invoice'));
    }

    public function change_status(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'payment_date' => 'required',
        ], [
            'status.required' => 'يجب أختيار حالة الدفع',
            'payment_date.required' => 'يجب إدخال تارخ الدفع'
        ]);

        $invoice = Invoice::find($id);
        $invoice->update([
            'value_status' => $request->status,
            'payment_date' => $request->payment_date,
        ]);

        // $invoiceDetails = InvoiceDetail::where('invoice_id', $id)->first;
        InvoiceDetail::create([
            'invoice_id' => $invoice->id,
            'invoice_number' => $invoice->invoice_number,
            'product' => $invoice->product,
            'section' => $invoice->section_id,
            'value_status' => $request->status,
            'payment_date' => $request->payment_date,
            'note' => $invoice->note,
            'created_by' => auth()->user()->name,
        ]);

        session()->flash('Status_Update');
        return redirect('/invoices');

    }

    public function edit($id)
    {
        $invoice = Invoice::find($id);
        $sections = Section::all();
        return view('invoices.edit_invoice', compact('invoice', 'sections'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'invoice_number' => 'required|string|max:50',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'product' => 'required|max:50',
            'section' => 'required|integer|exists:sections,id',
            'amount_collection' => 'required',
            'amount_commission' => 'required',
        ], [
            'invoice_number.required' => 'يجب إدخال رقم الفاتورة',
            'invoice_date.required' => 'يجب إدخال تاريخ الفاتورة',
            'due_date.required' => 'يجب إدخال تاريخ الاستحقاق',
            'product.required' => 'يجب إختيار المنتج',
            'section.required' => 'يجب إختيار القسم ',
            'amount_collection.required' => 'يجب إدخال مبلغ التحصيل',
            'amount_commission.required' => 'يجب إدخال مبلغ العمولة',
        ]);    
        
        $invoice = Invoice::find($id);

        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'product' => $request->product,
            'section_id' => $request->section,
            'amount_collection' => $request->amount_collection,
            'amount_commission' => $request->amount_commission,
            'discount' => $request->discount,
            'value_vat' => $request->value_vat,
            'rate_vat' => $request->rate_vat,
            'total' => $request->total,
            'value_status' => 2,
            'note' => $request->note,
        ]);

        return back()->with('success', 'تم تعديل الفاتورة بنجاح');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $invoice = Invoice::find($id);
        $invoice_number = $invoice->invoice_number;

        Storage::disk('mahrous')->deleteDirectory($invoice_number);
        
        $invoice->delete();
        return back()->with('success', 'تم حذف الفاتورة بنجاح');
    }

    public function getProducts($id)
    {
        $products = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return response()->json($products);
    }

    public function print_invoice($id)
    {
        $invoice = Invoice::find($id);
        return view('invoices.print_invoice', compact('invoice'));
    }

    public function export() 
    {
        return Excel::download(new InvoiceEport, 'invoices.xlsx');
    }

    public function markAllRead()
    {
        $user = User::find(auth()->user()->id);

        foreach ($user->unreadNotifications as $notification) {

            // $notification->delete();     to delete
            $notification->markAsRead();
        }

        return redirect()->back();

    }

}
