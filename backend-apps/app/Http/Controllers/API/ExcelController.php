<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExcelController extends Controller
{

    public function downloadExcel(Request $request)
    {
        // Validate the request parameters
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Get the start and end dates from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

         // get data transaction 
        $transactions = \App\Models\Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->with(['customer', 'branchStore', 'voucher', 'user', 'service'])
            ->get();

        // using package phpspreadsheet export data to excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Transaction ID');
        $sheet->setCellValue('B1', 'Customer Name');
        $sheet->setCellValue('C1', 'Branch Store');
        $sheet->setCellValue('D1', 'Voucher Code');
        $sheet->setCellValue('E1', 'User Name');
        $sheet->setCellValue('F1', 'Service');
        $sheet->setCellValue('G1', 'Weight');
        $sheet->setCellValue('H1', 'Transaction Date');
        $sheet->setCellValue('I1', 'Base Amount');
        $sheet->setCellValue('J1', 'Discount Amount');
        $sheet->setCellValue('K1', 'Total Amount');
        $sheet->setCellValue('L1', 'Status Payment');
        $sheet->setCellValue('M1', 'Status Laundry');
        $sheet->setCellValue('N1', 'Notes');
        $sheet->setCellValue('O1', 'Payment Method');
        $sheet->setCellValue('P1', 'Payment Gateway URL');
        $sheet->setCellValue('Q1', 'Payment Session ID');
        $sheet->setCellValue('R1', 'Payment Reference ID');

        // download data to excel
        $row = 2;
        foreach ($transactions as $transaction) {
            $sheet->setCellValue('A' . $row, $transaction->id);
            $sheet->setCellValue('B' . $row, $transaction->customer->name);
            $sheet->setCellValue('C' . $row, $transaction->branchStore->name);
            $sheet->setCellValue('D' . $row, $transaction->voucher->code ?? 'N/A');
            $sheet->setCellValue('E' . $row, $transaction->user->name);
            $sheet->setCellValue('F' . $row, $transaction->service->name);
            $sheet->setCellValue('G' . $row, $transaction->weight);
            $sheet->setCellValue('H' . $row, $transaction->transaction_date);
            $sheet->setCellValue('I' . $row, $transaction->base_amount);
            $sheet->setCellValue('J' . $row, $transaction->discount_amount);
            $sheet->setCellValue('K' . $row, $transaction->total_amount);
            $sheet->setCellValue('L' . $row, $transaction->status_payment);
            $sheet->setCellValue('M' . $row, $transaction->status_laundry);
            $sheet->setCellValue('N' . $row, $transaction->notes);
            $sheet->setCellValue('O' . $row, $transaction->payment_method);
            $sheet->setCellValue('P' . $row, $transaction->urlPaymentGateway);
            $sheet->setCellValue('Q' . $row, $transaction->payment_session_id);
            $sheet->setCellValue('R' . $row, $transaction->payment_reference_id);
            $row++;
        }

        // Set the header for the download
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'transactions_' . $startDate . '_to_' . $endDate . '.xlsx';
        
        // return download response
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );

    }


    
}
