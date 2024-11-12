<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Expense;
use App\Models\ExpenseCategories;

class ExpenseController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:expense-list|expense-create|expense-edit|expense-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:expense-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:expense-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:expense-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = Expense::orderBy('id', 'DESC')->with('category')->get();
        return view('backEnd.expense.index', compact('data'));
    }
    public function create()
    {
        $categories = ExpenseCategories::where('status', 1)->get();
        return view('backEnd.expense.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'expense_cat_id' => 'required',
            'name' => 'required',
            'status' => 'required',
        ]);


        $input = $request->all();

        Expense::create($input);
        Toastr::success('Success', 'Data insert successfully');
        return redirect()->route('expense.index');
    }

    public function edit($id)
    {
        $edit_data = Expense::find($id);
        $categories = ExpenseCategories::select('id', 'name')->get();
        return view('backEnd.expense.edit', compact('edit_data', 'categories'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);
        $update_data = Expense::find($request->id);
        $input = $request->all();

        $input['status'] = $request->status ? 1 : 0;

        $update_data->update($input);

        Toastr::success('Success', 'Data update successfully');
        return redirect()->route('expense.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Expense::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Expense::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Expense::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
}
