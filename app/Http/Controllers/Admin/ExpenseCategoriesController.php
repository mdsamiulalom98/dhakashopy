<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\ExpenseCategories;

class ExpenseCategoriesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:expensecategory-list|expensecategory-create|expensecategory-edit|expensecategory-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:expensecategory-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:expensecategory-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:expensecategory-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = ExpenseCategories::orderBy('id', 'DESC')->get();
        // return $data;
        return view('backEnd.expensecategory.index', compact('data'));
    }
    public function create()
    {
        $expensecategories = ExpenseCategories::orderBy('id', 'DESC')->select('id', 'name')->get();
        return view('backEnd.expensecategory.create', compact('expensecategories'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
        ]);


        $input = $request->all();
        ExpenseCategories::create($input);
        Toastr::success('Success', 'Data insert successfully');
        return redirect()->route('expensecategories.index');
    }

    public function edit($id)
    {
        $edit_data = ExpenseCategories::find($id);
        $expensecategories = ExpenseCategories::select('id', 'name')->get();
        return view('backEnd.expensecategory.edit', compact('edit_data', 'expensecategories'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $update_data = ExpenseCategories::find($request->id);
        $input = $request->all();
        $input['status'] = $request->status ? 1 : 0;

        $update_data->update($input);

        Toastr::success('Success', 'Data update successfully');
        return redirect()->route('expensecategories.index');
    }

    public function inactive(Request $request)
    {
        $inactive = ExpenseCategories::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = ExpenseCategories::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = ExpenseCategories::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
}
