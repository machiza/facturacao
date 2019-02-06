<?php

namespace App\Http\Controllers;

//Hugo
if(isset($_POST["btn_pagar"])){
    require_once './conexao.php';
    
    $referencia = $_POST["invoice_reference"];
    $amount = $_POST ["amount"];

    $sql = "Select * from sales_orders where reference = '$referencia'";
    $comando = $pdo->prepare($sql);
    $comando->execute();
    $t = $comando->fetch();
    $saldo_default = $t["paid_amount"];

if($saldo_default = 0){

    //update pending:
    $sql_paid_doc = "update sales_pending set amount_paid_pending = :paid where reference_pending = :ref_paid";
    $comando_paid_doc = $pdo->prepare($sql_paid_doc);
    $comando_paid_doc->bindParam(":paid", $amount);
    $comando_paid_doc->bindParam(':ref_paid', $referencia);
    $comando_paid_doc->execute();
    //end pending
}else{
    $factura = $t["total"];
    $total_paid_amount = $t ["paid_amount"];

    $new_total_paid_amount = $total_paid_amount + $amount;
    $saldo = $factura - $new_total_paid_amount;

    //update pending:
    $sql_paid_doc = "update sales_pending set amount_paid_pending = :paid where reference_pending = :ref_paid";
    $comando_paid_doc = $pdo->prepare($sql_paid_doc);
    $comando_paid_doc->bindParam(":paid", $new_total_paid_amount);
    $comando_paid_doc->bindParam(':ref_paid', $referencia);
    $comando_paid_doc->execute();
    //end pending  
}
    //update cc:
    //$ref_ord = $_POST["order_no"];
    $sql_saldo_doc = "update sales_cc set saldo_doc = :saldo where reference_doc = :ref_doc";
    $comando_saldo_doc = $pdo->prepare($sql_saldo_doc);
    $comando_saldo_doc->bindParam(":saldo", $saldo);
    $comando_saldo_doc->bindParam(':ref_doc', $referencia);
    $comando_saldo_doc->execute();
    //end cc
}//fim


use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Model\Payment;
use App\Model\Shipment;
use Validator;
use DB;
use Session;
use Auth;
use PDF;
use App\Http\Start\Helpers;



class PaymentController extends Controller
{

    public function __construct(Auth $auth, Payment $payment,Shipment $shipment,EmailController $email){
          $this->middleware('auth');
          $this->auth = $auth::user(); 
          $this->payment = $payment; 
          $this->shipment = $shipment;
          $this->email = $email;
    }

   /**
    * Payment list
    */
    public function index(){
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'payment/list';
        $data['paymentList'] = DB::table('sales_cc')
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_cc.debtor_no_doc')
                             ->leftjoin('payment_terms','payment_terms.id','=','sales_cc.payment_type_id_doc')
                             ->leftjoin('sales_orders','sales_orders.reference','=','sales_cc.reference_doc')
                             //->leftjoin('payment_history','payment_history.reference','=','sales_cc.reference_doc')
                             ->select('sales_cc.*','debtors_master.name','payment_terms.name as pay_type','sales_orders.order_no as invoice_id','sales_orders.order_reference_id as order_id')
                             ->orderBy('sales_cc.idcc','DESC')->where('payment_type_id_doc','2')
                             ->get();

        $data['accounts'] = DB::table('bank_accounts')->where(['deleted'=>0])->pluck('account_name','id');
        $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','income')
                                    ->pluck('name','id'); 


        return view('admin.payment.paymentList', $data);     
    }

   /**
    * Payment list
    */
    public function paymentFiltering(){
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'payment/list';
        $data['customer'] = $customer = isset($_GET['customer']) ? $_GET['customer'] : NULL;
        $data['method'] = $method = isset($_GET['method']) ? $_GET['method'] : NULL;
        
        $data['customerList'] = DB::table('debtors_master')->select('debtor_no','name')->where(['inactive'=>0])->get();
        $data['methodList'] = DB::table('payment_terms')->select('id','name')->get();

        $fromDate = DB::table('payment_history')->select('payment_date')->orderBy('payment_date','asc')->first();
        
        if(isset($_GET['from'])){
            $data['from'] = $from = $_GET['from'];
        }else{
           $data['from'] = $from = isset($fromDate->payment_date) ? formatDate(date("d-m-Y", strtotime($fromDate->payment_date))) : date('d-m-Y'); 
        }
        
        if(isset($_GET['to'])){
            $data['to'] = $to = $_GET['to'];
        }else{
            $data['to'] = $to = formatDate(date('d-m-Y'));
        }

        $data['paymentList'] = $this->payment->paymentFilter($from, $to, $customer, $method);
        return view('admin.payment.filterPaymentList', $data);     
    }

    /**
     * Create new payment.
     *
     */
    public function createPayment(Request $request)
    {

      

        $this->validate($request, [
            'account_no'=>'required',
            'payment_type_id' => 'required',
            'category_id'=>'required',
            'amount' => 'required|numeric',
            'payment_date'=>'required',
            'description' =>'required'
        ]);

        // Transaction Table
        $data['account_no'] = $request->account_no;
        $data['trans_date'] = DbDateFormat($request->payment_date);
        $data['description'] = $request->description;
        $data['amount'] = abs($request->amount);
        $data['category_id'] = $request->category_id;
        $data['person_id'] = $this->auth->id;
        $data['trans_type'] = 'cash-in-by-sale';
        $data['payment_method'] = $request->payment_type_id;
        $data['created_at'] = date("Y-m-d H:i:s");
        $transactionId = DB::table('bank_trans')->insertGetId($data);

        // Payment Table
        $payment['transaction_id'] = $transactionId;
        $payment['invoice_reference'] = $request->invoice_reference;
        $payment['order_reference'] = $request->order_reference;
        $payment['payment_type_id'] = $request->payment_type_id;
        $payment['amount'] =  abs($request->amount);
        $payment['payment_date'] = DbDateFormat($request->payment_date);
        $payment['reference'] =  $request->idrecibo; 
        $payment['person_id'] = $this->auth->id;
        $payment['customer_id'] = $request->customer_id; 
        
        $orderNo = $request->order_no;
        $invoiceNo = $request->invoice_no; 
        $payment = DB::table('payment_history')->insertGetId($payment);

        
        //Start CC
        require './conexao.php';
        
        $doc = $_POST['invoice_reference'];
        $parte_ord_doc = $_POST["invoice_no"];
        $parte_ord = $_POST["order_reference"];
        $id = $_POST['customer_id'];
        $reference = $_POST['idrecibo'];
        $account_no = $_POST['account_no'];
        $payment_method = $_POST['payment_type_id'];
        $category_id = $_POST['category_id'];
        $ttl_paid = $_POST["amount"];
        $trans_date = $_POST['payment_date'];

        $data1 = substr($trans_date, 0, 2);
        $data2 = substr($trans_date, 3, 2);
        $data3 = substr($trans_date, 6, 4);
        if($data1 > 10){
            $data_final = $data3."-". + $data2."-". + $data1; 
        }else{
            $data_final = $data3."-". + $data2."-0". + $data1;
        }

          $entra = "1";
          $insert_rec = "insert into sales_cc (debtor_no_doc, order_no_doc, rec_no_doc, reference_doc, order_reference_doc, amount_credito_doc, payment_type_id_doc, debito_credito, ord_date_doc) values (:debtor_no_doc, :order_no_doc, :rec_no_doc, :reference_doc, :order_reference_doc, :amount_credito_doc, :payment_type_id_doc, :entra, :ord_date_doc)";
          $comando_update_rec = $pdo->prepare($insert_rec);
          $comando_update_rec->bindParam(":debtor_no_doc", $id);//customer
          $comando_update_rec->bindParam(":order_no_doc", $parte_ord_doc);//order_no_doc
          $comando_update_rec->bindParam(":rec_no_doc", $payment);
          $comando_update_rec->bindParam(":reference_doc", $reference);//recibo
          $comando_update_rec->bindParam(":order_reference_doc", $parte_ord);//cot
          $comando_update_rec->bindParam(":amount_credito_doc", $ttl_paid);//total pago
          $comando_update_rec->bindParam(":payment_type_id_doc", $payment_method);//new
           $comando_update_rec->bindParam(":entra", $entra);//entra
          $comando_update_rec->bindParam(":ord_date_doc", $data_final);//data
          if($comando_update_rec->execute()){
              if (!empty($payment)) {
                $paidAmount = $this->payment->updatePayment($request->invoice_reference,$request->amount);
                \Session::flash('success',trans('message.success.save_success'));
                return redirect()->intended('invoice/view-detail-invoice/'.$orderNo.'/'.$invoiceNo);
              }   
          }//END CC
    }

