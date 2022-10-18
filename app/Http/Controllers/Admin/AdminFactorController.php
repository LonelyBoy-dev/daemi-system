<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Factor;
use App\Models\Factor_row;
use App\Models\Product;
use App\Models\User;
use PDF;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class AdminFactorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $value=@$_GET['type'];
        $pageNum=0;
        if ($value){
            $factor_id=[];
            $item_s=Factor::select('factor_id')->distinct()->get();
            foreach ($item_s as $item){
                $factor_id=Factor::where('factor_id',$item->factor_id)->first();
                $id[]=$factor_id->id;
            }
            $factors=Factor::where('name', 'like', '%'.$value.'%')->whereIn('id',$id)->orwhere('factor_id', 'like', '%'.$value.'%')->whereIn('id',$id)->paginate(5);
        }else{
            $factors=Factor::select('factor_id')->distinct()->paginate(5);
        }
        $pageNum = count($factors);
        $item_s = Factor::select('factor_id')->distinct()->get();
        $factor_row = Factor_row::with('product')->get();
        $table = base64_encode('factors');
        $Active = "factors";
        return view('admin.factor.index', compact(['factors', 'table', 'Active', 'factor_row','item_s','pageNum']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('status', 'show')->get();
        $categories = Category::where('status', 'show')->get();
        $brands = Brand::where('status', 'show')->get();
        $factor_row = Factor_row::with('product')->get();
        $Active = "factors";
        $table = base64_encode('factor_row');
        return view('admin.factor.create', compact(['Active', 'table', 'products','categories', 'brands', 'factor_row']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ], [
            'name.required' => 'نام خریدار را وارد کنید',
        ]);
        $factor_row = Factor_row::all();
        $v = new Verta();
        $factor_id = $v->year . $v->month . $v->day . $v->second . rand(100, 999);

        foreach ($factor_row as $key=>$item) {
            $factor = new Factor();
            $factor->factor_id = $factor_id;
            $factor->name = $request->name;
            if ($request->Total_discount != "") {
                $factor->Total_discount = trim($request->Total_discount);
            } else {
                $factor->Total_discount = 0;
            }
            if ($request->install != "") {
                $factor->install = trim($request->install);
                $factor->install_toman="";
            } elseif ($request->install_toman != ""){
                $factor->install="";
                $factor->install_toman=trim($request->install_toman);
            }else {
                $factor->install = trim(setting()['install|setup']);
            }

            $factor->product_id = $item->product_id;
            $factor->count = $item->count;
            $factor->price = $item->price;
            $factor->member_id = $item->member_id;
            $factor->discount = $item->discount;

            $total_discount_price = $item->price * $item->count;
            if ($item->discount != "") {
                $total_discount_price = $total_discount_price * (100 - $item->discount) / 100;
            }
            $factor->total_price = $item->price * $item->count;
            $factor->total_discount_price = $total_discount_price;
            $factor->ordering = $key;
            $factor->save();
        }

        $new_factor = Factor::where('factor_id', $factor_id)->get();
        foreach ($new_factor as $new) {
            $discount_price[] = $new->total_discount_price;
            $total_price[] = $new->total_price;
        }
        if ($new_factor[0]->install!=""){
            $install_default=$new_factor[0]->install;
            $install = (array_sum($total_price) * $install_default) / 100;
        }elseif ($new_factor[0]->install_toman!=""){
            $install_default=$new_factor[0]->install_toman;
            $install = $install_default;
        }else{
            $install_default=setting()['install|setup'];
            $install = (array_sum($total_price) * $install_default) / 100;
        }


        $total = array_sum($discount_price) + $install;

        if ($new_factor[0]->Total_discount != "") {
            $total = $total - $new_factor[0]->Total_discount;
        }
        Factor::where('factor_id', $factor_id)->update(['Total' => $total]);
        Factor_row::truncate();
        session()->put('session-insert-update', 'فاکتور با موفقیت اضافه شد');
        return redirect('/admin/factors');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $factors = Factor::where('factor_id', $id)->with('product')->orderby('ordering','asc')->get();
        $Active = "factors";
        return view('admin.factor.show', compact(['Active', 'factors']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::where('status', 'show')->get();
        $products = Product::where('status', 'show')->get();
        $brands = Brand::where('status', 'show')->get();
        $factors = Factor::where('factor_id', $id)->with('product')->orderby('ordering','asc')->get();
        $Active = "factors";
        $table = base64_encode('factors');
        return view('admin.factor.edit', compact(['Active', 'table', 'products', 'brands','categories', 'factors']));
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
        $this->validate($request, [
            'name' => 'required',
        ], [
            'name.required' => 'نام خریدار را وارد کنید',
        ]);

        Factor::where('factor_id', $id)->update(['name' => $request->name,'member_id'=>$request->member_id]);
        Factor::where('factor_id', $id)->update(['install' => 0]);
        Factor::where('factor_id', $id)->update(['install_toman' =>0]);
        if ($request->install!="" and $request->install!=0){
            Factor::where('factor_id', $id)->update(['install' => $request->install]);

        }elseif($request->install_toman!="" and $request->install_toman!=0){
            Factor::where('factor_id', $id)->update(['install_toman' => $request->install_toman]);
        }else{
            Factor::where('factor_id', $id)->update(['install' => trim(setting()['install|setup'])]);
        }


        $factors = Factor::where('factor_id', $id)->get();
        foreach ($factors as $factor) {
            $price[] = $factor->price;
            $total_price[] = $factor->total_price;
            $total_discount_price[] = $factor->total_discount_price;
        }
        if ($factors[0]->install!="" and $factors[0]->install!=0){
            $install_default=$factors[0]->install;
            $install = (array_sum(@$total_price) * $install_default) / 100;
        }elseif ($factors[0]->install_toman!="" and $factors[0]->install_toman!=0){
            $install_default=$factors[0]->install_toman;
            $install = $install_default;
        }else{
            $install_default=setting()['install|setup'];
            $install = (array_sum(@$total_price) * $install_default) / 100;
        }

        $total = array_sum($total_discount_price) + $install;
        if (trim($request->Total_discount) != "" and $request->Total_discount > 0) {
            $Total = $total - $request->Total_discount;
        } else {
            $Total = array_sum($total_discount_price) + $install;
        }
        Factor::where('factor_id', $id)->update(['Total_discount' => $request->Total_discount]);
        Factor::where('factor_id', $id)->update(['Total' => $Total]);


        session()->put('session-insert-update', 'فاکتور با موفقیت ویرایش شد');
        return redirect('/admin/factors');
    }
    public function factor_pdf($id)
    {
        $factors = Factor::where('factor_id', $id)->with('product')->orderby('ordering','asc')->get();
        $Active = "factors";
        $pdf = PDF::loadView('admin.factor.pdf-factor', compact(['Active', 'factors']));
        return $pdf->download('factor-'.$id.'.pdf');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete()
    {
        Factor_row::truncate();
        session()->put('session-insert-update', 'فاکتور قبلی با موفقیت حذف شد');
        return redirect('/admin/factors');
    }

    public function destroy($id)
    {
    }
}
