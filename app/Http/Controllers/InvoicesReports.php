<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoicesReports extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:التقارير'], ['only' => ['index']]);
    }

    public function index()
    {
        return view('reports.invoices_reports');
    }

    public function search(Request $request) 
    {

        $radio = $request->radio;
        $query = Invoice::query();
        $conditionsApplied = false;

        // في حالة البحث بنوع الفاتورة
        if ($radio == 1) {

            if (!empty($request->type)) {
                $query->where('value_status', $request->type);
                $conditionsApplied = true;
            }

            if (!empty($request->start_at)) {
                $query->whereDate('invoice_date', '>=', $request->start_at);
                $conditionsApplied = true;
            }

            if (!empty($request->end_at)) {
                $query->whereDate('invoice_date', '<=', $request->end_at);
                $conditionsApplied = true;
            }

            if ($conditionsApplied) {
                $invoices = $query->get();
                return view('reports.invoices_reports', compact('invoices'));
            }

            return view('reports.invoices_reports');
        
        // في البحث برقم الفاتورة
        } else  {

            $invoices = Invoice::where('invoice_number', $request->invoice_number)->get();
            return view('reports.invoices_reports',compact('invoices'));

        }
    }
}