    public function newpayment(){
      $data['menu'] = 'sales';
      $data['sub_menu'] = 'payment/new_payment';
      $data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0,'status_debtor'=>'activo'])->Orwhere(['inactive'=>0,'status_debtor'=>''])->get();
      $data['accounts'] = DB::table('bank_accounts')->where(['deleted'=>0])->pluck('account_name','id');
      $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','income')
                                    ->pluck('name','id');
      $data['payments'] = DB::table('payment_terms')->get();
      $data['paymentTerms'] = DB::table('invoice_payment_terms')->get();

      $invoice_count = DB::table('sales_orders')->where('trans_type',SALESINVOICE)->count();
        
      $data['salesType'] = DB::table('sales_types')->select('sales_type','id')->get();

      $invoice_count = DB::table('payment_history')->count();
      if($invoice_count>0){
        $invoiceReference = DB::table('payment_history')->select('reference')->orderBy('id','DESC')->first();

        $ref = explode("-",$invoiceReference->reference);
        $data['invoice_count'] = (int) $ref[1];
      }else{
            $data['invoice_count'] = 0 ;
      }

      return view('admin.payment.paymentNew', $data);
    }

    
    
  
    public function getInvoices(){ 

        require './conexao.php';

        //$sql = "Select * from sales_cc where debtor_no_doc = '" . $_POST["debtor_no"] . "' AND amount_doc <> 0 AND saldo_doc <> 0 and status <> 'cancelado' ";

        $sql = "Select * from sales_cc where debtor_no_doc = '" . $_POST["debtor_no"] . "' AND amount_doc <> 0 AND saldo_doc <> 0 and status <> 'cancelado'";
        $comando = $pdo->prepare($sql);
        $comando->execute();
        $row = $comando->rowCount();
        $rows = 0;
        if($row > 2){
           $rows = $row - 3;
           //echo "Nr linhas if1: ".$rows."<br><br>";
        }else if($row == 2){
          $rows = $row - 2;
          //echo "Nr linhas if2: ".$rows."<br><br>";
        }else{
          $rows = $row - 1;
          //echo "Nr linhas else: ".$rows."<br><br>";
        }

        for($i=0; $i<$row; $i++){
            //echo $i."is: <br>";
        }

        if($row >= 1){
            //echo "<p id='docs'>Seleciona as Facturas a Pagar</p>";
            echo 
            "<div class='table-responsive'>
                <table class='table table-bordered' id='table'>
                  <thead>
                    <tr class='tbl_header_color dynamicRows'>
                    <th width='20%' class='text-center'>".trans('message.accounting.docs')."</th>
                    <th width='20%' class='text-center'>".trans('message.accounting.data') ."</th>
                    <th width='20% class='text-center'>".trans('message.table.total_price') ."</th>
                    <th width='20% class='text-center'>".trans('message.table.balance_amount') ."</th>
                    <th width='20% class='text-center'>".trans('message.quotation.amount') ."</th>

                    </tr>
                  </thead>
                  <tbody>";
                    while ($rs = $comando->fetch()){
                      $id = $rs ["order_no_doc"];
                      $ref = $rs ["reference_doc"]; $ref_order = $rs ["order_reference_doc"];
                      $data = $rs ["ord_date_doc"];
                      $total = $rs ["amount_doc"];
                      $paid = $total - $rs ["saldo_doc"];
                      $saldo = $total - $paid;

                      $row_final = $rows++; //echo $row_final.": rows final";
                      $idSpan=$row_final.'a';

                      //$row_final2 = $rows; $rows_doc = $row_final2 - 1; //echo $rows_doc.'doc';

                      echo "<style>
                              #idsaldo{
                                 border: none;
                                 background-color: white;
                             }
                            </style>";
                      echo 
                      "<br>
                      ";
                      $lop=explode('-', $ref);

                     

                      echo "<tr style='text-align: center;'>";
                     
                    
                          echo "
                          <td>";
                          if($lop[0]=='NC'){
                            echo "<div style='color:red'>
                                      <label style='font-weight: normal; cursor: pointer;' >
                                            <input type='checkbox' value='Payment for $ref $ref_order $id' name='invoice_reference[]' class='factura checkitem'>
                                              $ref
                                      </label>
                                </div>
                                ";
                            }else{
                                echo "
                                <label style='font-weight: normal; cursor: pointer;' >
                                      <input type='checkbox' value='Payment for $ref $ref_order $id' name='invoice_reference[]' class='factura checkitem'>
                                        $ref
                                </label>
                                ";
                            }echo "
                                
                          </td>  

                          <td>";
                              if($lop[0]=='NC'){
                                 echo "<div style='color:red'> $data </div>
                                ";
                              }else{
                                echo $data;
                              }echo "  
                          </td>";
                          if($lop[0]=='NC'){ echo "
                              <td style='color:red'>".Session::get('currency_symbol').number_format($total,2)."</td>
                           ";}else{ echo "
                             <td>".Session::get('currency_symbol').number_format($total,2)."</td>
                           ";
                           }echo " 

                          <td>";if($lop[0]=='NC'){ echo " <div style='color:red'>
                             <input id='idsaldo' name='sald' value='".Session::get('currency_symbol').number_format($saldo,2)."' disabled> </div>";
                              }else{
                               echo " <input id='idsaldo' name='sald' value='".Session::get('currency_symbol').number_format($saldo,2)."' disabled>";
                              }echo "
                          </td>


                          <td>
                             <input type='number' step='1.0' min='1'name='amount[]' class='valor_a_pagar'  id='".$row_final."' 
                       placeholder='".trans('message.quotation.amount_to_pay') ."' onkeyup='tallyValues()' disabled>
                        <span style='color:red;' class='limite' id='".$idSpan."' hidden>Limite Excedido!</span>
                          </td>
                      </tr>";

                    }echo "<tr>
                            <td style='text-align:center'>
                              <label style='font-weight: normal; cursor: pointer;' >
                                <input type='checkbox' name='marcar_todos' id='checkall'/>".trans('message.quotation.Select_All') ."
                              </label>
                            </td>
                            <td colspan='3' style='text-align:Right; font-weight: bold'>".trans('message.quotation.total_amount_to_pay') .":
                            </td>
                            <td style='text-align:center'><input type='number' name='ttl_paid' id='totalcost' readonly></td>
                          </tr>";
                  echo
                  "</tbody>
                </table>
            </div>";

              // codigo para chamar o modal        
        echo "
                 <div class='modal fade' id='confirmacao_pagamento' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
            <div class='modal-dialog' role='document'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>×</span></button>
                  <h4 class='modal-title' id='myModalLabel'>Confirmação de Pagamento</h4>
                </div>

                  <div class='modal-body'>
                      <div  class='row'>
                          <div  class='col-md-6'>
                              <div class='form-group'>
                                  <label class='control-label' for='title'>Referencia do Documento</label>
                                  <div id='conteudoModal'>  
                                  
                                  </div>
                              </div>
                          </div>   

                           <div  class='col-md-6'>
                              <div class='form-group'>
                                   <label class='control-label' for='title'>Valor a Pagar:</label>
                                  <div id='conteudoModal2'>  
                                  
                                  </div>
                              </div>
                          </div>          
                      </div><!-- row -->
                  </div><!-- modal body -->
                
            <div class='box-footer'>
                <div class='form-group'>
                  <button type='button' class='btn btn-default pull-left' data-dismiss='modal'>Cancelar</button>
                   <button type='submit' class='btn crud-submit btn-primary pull-right'>Comfirmo</button>
                </div>  
              </div>
            </div>
          </div>
       </div>    
        ";

      
      
            echo
            "<script>

              function retornaValorFloat1(str){ 
                //var str = 'MT 1,834,343.43';
                var ParteSegunda = str.split('.')[1];
                var primeiraParte= str.split('.',1);
                var string=''+primeiraParte;
                var valorPrimeiro = string.replace(/[^0-9]/g,'');

                var segunda='0.'+ParteSegunda;

                var valorFinal=parseFloat(valorPrimeiro)+parseFloat(segunda);
                //alert('o valor final eh '+valorFinal);
                return valorFinal;
              }


              function notacredito(str){ 
                //var str = 'NC-0002/2018';
                var valorPrimeiro = str.replace(/[^0-9]/g,'');
                var ParteSegunda = valorPrimeiro.split(' ');
                
                 
                 // var primeiraParte1= str.replace('/[^0-9]/g','');
                  var primeiraParte1= str.replace(/^\s+|\s+$/g,'');
                   var primeiraParte= primeiraParte1.split('-',1);

                 // var ParteSegunda1 = primeiraParte.split('');  
                  //var string=''+primeiraParte;

                  //var segunda='0.'+ParteSegunda;

                  return primeiraParte;
              }




              $('.valor_a_pagar').keyup(function() {
                 // tallyValues();
                
              
               // var x =currentRow.find('.valor_a_pagar').val();
                //x.value = x.value.toUpperCase();


              });


              $('#checkall').change(function(){

                var linhaCorrente=$(this).closest('tr');  
                  $('.checkitem').prop('checked', $(this).prop('checked'))
                  colocarTodosValores();
                  Desconto();
              
                  if($(this).prop('checked')==false){
                      
                       limpar();
                       $('#verificarLimite').val('false');
                       $('.limite').prop('hidden', true);
                  }else{
                     tallyValues();
                     verificarLimite();
                  }

              })


              $('.checkitem').change(function(){

                var linhaCorrente=$(this).closest('tr');              
                  if($(this).prop('checked')==false){ 
                    linhaCorrente.find('.valor_a_pagar').prop('disabled',true); 
                    $('#checkall').prop('checked', false)
                    var currentRow=$(this).closest('tr'); 
                     currentRow.find('.valor_a_pagar').val('');
                     var idSpan=currentRow.find('span').attr('id');
                    $('#'+idSpan).prop('hidden',true);
                  }

                  if($(this).prop('checked')==true){
                    
                    //valor total colocando para a confirmacao
                    $('#total').val($('#totalcost').val());
                    $('#checkall').prop('checked', false)
                    linhaCorrente.find('.valor_a_pagar').prop('disabled',false); 
                        var currentRow=$(this).closest('tr'); 
                        var saldo = currentRow.find('input[name=sald]').val();


                        //Feito1
                       // var preco = currentRow.find('td').eq(3).text(); 
                        //alert('o saldo eh' +saldo);
                        //alert('o novo saldo eh===> ' +retornaValorFloat1(saldo));
                        // var str = saldo;
                        //var res = str.split('$');
                       // var res = str.split('Mt');
                        //res1=res[1].split(',');
                        

                         /*
                         var resultado=parseFloat(res[2]);
                         alert('o tamanho do valor sem sifrao eh '+res1.length);

                          if(res1.length==1){
                             total= res1[0];
                          }else{
                            for(var i=0;i<res1.length;i++){
                              total=total+res1[i];
                            }
                          }
                       */
                       

                       // var resultado=parseInt(res[2]);
                        //var total= res1[0]+res1[1];
                         //currentRow.find('input[name=amount]').val(total);
                        //total=saldo
                         // debito=parseInt(total);  

                        var total='';
                        total=retornaValorFloat1(saldo).toFixed(2);

                        

                        currentRow.find('.valor_a_pagar').val(total);
                      
                           
                  }

                   if($('.checkitem:checked').length == $('.checkitem').length){
                    $('#checkall').prop('checked', true) 
                  }
                    if($('.checkitem:checked').length==0)
                    {
                      $('#verificarLimite').val('false');
                    }
                  tallyValues();
                   verificarLimite();
          });


              
                    function tallyValues(){
                    // Set the amount to start at 0
                    var amount = 0;

                    // Loop through each dom element
                   $('tbody tr').each(function(i, val){

                    // Find the previous sibling (td) and then find the input inside and see if it's checked
                    var currentRow=$(this);

                    var checkbox_cell_is_checked =currentRow.find('.factura').is(':checked');

                    // Is it checked?
                    if(checkbox_cell_is_checked){
                      
                    var valor=currentRow.find('.valor_a_pagar').val();
                    //amount=amount+1;
                        amount += parseFloat(valor);

                        
                       // $('#total').val(amount);
                        document.getElementById('total').value = amount.toFixed(2);
                    }

                    });

                    // Output the amount
                   // alert(amount);
                    
                    var valorCredito= Desconto()*2;

                   // alert('o valor do credito eh '+valorCredito);

                    var ValorTotal=amount-valorCredito;
                    $('#total').val(ValorTotal);
                    $('#totalcost').val(ValorTotal);
                }    


                //funcao para limpar o as checkbox
                function limpar(){
                   
                    // Loop through each dom element
                   $('tbody tr').each(function(i, val){

                    // Find the previous sibling (td) and then find the input inside and see if it's checked
                    var currentRow=$(this);

                     currentRow.find('.valor_a_pagar').prop('disabled', true);
                    var checkbox_cell_is_checked =currentRow.find('.factura').is(':checked');

                    // Is it checked?
                    if(!checkbox_cell_is_checked){
                      //currentRow.find('input[name=amount]').val('');
                      currentRow.find('.valor_a_pagar').val('');
                      
                    }
                      $('#totalcost').val(0);

                      console.log('limpar os valores das caixas de texto');
                    });                  
                }



                function colocarTodosValores(){

                  $('tbody tr').each(function(i, val){
                    
                    var currentRow=$(this);
                    var checkbox_cell_is_checked =currentRow.find('.factura').is(':checked');
                    
                    if(checkbox_cell_is_checked){
                      currentRow.find('.valor_a_pagar').prop('disabled', false);

                        var currentRow=$(this).closest('tr'); 
                        var saldo = currentRow.find('input[name=sald]').val();

                        var preco = currentRow.find('td').eq(3).text(); 

                        //Feito3
                        //alert('o saldo eh' +saldo); 
                        //var str = saldo;
                        //var res = str.split('$');
                        //var res = str.split('MT');

                        //res1=res[1].split(',');
                        
                        //alert('a separacao foi de '+res);


                        var total='';
                        total=retornaValorFloat1(saldo).toFixed(2);

                        // var resultado=parseFloat(res[2]);
                        //alert('o tamanho do valor sem sifrao eh '+res1.length);
                        /*if(res1.length==1){
                           total= res1[0];
                          }
                          else{
                              for(var i=0;i<res1.length;i++){
                                total=total+res1[i];
                          }
                        }
                        */

                        currentRow.find('.valor_a_pagar').val(total);
                    
                    }
                      console.log('limpar os valores');
                    });            
                }


                    function Desconto(){

                    // Set the amount to start at 0
                    var amount = 0;

                    // Loop through each dom element
                    $('tbody tr').each(function(i, val){

                    // Find the previous sibling (td) and then find the input inside and see if it's checked
                    var currentRow=$(this);

                    var checkbox_cell_is_checked =currentRow.find('.factura').is(':checked');

                    // Is it checked?
                    if(checkbox_cell_is_checked){

                    var valor=currentRow.find('.valor_a_pagar').val();

                    var col1=currentRow.find('td:eq(0)').text();

                   

                    
                    if(notacredito(col1)=='NC'){
                      
                      //amount=amount+1;
                    amount += parseFloat(valor);
                     // alert('notaCredito Encontrada'+notacredito(col1));
                    
                    }
                    // $('#total').val(amount);
                      document.getElementById('total').value = amount.toFixed(2);
                    }

                    });
                     
                    return amount;
                    
                }    

              


               $('.valor_a_pagar').keyup(function(){ 
                  var currentRow=$(this).closest('tr');

                        var saldo = currentRow.find('input[name=sald]').val();

                       // var preco = currentRow.find('td').eq(3).text(); 
                      //alert('o saldo eh' +saldo);


                      //  Feito4
                        //var str = saldo;
                        //var res = str.split('$');
                       // var res = str.split('MT');

                       // res1=res[1].split(',');
                        //leia 2
                        
                        
                        var total='';
                        total=retornaValorFloat1(saldo);
                        // var resultado=parseFloat(res[2]);
                        //alert('o tamanho do valor sem sifrao eh '+res1.length);
                            /*if(res1.length==1){
                               total= res1[0];
                              }
                              else{
                                  for(var i=0;i<res1.length;i++){
                                    total=total+res1[i];
                              }
                            
                        }
                       */
                  var valor_a_pagar=parseFloat($(this).closest('tr').find('.valor_a_pagar').val());
                  
                 if(valor_a_pagar>parseFloat(total)){
                    //Fora do limite
                      var idSpan=currentRow.find('span').attr('id');
                     $('#'+idSpan).prop('hidden',false);
                  }

                  else if (valor_a_pagar>0 && valor_a_pagar<=parseFloat(total)){
                    //Dentro do limite
                   var idSpan=currentRow.find('span').attr('id');
                    $('#'+idSpan).prop('hidden',true);
                  }
                  verificarLimite();

              });


        
        // funcao para chamar model
         //chamando o modal
                    $('.btnSubmitk').click(function(e){
                          e.preventDefault();
                           
                            var rows = '';
                            var rows1 = '';
                             
                              $('tbody tr').each(function(i, val){
                              var currentRow=$(this);
                              var checkbox_cell_is_checked =currentRow.find('.factura').is(':checked');

                              if(checkbox_cell_is_checked){

                                  var currentRow=$(this).closest('tr'); 

                                  var preco = currentRow.find('td').eq(0).text();    
                                  var valorApagar =currentRow.find('.valor_a_pagar').val();
                                                                       
                                   rows=rows+'<label>'+preco+'</label></br>';
                                   rows1=rows1+'<label>'+valorApagar+'</label></br>';

                                }
                          });    
                          $('#conteudoModal').html(rows);
                          $('#conteudoModal2').html(rows1);
                          $('#confirmacao_pagamento').modal('show');
                    });
                    
                     function verificarLimite(){
                  $('tbody tr').each(function(i, val){
                    var currentRow=$(this);
                      var checkbox_cell_is_checked =currentRow.find('.factura').is(':checked');

                    if(checkbox_cell_is_checked){
                     var currentRow=$(this).closest('tr'); 
                        var saldo = currentRow.find('input[name=sald]').val();
                        var valorP= parseFloat(currentRow.find('.valor_a_pagar').val());
                        var str = saldo;
                        

                       // Feito2
                       //var res = str.split('$');
                       // var res = str.split('Mt');
                       // res1=res[1].split(',');

                        
                       // alert('the valor '+res);

                      
                          var total='';
                        total=retornaValorFloat1(saldo).toFixed(2);;
                      
                        // var resultado=parseFloat(res[2]);
                        //alert('o tamanho do valor sem sifrao eh '+res1.length);
                        /*if(res1.length==1){
                           total= res1[0];
                          }
                          else{
                              for(var i=0;i<res1.length;i++){
                                total=total+res1[i];
                          }
                        
                        }*/


                        var debito=parseFloat(total);

                       if(valorP>debito)
                        {
                          //fora do limite
                          $('#verificarLimite').val('false');
                          console.log('Fora do limite: '+valorP+'>'+debito);
                          console.log('EstadoLimite: '+$('#verificarLimite').val());
                          console.log('status: '+$('#status').val());
                          return false;

                        }
                       else if(valorP>0 && valorP<=debito)
                        {
                          //dentro do limite
                          $('#verificarLimite').val('true');
                          console.log('dentro do limite: '+valorP+'<='+debito);
                          console.log('EstadoLimite: '+$('#verificarLimite').val());
                          console.log('status: '+$('#status').val());

                        }
                    }
                    });            
                }
      </script>";

        }else{
          echo 
          "<div class='table-responsive'>
                <table class='table table-bordered'>
                  <thead>
                    <tr class='tbl_header_color dynamicRows'>
                    <th width='30%' class='text-center'>".trans('message.accounting.docs')."</th>
                    <th width='10%' class='text-center'>".trans('message.accounting.data') ."</th>
                    <th width='10% class='text-center'>".trans('message.table.total_price') ."</th>
                    <th width='10% class='text-center'>".trans('message.table.balance_amount') ."</th>
                    <th width='20% class='text-center'>".trans('message.quotation.amount') ."</th>
                  </tr>
                  </thead>
                  <tbody>";
                  echo "<tr>
                         <td colspan='5' style='color: red; text-align: center;'>". trans('message.form.no_invoice') ."</td>
                        </tr>";
                  echo
                  "</tbody>
                </table>
          </div>";
        }
        
        echo
        "<script>
            function soma(){
              var sum = 0;
              var id, elem, valor;
              for (i=0; i<$row; i++) {
                id = i;
                if(document.getElementById(id)!=null){
                elem = document.getElementById(id);
                valor=Number(elem.value);
                sum += valor;
                }
              } 
               $('#total').val(sum); 
               $('#totalcost').val(sum); 
              //document.getElementById('totalcost').value = sum.toFixed(2);
            }
        </script>";
    }    



    public function createNewPayment(Request $request){

       $somaNotacredito=0; 
       $somaDebitoFactura=0; 

       $userId = \Auth::user()->id;
      $this->validate($request, [
            'account_no'=>'required',
            'payment_type_id' => 'required',
            'category_id'=>'required',
            //'amount' => 'required|numeric',
            'payment_date'=>'required',
            'debtor_no' =>'required',
            'invoice_reference' => 'required'
        ]);

        require './conexao.php';
        
        $doc = $_POST['invoice_reference'];
        $amount = $_POST['amount'];

        $id = $_POST['debtor_no'];
        $account_no = $_POST['account_no'];
        $trans_date = $_POST['payment_date'];
        $category_id = $_POST['category_id'];
        $reference = $_POST['idrecibo'];
        $person_id = $this->auth->id;
        $trans_type = 'cash-in-by-sale';
        $payment_method = $_POST['payment_type_id'];
        $created_at = date("Y-m-d H:i:s");

        $ttl_paid = $_POST["ttl_paid"];

        $data1 = substr($trans_date, 0, 2);
        $data2 = substr($trans_date, 3, 2);
        $data3 = substr($trans_date, 6, 4);
        if($data1 > 10){
            $data_final = $data3."-". + $data2."-". + $data1; 
        }else{
            $data_final = $data3."-". + $data2."-0". + $data1;
        }

        $tets="";

        if($doc && $amount >0){ 
          foreach ($doc as $docs => $items)
          { 
           $docss = $doc [$docs];
           $amounts = $amount [$docs];
          
      
          //foreach (array_combine($doc, $amount) as $docs => $amounts) {
           $parte_doc = substr($docss, 0, 24);
            //echo $parte_doc."<br>";
            //echo $amounts."<br>";

            $parte_ord = substr($docss, 24, 14); //echo $parte_ord."<br>";//cotacao
            $parte_doc_pay_hist = substr($docss, 12, 13);//echo "Factura2: ".$parte_doc_pay_hist."<br>";
            $parte_calcula_inicial = substr($docss, 12, 2);
            $parte_calcula = substr($docss, 12, 13);
            $parte_ord_doc = substr($docss, 39); //echo $parte_ord_doc;
           
            // Transaction Table
            $sql_bank_trans = "INSERT INTO bank_trans(account_no, trans_date, description,reference, amount, category_id, person_id, trans_type, payment_method, created_at) VALUES(:account_no, :trans_date, :description,:reference, :amount, :category_id, :person_id, :trans_type, :payment_method, :created_at)";
            $stmt = $pdo->prepare($sql_bank_trans);
            $stmt->bindParam(":account_no", $account_no);
            $stmt->bindParam(":trans_date", $data_final);
            $stmt->bindParam(":description", $parte_doc);
            $stmt->bindParam(":reference", $reference);
            //if($docs == 0){
             // $stmt->bindParam(":amount", $ttl_paid);

            //}else{

               //$stmt->bindParam(":amount",$amounts);
               if($parte_calcula_inicial == 'NC'){

                    $somaNotacredito=$somaNotacredito+$amounts;

                    $res=(-1*$amounts);

                    $stmt->bindParam(":amount", $res);
                 }else{

                  $somaDebitoFactura=$somaDebitoFactura+$amounts;

                  $stmt->bindParam(":amount",$amounts);
                 }
            //}
            $stmt->bindParam(":category_id", $category_id);
            $stmt->bindParam(":person_id", $person_id);
            $stmt->bindParam(":trans_type", $trans_type);
            $stmt->bindParam(":payment_method", $payment_method);
            $stmt->bindParam(":created_at", $created_at);
            if($stmt->execute()){
              $last_id = $pdo->lastInsertId();

              // Payment Table
              $sql_pay_hist = "INSERT INTO payment_history
              (transaction_id, invoice_reference, order_reference, payment_type_id, amount, payment_date, reference, person_id, customer_id)
              VALUES
              (:transaction_id, :invoice_reference, :order_reference, :payment_type_id, :amount, :payment_date, :reference, :person_id, :customer_id)";
              $stmt_pay_hist = $pdo->prepare($sql_pay_hist);
              $stmt_pay_hist->bindParam(":transaction_id", $last_id);
              $stmt_pay_hist->bindParam(":invoice_reference", $parte_doc_pay_hist);
              $stmt_pay_hist->bindParam(":order_reference", $parte_ord);
              $stmt_pay_hist->bindParam(":payment_type_id", $payment_method);
              
             
            
              if($parte_calcula_inicial == 'NC'){

                    $res=(-1*$amounts);
                    $stmt_pay_hist->bindParam(":amount", $res);
                 }else{
                     $stmt_pay_hist->bindParam(":amount", $amounts);
                 }


              $stmt_pay_hist->bindParam(":payment_date", $data_final);
              $stmt_pay_hist->bindParam(":reference", $reference);
              $stmt_pay_hist->bindParam(":person_id", $person_id);
              $stmt_pay_hist->bindParam(":customer_id", $id);
              if($stmt_pay_hist->execute()){
                $last_payment_id = $pdo->lastInsertId();

                if($parte_calcula_inicial == 'FT'){
                  $sql = "Select * from sales_cc
                  INNER JOIN sales_orders ON sales_cc.reference_doc=sales_orders.reference
                  where reference_doc = '$parte_calcula'";
                }else if($parte_calcula_inicial == 'ND'){
                  $sql = "Select * from sales_cc
                  INNER JOIN sales_debito ON sales_cc.reference_doc=sales_debito.reference_debit
                  where reference_doc = '$parte_calcula'";
                }else{
                    $sql = "Select * from sales_cc
                  INNER JOIN sales_credito ON sales_cc.reference_doc=sales_credito.reference_credit
                  where reference_doc = '$parte_calcula'";
                }
                $comando = $pdo->prepare($sql);
                if($comando->execute()){
                  $t = $comando->fetch();
                  if($parte_calcula_inicial == 'NC'){
                    $factura = $t["credito"];
                    $total_paid_amount = $t ["paid_amount_credit"];
                  }else if($parte_calcula_inicial == 'ND'){
                    $factura = $t["debito"];
                    $total_paid_amount = $t ["paid_amount_debit"];
                  }else{
                   $factura = $t["total"];
                   $total_paid_amount = $t ["paid_amount"];
                  }
                  
                   $new_total_paid_amount = $total_paid_amount + $amounts;
                   $saldo = $factura - $new_total_paid_amount;



                  $sql_saldo = "update sales_orders set paid_amount = :paid_amount where reference = :ref";
                  $comando_saldo = $pdo->prepare($sql_saldo);
                  $comando_saldo->bindParam(":paid_amount", $new_total_paid_amount);
                  $comando_saldo->bindParam(':ref', $parte_calcula);
                  $comando_saldo->execute();

                  //update pending:
                  $sql_paid_doc = "update sales_pending set amount_paid_pending = :paid where reference_pending = :ref_paid";
                  $comando_paid_doc = $pdo->prepare($sql_paid_doc);
                  $comando_paid_doc->bindParam(":paid", $new_total_paid_amount);
                  $comando_paid_doc->bindParam(':ref_paid', $parte_calcula);
                  $comando_paid_doc->execute();
                  //end pending  
 
                  

                  DB::table('sales_debito')->where('reference_debit', $parte_calcula)->update(['paid_amount_debit' => $new_total_paid_amount]);
                 
                  DB::table('sales_credito')->where('reference_credit', $parte_calcula)->update(['paid_amount_credit' => $new_total_paid_amount]);
                 


                  //update cc:
                  //$ref_ord = $_POST["order_no"];
                  $entra = "1";
                  $sql_saldo_doc = "update sales_cc set saldo_doc = :saldo where reference_doc = :ref_doc";
                  $comando_saldo_doc = $pdo->prepare($sql_saldo_doc);
                  $comando_saldo_doc->bindParam(":saldo", $saldo);
                  $comando_saldo_doc->bindParam(':ref_doc', $parte_calcula);
                  $comando_saldo_doc->execute();
                  //end cc
                }
              
                /*echo $parte_doc."<br>";
                echo $parte_ord."<br>";
                echo $parte_doc_pay_hist."<br>";*/
              }//end second execute
            }//end first execute
          
          }//endforeach 

          //$novoTOTAL=$ttl_paid-$soma;
          $novoTOTAL=$somaDebitoFactura-$somaNotacredito;

          //Start CC 
          $insert_rec = "insert into sales_cc (debtor_no_doc, order_no_doc, rec_no_doc, reference_doc, order_reference_doc, amount_credito_doc, payment_type_id_doc, debito_credito, ord_date_doc) values (:debtor_no_doc, :order_no_doc, :rec_no_doc, :reference_doc, :order_reference_doc, :amount_credito_doc, :payment_type_id_doc, :entra, :ord_date_doc)";
          $comando_update_rec = $pdo->prepare($insert_rec);
          $comando_update_rec->bindParam(":debtor_no_doc", $id);//customer
          $comando_update_rec->bindParam(":order_no_doc", $parte_ord_doc);//order_no_doc
          $comando_update_rec->bindParam(":rec_no_doc", $last_payment_id);
          $comando_update_rec->bindParam(":reference_doc", $reference);//recibo
          $comando_update_rec->bindParam(":order_reference_doc", $parte_ord);//cot
          $comando_update_rec->bindParam(":amount_credito_doc", $novoTOTAL);//total pago
          $comando_update_rec->bindParam(":payment_type_id_doc", $payment_method);//new
          $comando_update_rec->bindParam(":entra", $entra);//entra
          $comando_update_rec->bindParam(":ord_date_doc", $data_final);//data
          if($comando_update_rec->execute()){
              return redirect()->intended('payment/view-receipt/'.$last_payment_id);
          }//END CC
        }//END IF
    }

    /**
    * Delete payment by id 
    **/

    public function createNewPaymentL(Request $request){

      //return $request->all();
     
      $userId = \Auth::user()->id;
      $this->validate($request, [
            'account_no'=>'required',
            'payment_type_id' => 'required',
            'category_id'=>'required',
            //'amount' => 'required|numeric',
            'payment_date'=>'required',
            'debtor_no' =>'required',
            'invoice_reference' => 'required'
        ]);

        $doc = $_POST['invoice_reference'];
        $amount = $_POST['amount'];

        $id = $_POST['debtor_no'];
        $account_no = $_POST['account_no'];
        $trans_date = $_POST['payment_date'];
        $category_id = $_POST['category_id'];
        $reference = $_POST['idrecibo'];
        $person_id = $this->auth->id;
        $trans_type = 'cash-in-by-sale';
        $payment_method = $_POST['payment_type_id'];
        $created_at = date("Y-m-d H:i:s");

        $ttl_paid = $_POST["ttl_paid"];

        $data1 = substr($trans_date, 0, 2);
        $data2 = substr($trans_date, 3, 2);
        $data3 = substr($trans_date, 6, 4);
        if($data1 > 10){
            $data_final = $data3."-". + $data2."-". + $data1; 
        }else{
            $data_final = $data3."-". + $data2."-0". + $data1;
        }

        //condig 
        if($doc && $amount >0){ 
          foreach ($doc as $docs => $items) { 
            $docss = $doc [$docs];
            $amounts = $amount [$docs];
            
          
          //foreach (array_combine($doc, $amount) as $docs => $amounts) {
           $parte_doc = substr($docss, 0, 24);
            //echo $parte_doc."<br>";
            //echo $amounts."<br>";

            $parte_ord = substr($docss, 24, 14); //echo $parte_ord."<br>";//cotacao
            $parte_doc_pay_hist = substr($docss, 12, 13);//echo "Factura2: ".$parte_doc_pay_hist."<br>";
            $parte_calcula_inicial = substr($docss, 12, 2);
            $parte_calcula = substr($docss, 12, 13);
            $parte_ord_doc = substr($docss, 39); //echo $parte_ord_doc;
          }
        }
    }

       

    public function delete(Request $request){
        $id = $request['id'];
        $paymentInfo = DB::table('payment_history')
                     ->where('id',$id)
                     ->select('id','order_reference','invoice_reference','amount','transaction_id')
                     ->first();
        //d($paymentInfo,1);
        $totalPaidAmount = DB::table('sales_orders')
                     ->where(['order_reference'=>$paymentInfo->order_reference,'reference'=>$paymentInfo->invoice_reference])
                     ->sum('paid_amount');
        $newAmount   = ($totalPaidAmount-$paymentInfo->amount);
        $update      = DB::table('sales_orders')
                     ->where(['order_reference'=>$paymentInfo->order_reference,'reference'=>$paymentInfo->invoice_reference])
                     ->update(['paid_amount'=>$newAmount]);

        DB::table('payment_history')->where('id',$id)->delete();
        
        if($paymentInfo->transaction_id){

            DB::table('bank_trans')->where('id',$paymentInfo->transaction_id)->delete();
        }
        \Session::flash('success',trans('message.success.save_success'));
        return redirect()->intended('payment/list');
    }

    /**
    * Display receipt of payment
    */

    public function viewReceipt($id){
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'payment/list'; 
       $receipt['reference']=DB::table('payment_history')
                     ->where('id',$id)
                     ->select('reference')->first();
       $reference= $receipt['reference']->reference;

      //Delete dados1 later
         $data['dados1'] = DB::table('payment_history')
                     ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                     ->leftjoin('sales_orders','sales_orders.reference','=','payment_history.invoice_reference')
                     ->leftjoin('sales_debito','sales_debito.reference_debit','=','payment_history.invoice_reference')
                     ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history.customer_id')
                     ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                     ->leftjoin('countries','countries.id','=','cust_branch.billing_country_id')
                     ->leftjoin('sales_cc','sales_cc.reference_doc','=','payment_history.reference')
                     ->where('payment_history.reference',$reference)
                     ->select('payment_history.*','payment_terms.name as payment_method','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','sales_orders.ord_date as invoice_date','sales_orders.total as invoice_amount','sales_orders.order_reference_id','countries.country','debtors_master.debtor_no','debtors_master.email','debtors_master.phone','debtors_master.name', 'sales_debito.debito as debit_amount','sales_cc.reference_doc','sales_cc.amount_doc', 'sales_cc.ord_date_doc')      
                     ->get();

        $data['dados'] = DB::table('payment_history')
                     ->where('payment_history.reference',$reference)
                     ->get();


        $data['paymentInfo'] = DB::table('payment_history')
                     ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                     ->leftjoin('sales_orders','sales_orders.reference','=','payment_history.invoice_reference')
                     ->leftjoin('sales_debito','sales_debito.reference_debit','=','payment_history.invoice_reference')
                     ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history.customer_id')
                     ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                     ->leftjoin('countries','countries.id','=','cust_branch.billing_country_id')
                     ->where('payment_history.id',$id)
                     ->select('payment_history.*','payment_terms.name as payment_method','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','sales_orders.ord_date as invoice_date','sales_orders.total as invoice_amount','sales_orders.order_reference_id','countries.country','debtors_master.debtor_no','debtors_master.email','debtors_master.phone','debtors_master.name', 'sales_debito.debito as debit_amount')      
                     ->first();
      
        //Right part start
        $data['paymentsList'] = DB::table('payment_history')
                            ->where(['order_reference'=>$data['paymentInfo']->order_reference])
                            ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                            ->select('payment_history.*','payment_terms.name')
                            ->orderBy('payment_date','DESC')
                            ->get();

        $data['orderInfo']  = DB::table('sales_orders')->where('order_no',$data['paymentInfo']->order_reference_id)->select('reference','order_no','invoice_type')->first();
         //Right part end
       $lang = Session::get('dflt_lang');
        $data['emailInfo'] = DB::table('email_temp_details')->where(['temp_id'=>1,'lang'=>$lang])->select('subject','body')->first();
       $data['invoiceType'] = '';
       //$data['invoiced_status'] = 'yes';
       //d($data['orderInfo'],1);
        return view('admin.payment.viewReceipt', $data);
    }

    /**
    * Create receipt of payment
    */

    public function createReceiptPdf($id){        
        $data['paymentInfo'] = DB::table('payment_history')
                     ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                     ->leftjoin('sales_orders','sales_orders.reference','=','payment_history.invoice_reference')
                     ->leftjoin('sales_debito','sales_debito.reference_debit','=','payment_history.invoice_reference')//zz
                     ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history.customer_id')
                     ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                     ->leftjoin('countries','countries.id','=','cust_branch.billing_country_id')
                     ->where('payment_history.id',$id)
                     ->select('payment_history.*','payment_terms.name as payment_method','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','sales_orders.ord_date as invoice_date','sales_orders.total as invoice_amount','sales_orders.order_reference_id','countries.country','debtors_master.debtor_no','debtors_master.email','debtors_master.phone','debtors_master.name', 'sales_debito.debito as debit_amount')      
                     ->first();

        //return view('admin.payment.paymentReceiptPdf', $data);  
        $pdf = PDF::loadView('admin.payment.printReceipt', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
       // $pdf->setPaper(array(0,0,530,375), 'portrait');
        
       return $pdf->download('payment_'.time().'.pdf',array("Attachment"=>0));

    }

    /**
    * Print receipt of payment
    */

    public function printReceipt($id){        

        $data['paymentInfo'] = DB::table('payment_history')
                     ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                     ->leftjoin('sales_orders','sales_orders.reference','=','payment_history.invoice_reference')
                     ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history.customer_id')
                     ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                     ->leftjoin('countries','countries.id','=','cust_branch.billing_country_id')
                     ->where('payment_history.id',$id)
                     ->select('payment_history.*','payment_terms.name as payment_method','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','sales_orders.ord_date as invoice_date','sales_orders.total as invoice_amount','sales_orders.order_reference_id','countries.country','debtors_master.debtor_no','debtors_master.email','debtors_master.phone','debtors_master.name')      
                     ->first();                    
       
        //return view('admin.payment.printReceipt', $data); 
        $pdf = PDF::loadView('admin.payment.printReceipt', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        
        return $pdf->stream('payment_'.time().'.pdf',array("Attachment"=>0));

    }

    /**
    * Send email to customer for payment information
    
    public function sendPaymentInformationByEmail(Request $request){
        $this->email->sendEmail($request['email'],$request['subject'],$request['message']);
        \Session::flash('success',trans('message.email.email_send_success'));
        return redirect()->intended('payment/view-receipt/'.$request['id']);
    }
    */
    //

     public function sendPaymentInformationByEmail(Request $request){
        
        $orderNo = $request['id'];
        $invoiceName = 'recibo.pdf';

        if(isset($request['quotation_pdf']) && $request['quotation_pdf']=='on'){
           
            $this->orderPdfEmail($orderNo,$invoiceName);
            $this->email->sendEmailWithAttachment($request['email'],$request['subject'],$request['message'],$invoiceName);
         }else{
            $this->email->sendEmail($request['email'],$request['subject'],$request['message']);

         } 

        \Session::flash('success',trans('message.email.email_send_success'));
        return redirect()->intended('payment/view-receipt/'.$request['id']);
    }

   

    public function orderPdfEmail($id,$invoiceName){

        $data['paymentInfo'] = DB::table('payment_history')
                     ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                     ->leftjoin('sales_orders','sales_orders.reference','=','payment_history.invoice_reference')
                     ->leftjoin('sales_debito','sales_debito.reference_debit','=','payment_history.invoice_reference')//zz
                     ->leftjoin('debtors_master','debtors_master.debtor_no','=','payment_history.customer_id')
                     ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                     ->leftjoin('countries','countries.id','=','cust_branch.billing_country_id')
                     ->where('payment_history.id',$id)
                     ->select('payment_history.*','payment_terms.name as payment_method','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','sales_orders.ord_date as invoice_date','sales_orders.total as invoice_amount','sales_orders.order_reference_id','countries.country','debtors_master.debtor_no','debtors_master.email','debtors_master.phone','debtors_master.name', 'sales_debito.debito as debit_amount')      
                     ->first();

        $pdf = PDF::loadView('admin.payment.paymentReceiptPdf', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
         return $pdf->save(public_path().'/uploads/invoices/'.$invoiceName); 
      

    }








    /**
    * Pay all amount
    */
    public function payAllAmount($order_no){
        $allInvoiced = DB::table('sales_orders')->where('order_reference_id',$order_no)->select('order_no as inv_no','order_reference','reference','debtor_no as customer_id','payment_id','total as invoiced_amount','paid_amount')->get();
        //d($allInvoiced,1);
        foreach ($allInvoiced as $key => $value) {
            $amount = ($value->invoiced_amount - $value->paid_amount);
           // d($amount,1);
            DB::table('sales_orders')->where('order_no',$value->inv_no)->update(['paid_amount'=>$value->invoiced_amount]);
            if(abs($amount) >= 0){
            $payment[$key]['invoice_reference'] = (string)$value->reference;
            $payment[$key]['order_reference'] = (string)$value->order_reference;
            $payment[$key]['payment_type_id'] = $value->payment_id;
            $payment[$key]['amount'] = $amount ;
            $payment[$key]['payment_date'] = DbDateFormat(date('d-m-Y'));
            $payment[$key]['reference'] =  'by all pay'; 
            $payment[$key]['person_id'] = $this->auth->id; 
            $payment[$key]['customer_id'] = $value->customer_id;
            //d($payment,1);
            $payments = DB::table('payment_history')->insertGetId($payment[$key]);
        }
    }
    \Session::flash('success',trans('message.extra_text.payment_success'));
    return redirect()->intended('order/view-order-details/'.$order_no);
    }

    public function editPayment(Request $request){
        $data = [];
        $payment_id = $request->pid;
        $transaction_id = $request->trid;
        $paymentInfo = DB::table('payment_history as ph')
                      ->leftjoin('bank_trans as bt','bt.id','=','ph.transaction_id')
                       ->select("ph.*",'bt.account_no','bt.category_id','bt.attachment')
                      ->where(['ph.id'=>$payment_id])
                      ->first();
        //d($paymentInfo,1);
        $data['pid'] = $paymentInfo->id;
        $data['trid'] = $paymentInfo->transaction_id;
        $data['amount'] = $paymentInfo->amount;
        $data['account_no'] = $paymentInfo->account_no;
        $data['category_id'] = $paymentInfo->category_id;
        $data['attachment'] = $paymentInfo->attachment;
        $data['invoice_reference'] = $paymentInfo->invoice_reference;
        return json_encode($data);
    }

     public function updatePayment(Request $request){
        
        $preAmount = $request->preAmount;
        $invoiceRef = $request->invoice_ref;
        
        $totalPaidAmount = DB::table('sales_orders')
                     ->where(['reference'=>$invoiceRef])
                     ->sum('paid_amount');

        $newAmount   = ($totalPaidAmount-$preAmount)+$request->amount;

       DB::table('sales_orders')
                     ->where(['reference'=>$invoiceRef])
                     ->update(['paid_amount'=>$newAmount]);


        $payment_id = $request->pid;
        $transaction_id = $request->trid;  
        $amount = $request->amount;
        $account_no = $request->account_no;
        $category_id = $request->category_id;
        $status = $request->status;
        
       DB::table('payment_history')
                     ->where(['id'=>$payment_id])
                     ->update(['amount'=>$amount,'status'=>$status]);

        $trans['account_no'] = $account_no; 
        $trans['category_id'] = $category_id;
        $trans['amount'] = $amount;

       DB::table('bank_trans')
                     ->where(['id'=>$transaction_id])
                     ->update($trans);

     \Session::flash('success',trans('message.extra_text.payment_success'));
     return redirect()->intended('payment/list');

     }

     public function report()
     {
        $data['paymentList'] = DB::table('sales_cc')
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_cc.debtor_no_doc')
                             ->leftjoin('payment_terms','payment_terms.id','=','sales_cc.payment_type_id_doc')
                             ->leftjoin('sales_orders','sales_orders.reference','=','sales_cc.reference_doc')
                             //->leftjoin('payment_history','payment_history.reference','=','sales_cc.reference_doc')
                             ->select('sales_cc.*','debtors_master.name','payment_terms.name as pay_type','sales_orders.order_no as invoice_id','sales_orders.order_reference_id as order_id')
                             ->orderBy('sales_cc.idcc','DESC')->where('payment_type_id_doc','2')
                             ->get();
        $pdf = PDF::loadView('admin.payment.report.paymentsReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Recibos'.time().'.pdf',array("Attachment"=>0));

     }


     public function destroy($id){
      //return 'it will be deleted';
      $total=0; 
      $amounts=0; 
      $resultado='#';           
      $primeiro='';   

      $dados=DB::table('payment_history')
                     ->where('id',$id)
                     ->select('reference')->first();
      $referencia_Recibo= $dados->reference;
      
      $document_listas=DB::table('payment_history')
                     ->where('reference',$dados->reference)
                     ->select('payment_history.*')->get();

      $transacoes=DB::table('bank_trans')
                     ->where('reference',$dados->reference)
                     ->select('bank_trans.*')->get();

       //invoice_reference              
      // localizando os pagamentos  
      foreach ($document_listas as $document_lista) {
       // $resultado=$resultado.'='.$document_lista->invoice_reference;
         $primeiro=$primeiro.'=='.'Payment for '.$document_lista->invoice_reference;

          $ref=explode("-",$document_lista->invoice_reference);
         // $resultado=$resultado.'='.$ref[0];

          if($ref[0] == 'FT'){
            $dados_cc=DB::table('sales_cc')
            ->leftjoin('sales_orders','sales_cc.reference_doc','=','sales_orders.reference')
            ->where('reference_doc',$document_lista->invoice_reference)
            ->select('sales_cc.*','sales_orders.*')->first();

              $factura =  $dados_cc->total;
              $total_paid_amount =$dados_cc->paid_amount;

          }else if($ref[0] == 'ND'){
            $dados_cc=DB::table('sales_cc')
            ->leftjoin('sales_debito','sales_cc.reference_doc','=','sales_debito.reference_debit')
            ->where('reference_doc',$document_lista->invoice_reference)
            ->select('sales_cc.*','sales_debito.*')->first();

              $factura = $dados_cc->debito;
              $total_paid_amount = $dados_cc->paid_amount_debit;

          }else{
              $dados_cc=DB::table('sales_cc')
            ->leftjoin('sales_credito','sales_cc.reference_doc','=','sales_credito.reference_credit')
            ->where('reference_doc',$document_lista->invoice_reference)
            ->select('sales_cc.*','sales_credito.*')->first();
              
              $factura = $dados_cc->credito;
              $total_paid_amount = $dados_cc->paid_amount_credit;
          }             

          //$dados_cc->reference_doc;           

          if($ref[0]== 'NC'){
                $amounts= (-1*$document_lista->amount);
          }else{
               $amounts= $document_lista->amount;
           }
              
              /*Na insercao comportamento 
              $new_total_paid_amount = $total_paid_amount + $amounts;
              $saldo = $factura - $new_total_paid_amount;
               */
                
               $new_total_paid_amount = $total_paid_amount - $amounts;
               $saldo = $factura + $new_total_paid_amount;

              DB::table('sales_orders')->where('reference', $document_lista->invoice_reference)->update(['paid_amount' => $new_total_paid_amount]);

              DB::table('sales_pending')->where('reference_pending', $document_lista->invoice_reference)->update(['amount_paid_pending' => $new_total_paid_amount]);



              DB::table('sales_debito')->where('reference_debit', $document_lista->invoice_reference)->update(['paid_amount_debit' => $new_total_paid_amount]);

              DB::table('sales_credito')->where('reference_credit', $document_lista->invoice_reference)->update(['paid_amount_credit' => $new_total_paid_amount]);
                 


              DB::table('sales_cc')->where('reference_doc', $document_lista->invoice_reference)->update(['saldo_doc' => $saldo]);


        }// fim do foreach
          
          //apagar o historico das pagamentos
         $document_litermo_pagamentostas=DB::table('payment_history')
                     ->where('reference',$dados->reference)
                     ->select('payment_history.*')->delete();
                     //->select('payment_history.*')->get();
           //apagar o historico das transacoes bancarias          
          $transacoes=DB::table('bank_trans')
                     ->where('reference',$dados->reference)
                     ->select('bank_trans.*')->delete();


         // DB::table('sales_cc')->where('reference_doc',$referencia_Recibo)->update(['amount_credito_doc' => 0]);           
          DB::table('sales_cc')->where('reference_doc',$referencia_Recibo)->delete();           
        
          \Session::flash('success',trans('message.success.delete_success'));
          return redirect()->intended('payment/list');

                /*   \Session::flash('fail','');
                  return redirect()->intended('payment/list');
                */  
        }

    // public function periodoCalcula($id) {
    //   return $price = DB::table('invoice_payment_terms')
    //                   ->where('id', $id)
    //                   ->first()->days_before_due;
    // }

    public function termo_pagamento($id) {
      return $diasDepois = DB::table('invoice_payment_terms')
                          ->where('id', $id)
                          ->first()->days_before_due;
    }
  }

?>