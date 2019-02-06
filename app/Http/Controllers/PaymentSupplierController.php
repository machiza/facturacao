<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Purchase;
use Validator;
use DB;
use Session;
use Auth;
use PDF;
use App\Http\Start\Helpers;

class PaymentSupplierController extends Controller
{
    public function __construct(Auth $auth) {
    $this->middleware('auth');
    $this->auth = $auth::user();
    }

    public function createPayment(Request $request)
    {
        $this->validate($request, [
            'account_no'=>'required',
            'payment_type_id' => 'required',
            'category_id'=>'required',
            'amount' => 'required|numeric',
        ]);

    	  require_once './conexao.php';
        $ref = $_POST["invoice_reference"];
        $order_no = $_POST["order_no"];
    	  $supplier_no = $_POST["supp_id"];
    	  $account_no = $_POST["account_no"];
    	  $payment_id = $_POST["payment_type_id"];
        $category_id = $_POST["category_id"];
        $payment_date = $_POST["payment_date"];
        $amount = $_POST["amount"];

        $sql_query = "Select * from purch_orders where order_no = '$order_no'";
        $comando_query = $pdo->prepare($sql_query);
        if($comando_query->execute()){
        	$rs_query = $comando_query->fetch();
            $valorpago = $rs_query["valor_pago"];

            $new_total_valorpago = $valorpago + $amount;
            //$saldo = $factura - $new_total_valorpago;
            $sql_paid = "update purch_orders set valor_pago = :pago where order_no = :ref";
            $comando_paid = $pdo->prepare($sql_paid);
            $comando_paid->bindParam(":pago", $new_total_valorpago);
            $comando_paid->bindParam(':ref', $order_no);
            if($comando_paid->execute()){
                $new_negative_balance = "-".$new_total_valorpago;
                // Transaction Table
                $data['account_no'] = $request->account_no;//
                $data['trans_date'] = DbDateFormat($request->payment_date);//
                $data['description'] = "Supplier Payment";//
                $data['amount'] = $new_negative_balance;//
                $data['category_id'] = '1';
                $data['person_id'] = $this->auth->id;
                $data['trans_type'] = 'cash-in-by-sale';//
                $data['payment_method'] = $request->payment_type_id;
                $data['created_at'] = date("Y-m-d H:i:s");//
                $transactionId = DB::table('bank_trans')->insertGetId($data);


                // Payment Table
                $payment['transaction_id'] = $transactionId;
                $payment['order_reference'] = $request->invoice_reference;
                $payment['payment_type_id'] = $request->payment_type_id;
                $payment['amount'] =  abs($request->amount);
                $payment['payment_date'] = DbDateFormat($request->payment_date);
                $payment['reference'] =  $request->idrecibo; 
                $payment['person_id'] = $this->auth->id;
                $payment['supp_id'] = $request->supp_id;
                $payment = DB::table('payment_purchase_history')->insertGetId($payment);

                // Receipt Table
                $payment2['reference'] = $request->idrecibo; 
                $payment2['total_amount'] =  abs($request->amount);
                $payment2['pay_history_id'] =  $payment; 
                $payment2['payment_type_id'] = $request->payment_type_id;
                $payment2['payment_date'] = DbDateFormat($request->payment_date);
                $payment2['supp_id'] = $request->supp_id;
                $payment2 = DB::table('receiptLists')->insertGetId($payment2);

                //cc
                $sai = '1';
                $payment3['supp_id_doc'] = $request->supp_id;
                $payment3['order_no_doc'] = $order_no;
                $payment3['reference_doc'] = $request->idrecibo; 
                $payment3['amount_credito_doc'] =  abs($request->amount);
                $payment3['debito_credito'] =  $sai; 
                $payment3['ord_date_doc'] = DbDateFormat($request->payment_date);
                $payment3 = DB::table('purch_cc')->insertGetId($payment3);
                //end cc

                if(!empty($payment2)){
                    \Session::flash('success',trans('message.extra_text.payment_success'));
                    //return redirect()->intended('purchase/view-purchase-details/'.$order_no);
                    return redirect()->intended('payment/view-supp-receipt/'.$payment);
                }
            }
        }       
    }

    

