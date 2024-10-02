<?php

namespace App\Http\Controllers;

use App\Models\Invoice;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

// ========================== نسبة عدد الفواتير ================================
        $x = round(Invoice::where('value_status', 1)->count() /  \App\Models\Invoice::count()  * 100, 1);
        $y = round(Invoice::where('value_status', 2)->count() /  \App\Models\Invoice::count()  * 100, 1);
        $z = round(Invoice::where('value_status', 3)->count() /  \App\Models\Invoice::count()  * 100, 1);
        // $x = 100;
        // $y = 80;
        // $z = 50;


$bar = app()->chartjs
         ->name('barChartTest')
         ->type('bar')
         ->size(['width' => 300, 'height' => 200])
         ->labels([' الفواتير المدفوعة', ' الفواتير الغير مدفوعة', ' المدفوعة جزئيا'])
         ->datasets([
             [
                 "label" => "نسبة الفواتير",
                 'backgroundColor' => ['#A3B763', '#FF407D', '#7071E8'],
                 'data' => [$x, $y, $z]
             ],
         ])
         ->options([
            "scales" => [
                "yAxes" => [[
                    "ticks" => [
                        "beginAtZero" => true,
                        // "stepSize" => 5
                    ]
                ]]
            ]
         ]);


// ========================== نسبة قيمة الفواتير ================================
$all_money = Invoice::sum('total');
$x = round(Invoice::where('value_status', 1)->sum('total') / $all_money * 100, 1);
$y = round(Invoice::where('value_status', 2)->sum('total') / $all_money * 100, 1);
$z = round(Invoice::where('value_status', 3)->sum('total') / $all_money * 100, 1);

$pie = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels([' الفواتير المدفوعة', ' الفواتير الغير مدفوعة', ' المدفوعة جزئيا'])
        ->datasets([
            [
                'backgroundColor' => ['#A3B763', '#FF407D', '#7071E8'],
                'hoverBackgroundColor' => ['#A3B763', '#FF407D', '#7071E8'],
                'data' => [$x, $y, $z]
            ]
        ])
        ->options([]);

        return view('home', compact('bar', 'pie'));
    }
}
