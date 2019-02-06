<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Category;
use App\Http\Start\Helpers;
use Session;
use Input;
use DB;
use Validator;

class IncomeExpenseCategoryController extends Controller
{
    public function __construct(){

    }
    /**
     * Display a listing of the Category.
     *
     * @return Category List page view
     */
    public function index()
    {
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'general';
        $data['list_menu'] = 'income-expense-category';
        $data['types']     = array('income'=>'Income','expense'=>'Expense');
        $data['categoryList'] = DB::table('income_expense_categories')->orderBy('name','asc')->get();
        
        return view('admin.IncomeExpenseCategory.category_list', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
        ]);

        $data['name'] = $request->name;
        $data['type'] = $request->type;
        DB::table('income_expense_categories')->insert($data);

        Session::flash('success',trans('message.success.save_success'));
        return redirect()->intended('income-expense-category/list');

    }

    public function edit()
    {
        $id = $_POST['id'];

        $categoryData = DB::table('income_expense_categories')->where('id',$id)->first();

        $return_arr['name'] = $categoryData->name;
        $return_arr['type'] = $categoryData->type;
        $return_arr['id'] = $categoryData->id;

        echo json_encode($return_arr);
    }

    public function update(Request $request)
    {    
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required'
        ]);

        $id = $request->id;
        $data['name'] = $request->name;
        $data['type'] = $request->type;
        DB::table('income_expense_categories')->where('id',$id)->update($data);
        
        Session::flash('success',trans('message.success.update_success'));
        return redirect()->intended('income-expense-category/list');
    }


    public function destroy($id)
    {
        if (isset($id)) {
            DB::table('income_expense_categories')->where('id', '=', $id)->delete();
            Session::flash('success',trans('message.success.delete_success'));
            return redirect()->intended('income-expense-category/list');
        }
    }
}
