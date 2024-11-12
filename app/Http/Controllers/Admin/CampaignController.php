<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CampaignReview;
use App\Models\Campaign;
use Image;
use Brian2694\Toastr\Facades\Toastr;
use Str;
use File;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $show_data = Campaign::orderBy('id','DESC')->get();
        return view('backEnd.campaign.index',compact('show_data'));
    }
    public function create()
    {
        $products = Product::where(['status'=>1])->select('id','name','status')->get();
        return view('backEnd.campaign.create',compact('products'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'short_description' => 'required',
            'description' => 'required',
            'name' => 'required',
            'status' => 'required',
        ]);

        $input = $request->except(['files','image']);

        // banner
        $image1 = $request->file('banner');
        $name1 =  time().'-'.$image1->getClientOriginalName();
        $name1 = strtolower(preg_replace('/\s+/', '-', $name1));
        $uploadPath1 = 'public/uploads/campaign/';
        $image1->move($uploadPath1,$name1);
        $imageUrl1 =$uploadPath1.$name1;

        $input['slug'] = strtolower(Str::slug($request->name));
        $input['banner'] = $imageUrl1;
        $campaign = Campaign::create($input);

        $images = $request->file('image');
        if($images){
            foreach ($images as $key => $image) {
                $name =  time().'-'.$image->getClientOriginalName();
                $name = strtolower(preg_replace('/\s+/', '-', $name));
                $uploadPath = 'public/uploads/campaign/';
                $image->move($uploadPath,$name);
                $imageUrl =$uploadPath.$name;

                $pimage             = new CampaignReview();
                $pimage->campaign_id = $campaign->id;
                $pimage->image       = $imageUrl;
                $pimage->save();
            }

        }

        Toastr::success('Success','Data insert successfully');
        return redirect()->route('campaign.index');
    }

    public function edit($id)
    {
        $edit_data = Campaign::with('images')->find($id);
        $select_products = Product::where('campaign_id',$id)->get();
        $show_data = Campaign::orderBy('id','DESC')->get();
        $products = Product::where(['status'=>1])->select('id','name','status')->get();
        return view('backEnd.campaign.edit',compact('edit_data','products','select_products'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);
        // image one
        $update_data = Campaign::find($request->hidden_id);
        $input = $request->except('hidden_id','product_ids','files','image');

        $image1 = $request->file('banner');
        if($image1){
            $image1 = $request->file('banner');
            $name1 =  time().'-'.$image1->getClientOriginalName();
            $name1 = strtolower(preg_replace('/\s+/', '-', $name1));
            $uploadPath1 = 'public/uploads/campaign/';
            $image1->move($uploadPath1,$name1);
            $imageUrl1 =$uploadPath1.$name1;
            File::delete($update_data->banner);
            $input['banner'] = $imageUrl1;
        }else{
            $input['banner'] = $update_data->banner;
        }


        $input['slug'] = strtolower(Str::slug($request->name));
        $update_data = Campaign::find($request->hidden_id);
        $update_data->update($input);

        $images = $request->file('image');
        if($images){
            foreach ($images as $key => $image) {
                $name =  time().'-'.$image->getClientOriginalName();
                $name = strtolower(preg_replace('/\s+/', '-', $name));
                $uploadPath = 'public/uploads/campaign/';
                $image->move($uploadPath,$name);
                $imageUrl =$uploadPath.$name;

                $pimage             = new CampaignReview();
                $pimage->campaign_id = $update_data->id;
                $pimage->image      = $imageUrl;
                $pimage->save();
            }
        }

        Toastr::success('Success','Data update successfully');
        return redirect()->route('campaign.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Campaign::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Campaign::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {

        $delete_data = Campaign::find($request->hidden_id);
        $delete_data->delete();

        $campaign = Product::whereNotNull('campaign_id')->get();
        foreach($campaign as $key=>$value){
            $product = Product::find($value->id);
            $product->campaign_id = null;
            $product->save();
        }
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
    public function imgdestroy(Request $request)
    {
        $delete_data = CampaignReview::find($request->id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}
