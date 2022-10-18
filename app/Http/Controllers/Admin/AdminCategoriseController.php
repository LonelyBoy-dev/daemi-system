<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoriseController extends Controller
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
            $categories=Category::where('title', 'like', '%'.$value.'%')->paginate(5);
        }else{
            $categories=Category::paginate(5);
        }
        $pageNum = count($categories);
        $items=Category::all();
        $table=base64_encode('categories');
        $Active="categories";
        return view('admin.categories.index',compact(['table','Active','items','categories','pageNum']));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Active="categories";
        return view('admin.categories.create',compact(['Active']));
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
        $category=new Category();
        $category->title=$request->title;
        $category->status=$request->status;
        $category->save();

        session()->put('session-insert-update','دسته بندی جدید با موفقیت اضافه شد');
        return redirect('/admin/categories');
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
        $item=Category::find($id);
        $Active="categories";
        return view('admin.categories.edit',compact(['item','Active']));
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
        $category=Category::find($id);
        $category->title=$request->title;
        $category->status=$request->status;
        $category->save();

        session()->put('session-insert-update','دسته بندی  با موفقیت ویرایش شد');
        return redirect('/admin/categories');
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
