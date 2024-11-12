<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\CouponCode;
use File;

class CouponCodeController extends Controller
{
     function __construct()
    {
         $this->middleware('permission:couponcode-list|couponcode-create|couponcode-edit|couponcode-delete', ['only' => ['index','store']]);
         $this->middleware('permission:couponcode-create', ['only' => ['create','store']]);
         $this->middleware('permission:couponcode-edit', ['only' => ['edit','update']]);
    }
    
    public function index(Request $request)
    {
        $data = CouponCode::orderBy('id','DESC')->get();
        return view('backEnd.couponcode.index',compact('data'));
    }
    public function create()
    {
        return view('backEnd.couponcode.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'coupon_code' => 'required',
            'expiry_date' => 'required',
            'offer_type' => 'required',
            'amount' => 'required',
            'buy_amount' => 'required',
            'image' => 'required',
            'status' => 'required',
        ]);
        // image with intervention 
        $image = $request->file('image');
        $name =  time().'-'.$image->getClientOriginalName();
        $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
        $name = strtolower(preg_replace('/\s+/', '-', $name));
        $uploadpath = 'public/uploads/couponcode/';
        $imageUrl = $uploadpath.$name; 
        $img = Image::make($image->getRealPath());
        $img->encode('webp', 90);
        $width = 210;
        $height = 210;
        $img->height() > $img->width() ? $width=null : $height=null;
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($imageUrl);

        $input = $request->all();
        $input['image'] = $imageUrl;
        CouponCode::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('couponcodes.index');
    }
    
    public function edit($id)
    {
        $edit_data = CouponCode::find($id);
        return view('backEnd.couponcode.edit',compact('edit_data'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'coupon_code' => 'required',
            'expiry_date' => 'required',
            'offer_type' => 'required',
            'amount' => 'required',
            'buy_amount' => 'required',
        ]);
        $update_data = CouponCode::find($request->id);
        $input = $request->all();
        $image = $request->file('image');
        if($image){
            // image with intervention 
            $name =  time().'-'.$image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/couponcode/';
            $imageUrl = $uploadpath.$name; 
            $img=Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = 210;
            $height = 210;
            $img->height() > $img->width() ? $width=null : $height=null;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($imageUrl);
            $input['image'] = $imageUrl;
            File::delete($update_data->image);
        }else{
            $input['image'] = $update_data->image;
        }
        $input['status'] = $request->status?1:0;
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('couponcodes.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = CouponCode::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = CouponCode::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = CouponCode::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
