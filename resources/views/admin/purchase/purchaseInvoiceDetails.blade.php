<?php
require_once './conexao.php';
//numero de linhas:
$sql = "Select * from cust_branch";
$comando = $pdo->prepare($sql);
$comando->execute();
$resultado = $comando->fetch();
$nuit = $resultado ["nuit"];

$sql_company = "Select * from preference where id=20";
$comando_company = $pdo->prepare($sql_company);
$comando_company->execute();
$rs_company = $comando_company->fetch();
$nuit_company = $rs_company ["value"];

$dt = date("Y/m/d");
$data1 = substr($dt, 0, 4);
$data2 = substr($dt, 5, 2);
$data3 = substr($dt, 8, 2);
if($data1 > 10){
  $data_final = $data3."-". + $data2."-". + $data1; 
}else{
  $data_final = $data3."-". + $data2."-0". + $data1;
}

//data para id:
$parte_ano = substr($dt,  0, 4);
?>

@extends('layouts.app')
@section('content')
  <section class="content">

    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-10">
           <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.purchase') }}</div>
          </div> 
          <div class="col-md-2">
           @if(Helpers::has_permission(Auth::user()->id, 'add_purchase'))
              <a href="{{ url('purchase/add') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.new_purchase') }}</a>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
          <div class="box box-default">
          <div class="box-body">
                <div class="btn-group pull-right">
                  <a target="_blank" href="{{URL::to('/')}}/purchase/print/{{$purchData->order_no}}" title="Print" class="btn btn-default btn-flat">{{ trans('message.extra_text.print') }}</a>
                  <a target="_blank" href="{{URL::to('/')}}/purchase/pdf/{{$purchData->order_no}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
                   
                   <!--@if(Helpers::has_permission(Auth::user()->id, 'edit_purchase'))
                  <a href="{{URL::to('/')}}/purchase/edit/{{$purchData->order_no}}" title="Edit" class="btn btn-default btn-flat">{{ trans('message.extra_text.edit') }}</a>
                    @endif-->
                    
                    <!--@if(Helpers::has_permission(Auth::user()->id, 'delete_purchase'))
                  <form method="POST" action="{{ url("purchase/delete/$purchData->order_no") }}" accept-charset="UTF-8" style="display:inline">
                      {!! csrf_field() !!}
                      <button class="btn btn-default btn-flat delete-btn" title="{{ trans('message.table.delete')}}" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_purchase') }}" data-message="{{ trans('message.invoice.delete_purchase_confirm') }}">
                         {{ trans('message.extra_text.delete') }}
                      </button>
                  </form>
                    @endif-->

                    <!--pagamentos fornecedor:-->
                    @if(Helpers::has_permission(Auth::user()->id, 'add_purchase'))
                      <button title="{{ trans('message.invoice.pay_now')}}" type="button" class="btn btn-default btn-flat success-btn" data-toggle="modal" data-target="#payModal">
                        {{ trans('message.invoice.pay_now')}}
                      </button>
                    @endif
                </div>
          </div>

            <div class="box-body">
              <div class="row">
                
                  <div class="col-md-4">
                    <strong>{{ Session::get('company_name') }}</strong>
                    <h5 class="">{{ Session::get('company_street') }}</h5>
                    <h5 class="">{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</h5>
                    <h5 class="">{{ Session::get('company_country_id') }}</h5>
                    <h5>Nuit: <?php echo $nuit_company;?></h5>
                  </div>

                <div class="col-md-4">
                  <strong>{{!empty($purchData->supp_name) ? $purchData->supp_name : ''}}</strong>
                  
                  <h5>{{ !empty($purchData->address) ? $purchData->address : ''}}</h5>
                  <h5>{{ !empty($purchData->city) ? $purchData->city : ''}}{{ !empty($purchData->state) ? ', '.$purchData->state : ''}}</h5>
                  <h5>{{ !empty($purchData->country) ? $purchData->country : '' }}{{ !empty($purchData->zipcode) ? ', '.$purchData->zipcode : '' }}</h5>

                  <h5>Nuit: {{ !empty($purchData->nuit) ? $purchData->nuit : ''}}</h5>
                </div>

                <div class="col-md-4">
                    <strong>{{ trans('message.table.invoice_no').' # '.$purchData->reference }}</strong>
                    <h5>{{ trans('message.extra_text.location')}} : {{$purchData->location_name}}</h5>
                    <h5>{{ trans('message.table.date')}} : {{formatDate($purchData->ord_date)}}</h5>
                </div>
              </div>

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
                       <th width="10%" class="text-center">{{ trans('message.table.discount') }}(%)</th>
                        <th width="10%" class="text-right">{{ trans('message.table.amount') }}</th>
                      </tr>
                      <?php
                       $itemsInformation = '';
                      ?>
                      @if(count($invoiceItems)>0)
                       <?php $subTotal = 0;$units = 0;$valueTotal=0; $discountTotal=0; 
                       $taxValue=0; $taxAmount=0;?>
                        @foreach($invoiceItems as $result)
                            <tr>
                              <td class="text-center">{{$result->description}}</td>
                              <td class="text-center">{{$result->quantity_received}}</td>
                              <td class="text-center">{{number_format($result->unit_price,2,'.',',') }}</td>
                              <td class="text-center">{{$result->tax_rate}}</td>
                              <td class="text-center">{{$result->discount_percent}}</td>
                              <?php
                                $priceAmount = ($result->quantity_received*$result->unit_price);
                                $price_dicounted=$priceAmount-($priceAmount*$result->discount_percent)/100;
                               // $subTotal += $priceAmount;
                                $units += $result->quantity_received;
                                $itemsInformation .= '<div>'.$result->quantity_received.'x'.' '.$result->description.'</div>';
                                $value=$result->unit_price*$result->quantity_received;
                                $valueTotal+=$value;
                                $discount=$result->quantity_received*($result->unit_price-(($result->unit_price*$result->discount_percent)/100));
                               $subTotal+=$discount;
                               $discountAmount=$result->quantity_received*($result->unit_price*$result->discount_percent)/100;
                                $discountTotal+=$discountAmount;

                              ?>
                              <td align="right">{{ Session::get('currency_symbol').number_format($price_dicounted,2,'.',',') }}</td>
                            </tr>
                        @endforeach
                        <tr class="tableInfos"><td colspan="4" align="right">{{ trans('message.table.total_qty') }}</td><td align="right" colspan="2">{{$units}}</td></tr>
                         <tr class="tableInfos"><td colspan="4" align="right">{{ trans('message.table.before_discount')}}</td>
                          <td align="right" colspan="2">  {{ Session::get('currency_symbol').number_format($valueTotal,2,'.',',') }}</td></tr>
                          <tr class="tableInfos"><td colspan="4" align="right">{{ trans('message.table.discount')}}</td>
                            <td align="right" colspan="2">{{ Session::get('currency_symbol').number_format($discountTotal,2,'.',',') }}</td></tr>
                      <tr class="tableInfos"><td colspan="4" align="right">{{ trans('message.table.sub_total') }}</td><td align="right" colspan="2">{{ Session::get('currency_symbol').number_format($subTotal,2,'.',',') }}</td></tr>
                      <tr><td colspan="4" align="right">{{ trans('message.table.tax') }}</td><td colspan="2" class="text-right">{{ Session::get('currency_symbol').number_format($purchData->total-$subTotal,2,'.',',') }}</td></tr>
                      <tr class="tableInfos">
                        <td colspan="4" align="right">
                          <strong>{{ trans('message.table.grand_total') }}</strong>
                        </td>
                      <td colspan="2" class="text-right"><strong>
                        {{ Session::get('currency_symbol').number_format($purchData->total,2,'.',',') }}</strong>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4" align="right">
                        <strong>{{ trans('message.invoice.paid') }}</strong>
                      </td>
                      <td colspan="2" class="text-right">
                        {{ Session::get('currency_symbol').number_format($purchData->valor_pago,2,'.',',') }}
                      </td>
                    </tr>
                    <tr>
                      <td colspan="4" align="right">
                        {{ trans('message.table.balance_amount') }}
                      </td>
                      <td colspan="2" class="text-right">
                        {{ Session::get('currency_symbol').number_format($purchData->total - $purchData->valor_pago,2,'.',',') }}
                      </td>
                    </tr>
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
        <form class="form-horizontal" id="payForm" action="{{url('payment_supplier/save')}}" method="POST">
          <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">

          <input type="hidden" name="invoice_reference" value="{{$purchData->reference}}">
          <input type="hidden" name="order_no" value="{{$purchData->order_no}}">

          <input type="hidden" name="supp_id" value="{{$purchData->supplier_id}}">

          <!--Hugo-->
          <div class="form-group">
            <label for="amount" class="col-sm-3 control-label require">{{ trans('message.table.reference') }}</label>
            <div class="col-sm-6">
              <input type="text" id="reference_no" class="form-control" name="idrecibo" value="PF-{{ sprintf("%04d", $invoice_count+1)}}/<?php echo $parte_ano;?>" type="text" readonly>
            </div>
          </div>
          
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
            <label for="payment_type_id" class="col-sm-3 control-label require">
              {{ trans('message.form.payment_type') }}
            </label>
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
              <input type="number" name="amount" value="{{$purchData->total - $purchData->valor_pago}}" class="form-control" id="amount" placeholder="Amount">
            </div>
          </div>

          <!--data do pagamento da ordem compra:-->
          <div class="form-group">
            <label for="payment_date" class="col-sm-3 control-label require">{{ trans('message.form.date') }}  </label>
            <div class="col-sm-6">
              <input type="text" name="payment_date" class="form-control" id="payment_date" placeholder="{{ trans('message.invoice.paid_on') }}" value="<?php echo $data_final;?>" readonly>
            </div>
          </div>

          <!--referencia da ordem compra:-->
          <div class="form-group">
            <label for="reference" class="col-sm-3 control-label require">{{ trans('message.table.description') }} </label>
            <div class="col-sm-6">
              <input type="text" name="description" class="form-control" id="description" placeholder="{{ trans('message.table.description') }}" value="<?php echo "Payment for ".$purchData->reference;?>" readonly>
            </div>
          </div>

          <!--Hugo-->

          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
              <button type="submit" class="btn btn-primary btn-flat" name="btn_pagar">{{ trans('message.invoice.pay_now') }}</button>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
  <!--Pay Modal End-->


  @include('layouts.includes.message_boxes')
@endsection

@section('js')
<script type="text/javascript">

</script>
@endsection