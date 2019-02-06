@foreach($invoiceData as $result)
@php
$d = $result['order_no']
@endphp
@endforeach

@php
$id = $customerInfo->debtor_no;
@endphp

<?php
//data para id:
$dt = date("Y/m/d");
$parte_ano = substr($dt,  0, 4);

require_once './conexao.php';
//numero de linhas:
$sql = "Select * from cust_branch where debtor_no = '$id'";
$comando = $pdo->prepare($sql);
$comando->execute();
$resultado = $comando->fetch();
$nuit = $resultado ["nuit"];


//pega id d debit
$sql_debito_no = "Select * from sales_debito
                inner join sales_order_details on sales_debito.debit_no=sales_order_details.order_no
                where invoice_type_debit = 'directInvoice' AND order_no_id = $d";
$comando_debito_no = $pdo->prepare($sql_debito_no);
$comando_debito_no->execute();
$rs_debt_no = $comando_debito_no->fetch();
$d_no =  $rs_debt_no["debit_no"];
$d_ref =  $rs_debt_no["reference_debit"];

$debit_amount =  $rs_debt_no["debito"] - $rs_debt_no["paid_amount_debit"];

$sql_debito = "Select * from sales_debito
                inner join sales_order_details on sales_debito.debit_no=sales_order_details.order_no
                where invoice_type_debit = 'directInvoice' AND debit_no = $d_no";
$comando_debito = $pdo->prepare($sql_debito);
$comando_debito->execute();

$sql_company = "Select * from preference where id=20";
$comando_company = $pdo->prepare($sql_company);
$comando_company->execute();
$rs_company = $comando_company->fetch();
$nuit_company = $rs_company ["value"];
?>

