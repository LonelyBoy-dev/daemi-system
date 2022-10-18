<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductsController extends Controller
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
            $products=Product::with('category','brand')->where('title', 'like', '%'.$value.'%')->paginate(5);
        }else{
            $products=Product::with('category','brand')->paginate(5);
        }
        $pageNum = count($products);
        $items=Product::with('category','brand')->get();
        $table=base64_encode('products');
        $Active="products";
        return view('admin.products.index',compact(['table','Active','items','products','pageNum']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::where('status','show')->get();
        $brands=Brand::where('status','show')->get();
        $Active="products";
        return view('admin.products.create',compact(['Active','categories','brands']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'price' => 'required',
        ], [
            'title.required' => 'عنوان را وارد کنید',
            'price.required' => 'قیمت محصول را وارد کنید',
        ]);
        $item=new Product();
        $item->title=$request->title;
        $item->status=$request->status;
        $item->content=$request->input('content');
        $item->price=$request->price;
        $item->depot=$request->depot;
        $item->category_id=$request->category;
        if (@$item->brand_id!=""){
            $item->brand_id=$request->brand;
        }

        $item->save();
        session()->put('session-insert-update','محصول جدید با موفقیت اضافه شد');
        return redirect('/admin/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product=Product::find($id);
        $categories=Category::where('status','show')->get();
        $brands=Brand::where('status','show')->get();
        $Active="products";
        return view('admin.products.edit',compact(['Active','categories','brands','product']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
        ], [
            'title.required' => 'عنوان را وارد کنید',
        ]);
        $item=Product::find($id);
        $item->title=$request->title;
        $item->status=$request->status;
        $item->content=$request->input('content');
        $item->price=$request->price;
        $item->depot=$request->depot;

            $item->category_id=$request->category;
          
                $item->brand_id=$request->brand;


        $item->save();
        session()->put('session-insert-update','محصول با موفقیت ویرایش شد');
        return redirect('/admin/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
