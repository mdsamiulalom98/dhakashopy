<?php

namespace App\Http\Controllers\Frontend;

use shurjopayv2\ShurjopayLaravelPackage8\Http\Controllers\ShurjopayController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Product;
use App\Models\District;
use App\Models\CreatePage;
use App\Models\Campaign;
use App\Models\Banner;
use App\Models\ShippingCharge;
use App\Models\Customer;
use App\Models\OrderDetails;
use App\Models\ProductVariable;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Review;

class FrontendController extends Controller
{
    public function index()
    {
        // return "Welcome to Kenakatar.com";
        $frontcategory = Category::where(['status' => 1])
            ->select('id', 'name', 'image', 'slug', 'status')
            ->get();

        $sliders = Banner::where(['status' => 1, 'category_id' => 1])
            ->select('id', 'image', 'link')
            ->get();

        $hotdeal_top = Product::where(['status' => 1, 'topsale' => 1])
            ->orderBy('id', 'DESC')
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'type')
            ->withCount('variable')
            ->limit(12)
            ->get();
        // return $hotdeal_top;

        $homecategory = Category::where(['front_view' => 1, 'status' => 1])
            ->orderBy('id', 'ASC')
            ->get();

        return view('frontEnd.layouts.pages.index', compact('sliders', 'frontcategory', 'hotdeal_top', 'homecategory'));
    }

    public function hotdeals()
    {

        $products = Product::where(['status' => 1, 'topsale' => 1])
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'type')
            ->paginate(36);
        return view('frontEnd.layouts.pages.hotdeals', compact('products'));
    }

    public function category($slug, Request $request)
    {
        $category = Category::where(['slug' => $slug, 'status' => 1])->first();
        $products = Product::where(['status' => 1, 'category_id' => $category->id])
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'type', 'category_id')->withCount('variable');
        $subcategories = Subcategory::where('category_id', $category->id)->get();

        // return $request->sort;
        if ($request->sort == 1) {
            $products = $products->orderBy('created_at', 'desc');
        } elseif ($request->sort == 2) {
            $products = $products->orderBy('created_at', 'asc');
        } elseif ($request->sort == 3) {
            $products = $products->orderBy('new_price', 'desc');
        } elseif ($request->sort == 4) {
            $products = $products->orderBy('new_price', 'asc');
        } elseif ($request->sort == 5) {
            $products = $products->orderBy('name', 'asc');
        } elseif ($request->sort == 6) {
            $products = $products->orderBy('name', 'desc');
        } else {
            $products = $products->latest();
        }

        $min_price = $products->min('new_price');
        $max_price = $products->max('new_price');
        if ($request->min_price && $request->max_price) {
            $products = $products->where('new_price', '>=', $request->min_price);
            $products = $products->where('new_price', '<=', $request->max_price);
        }

        $products = $products->paginate(24);
        return view('frontEnd.layouts.pages.category', compact('category', 'products', 'subcategories', 'min_price', 'max_price'));
    }

    public function subcategory($slug, Request $request)
    {
        $subcategory = Subcategory::where(['slug' => $slug, 'status' => 1])->first();
        $products = Product::where(['status' => 1, 'subcategory_id' => $subcategory->id])
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'type', 'category_id', 'subcategory_id')->withCount('variable');
        $childcategories = Childcategory::where('subcategory_id', $subcategory->id)->get();

        // return $request->sort;
        if ($request->sort == 1) {
            $products = $products->orderBy('created_at', 'desc');
        } elseif ($request->sort == 2) {
            $products = $products->orderBy('created_at', 'asc');
        } elseif ($request->sort == 3) {
            $products = $products->orderBy('new_price', 'desc');
        } elseif ($request->sort == 4) {
            $products = $products->orderBy('new_price', 'asc');
        } elseif ($request->sort == 5) {
            $products = $products->orderBy('name', 'asc');
        } elseif ($request->sort == 6) {
            $products = $products->orderBy('name', 'desc');
        } else {
            $products = $products->latest();
        }

        $min_price = $products->min('new_price');
        $max_price = $products->max('new_price');
        if ($request->min_price && $request->max_price) {
            $products = $products->where('new_price', '>=', $request->min_price);
            $products = $products->where('new_price', '<=', $request->max_price);
        }

        $selectedChildcategories = $request->input('childcategory', []);
        $products = $products->when($selectedChildcategories, function ($query) use ($selectedChildcategories) {
            return $query->whereHas('childcategory', function ($subQuery) use ($selectedChildcategories) {
                $subQuery->whereIn('id', $selectedChildcategories);
            });
        });

        $products = $products->paginate(24);
        // return $products;
        $impproducts = Product::where(['status' => 1, 'topsale' => 1])
            ->with('image')
            ->limit(6)
            ->select('id', 'name', 'slug')
            ->get();

        return view('frontEnd.layouts.pages.subcategory', compact('subcategory', 'products', 'impproducts', 'childcategories', 'max_price', 'min_price'));
    }

    public function products($slug, Request $request)
    {
        $childcategory = Childcategory::where(['slug' => $slug, 'status' => 1])->first();
        $childcategories = Childcategory::where('subcategory_id', $childcategory->subcategory_id)->get();
        $products = Product::where(['status' => 1, 'childcategory_id' => $childcategory->id])->with('category')
            ->select('id', 'name', 'slug', 'new_price', 'old_price', 'type', 'category_id', 'subcategory_id', 'childcategory_id');


        // return $request->sort;
        if ($request->sort == 1) {
            $products = $products->orderBy('created_at', 'desc');
        } elseif ($request->sort == 2) {
            $products = $products->orderBy('created_at', 'asc');
        } elseif ($request->sort == 3) {
            $products = $products->orderBy('new_price', 'desc');
        } elseif ($request->sort == 4) {
            $products = $products->orderBy('new_price', 'asc');
        } elseif ($request->sort == 5) {
            $products = $products->orderBy('name', 'asc');
        } elseif ($request->sort == 6) {
            $products = $products->orderBy('name', 'desc');
        } else {
            $products = $products->latest();
        }

        $min_price = $products->min('new_price');
        $max_price = $products->max('new_price');
        if ($request->min_price && $request->max_price) {
            $products = $products->where('new_price', '>=', $request->min_price);
            $products = $products->where('new_price', '<=', $request->max_price);
        }

        $products = $products->paginate(24);
        // return $products;
        $impproducts = Product::where(['status' => 1, 'topsale' => 1])
            ->with('image')
            ->limit(6)
            ->select('id', 'name', 'slug')
            ->get();

        return view('frontEnd.layouts.pages.childcategory', compact('childcategory', 'products', 'impproducts', 'min_price', 'max_price', 'childcategories'));
    }


    public function details($slug)
    {
        $details = Product::where(['slug' => $slug, 'status' => 1])
            ->with('image', 'images', 'category', 'subcategory', 'childcategory')
            ->withCount('variable')
            ->firstOrFail();

        $products = Product::where(['category_id' => $details->category_id, 'status' => 1])
            ->with('image')
            ->select('id', 'name', 'slug', 'status', 'category_id', 'new_price', 'old_price', 'type')
            ->withCount('variable')
            ->get();

        $shippingcharge = ShippingCharge::where('status', 1)->get();
        
        $reviews = Review::where('product_id', $details->id)->get();

        $productcolors = ProductVariable::where('product_id', $details->id)->where('stock', '>', 0)
            ->whereNotNull('color')
            ->select('color')
            ->distinct()
            ->get();

        $productsizes = ProductVariable::where('product_id', $details->id)->where('stock', '>', 0)
            ->whereNotNull('size')
            ->select('size')
            ->distinct()
            ->get();

        return view('frontEnd.layouts.pages.details', compact('details', 'products', 'shippingcharge', 'productcolors', 'productsizes', 'reviews'));
    }
    public function stock_check(Request $request)
    {
        $product = ProductVariable::where(['product_id' => $request->id, 'color' => $request->color, 'size' => $request->size])->first();

        $status = $product ? true : false;
        $response = [
            'status' => $status,
            'product' => $product
        ];
        return response()->json($response);
    }
    public function shipping_charge(Request $request)
    {
        $shipping = ShippingCharge::where(['id' => $request->id])->first();
        Session::put('shipping', $shipping->amount);
        return view('frontEnd.layouts.ajax.cart');
    }
    public function shipping_charge_cam(Request $request)
    {
        $shipping = ShippingCharge::where(['id' => $request->id])->first();
        Session::put('shipping', $shipping->amount);
        return view('frontEnd.layouts.ajax.cart_bn');
    }
    public function quickview(Request $request)
    {
        $data['data'] = Product::where(['id' => $request->id, 'status' => 1])->with('images')->withCount('reviews')->first();
        $data = view('frontEnd.layouts.ajax.quickview', $data)->render();
        if ($data != '') {
            echo $data;
        }
    }
    public function livesearch(Request $request)
    {
        $products = Product::select('id', 'name', 'slug', 'new_price', 'old_price', 'type')
            ->withCount('variable')
            ->where('status', 1)
            ->with('image');
        if ($request->keyword) {
            $products = $products->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
        if ($request->category) {
            $products = $products->where('category_id', $request->category);
        }
        $products = $products->get();

        if (empty($request->category) && empty($request->keyword)) {
            $products = [];
        }
        return view('frontEnd.layouts.ajax.search', compact('products'));
    }
    public function search(Request $request)
    {
        $products = Product::select('id', 'name', 'slug', 'new_price', 'old_price', 'type')
            ->withCount('variable')
            ->where('status', 1)
            ->with('image');
        if ($request->keyword) {
            $products = $products->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
        if ($request->category) {
            $products = $products->where('category_id', $request->category);
        }
        $products = $products->paginate(36);
        $keyword = $request->keyword;
        return view('frontEnd.layouts.pages.search', compact('products', 'keyword'));
    }



    public function contact(Request $request)
    {
        return view('frontEnd.layouts.pages.contact');
    }

    public function page($slug)
    {
        $page = CreatePage::where('slug', $slug)->firstOrFail();
        return view('frontEnd.layouts.pages.page', compact('page'));
    }
    public function districts(Request $request)
    {
        $areas = District::where(['district' => $request->id])->pluck('area_name', 'id');
        return response()->json($areas);
    }
    public function campaign($slug, Request $request)
    {

        $campaign = Campaign::where('slug', $slug)->with('images')->first();

        $product = Product::select('id', 'name', 'slug', 'new_price', 'old_price', 'purchase_price', 'type', 'stock')->where(['id' => $campaign->product_id])->first();
        // return $product;
        
        $productcolors = ProductVariable::where('product_id', $campaign->product_id)->where('stock', '>', 0)
            ->whereNotNull('color')
            ->select('color')
            ->distinct()
            ->get();

        $productsizes = ProductVariable::where('product_id', $campaign->product_id)->where('stock', '>', 0)
            ->whereNotNull('size')
            ->select('size')
            ->distinct()
            ->get();

        Cart::instance('shopping')->destroy();


        $var_product = ProductVariable::where(['product_id' => $campaign->product_id])->first();
        if ($product->type == 0) {
            $purchase_price = $var_product ? $var_product->purchase_price : 0;
            $old_price = $var_product ? $var_product->old_price : 0;
            $new_price = $var_product ? $var_product->new_price : 0;
            $stock = $var_product ? $var_product->stock : 0;
        } else {
            $purchase_price = $product->purchase_price;
            $old_price = $product->old_price;
            $new_price = $product->new_price;
            $stock = $product->stock;
        }

        $qty = 1;
        $cartitem = Cart::instance('shopping')->content()->where('id', $product->id)->first();

        Cart::instance('shopping')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $new_price,
            'options' => [
                'slug' => $product->slug,
                'image' => $product->image->image,
                'old_price' => $new_price,
                'purchase_price' => $purchase_price,
                'product_size' => $request->product_size,
                'product_color' => $request->product_color,
                'type' => $product->type
            ],
        ]);
        $shippingcharge = ShippingCharge::where('status', 1)->get();
        $select_charge = ShippingCharge::where('status', 1)->first();
        Session::put('shipping', $select_charge->amount);
        return view('frontEnd.layouts.pages.campaign.campaign', compact('campaign', 'productsizes', 'productcolors', 'shippingcharge', 'old_price', 'new_price'));
    }
    public function campaign_stock(Request $request)
    {
        $product = Product::select('id', 'name', 'slug', 'new_price', 'old_price', 'purchase_price', 'type', 'stock')->where(['id' => $request->id])->first();

        $variable = ProductVariable::where(['product_id' => $request->id, 'color' => $request->color, 'size' => $request->size])->first();
        $qty = 1;
        $status = $variable ? true : false;

        if ($status == true) {
            // return $variable;
            // return "wait";
            Cart::instance('shopping')->destroy();
            Cart::instance('shopping')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $qty,
                'price' => $variable->new_price,
                'options' => [
                    'slug' => $product->slug,
                    'image' => $product->image->image,
                    'old_price' => $variable->new_price,
                    'purchase_price' => $variable->purchase_price,
                    'product_size' => $request->size,
                    'product_color' => $request->color,
                    'type' => $product->type
                ],
            ]);
        }
        $data = Cart::instance('shopping')->content();
        return response()->json($status);

        return view('frontEnd.layouts.ajax.cart', compact('data'));
        $response = [
            'status' => $status,
            'data' => $data
        ];
        return response()->json($response);
    }

    public function payment_success(Request $request)
    {
        $order_id = $request->order_id;
        $shurjopay_service = new ShurjopayController();
        $json = $shurjopay_service->verify($order_id);
        $data = json_decode($json);

        if ($data[0]->sp_code != 1000) {
            Toastr::error('Your payment failed, try again', 'Oops!');
            if ($data[0]->value1 == 'customer_payment') {
                return redirect()->route('home');
            } else {
                return redirect()->route('home');
            }
        }

        if ($data[0]->value1 == 'customer_payment') {

            $customer = Customer::find(Auth::guard('customer')->user()->id);

            // order data save
            $order = new Order();
            $order->invoice_id = $data[0]->id;
            $order->amount = $data[0]->amount;
            $order->customer_id = Auth::guard('customer')->user()->id;
            $order->order_status = $data[0]->bank_status;
            $order->save();

            // payment data save
            $payment = new Payment();
            $payment->order_id = $order->id;
            $payment->customer_id = Auth::guard('customer')->user()->id;
            $payment->payment_method = 'shurjopay';
            $payment->amount = $order->amount;
            $payment->trx_id = $data[0]->bank_trx_id;
            $payment->sender_number = $data[0]->phone_no;
            $payment->payment_status = 'paid';
            $payment->save();
            // order details data save
            foreach (Cart::instance('shopping')->content() as $cart) {
                $order_details = new OrderDetails();
                $order_details->order_id = $order->id;
                $order_details->product_id = $cart->id;
                $order_details->product_name = $cart->name;
                $order_details->purchase_price = $cart->options->purchase_price;
                $order_details->sale_price = $cart->price;
                $order_details->qty = $cart->qty;
                $order_details->save();
            }

            Cart::instance('shopping')->destroy();
            Toastr::error('Thanks, Your payment send successfully', 'Success!');
            return redirect()->route('home');
        }

        Toastr::error('Something wrong, please try agian', 'Error!');
        return redirect()->route('home');
    }
    public function payment_cancel(Request $request)
    {
        $order_id = $request->order_id;
        $shurjopay_service = new ShurjopayController();
        $json = $shurjopay_service->verify($order_id);
        $data = json_decode($json);

        Toastr::error('Your payment cancelled', 'Cancelled!');
        if ($data[0]->sp_code != 1000) {
            if ($data[0]->value1 == 'customer_payment') {
                return redirect()->route('home');
            } else {
                return redirect()->route('home');
            }
        }
    }

    public function offers()
    {
        return view('frontEnd.layouts.pages.offers');
    }
}
