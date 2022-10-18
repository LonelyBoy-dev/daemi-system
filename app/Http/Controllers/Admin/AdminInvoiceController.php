<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Factor;
use App\Models\Invoice;
use App\Models\Product;
use PDF;
use Illuminate\Http\Request;

class AdminInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = $_GET['id'];
        if ($id != "") {
            $factors = Factor::where('factor_id', $id)->with('product')->get();
            $invoices = Invoice::where('factor_id', $id)->orderBy('id', 'desc')->get();
            return view('admin.invoice.create', compact(['factors', 'invoices']));
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoices = Invoice::where('factor_id', $request->factor_id)->get();
        $factors = Factor::where('factor_id', $request->factor_id)->get();
        $amount_paid=[];
        foreach ($invoices as $item) {
            $amount_paid[] = $item->amount_paid;
        }
        $remaining = $factors[0]->Total - array_sum($amount_paid);
        if ($request->check == "no") {
            $this->validate($request, [
                'amount_paid' => 'required',
            ], [
                'amount_paid.required' => 'مبلغ پرداختی را وارد کنید',
            ]);
            if ($remaining < trim($request->amount_paid)) {
                session()->put('error-insert', 'مبلغ پرداختی نمی تواند بیشتر از مبلغ فاکتور باشد');
                return redirect('/admin/invoice/create?id=' . $request->factor_id);
            }
            $amount = trim($request->amount_paid);
        } elseif ($request->check == "yes") {
            $this->validate($request, [
                'check_id' => 'required',
                'amount_paid_check' => 'required',
            ], [
                'check_id.required' => 'شماره چک را وارد کنید',
                'amount_paid_check.required' => 'مبلغ پرداختی را وارد کنید',
            ]);
            if ($remaining < trim($request->amount_paid_check)) {
                session()->put('error-insert', 'مبلغ پرداختی نمی تواند بیشتر از مبلغ فاکتور باشد');
                return redirect('/admin/invoice/create?id=' . $request->factor_id);
            }
            $amount = trim($request->amount_paid_check);
        }

        $Invoice = new Invoice();
        $Invoice->factor_id = $request->factor_id;
        $Invoice->price = $factors[0]->Total;
        $Invoice->check_id = $request->check_id;

        if ($request->check == "no") {
            $Invoice->amount_paid = $request->amount_paid;
        } elseif ($request->check == "yes") {
            $Invoice->amount_paid = $request->amount_paid_check;
        }

        $inv = Invoice::where('factor_id', $request->factor_id)->orderBy('id', 'desc')->first();
        if (empty($inv)) {
            $Invoice->remaining = $factors[0]->Total - trim($amount);
            $Invoice->Total_remaining = $factors[0]->Total - trim($amount);
        } else {
            $Invoice->remaining = $remaining - trim($amount);
        }

        $Invoice->check = $request->check;
        $Invoice->description = $request->description;
        $Invoice->save();
        $Invoice_remaining = Invoice::where('factor_id', $request->factor_id)->orderBy('id', 'desc')->first();
        if (!empty($Invoice_remaining)) {
            Invoice::where('factor_id', $request->factor_id)->update(['Total_remaining' => $remaining - trim($amount)]);
            if($remaining - trim($amount)<=0){
                foreach ($factors as $fac){
                    $product= Product::find($fac->product_id);
                    $product->depot=$product->depot-$fac->count;
                    $product->save();
                }
            }
        }
        session()->put('session-insert-update', 'محصول جدید با موفقیت اضافه شد');
        return redirect('/admin/invoice/' . $request->factor_id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = Invoice::where('factor_id', $id)->get();
        $factors = Factor::where('factor_id', $id)->with('product')->get();
        $factor_id = $id;
        $Active = "factors";
        $table = base64_encode('invoices');
        return view('admin.invoice.index', compact(['Active', 'invoices', 'table', 'factors','factor_id']));
    }

    public function show_invoice($id)
    {
        $invoices = Invoice::where('factor_id', $id)->get();
        if (count($invoices)) {
            $factors = Factor::where('factor_id', $id)->with('product')->get();
            $Active = "factors";
            $table = base64_encode('invoices');
            return view('admin.invoice.show-invoice', compact(['Active', 'invoices', 'table', 'factors']));

        } else {
            return redirect('/admin/invoice/' . $id);
        }
    }
    public function invoice_pdf($id)
    {
        $invoices = Invoice::where('factor_id', $id)->get();
        $factors = Factor::where('factor_id', $id)->with('product')->get();
        $Active = "factors";
        $table = base64_encode('invoices');
        $pdf = PDF::loadView('admin.invoice.pdf-invoice', compact(['Active', 'invoices', 'table', 'factors']));
        return $pdf->download('invoices-'.$id.'.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
