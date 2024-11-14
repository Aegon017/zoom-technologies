<?php

namespace App\Actions\Payment;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateInvoice
{
    public function execute(Order $order): string
    {
        $data = ['order' => $order];
        $pdf = Pdf::loadView('pages.invoice', $data);
        $pdfFileName = 'invoices/invoice_' . time() . '.pdf';
        $pdfPath = public_path($pdfFileName);
        $pdf->save($pdfPath);
        return $pdfFileName;
    }
}
