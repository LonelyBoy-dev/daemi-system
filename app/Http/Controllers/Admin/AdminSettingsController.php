<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class AdminSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=Setting::all();
        return view('admin.settings.index',compact(['items']));
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
        foreach ($request->input() as $key => $value) {
            if ($key!="logo"){
                    Setting::where('setting',$key)->update(['value'=>$value]);
            }
        }
        if (!empty($request->logo)){
            $file = $request->file('logo');
            if($file){
                $imgsetting=Setting::where('setting','logo')->first();
                if ($imgsetting->value!="" and $imgsetting->value){
                    @unlink(public_path($imgsetting->value));
                }

                $name = rand(1,99999).time().'_'.$file->getClientOriginalName();
                if ($file->clientExtension()!="svg") {
                    $image = Image::make($file);
                    $image->resize(150, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    if(!is_dir('images')){
                        mkdir("images");
                    }
                    $image->save('images/'. $name);
                }else{
                    if(!is_dir('images')){
                        mkdir("images");
                    }
                    $file->move('images', $name);


                }

                ///////////// save image in table /////////////
                ///

                $imgsetting->value = "images/".$name;
                $imgsetting->save();
            }
        }
        session()->put('session-insert-update','تنضیمات شما با موفقیت ذخیره شده');
        return redirect('/admin/settings');
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