    public function PaymentListAll(){
        $data['menu'] = 'purchase';
        $data['sub_menu'] = 'purchase/direct-invoice_pay_for';

        $data['paymentList1'] = DB::table('payment_purchase_history')
                             ->leftjoin('suppliers','suppliers.supplier_id','=','payment_purchase_history.supp_id')
                             ->leftjoin('payment_terms','payment_terms.id','=','payment_purchase_history.payment_type_id')
                             ->select('payment_purchase_history.*','payment_terms.name as pay_type', 'suppliers.supplier_id', 'suppliers.supp_name')
                             ->distinct()
                             ->orderBy('payment_purchase_history.id','DESC')
                             ->get();

        $data['accounts'] = DB::table('bank_accounts')->where(['deleted'=>0])->pluck('account_name','id');
        $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','income')
                                    ->pluck('name','id');

       $data['paymentList'] = DB::table('receiptLists')
            ->leftjoin('suppliers','suppliers.supplier_id','=','receiptLists.supp_id')
            ->leftjoin('payment_terms','payment_terms.id','=','receiptLists.payment_type_id')
            ->select('receiptLists.*','payment_terms.name as pay_type', 'suppliers.supplier_id', 'suppliers.supp_name')
            ->orderBy('receiptLists.id','DESC')
            ->get();

        return view('admin.payment.paymentSuppList', $data);
    }

    public function PaymentListSingle($id){
        $data['menu'] = 'relationship';
        $data['sub_menu'] = 'supplier';

        $data['paymentList1'] = DB::table('payment_purchase_history')
                            ->where('supplier_id', $id)
                             ->leftjoin('suppliers','suppliers.supplier_id','=','payment_purchase_history.supp_id')
                             ->leftjoin('payment_terms','payment_terms.id','=','payment_purchase_history.payment_type_id')
                             ->select('payment_purchase_history.*','payment_terms.name as pay_type', 'suppliers.supplier_id', 'suppliers.supp_name')
                             ->distinct()
                             ->orderBy('payment_purchase_history.id','DESC')
                             ->first();


        $data['recibos'] = DB::table('receiptLists')
            ->where('supp_id', $id)
            ->leftjoin('suppliers','suppliers.supplier_id','=','receiptLists.supp_id')
            ->leftjoin('payment_terms','payment_terms.id','=','receiptLists.payment_type_id')
            ->select('receiptLists.*','payment_terms.name as pay_type', 'suppliers.supplier_id', 'suppliers.supp_name')
            ->orderBy('receiptLists.id','DESC')
            ->get();

        $data['supplierData'] = DB::table('suppliers')->where('supplier_id', $id)->first();

        return view('admin.supplier.paymentSuppList', $data);
    }

    public function createPaymentAll(){
        $data['menu'] = 'purchase';
        $data['sub_menu'] = 'purchase/direct-invoice_pay_for';

        $data['customerData'] = DB::table('suppliers')->where(['inactive'=>0])->get();
        $data['salesType'] = DB::table('sales_types')->select('sales_type','id')->get();

        $data['accounts'] = DB::table('bank_accounts')->where(['deleted'=>0])->pluck('account_name','id');
        $data['incomeCategories'] = DB::table('income_expense_categories')
                                    ->where('type','income')
                                    ->pluck('name','id');
        $data['payments'] = DB::table('payment_terms')->get();
        $data['paymentTerms'] = DB::table('invoice_payment_terms')->get();

        $invoice_count = DB::table('payment_purchase_history')->count();
                if($invoice_count>0){
                    $invoiceReference = DB::table('payment_purchase_history')->select('reference')->orderBy('id','DESC')->first();

                   $ref = explode("-",$invoiceReference->reference);
                   $data['invoice_count'] = (int) $ref[1];
                }else{
                   $data['invoice_count'] = 0 ;
                }

        return view('admin.payment.paymentSuppNew', $data);
    }




