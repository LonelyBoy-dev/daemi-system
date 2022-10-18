<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item=User::find(Auth::id());
        $table=base64_encode('users');
        return view('admin.profile.index',compact(['table','item']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|string|max:255|min:3',
            'username' => 'nullable|unique:users,username,' . Auth::id(),
            'mobile' => 'nullable|regex:/(09)[0-9]{9}/|digits:11|unique:users,mobile,'. Auth::id(),
            'email' => 'required|email|unique:users,email,'. Auth::id(),
            'password' => 'nullable|min:6|confirmed',
        ], [
            'name.required' => 'نام را وارد کنید',
            'name.min' => 'حداقل 3 کاراکتر می باشد',
            'mobile.required' => 'شماره موبایل را وارد کنید',
            'mobile.digits' => 'شماره موبایل صحیح نیست',
            'mobile.unique' => 'شماره موبایل را وارد کنید',
            'mobile.regex' => 'شماره موبایل صحیح نیست',
            'email.required' => 'ایمیل  را وارد کنید',
            'email.email' => 'ایمیل صحیح نمی باشد',
            'password.required' => 'رمز عبور را وارد کنید',
            'password.min' => 'رمز عبور حداقل 6 کاراکتر می باشد',
            'password.confirmed' => 'رمز عبور و تکرار رمز عبور یکسان نیست',
            'password.regex' => 'رمز عبور باید ترکیبی از حروف لاتین و عدد باشد',
        ]);
        $user=User::find(Auth::id());
        $user->name = $request->name;
        $user->username = $request->username;
        //$user->mobile = $request->mobile;
        $user->email = $request->email;
        if ($request->password!=""){
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();
        session()->put('session-insert-update', 'اطلاعات پروفایل شما با موفقیت ویرایش شد');
        return redirect('/admin/profile');
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
        //
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
        //
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
