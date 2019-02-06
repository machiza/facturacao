<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Artisan;
use Auth;
use Session;
use DB;

class CronController extends Controller
{
    
	 public function index()
    { 

		Artisan::call('db:seed');
		return 'done';

   	} 	

    public function setup()
    { 
    
		/*
		$user = array(
                'email'=>'demo@n3.co.mz',
                'password'=>'$2y$10$GbgX0Z2DGHOJIWAkFbkXaOPGH1Fu8QBqktctseholx3RLlKHGM/Y6',
                'real_name'=>'Admin',
                'role_id'=>1,
                'inactive'=>0,
                'remember_token'=>'XbPj4olmc87dlLBoQL2e3v9LJc23EEnoRAI5Pfv8MnGEUFq0ZYpaZAd5JuaW'
        );
      
			DB::table('users')->insert($user);
		*/

		$permissao=DB::select('select * from permissions where name=:nome',['nome'=>'update_version']);
    	if($permissao==null){
    		DB::insert('insert into permissions (id, name,display_name,description ) values (?, ?,?,?)', [114, 'update_version','Update version','Update version']);
    		DB::insert('insert into permission_role (permission_id, role_id) values (?, ?)', [114, 1]);	
		
		}

		$versao=DB::select('select * from preference where  value=:valor ',['valor'=>'1.1.11']);
		if($versao==null){
						
			DB::table('migrations')->truncate();
			Artisan::call('migrate');

			$total= DB::table('preference')->whereBetween('id', [21, 22])->delete();

			DB::insert('insert into preference (id, category,field,value ) values (?, ?,?,?)', [21, 'preference','version','1.1.11']);

			DB::insert('insert into preference (id, category,field,value ) values (?, ?,?,?)', [22, 'preference','date_version','2019']);

			// condicao deve ser executada para versoes antigas
			if(2!=2)
			   {
				
				DB::update("update cust_branch set billing_country_id = 'MZ' where cust_branch.branch_code > ?", [0]);	

				DB::table('sales_order_details')
				->whereNull('tipo_operacao')
				->update(['tipo_operacao' => '']);

				//update CC table
				$contas=DB::table('sales_cc')
				->select('sales_cc.*')->get();

				foreach($contas as $dados){
					$linha=explode('-',$dados->reference_doc);
				if($linha[0]=='NC'){
					DB::table('sales_cc')->where('idcc', $dados->idcc)->update(['debito_credito' => 0]);
				}else{
					DB::table('sales_cc')->where('idcc', $dados->idcc)->update(['debito_credito' => 1]);
				}
				if($linha[0]=='RE'){
					DB::table('sales_cc')->where('idcc', $dados->idcc)->update(['payment_type_id_doc' => 2]);
				}
			  }

			}


			Auth::logout();

			\Session::flash('success',trans('Actualizado com suesso para a versao 1.1.10'));
			return redirect()->intended('update/version');


		}else{

			\Session::flash('success',trans('versao ja actualizada 1.1.10'));
				return redirect()->intended('update/version');
				
	}				


}

	
    public function update_version()
    { 
    	$data['menu'] = 'setting';
        $data['sub_menu'] = 'general';
        $data['list_menu'] = 'update_version';
        $data['emailConfigData'] = DB::table('email_config')->first();
        return view('admin.setting.updateSystem',$data);
    
	}


	
	public function force_quick()
    {
	  //DB::delete('delete * from permissions where id=:codigo and id=:codigo1',['codigo'=>'21','codigo1'=>'22']);
      $total= DB::table('preference')->whereBetween('id', [21, 22])->delete();
	  return $this->setup();
	}

	public function force()
    { 

		$contas=DB::table('sales_cc')
		         ->select('sales_cc.*')->get();


		foreach($contas as $dados){
		  
		    $linha=explode('-',$dados->reference_doc);

			if($linha[0]=='NC'){
				DB::table('sales_cc')->where('idcc', $dados->idcc)->update(['debito_credito' => 0]);
			}else{
				DB::table('sales_cc')->where('idcc', $dados->idcc)->update(['debito_credito' => 1]);
			}
			
		}
	
		\Session::flash('success',trans('Actualizado com suesso para a versao 1.1.10'));
		 return redirect()->intended('update/version');
    }


    



}