@extends('layouts.app')
@section('content')

  <section class="content">

      <!---Top Section Start-->
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
             <div class="top-bar-title">{{ trans('message.transaction.debit') }}</div>
            </div>
            <div class="col-md-2">
             @if(Helpers::has_permission(Auth::user()->id, 'add_invoice'))
                <a href="{{ url("sales/add_debit") }}" class="btn btn-block btn-default btn-flat btn-border-orange">{{ trans('message.transaction.invoice_new_debit') }}</a>
              @endif
            </div>
          </div>
        </div>
      </div>
      <!---Top Section End-->

    <div class="row">
      <div class="col-md-8 right-padding-col8">
          <div class="box box-default">
              <div class="box-body">
                  <div class="btn-group">
                  @if($saleDataInvoice->debito > 0)
                  @if($saleDataInvoice->paid_amount_debit == 0)
                    <div class="btn-unpaid">
                      {{ trans('message.invoice.unpaid')}}
                    </div>
                  @elseif($saleDataInvoice->paid_amount_debit > 0 and $saleDataInvoice->debito > $saleDataInvoice->paid_amount_debit )
                    <div class="btn-paid-partial" >
                      {{ trans('message.invoice.partially_paid')}}
                    </div>
                  @elseif($saleDataInvoice->total <= $saleDataInvoice->paid_amount)
                    <div class="btn-paid" >
                      {{ trans('message.invoice.paid')}}
                    </div>
                  @endif

                  @else
                  <div class="btn-paid" >{{ trans('message.invoice.paid')}}</div>
                  @endif
                  
                  </div>
                    <div class="btn-group pull-right">

                      <button title="Email" type="button" class="btn btn-default btn-flat" data-toggle="modal" data-target="#emailInvoice">
                        {{ trans('message.extra_text.email') }}
                      </button>

                       <!--print-->
                      <a target="_blank" href="{{URL::to('/')}}/invoice/print_debit/{{$saleDataOrder->order_no}}/{{$saleDataInvoice->order_no}}" title="Print" class="btn btn-default btn-flat">{{ trans('message.extra_text.print') }}</a>

                      <!--btn chamar pfd-->
                      <a target="_blank" href="{{URL::to('/')}}/invoice/pdf-debito/{{$saleDataOrder->order_no}}/{{$saleDataInvoice->order_no}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
                      
                     <!--
                      <a href="{{URL::to('/')}}/sales/edit/{{$saleDataInvoice->order_no}}" title="Edit" class="btn btn-default btn-flat">{{ trans('message.extra_text.edit') }}</a>
                     

                     
                      <a href="{{ URL::to('/')}}/invoice/delete-invoice/{{$saleDataInvoice->order_no}}" class="btn btn-default btn-flat delete-btn delete_data" type="button">
                            {{ trans('message.extra_text.delete') }}
                      </a>
                      -->

                      @if($saleDataInvoice->debito > $saleDataInvoice->paid_amount_debit)
                     
                        <button title="{{ trans('message.invoice.pay_now')}}" type="button" class="btn btn-default btn-flat success-btn" data-toggle="modal" data-target="#payModal">{{ trans('message.invoice.pay_now')}}</button>
                     
                       @endif
                      
                    </div>
              </div>

            <div class="box-body">
              <div class="row">
                
                  <div class="col-md-4">
                    <strong>{{ Session::get('company_name') }}</strong>
                    <h5 class="">{{ Session::get('company_street') }}</h5>
                    <h5 class="">{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</h5>
                    <h5 class="">{{ Session::get('company_country_id') }}, Nuit: {{--$empresa->value--}}</h5>
                  </div>

                  <div class="col-md-4">
                  <strong>{{ trans('message.extra_text.bill_to') }}</strong>
                  <h5>{{ !empty($customerInfo->name) ? $customerInfo->name : ''}}</h5>

                  <h5>{{ !empty($customerInfo->billing_street) ? $customerInfo->billing_street : ''}} </h5>
                  <h5>{{ !empty($customerInfo->billing_state) ? $customerInfo->billing_state : ''}}{{ !empty($customerInfo->billing_city) ? ', '.$customerInfo->billing_city : ''}}</h5>
                  <h5>{{ !empty($customerInfo->billing_country_id) ? $customerInfo->billing_country_id : ''}} {{ !empty($customerInfo->billing_zip_code) ? ', '.$customerInfo->billing_zip_code : ''}}</h5>

                  <!--Nuit-->
                  <h5>Nuit:{{--$customerInfo->nuit--}} </h5>
                  </div>

                <!--Coluna fact-debt-->
                <div class="col-md-4">
                  <strong>{{ trans('message.invoice_pdf.invoice_debit_no') }} # {{($saleDataInvoice->reference_debit)}} ({{ trans('message.table.invoice_no').' # '.$saleDataInvoice->reference }} )</strong>
                  <h5>{{ trans('message.extra_text.location')}} : {{$saleDataInvoice->location_name}}</h5>
                  <h5>{{ trans('message.invoice.invoice_date')}} : {{formatDate($saleDataInvoice->ord_date)}}</h5>
                  
                  <!--data do debit-->
                  <h5>{{ trans('message.invoice.invoice_date_debit')}} : {{formatDate($saleDataInvoice->debit_date)}}</h5>

                  <h5>{{ trans('message.invoice.due_date')}} : {{formatDate($due_date)}}</h5>
                </div>

              </div>

              <!--TBL:-->
              <div class="row">
                <div class="col-md-12">
                  <div class="box-body no-padding">
                    <div class="table-responsive">
                    <table class="table table-bordered" id="salesInvoice">
                      <tbody>
                      <tr class="tbl_header_color dynamicRows">
                        <th width="30%" class="text-center">{{ trans('message.table.description') }}</th>
                        <th width="10%" class="text-center">{{ trans('message.table.quantity') }}</th>
                        <th width="10%" class="text-center">{{ trans('message.table.rate') }}({{Session::get('currency_symbol')}})</th>
                        <th width="10%" class="text-center">{{ trans('message.table.tax') }}(%)</th>
                         <th class="text-center" width="10%">{{ trans('message.table.discount') }}(%)</th>
                        <th width="10%" class="text-center">{{ trans('message.table.amount') }}({{Session::get('currency_symbol')}})</th>
                      </tr>
                      <?php
                       $itemsInformation = '';
                       $taxAmount = 0;
                       $taxTotal = 0;
                      ?>
                      @if(count($invoiceData)>0)
                       <?php $subTotal = 0;$units = 0;?>
                        @foreach($invoiceData as $result)
                          @if($result['quantity']>0)

                          <?php while ($rs = $comando_debito->fetch(PDO::FETCH_ASSOC)){
                            $qty = $rs["quantity"];
                            $pU = $rs['unit_price'];
                            $disconto = $rs['discount_percent'];
                            ?>
                            <tr>
                              <td class="text-center"><?php echo $rs["description"];?></td>
                              <td class="text-center"><?php echo $qty;?></td>
                              <td class="text-center"><?php echo number_format("$pU",2); ?></td>
                              <td class="text-center">{{number_format($result['tax_rate'],2,'.',',')}}</td>
                              <td class="text-center"><?php echo number_format("$disconto",2);?></td>
                              <?php
                                $priceAmount = ($qty*$pU);
                                $discount = ($priceAmount*$rs['discount_percent'])/100;
                                $newPrice = ($priceAmount-$discount);

                                $taxAmount = (($newPrice*$result['tax_rate'])/100);
                                $taxTotal += $taxAmount;
                                $subTotal += $newPrice;
                                $units += $qty;
                                $itemsInformation .= '<div>'.$qty.'x'.' '.$rs["description"].'</div>';
                              ?>
                              <td align="right">{{number_format($newPrice,2,'.',',') }}</td>
                            </tr>
                             
                             <?php }?>

                            @endif
                        @endforeach
                        <tr class="tableInfos">
                          <td colspan="5" align="right">{{ trans('message.table.total_qty') }}</td>
                          <td align="right" colspan="2">{{$units}}</td>
                        </tr>
                        
                      <tr class="tableInfos">
                        <td colspan="5" align="right">{{ trans('message.table.sub_total') }}</td>
                        <td align="right" colspan="2">{{ Session::get('currency_symbol').number_format($subTotal,2,'.',',') }}</td>
                      </tr>


                      <tr><td colspan="5" align="right">Tax</td><td colspan="2" class="text-right">{{ Session::get('currency_symbol').number_format($taxTotal,2,'.',',') }}</td></tr>

                       
                       <!--titulo preco pois-debito-->
                      <tr class="tableInfos">
                        <td colspan="5" align="right"><strong>{{ trans('message.table.price') }}</strong>
                      </td>
                      <!--rs preco pois-debit-->
                      <td colspan="2" class="text-right">
                        <strong>{{ Session::get('currency_symbol').number_format($subTotal+$taxTotal,2,'.',',') }}</strong></td>
                      </tr>

                      <!--pago-->
                      <tr class="tableInfos">
                        <td colspan="5" align="right">{{ trans('message.invoice.paid') }}</td>
                        <td colspan="2" class="text-right"> {{Session::get('currency_symbol').number_format($saleDataInvoice->paid_amount_debit,2,'.',',') }}
                        </td>
                      </tr>
                      <!--end pago-->
 
                      <!--saldo-->
                      <tr class="tableInfos"><td colspan="5" align="right">
                        <strong>{{ trans('message.invoice.due') }}</strong>
                      </td>

                        <td colspan="2" class="text-right">
                          <strong>
                        @if(($subTotal+$taxTotal-$saleDataInvoice->paid_amount_debit)<0)
                        -{{ Session::get('currency_symbol').number_format(abs($subTotal+$taxTotal-$saleDataInvoice->paid_amount_debit),2,'.',',') }}
                        @else
                        {{ Session::get('currency_symbol').number_format(abs($subTotal+$taxTotal-$saleDataInvoice->paid_amount_debit),2,'.',',') }}
                        @endif
                      </strong>
                    </td>
                  </tr>
                  <!--end saldo-->
                      @endif
                      </tbody>
                    </table>
                    </div>
                    <br><br>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      @include('layouts.includes.content_right_option')
      </div>
  </section>

  
  <!--Pay Modal Start-->
  <div class="modal fade" id="payModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ trans('message.table.new_payment') }}</h4>
        </div>
        <div class="modal-body">
        <form class="form-horizontal" id="payForm" action="{{url('payment_debit/save')}}" method="POST">
          <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
          <input type="hidden" name="invoice_reference" value="{{$saleDataInvoice->reference_debit}}"><!--ref fact-->
          <input type="hidden" name="order_reference" value="{{$saleDataOrder->reference}}"><!--Ref Cot-->
          <input type="hidden" name="customer_id" value="{{$customerInfo->debtor_no}}">

          <input type="hidden" name="order_no" value="{{$orderInfo->order_no}}"><!--id cot-->
          <input type="hidden" name="invoice_no" value="{{$invoice_no}}"><!--nr fact-->

          <input type="hidden" name="debit_no_id" value="<?php echo $d_no;?>"><!--id do deb-->

          <!--Hugo-->
          <input type="hidden" id="reference_no" class="form-control" name="idrecibo" value="RE-{{ sprintf("%04d", $debito_count+1)}}/<?php echo $parte_ano;?>" type="text" readonly>
          
          
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.bank.account') }}</label>
            <div class="col-sm-6">
               <select style="width:100%" class="form-control select2" name="account_no" id="account_no">
                <option value="">{{ trans('message.form.select_one') }}</option>
                @foreach($accounts as $acc_no=>$acc_name)
                  <option value="{{$acc_no}}" >{{$acc_name}}</option>
                @endforeach
                </select>
            </div>
          </div>

          <div class="form-group">
            <label for="payment_type_id" class="col-sm-3 control-label require">{{ trans('message.form.payment_type') }} </label>
            <div class="col-sm-6">
              <select style="width:100%" class="form-control select2" name="payment_type_id" id="payment_type_id">
                @foreach($payments as $payment)
                <option value="{{$payment->id}}">{{$payment->name}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.table.category') }}</label>
            <div class="col-sm-6">
               <select style="width:100%" class="form-control select2" name="category_id" id="category_id">
                <option value="">{{ trans('message.form.select_one') }}</option>
                @foreach($incomeCategories as $cat_id=>$cat_name)
                  <option value="{{$cat_id}}" >{{$cat_name}}</option>
                @endforeach
                </select>
            </div>
          </div>


          <div class="form-group">
            <label for="amount" class="col-sm-3 control-label require">{{ trans('message.invoice.amount') }}  </label>
            <div class="col-sm-6">
              <input type="number" name="amount" value="<?php echo $debit_amount;?>" class="form-control" id="amount" placeholder="Amount">
            </div>
          </div>
          
          <!--saldo-->
          <div class="form-group">
            <label for="payment_date" class="col-sm-3 control-label require">{{ trans('message.form.date') }}  </label>
            <div class="col-sm-6">
              <input type="text" name="payment_date" class="form-control" id="payment_date" placeholder="{{ trans('message.invoice.paid_on') }}">
            </div>
          </div>

          <div class="form-group">
            <label for="reference" class="col-sm-3 control-label require">{{ trans('message.table.description') }} </label>
            <div class="col-sm-6">
              <input type="text" name="description" class="form-control" id="description" placeholder="{{ trans('message.table.description') }}" value="<?php echo "Payment for-".$d_ref;?>" readonly>
            </div>
          </div>

          <div class="form-group">
            <label for="reference" class="col-sm-3 control-label">{{ trans('message.table.reference') }}  </label>
            <div class="col-sm-6">
              <input type="text" name="reference" class="form-control" id="reference" placeholder="{{ trans('message.table.reference') }}">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
              <button type="submit" class="btn btn-primary btn-flat" name="btn_pagar_debito">{{ trans('message.invoice.pay_now') }}</button>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
  <!--Pay Modal End-->

  <!--Modal Email start-->
    <div id="emailInvoice" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <form id="sendVoiceInfo" method="POST" action="{{url('invoice/email-invoice-debit-info')}}">
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        <input type="hidden" value="{{$orderInfo->order_no}}" name="order_id" id="order_id">
        <input type="hidden" value="{{$invoice_no}}" name="invoice_id" id="invoice_id">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">{{ trans('message.email.email_invoice_debit_info')}}</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="email">{{ trans('message.email.send_to')}}:</label>
              <input type="email" value="{{$customerInfo->email}}" class="form-control" name="email" id="email">
            </div>
            <?php
            $subjectInfo = str_replace('{order_reference_no}', $orderInfo->reference, $emailInfo->subject);
            $subjectInfo = str_replace('{invoice_reference_no}', $saleDataInvoice->reference, $subjectInfo);
            $subjectInfo = str_replace('{company_name}', Session::get('company_name'), $subjectInfo);
            ?>
            <div class="form-group">
              <label for="subject">{{ trans('message.email.subject')}}:</label>
              <input type="text" class="form-control" name="subject" id="subject" value="{{$subjectInfo}}">
            </div>
              <div class="form-groupa">
                  <?php
                  $bodyInfo = str_replace('{customer_name}', $customerInfo->name, $emailInfo->body);
                  $bodyInfo = str_replace('{order_reference_no}', $orderInfo->reference, $bodyInfo);
                  $bodyInfo = str_replace('{invoice_reference_no}',$saleDataInvoice->reference, $bodyInfo);
                  $bodyInfo = str_replace('{due_date}',$due_date, $bodyInfo);
                  $bodyInfo = str_replace('{billing_street}', $customerInfo->billing_street, $bodyInfo);
                  $bodyInfo = str_replace('{billing_city}', $customerInfo->billing_city, $bodyInfo);
                  $bodyInfo = str_replace('{billing_state}', $customerInfo->billing_state, $bodyInfo);
                  $bodyInfo = str_replace('{billing_zip_code}', $customerInfo->billing_zip_code, $bodyInfo);
                  $bodyInfo = str_replace('{billing_country}', $customerInfo->billing_country_id, $bodyInfo);                      
                  $bodyInfo = str_replace('{company_name}', Session::get('company_name'), $bodyInfo);
                  $bodyInfo = str_replace('{invoice_summery}', $itemsInformation, $bodyInfo);                     
                  $bodyInfo = str_replace('{currency}', Session::get('currency_symbol'), $bodyInfo);
                  $bodyInfo = str_replace('{total_amount}', $saleDataInvoice->total, $bodyInfo); 
                  ?>
                  <textarea id="compose-textarea" name="message" id='message' class="form-control editor" style="height: 200px">{{$bodyInfo}}</textarea>
              </div>

            <div class="form-group">
                <div class="checkbox">
                  <label><input type="checkbox" name="invoice_pdf" checked><strong>{{$saleDataInvoice->reference_debit}}</strong></label>
                </div>
            </div>
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{ trans('message.email.close')}}</button><button type="submit" class="btn btn-primary btn-sm">{{ trans('message.email.send')}}</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  <!--Modal end -->
@include('layouts.includes.message_boxes') 
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function() {
      $(".select2").select2();
      $('#payment_date').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });  

    $('#payment_date').datepicker('update', new Date());

// Item form validation
    $('#payForm').validate({
        rules: {
            account_no:{
              required: true
            },
            payment_type_id: {
                required: true
            },
            amount: {
                required: true
            },
            payment_date:{
               required: true
            },
            category_id:{
            required: true
           },
          description:{
            required: true
          }                   
        }
    });

      $(function () {
        $(".editor").wysihtml5();
      });

    $('#sendVoiceInfo').validate({
        rules: {
            email: {
                required: true
            },
            subject:{
               required: true,
            },
            message:{
               required: true,
            }                   
        }
    }); 


$('.delete_data').bootstrap_confirm_delete({
  heading: "{{ trans('message.invoice.delete_invoice') }}",
  message: "{{ trans('message.invoice.delete_invoice_confirm') }}",
  data_type: null,
});       

});

</script>
@endsection