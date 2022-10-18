<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminBrandsController extends Controller
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
            $brands=Brand::where('title', 'like', '%'.$value.'%')->paginate(5);
        }else{
            $brands=Brand::paginate(5);
        }
        $pageNum = count($brands);
        $items=Brand::all();
        $table=base64_encode('brands');
        $Active="brands";
        return view('admin.brands.index',compact(['table','Active','items','brands','pageNum']));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 'show')->get();
        $Active="brands";
        return view('admin.brands.create',compact(['Active','categories']));
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
        ], [
            'title.required' => 'عنوان را وارد کنید',
        ]);
        $category=new Brand();
        $category->title=$request->title;
        $category->category_id=$request->category;
        $category->status=$request->status;
        $category->save();

        session()->put('session-insert-update','برند جدید با موفقیت اضافه شد');
        return redirect('/admin/brands');
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
        $item=Brand::find($id);
        $categories = Category::where('status', 'show')->get();
        $Active="brands";
        return view('admin.brands.edit',compact(['item','Active','categories']));
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
        $category=Brand::find($id);
        $category->title=$request->title;
        $category->category_id=$request->category;
        $category->status=$request->status;
        $category->save();

        session()->put('session-insert-update','برند  با موفقیت ویرایش شد');
        return redirect('/admin/brands');
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