    public function getInvoices(){ 

        require './conexao.php';

       // $sql = "Select * from purch_orders where supplier_id = '" . $_POST["supplier_id"] . "' AND total > valor_pago";

     

      $sql = "Select * from purch_orders where supplier_id = '" . $_POST["supplier_id"] . "' AND total > valor_pago";

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
                    <th width='20% class='text-center'>".trans('message.table.paid_amount') ."</th>
                    <th width='20% class='text-center'>".trans('message.table.balance_amount') ."</th>
                    <th width='20% class='text-center'>".trans('message.quotation.amount') ."</th>
                  </tr>
                  </thead>
                  <tbody>";
                    while ($rs = $comando->fetch()){
                      $id = $rs ["order_no"];
                      $ref = $rs ["reference"];
                      $data = $rs ["ord_date"];
                      $total = $rs ["total"];
                      $paid = $rs ["valor_pago"];
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
                      <tr style='text-align: center;'>
                          <td>
                             <label style='font-weight: normal; cursor: pointer;' >
                                <input type='checkbox' value='$ref $id' name='invoice_reference[]' class='factura checkitem'>
                                $ref
                             </label>
                          </td>
                          <td>$data</td>
                          <td>".Session::get('currency_symbol').number_format($total,2)."</td>
                          <td>".Session::get('currency_symbol').number_format($paid,2)."</td>
                          <td>
                             <input id='idsaldo' name='sald' value='".Session::get('currency_symbol').number_format($saldo,2)."' disabled>
                          </td>
                          <td>
                             <input type='number' step='1.0' min='1' name='amount[]'  class='valor_a_pagar' id='".$row_final."'
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
                            <td colspan='4' style='text-align:Right; font-weight: bold'>".trans('message.quotation.total_amount_to_pay') .":
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

            echo "<script>

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


              $('.valor_a_pagar').keyup(function() {
                 // tallyValues();
                
              
               // var x =currentRow.find('.valor_a_pagar').val();
                //x.value = x.value.toUpperCase();


              });


              $('#checkall').change(function(){

                var linhaCorrente=$(this).closest('tr');  
                  $('.checkitem').prop('checked', $(this).prop('checked'))
                  colocarTodosValores();
              
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
                    //alert(amount);
                    $('#totalcost').val(amount);
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

              document.getElementById('totalcost').value = sum.toFixed(2);
            }
        </script>";
    }


// Oficial function of Payment;

public function createNewPayment(Request $request){
        $userId = \Auth::user()->id;
        $this->validate($request, [
            'account_no'=>'required',
            'payment_type_id' => 'required',
            'category_id'=>'required',
            'payment_date'=>'required',
            'supplier_id' =>'required',
            'invoice_reference' => 'required'
        ]);

        require_once './conexao.php';

        $supplier_no = $_POST["supplier_id"];
        $account_no = $_POST["account_no"];
        $payment_id = $_POST["payment_type_id"];
        $category_id = $_POST["category_id"];
        $payment_date = $_POST["payment_date"];
        $person_id = $this->auth->id;
        $idrecibo = $_POST["idrecibo"];
        $data1 = substr($payment_date, 0, 2);
        $data2 = substr($payment_date, 3, 2);
        $data3 = substr($payment_date, 6, 4);
        if($data1 > 10){
            $data_final = $data3."-". + $data2."-". + $data1; 
        }else{
            $data_final = $data3."-". + $data2."-0". + $data1;
        }
        
        $total = $_POST["ttl_paid"];

        $new_negative_balance = "-".$total;

       
        $des='Payment for Supplier '.$request->idrecibo;
        // Transaction Table
        $data['account_no'] = $request->account_no;//
        $data['trans_date'] = DbDateFormat($request->payment_date);//
        $data['description'] = $des;//
        $data['amount'] = $new_negative_balance;//
        $data['category_id'] = '1';
        $data['person_id'] = $this->auth->id;
        $data['trans_type'] = 'cash-in-by-sale';//
        $data['payment_method'] = $request->payment_type_id;
        $data['created_at'] = date("Y-m-d H:i:s");//
        $transactionId = DB::table('bank_trans')->insertGetId($data);

        $doc = $_POST["invoice_reference"];
        $amount = $_POST["amount"];

        foreach ($doc as $docs => $items) {
          $docss = $doc [$docs];
          $amounts = $amount [$docs];

          $parte_doc = substr($docss, 0, 7);
          $parte_docs = $parte_doc;

          // Payment Table
          $sql_pay_hist = "INSERT INTO payment_purchase_history
              (transaction_id, payment_type_id,  order_reference, payment_date, amount, person_id, supp_id, reference)
              VALUES
              (:transaction_id, :payment_type_id, :order_reference, :payment_date, :amount, :person_id, :supp_id, :reference)";
          $stmt_pay_hist = $pdo->prepare($sql_pay_hist);
          $stmt_pay_hist->bindParam(":transaction_id", $transactionId);
          $stmt_pay_hist->bindParam(":payment_type_id", $payment_id);
          $stmt_pay_hist->bindParam(":order_reference", $parte_docs);
          $stmt_pay_hist->bindParam(":payment_date", $data_final);
          $stmt_pay_hist->bindParam(":amount", $amounts);
          $stmt_pay_hist->bindParam(":person_id", $person_id);
          $stmt_pay_hist->bindParam(":supp_id", $supplier_no);
          $stmt_pay_hist->bindParam(":reference", $idrecibo);
          $stmt_pay_hist->execute();
          $last_id = $pdo->lastInsertId();
        }

      foreach ($doc as $docs => $items) {
        $docss = $doc [$docs];
        $amounts = $amount [$docs];
        $parte_doc = substr($docss, 8, 10);
        $parte_docs = $parte_doc;

        $sql_query = "Select * from purch_orders where order_no = '$parte_docs'";
        $comando_query = $pdo->prepare($sql_query);
        if($comando_query->execute()){
            $rs_query = $comando_query->fetch();
            $valorpago = $rs_query["valor_pago"];

            $new_total_valorpago = $valorpago + $amounts;
            
            $sql_paid = "update purch_orders set valor_pago = :pago where order_no = :ref";
            $comando_paid = $pdo->prepare($sql_paid);
            $comando_paid->bindParam(":pago", $new_total_valorpago);
            $comando_paid->bindParam(':ref', $parte_docs);
            $comando_paid->execute();
        }
      }

      // Receipt Table
      $payment2['reference'] = $request->idrecibo; 
      $payment2['total_amount'] =  abs($request->ttl_paid);
      $payment2['pay_history_id'] =  $last_id; 
      $payment2['payment_type_id'] = $request->payment_type_id;
      $payment2['payment_date'] = DbDateFormat($request->payment_date);
      $payment2['supp_id'] = $request->supplier_id;
      $payment2 = DB::table('receiptlists')->insertGetId($payment2);

      //cc
                $sai = '1';
                $payment3['supp_id_doc'] = $request->supplier_id;
                //$payment3['order_no_doc'] = $order_no;
                $payment3['reference_doc'] = $request->idrecibo; 
                $payment3['amount_credito_doc'] =  abs($request->ttl_paid);
                $payment3['debito_credito'] =  $sai; 
                $payment3['ord_date_doc'] = DbDateFormat($request->payment_date);
                $payment3 = DB::table('purch_cc')->insertGetId($payment3);
                //end cc
      if(!empty($payment2)){
        \Session::flash('success',trans('message.extra_text.payment_success'));
        return redirect()->intended('payment/view-supp-receipt/'.$last_id);
      }
    }


    public function viewSuppReceipt($id){
        $data['menu'] = 'purchase';
        $data['sub_menu'] = 'purchase/direct-invoice_pay_for';

        $data['paymentInfo'] = DB::table('payment_purchase_history')
                     ->leftjoin('payment_terms','payment_terms.id','=','payment_purchase_history.payment_type_id')
                     ->leftjoin('purch_orders','purch_orders.reference','=','payment_purchase_history.order_reference')
                     ->leftjoin('suppliers','suppliers.supplier_id','=','payment_purchase_history.supp_id')

                     //->leftjoin('countries','countries.id','=','cust_branch.billing_country_id')
                     ->where('payment_purchase_history.id',$id)
                     ->select('payment_purchase_history.*','payment_terms.name as payment_method','purch_orders.ord_date as invoice_date','purch_orders.total as invoice_amount','suppliers.supp_name','suppliers.supplier_id','suppliers.email','suppliers.city','suppliers.address','suppliers.contact', 'suppliers.country', 'suppliers.nuit','suppliers.state')      
                     ->first();
      
        //Right part start
        $data['paymentsList'] = DB::table('payment_purchase_history')
                            ->where(['order_reference'=>$data['paymentInfo']->order_reference])
                            ->leftjoin('payment_terms','payment_terms.id','=','payment_purchase_history.payment_type_id')
                            ->select('payment_purchase_history.*','payment_terms.name')
                            ->orderBy('payment_date','DESC')
                            ->get();

        /*$data['orderInfo']  = DB::table('purch_orders')->where('order_no',$data['paymentInfo']->order_reference_id)->select('reference','order_no','invoice_type')->first();
         //Right part end*/
       $lang = Session::get('dflt_lang');
        $data['emailInfo'] = DB::table('email_temp_details')->where(['temp_id'=>1,'lang'=>$lang])->select('subject','body')->first();
       $data['invoiceType'] = '';
       //$data['invoiced_status'] = 'yes';
       //d($data['orderInfo'],1);
        return view('admin.payment.viewSuppReceipt', $data);
    }

    public function createReceiptPdf($id){        
                $data['paymentInfo'] = DB::table('payment_purchase_history')
                     ->leftjoin('payment_terms','payment_terms.id','=','payment_purchase_history.payment_type_id')
                     ->leftjoin('purch_orders','purch_orders.reference','=','payment_purchase_history.order_reference')
                     ->leftjoin('suppliers','suppliers.supplier_id','=','payment_purchase_history.supp_id')
                     ->where('payment_purchase_history.id',$id)
                     ->select('payment_purchase_history.*','payment_terms.name as payment_method','purch_orders.ord_date as invoice_date','purch_orders.total as invoice_amount','suppliers.supp_name','suppliers.supplier_id','suppliers.email','suppliers.city','suppliers.address','suppliers.contact', 'suppliers.country', 'suppliers.nuit','suppliers.state')      
                     ->first();

        //return view('admin.payment.paymentReceiptPdf', $data);  
        $pdf = PDF::loadView('admin.payment.paymentSuppReceiptPdf', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        
       return $pdf->download('supplier_payment_'.time().'.pdf',array("Attachment"=>0));

    }

    public function printReceipt($id){        

        $data['paymentInfo'] = DB::table('payment_purchase_history')
                     ->leftjoin('payment_terms','payment_terms.id','=','payment_purchase_history.payment_type_id')
                     ->leftjoin('purch_orders','purch_orders.reference','=','payment_purchase_history.order_reference')
                     ->leftjoin('suppliers','suppliers.supplier_id','=','payment_purchase_history.supp_id')
                     ->where('payment_purchase_history.id',$id)
                     ->select('payment_purchase_history.*','payment_terms.name as payment_method','purch_orders.ord_date as invoice_date','purch_orders.total as invoice_amount','suppliers.supp_name','suppliers.supplier_id','suppliers.email','suppliers.city','suppliers.address','suppliers.contact', 'suppliers.country', 'suppliers.nuit','suppliers.state')      
                     ->first();                  
       
        //return view('admin.payment.printReceipt', $data); 
        $pdf = PDF::loadView('admin.payment.printSuppReceipt', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        
        return $pdf->stream('supplier_payment_'.time().'.pdf',array("Attachment"=>0));

    }

    public function report()
    {
      $data['paymentList'] = DB::table('receiptLists')
        ->leftjoin('suppliers','suppliers.supplier_id','=','receiptLists.supp_id')
        ->leftjoin('payment_terms','payment_terms.id','=','receiptLists.payment_type_id')
        ->select('receiptLists.*','payment_terms.name as pay_type', 'suppliers.supplier_id', 'suppliers.supp_name')
        ->orderBy('receiptLists.id','DESC')
        ->get();

        $pdf = PDF::loadView('admin.purchase.report.paymentsReport', $data);
        $pdf->setPaper(array(0,0,750,1060), 'portrait');
        return $pdf->stream('Compras'.time().'.pdf',array("Attachment"=>0));
    }



          public function destroy($id){
          //return 'it will be deleted';
          $total=0; 
          $amounts=0; 
          $resultado='#';           
          $primeiro='';   

         

          $data['paymentList'] = DB::table('receiptLists')->where('id',$id)->first();
         

           $referencia=$data['paymentList']->reference;
           $descricao='Payment for Supplier '.$referencia;

           $historicos=DB::table('payment_purchase_history')
                         ->where('reference',$referencia)
                         ->select('payment_purchase_history.*')->get();



            foreach ($historicos as $historico) {
              # code...


                //historicos
                //order_reference

               
              $order=DB::table('purch_orders')->where('reference',$historico->order_reference)->first();

                //return $order->valor_pago;

               

                $novoSaldo=$order->valor_pago-$historico->amount;        
                        
                DB::table('purch_orders')->where('reference', $historico->order_reference)->update(['valor_pago' => $novoSaldo]);


               
            }

                          

                  DB::table('receiptLists')->where('id',$id)->delete();
                 DB::table('receiptLists')->where('reference',$referencia)->delete();           
                 DB::table('bank_trans')->where('description',$descricao)->delete();           
            
              \Session::flash('success',trans('message.success.delete_success'));
              return redirect()->intended('payment_supplier/list');

                    /*   \Session::flash('fail','');
                      return redirect()->intended('payment/list');
                    */  
            }


}
