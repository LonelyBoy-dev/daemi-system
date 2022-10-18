<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class AdminMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=Member::all();
        $table=base64_encode('members');
        $Active="members";
        return view('admin.members.index',compact(['Active','table','items']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Active="members";
        return view('admin.members.create',compact(['Active']));
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
            'name' => 'required',
            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11',
        ], [
            'name.required' => 'نام و نام خانوادگی را وارد کنید',
            'mobile.required' => 'شماره موبایل را وارد کنید',
            'mobile.regex' => 'شماره موبایل نامعتبر است',
            'mobile.digits' => 'شماره موبایل نامعتبر است',
        ]);
        $member=new Member();
        $member->name=$request->name;
        $member->mobile=$request->mobile;
        $member->status=$request->status;
        $member->save();

        session()->put('session-insert-update','مشتری جدید با موفقیت اضافه شد');
        return redirect('/admin/members');
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
        $item=Member::find($id);
        $Active="members";
        return view('admin.members.edit',compact(['Active','item']));
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
            'name' => 'required',
            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11',
        ], [
            'name.required' => 'نام و نام خانوادگی را وارد کنید',
            'mobile.required' => 'شماره موبایل را وارد کنید',
            'mobile.regex' => 'شماره موبایل نامعتبر است',
            'mobile.digits' => 'شماره موبایل نامعتبر است',
        ]);
        $member=Member::find($id);
        $member->name=$request->name;
        $member->mobile=$request->mobile;
        $member->status=$request->status;
        $member->save();

        session()->put('session-insert-update','مشتری جدید با موفقیت ویرایش شد');
        return redirect('/admin/members');
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
