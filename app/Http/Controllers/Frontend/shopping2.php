<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductVariable;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Cart;
use DB;
class ShoppingController extends Controller
{

    public function addTocartGet($id,Request $request){
        $qty=1;
        $productInfo = DB::table('products')->where('id',$id)->first();
        $productImage = DB::table('productimages')->where('product_id',$id)->first();
        $cartinfo=Cart::instance('shopping')->add(['id'=>$productInfo->id,'name'=>$productInfo->name,'qty'=>$qty,'price'=>$productInfo->new_price,
            'options' => [
                'image'=>$productImage->image,
                'old_price'=>$productInfo->old_price,
                 'slug' => $productInfo->slug,
                 'purchase_price' => $productInfo->purchase_price,
                 ]]);

        // return redirect()->back();
        return response()->json($cartinfo);
    }

    public function cart_store(Request $request){
        $product = Product::select('id','name','slug','new_price','old_price','purchase_price','type','stock')->where(['id' => $request->id])->first();

        $var_product = ProductVariable::where(['product_id'=>$request->id,'color'=>$request->product_color,'size'=>$request->product_size])->first();
        if($product->type == 0){
            $purchase_price = $var_product?$var_product->purchase_price:0;
            $old_price = $var_product?$var_product->old_price:0;
            $new_price = $var_product?$var_product->new_price:0;
            $stock = $var_product?$var_product->stock:0;
        }else{
            $purchase_price = $product->purchase_price;
            $old_price = $product->old_price;
            $new_price = $product->new_price;
            $stock = $product->stock;
        }

        $cartitem = Cart::instance('shopping')->content()->where('id', $product->id)->first();
        if($cartitem){
            $cart_qty = $cartitem->qty + $request->qty;
        }else{
            $cart_qty = $request->qty;
        }
        if($stock < $cart_qty){
           Toastr::error('Product stock limit over', 'Failed!');
           return back();
        }
        Cart::instance('shopping')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->qty,
            'price' => $new_price,
            'options' => [
                'slug' => $product->slug,
                'image' => $product->image->image,
                'old_price' => $new_price,
                'purchase_price' => $purchase_price,
                'product_size'=>$request->product_size,
                'product_color'=>$request->product_color,
                'type'=>$product->type
            ],
        ]);

        Toastr::success('Product successfully add to cart', 'Success!');
        return redirect()->route('customer.checkout');

    }
    public function campaign_stock(Request $request){
        $product = ProductVariable::where(['product_id' => $request->id, 'color' => $request->color,'size' => $request->size])->first();

        $status = $product ? true : false;
        $response = [
            'status' => $status,
            'product' => $product
        ];
         return response()->json($response);
    }
    public function cart_content(Request $request)
    {
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_remove(Request $request)
    {
        $remove = Cart::instance('shopping')->update($request->id, 0);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_increment(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty + 1;
        $increment = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_decrement(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty - 1;
        $decrement = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_count(Request $request)
    {
        $data = Cart::instance('shopping')->count();
        return view('frontEnd.layouts.ajax.cart_count', compact('data'));
    }
    public function mobilecart_qty(Request $request)
    {
        $data = Cart::instance('shopping')->count();
        return view('frontEnd.layouts.ajax.mobilecart_qty', compact('data'));
    }

    public function cart_remove_bn(Request $request)
    {
        $remove = Cart::instance('shopping')->update($request->id, 0);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart_bn', compact('data'));
    }
    public function cart_increment_bn(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty + 1;
        $increment = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart_bn', compact('data'));
    }
    public function cart_decrement_bn(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty - 1;
        $decrement = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart_bn', compact('data'));
    }

}
