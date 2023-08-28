<?php

namespace App\Http\Controllers;

use App\Models\InvoiceDetail;
use App\Models\InvoiceMaster;
use App\Models\ProductMaster;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    function add()
    {
        $products = ProductMaster::all();
        return view('customer', ['products' => $products]);
    }

    function saveRecord(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'product' => 'required',
            'rate' => 'required',
            'unit' => 'required',
            'qty' => 'required',
            'netamount' => 'required',
            'totalamount' => 'required',
            'discount' => 'required',
        ]);
        $orders = session()->get('orders', []);
        $orders[] = $request->all();
        session()->put('orders', $orders);

        return redirect()->back()->with('success', 'Item added successfully!');
    }

    function createInvoice(Request $request)
    {
        $invoiceData = $request->input('invoiceData');
        $lastInvoice = InvoiceMaster::orderBy('invoice_id', 'desc')->first();
        $lastInvoiceNo = $lastInvoice ? intval($lastInvoice->invoice_no)+1 : 1;
        $totalAmountSum = 0;

        foreach ($invoiceData as $item) {
            $totalAmountSum += (float) $item['totalAmount'];
        }
        $totalAmountSumFormatted = intval($totalAmountSum);
        $invoiceMaster = InvoiceMaster::create([
            'invoice_no' => $lastInvoiceNo, // You can generate your own invoice number logic here
            'invoice_date' => now(), // Current date and time
            'customer_name' => $invoiceData[0]['customerName'],
            'total_amount' => $totalAmountSumFormatted,
        ]);
        foreach ($invoiceData as $item) {
            InvoiceDetail::create([
                'invoice_id' => $invoiceMaster->id, // Replace with the actual InvoiceMaster ID
                'product_id' => $item['product_id'],
                'rate' => $item['rate'],
                'unit' => $item['unit'],
                'qty' => $item['qty'],
                'disc_percentage' => $item['discount'],
                'net_amount' => $item['netAmount'],
                'total_amount' => $item['totalAmount'],
            ]);
        }
        return response()->json(['status' => 'success', 'message' => 'Item added successfully!']);
    }

    public function viewOrders()
    {
        $orders = session()->get('orders', []);
        return view('customer', ['orders' => $orders]);
    }
}
