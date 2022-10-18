<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Factor;
use App\Models\Factor_row;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminAjaxController extends Controller
{
    public function numberToword(Request $request)
    {
        $Number2Word = new \Number2Word();
        @$Number2Word = @$Number2Word->numberToWords($request->number);
        return response([
            'word' => $Number2Word . ' تومان '
        ]);
    }

    public function delete_all_items(Request $request)
    {
        $table = base64_decode($request['table']);
        $deleted = DB::table($table)->whereIn('id', $request['id'])->delete();
        if ($deleted) {
            echo 'deleted';
        }
    }


    public function delete_solo_item(Request $request)
    {
        $table = base64_decode($request['table']);
        $deleted = DB::delete('delete from ' . $table . ' where id=?', [$request['id']]);
        if ($deleted) {
            echo 'deleted';
        }
    }


    public function delete_solo_invoice(Request $request)
    {
        $table = base64_decode($request['table']);
        //$deleted = DB::delete('delete from ' . $table . ' where id=?', [$request['id']]);
        $invoice = Invoice::find($request->id);
        $factor_id = $invoice->factor_id;
        $invoice->delete();
        $invoices = Invoice::where('factor_id', $factor_id)->get();
        $factor = Factor::where('factor_id', $factor_id)->first();
        if (count($invoices)) {
            $amount_paid = [];
            foreach ($invoices as $item) {
                $amount_paid[] = $item->amount_paid;
            }
            $Total_remaining = @$factor->Total - array_sum(@$amount_paid);
        } else {

            $Total_remaining = $factor->Total;
        }

        Invoice::where('factor_id', $factor_id)->update(['Total_remaining' => $Total_remaining]);

        return response([
            'delete' => 'deleted',
            'Total_remaining' => $Total_remaining,
        ]);

    }


    public function delete_all_factors(Request $request)
    {
        $table = base64_decode($request['table']);
        $deleted = DB::table($table)->whereIn('factor_id', $request['id'])->delete();
        if ($deleted) {
            echo 'deleted';
        }
    }

    public function delete_solo_factor(Request $request)
    {
        $table = base64_decode($request['table']);
        $deleted = DB::delete('delete from ' . $table . ' where factor_id=?', [$request['id']]);
        if ($deleted) {
            echo 'deleted';
        }
    }


    public function uploadimageprofile(Request $request)
    {
        $user = User::find(Auth::id());


        if (!empty($user->avatar)) {
            if (file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }
        }

        $file = $request->file('file');
        $image = Image::make($file);

        //save image
        $name = time() . rand() . $file->getClientOriginalName();
        $image->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        if (!is_dir('admin/images/user_profile/')) {
            mkdir("admin/images/user_profile/" );
        }

        $image->save('admin/images/user_profile/' . $name);


        /*                $file->move('images/user_profile/' . $request->id , $name);*/
        $user->avatar = 'admin/images/user_profile/'  . $name;
        $user->save();

        return response()->json([
            'status' => asset($user->avatar)
        ]);

    }

    public function get_product_price(Request $request)
    {
        return Product::find($request->id)->price;
    }

    public function set_factor_row(Request $request)
    {
        $item = new Factor_row();
        $item->product_id = $request->product;
        $item->count = $request->count;


        $product = Product::where('id', $request->product)->with('brand')->first();

        if ($product->depot>=$request->count) {


            $brand = Brand::find($product->brand_id);
            $price = $product->price;
            if ($request->price != "") {
                $price = $request->price;
            }

            $item->price = $price;
            $item->discount = $request->discount;
            $item->save();

            $discount = 0;
            $total_price = $price * $request->count;
            $discount_price = $total_price;
            if ($request->discount != "") {
                $discount = $request->discount;
                $discount_price = $price * (100 - $discount) / 100;
            }


            $item_row = Factor_row::all();
            return response([
                'id' => $item->id,
                'product' => $product,
                'price' => $price,
                'count' => $request->count,
                'brand' => @$brand->title . ' - ' . $product->content,
                'discount' => $discount,
                'table' => base64_encode('factor_row'),
                'row' => count($item_row),
                'total_price' => $total_price,
                'discount_price' => $discount_price,
            ]);
        }else{
            return response([
                'count'=>"NoCount",
                'depot'=>$product->depot,
            ]);
        }
    }

    public function update_factor(Request $request)
    {

        $item = new Factor();
        $item->product_id = $request->product;
        $item->count = $request->count;
        $item->factor_id = $request->factor_id;
        $item->name = $request->name;


        $product = Product::where('id', $request->product)->with('brand')->first();

        $brand = Brand::find(@$product->brand_id);

        $price = $product->price;
        if ($request->price != "") {
            $price = $request->price;
        }

        $item->price = $price;
        $item->discount = $request->discount;


        $discount = 0;
        $total_price = $price * $request->count;
        $discount_price = $total_price;
        if ($request->discount != "") {
            $discount = $request->discount;
            $discount_price = $total_price * (100 - $discount) / 100;
        }
        $item->total_discount_price = $discount_price;
        $item->total_price = $price * $request->count;

        $All_item = Factor::where('factor_id', $request->factor_id)->get();
        $item->ordering=count($All_item);
        $item->save();


        foreach ($All_item as $factor) {
            $total[] = $factor->total_price;
            $total_discount_price[] = $factor->total_discount_price;
        }
        if ($All_item[0]->install == "") {
            $install_default = setting()['install|setup'];
        } else {
            $install_default = $All_item[0]->install;
        }
        $total = array_sum($total);
        $install = ($total * $install_default) / 100;
        $total = array_sum($total_discount_price) + $install;
        $Total = $total;
        if ($All_item[0]->Total_discount != "" and $All_item[0]->Total_discount > 0) {
            $Total = $Total - $All_item[0]->Total_discount;
        }
        Factor::where('factor_id', $request->factor_id)->update(['Total' => $Total]);
        return response([
            'id' => $item->id,
            'product' => $product,
            'price' => $price,
            'count' => $request->count,
            'brand' => @$brand->title . ' - ' . $product->content,
            'discount' => $discount,
            'table' => base64_encode('factors'),
            'row' => count($All_item),
            'total_price' => $total_price,
        ]);
    }

    public function change_price(Request $request)
    {
        $factors = Factor::where('factor_id', $request->factor_id)->get();
        $discount = [];
        foreach ($factors as $factor) {
            $discount_price[] = $factor->total_discount_price;
            $total_price[] = $factor->total_price;
            $price = $factor->price * $factor->count;
            if ($factor->discount != "") {
                $discount[] = $price - $price * (100 - $factor->discount) / 100;
            }
        }


        if ($request->install != "" and $request->install != 0) {
            $install_default = $factors[0]->install;
        } elseif ($request->install_toman != "" and $request->install_toman != 0) {
            $install_default = $request->install_toman;
        } else {
            $install_default = setting()['install|setup'];
        }
        if ($request->install_toman != "" and $request->install_toman != 0) {
            $install = $install_default;
        } else {
            $install = (array_sum(@$total_price) * $install_default) / 100;
        }


        $total = array_sum($discount_price) + $install;
        $new_discount = 0;
        if ($request->discount != "" and $request->discount > 0) {
            $Total = $total - $request->discount;
            $new_discount = $total - $Total;
        } else {
            $Total = array_sum($discount_price) + $install;
        }
        $sum_dis = array_sum($discount);
        $all_discount = $total * (100 - $request->discount) / 100;
        return response([
            'Total' => $Total,
            'Total_discount' => $new_discount + $sum_dis,
        ]);
    }

    public function get_price_factor(Request $request)
    {
        $factors = Factor::where('factor_id', $request->factor_id)->get();
        if (count($factors)) {

            foreach ($factors as $factor) {
                $discount_price[] = $factor->total_discount_price;
                $total_price[] = $factor->total_price;
            }


            if ($request->install != "" and $request->install != 0) {
                $install_default = $request->install;
            } elseif ($request->install_toman != "" and $request->install_toman != 0) {
                $install_default = $request->install_toman;
            } else {
                /*if ($factors[0]->install!=""){
                    $install_default=$factors[0]->install;
                }elseif ($factors[0]->install_toman!=""){
                    $install_default=$factors[0]->install_toman;
                }else{}*/
                $install_default = setting()['install|setup'];

            }


            if ($request->install_toman != "" and $request->install_toman != 0) {
                $install = $install_default;
            } else {
                $install = (array_sum(@$total_price) * $install_default) / 100;
            }

            $total = array_sum($total_price) + $install;
            $sum_price = array_sum($total_price);
            if ($request->discount != "" and $request->discount != 0) {
                $Total_discount = array_sum($total_price) - $request->discount;
            } else {
                if ($request->discount == 0) {
                    $Total_discount = 0;
                } else {
                    $Total_discount = array_sum($total_price) - array_sum($discount_price);
                }
            }

            $Total = array_sum($discount_price) + $install;
            if ($request->discount != "" and $request->discount > 0) {
                if ($factors[0]->Total_discount != "" and $factors[0]->Total_discount != 0) {
                    $Total = $Total - $factors[0]->Total_discount;
                    $Total_discount = $Total_discount + $factors[0]->Total_discount;
                }
            }

            Factor::where('factor_id', $request->factor_id)->update(['Total' => $Total]);
            $Number2Word = new \Number2Word();

            return response([
                'sum_price' => $sum_price,
                'Total' => $Total,
                'total' => $total,
                'count' => count($factors),
                'install' => $install,
                'Total_discount' => $Total_discount,
                'hrofi' => $Number2Word->numberToWords($Total) . '(تومان)',
            ]);
        } else {
            return response([
                'sum_price' => 0,
                'Total' => 0,
                'total' => 0,
                'count' => 0,
                'install' => 0,
                'hrofi' => '',
            ]);
        }

    }

    public function get_price_factor_row(Request $request)
    {
        $factors = Factor_row::all();
        if (count($factors)) {
            $all_discount = [];
            foreach ($factors as $factor) {
                $price = $factor->price * $factor->count;
                $discount = 0;
                if ($factor->discount != "") {
                    $discount = $factor->discount;
                    $all_discount[] = $price - ($price * (100 - $discount) / 100);
                }

                $sum_price[] = $price;
                $total_price[] = $price * (100 - $factor->discount) / 100;
            }

            if ($factors[0]->install == "") {
                $install_default = setting()['install|setup'];
            } else {
                $install_default = $factors[0]->install;
            }


            $install = (array_sum(@$sum_price) * $install_default) / 100;
            $total = array_sum($sum_price) + $install;
            $Total = array_sum($total_price) + $install;
            $count = count($factors);
            /*if ($request->discount!="" and $request->discount>0 and $request->discount<=100){
                $Total=$total * (100-$request->discount) / 100;
            }*/
            return response([
                'sum_price' => array_sum(@$sum_price),
                'all_discount' => array_sum(@$all_discount),
                'count' => $count,
                'Total' => $Total,
                'total' => $total,
                'install' => $install,
            ]);
        } else {
            return response([
                'sum_price' => 0,
                'all_discount' => 0,
                'count' => 0,
                'Total' => 0,
                'total' => 0,
                'install' => 0,
            ]);
        }

    }


    public function get_product(Request $request)
    {
        $products = Product::where(['category_id' => $request->id, 'status' => 'show'])->where('depot', '>', '0')->get();
        foreach ($products as $item) { ?>
            <option <?php if (old('product') == $item->id) { ?> selected <?php } ?>
                    value="<?= $item->id ?>"><?= $item->title ?></option>
        <?php }

    }

    public function get_brands(Request $request)
    {
        $brands = Brand::where(['category_id' => $request->id, 'status' => 'show'])->get();

        if ($request->item_id != "") {
            $product = Product::find($request->item_id);
        }
        foreach ($brands as $item) { ?>
            <option <?php if (@$product->brand_id == $item->id) { ?> selected <?php } ?>
                    value="<?= $item->id ?>"><?= $item->title ?></option>
        <?php }

    }

    public function updateOrdering(Request $request)
    {

        foreach ($request->form as $key => $ordering){
            Factor::where('id',$ordering['value'])->update(['ordering'=>$key]);
        }
       //
       /* return response([
            'form'=>$request->form
        ]);*/
    }

}
