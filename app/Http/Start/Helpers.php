<?php

namespace App\Http\Start;

use View;
use Session;
use App\Models\Permission;
use App\Models\Role_user;
use App\Models\Permission_role;
use DB;
class Helpers
{

	public static function has_permission($user_id, $permissions = '')
	{
		$permissions = explode('|', $permissions);
		$user_permissions = DB::table('permissions')->whereIn('name', $permissions)->get();
		$permission_id = [];
		$i = 0;
		foreach ($user_permissions as $value) {
			$permission_id[$i++] = $value->id;
		}
		$role = DB::table('role_user')->where('user_id', $user_id)->first();

		if(count($permission_id) && isset($role->role_id)){
			$has_permit = DB::table('permission_role')->where('role_id', $role->role_id)->whereIn('permission_id', $permission_id);
			return $has_permit->count();
		}
		else return 0;
	}

}
