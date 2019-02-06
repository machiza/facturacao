<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Role;
use App\Http\Start\Helpers;
use Validator;
use DB;
use Session;

class RoleController extends Controller
{
    public function __construct(){

    }

    public function index()
    {
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'company';
        $data['list_menu'] = 'role';
        $data['roleData'] = DB::table('roles')->get();

        return view('admin.role.role', $data);
    }

    public function create()
    {
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'company';
        $data['list_menu'] = 'role';
        $data['permissions'] = DB::table('permissions')->get();
        return view('admin.role.role_add', $data);
    }


    public function store(Request $request)
    {
            $rules = array(
                    'name'         => 'required|unique:roles',
                    'display_name' => 'required',
                    'description'  => 'required'
                    );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) 
            {
                return back()->withErrors($validator)->withInput();
            }
            else
            {
                $role['name'] = $request->name;
                $role['display_name'] = $request->display_name;
                $role['description'] = $request->description;
                $roleId = DB::table('roles')->insertGetId($role);
                
                if($request->permission)
                    foreach ($request->permission as $key => $value) {
                        DB::table('permission_role')->insert(['permission_id' => $value, 'role_id' => $roleId]);
                    }
                Session::flash('message','Information added successfully');
                return redirect('role/list');
            }        
    }

    public function edit($id)
    {
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'company';
        $data['list_menu'] = 'role';
        $data['role'] = DB::table('roles')->where('id',$id)->first();
        
        $data['permissions'] = DB::table('permissions')->get();
        $data['stored_permissions'] = DB::table('permission_role')->where('role_id',$id)->pluck('permission_id');
        return view('admin.role.role_edit', $data);
    }


    public function update(Request $request)
    {
           
            $rules = array(
                    'name'         => 'required|unique:roles,name,'.$request->id,
                    'display_name' => 'required',
                    'description'  => 'required'
                    );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) 
            {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            }
            else
            {
                $role['name'] = $request->name;
                $role['display_name'] = $request->display_name;
                $role['description'] = $request->description;
                DB::table('roles')->where('id',$request->id)->update($role);

                $stored_permissions = DB::table('permission_role')->where('role_id',$request->id)->pluck('permission_id');
                $permission = isset($request->permission) ? $request->permission : [];
                if(!empty($stored_permissions)){
                    foreach ($stored_permissions as $key => $value) {
                        if(!in_array($value, $permission))
                            DB::table('permission_role')->where(['permission_id' => $value, 'role_id' => $request->id])->delete();
                     
                    }
                }
                if(!empty($permission)){
                    foreach ($permission as $key => $value) {
                        if(!in_array($value, $stored_permissions)){
                            DB::table('permission_role')->insert(['permission_id' => $value, 'role_id' => $request->id]);
                            }
                    }
                }

                return redirect('role/list');
            }

        \Session::flash('success',trans('message.success.update_success'));
         return redirect('role/list');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        DB::table('roles')->where(['id'=>$id])->delete();
        DB::table('permission_role')->where(['role_id'=>$id])->delete();
        Session::flash('success',trans('message.success.delete_success'));
        return redirect()->intended('role/list');

    }
}