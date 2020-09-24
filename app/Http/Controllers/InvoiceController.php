<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;

class InvoiceController extends Controller
{
    public function __invoke(Order $order)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf.invoice', [
            'order' => $order,
            'school' => $order->school
        ]);


       $pdf->save('invoice.pdf');
//        return view('pdf.invoice');

        return "thanks";
        //
    }
}
