<!--nuit-->
@php
$supp_id = $customerInfo->debtor_no;
@endphp
<!--end nuit-->

<?php
require_once './conexao.php';
//numero de linhas:
$sql = "Select * from cust_branch where debtor_no = '$supp_id'";
$comando = $pdo->prepare($sql);
$comando->execute();
$resultado = $comando->fetch();
$nuit = $resultado ["nuit"];

$sql_company = "Select * from preference where id=20";
$comando_company = $pdo->prepare($sql_company);
$comando_company->execute();
$rs_company = $comando_company->fetch();
$nuit_company = $rs_company ["value"];

?>

@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <!---Top Section Start-->
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
             <div class="top-bar-title">{{ trans('message.accounting.quotation') }}</div>
            </div>
            <div class="col-md-2">
              @if(Helpers::has_permission(Auth::user()->id, 'add_quotation'))
                <a href="{{ url("order/add") }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.accounting.add_new_quotation') }}</a>
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
                
                  <div class="row">
                    <div class="col-md-4">
                      <strong>{{ trans('message.quotation.quotation_no') }}# {{$customerInfo->reference}}</strong><br>
                      <strong>{{ trans('message.invoice.order_date')}} : {{ formatDate($saleData->ord_date)}}</strong>
                      <br>
                      <strong>{{ trans('message.extra_text.location')}} : {{ $saleData->location_name}}</strong>
                    </div>
                    <div class="col-md-8">
                      <div class="btn-group pull-right">
                        <button title="Email" type="button" class="btn btn-default btn-flat" data-toggle="modal" data-target="#emailOrder">{{ trans('message.extra_text.email') }}</button>
                        <a target="_blank" href="{{URL::to('/')}}/order/print/{{$saleData->order_no}}" title="Print" class="btn btn-default btn-flat">{{ trans('message.extra_text.print') }}</a>
                        <a target="_blank" href="{{URL::to('/')}}/order/pdf/{{$saleData->order_no}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
                        
                          <a href="{{URL::to('/')}}/order/edit/{{$saleData->order_no}}" title="Edit" class="btn btn-default btn-flat">{{ trans('message.extra_text.edit') }}</a>
                      

                       
                         <form method="POST" action="{{ url("order/delete/$saleData->order_no") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!}
                            <button class="btn btn-default btn-flat delete-btn" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_order') }}" data-message="{{ trans('message.invoice.delete_order_confirm') }}">
                               {{ trans('message.extra_text.delete') }}
                            </button>
                        </form>
                       
                      </div>
                    </div>
                  </div>
              </div>

              <div class="box-body">
                <div class="row">
                  
                  <div class="col-md-4">
                    <strong>{{ Session::get('company_name') }}</strong><!--titulo goobilling-->
                    <h5 class="">{{ Session::get('company_street') }}</h5>
                    <h5 class="">{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</h5>
                    <h5 class="">{{ Session::get('company_country_id') }}</h5>
                    <h5>Nuit: <?php echo $nuit_company;?></h5>
                  </div>

                  <div class="col-md-8">
                  <strong>{{ trans('message.quotation.quotation_to') }}</strong><!--titulo billto-->
                  <h5>{{ !empty($customerInfo->name) ? $customerInfo->name : ''}}</h5>

                  <h5>{{ !empty($customerInfo->billing_street) ? $customerInfo->billing_street : ''}} 
                 {{ !empty($customerInfo->billing_state) ? $customerInfo->billing_state : ''}}{{ !empty($customerInfo->billing_city) ? ', '.$customerInfo->billing_city : ''}}</h5>
                  <h5>{{ !empty($customerInfo->billing_country_id) ? $customerInfo->billing_country_id : ''}} {{ !empty($customerInfo->billing_zip_code) ? ', '.$customerInfo->billing_zip_code : ''}}</h5>

                  <!--NUIT-->
                   <h5>{{ !empty($customerInfo->phone) ? 'Telemovel :'. $customerInfo->phone : ''}}</h5>
                  <h5><?php if($nuit!=0){echo 'Nuit: '.$nuit;}else{echo "";} ;?></h5>
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
                           <th class="text-center" width="10%">{{ trans('message.table.discount') }}(%)</th>
                          <th width="10%" class="text-center">{{ trans('message.table.amount')}}({{Session::get('currency_symbol')}})</th>
                        </tr>
                        @if(count($invoiceData)>0)
                         <?php $subTotal = 0;$units = 0;$itemsInformation = ''; $taxAmount=0;$totalTax=0;?>
                          @foreach($invoiceData as $result)
                              <tr>
                                <td class="text-center">{{$result['description']}}</td>
                                <td class="text-center">{{$result['quantity']}}</td>
                                <td class="text-center">{{ number_format($result['unit_price'],2,'.',',') }}</td>
                                <td class="text-center">{{ number_format($result['tax_rate'],2,'.',',') }}</td>
                                <td class="text-center">{{ number_format($result['discount_percent'],2,'.',',') }}</td>
                                <?php
                                  $priceAmount = ($result['quantity']*$result['unit_price']);
                                  $discount = ($priceAmount*$result['discount_percent'])/100;
                                  $newPrice = ($priceAmount-$discount);

                                  $taxAmount = (($newPrice*$result['tax_rate'])/100);

                                  $totalTax += $taxAmount;

                                  $subTotal += $newPrice;
                                  $units += $result['quantity'];
                                  $itemsInformation .= '<div>'.$result['quantity'].'x'.' '.$result['description'].'</div>';
                                ?>
                                <td align="right">{{ number_format($newPrice,2,'.',',') }}</td>
                              </tr>
                          @endforeach
                          <tr class="tableInfos"><td colspan="5" align="right">{{ trans('message.table.total_qty') }}</td><td align="right" colspan="2">{{$units}}</td></tr>
                        <tr class="tableInfos"><td colspan="5" align="right">{{ trans('message.table.sub_total') }}</td><td align="right" colspan="2">{{ Session::get('currency_symbol').number_format($subTotal,2,'.',',') }}</td></tr>
                        

                        <tr><td colspan="5" align="right">Tax</td><td colspan="2" class="text-right">{{ Session::get('currency_symbol').number_format($totalTax,2,'.',',') }}</td></tr>


                          <tr class="tableInfos">
                            <td colspan="5" align="right">
                              <strong>{{ trans('message.table.grand_total') }}</strong>
                            </td>
                            <td colspan="2" class="text-right">
                              <strong>{{Session::get('currency_symbol').number_format($subTotal+$totalTax,2,'.',',')}}</strong>
                            </td>
                          </tr>
                          
                          <?php
                           $invoiceAmount = 0;
                            if(!empty($paymentsList)){
                             
                              foreach ($paymentsList as $key => $paymentAmount) {
                               $invoiceAmount += $paymentAmount->amount;
                              }
                            }
                          ?>
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
      <!--Modal start-->
        <div id="emailOrder" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <form id="sendOrderInfo" method="POST" action="{{url('order/email-order-info')}}">
            <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
            <input type="hidden" value="{{$orderInfo->order_no}}" name="order_id" id="order_id">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('message.email.email_order_info')}}</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="email">{{ trans('message.email.send_to')}}:</label>
                  <input type="email" value="{{$customerInfo->email}}" class="form-control" name="email" id="email">
                </div>
                <?php
                $subjectInfo = str_replace('{order_reference_no}', $orderInfo->reference, $emailInfo->subject);
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
                      $bodyInfo = str_replace('{billing_street}', $customerInfo->billing_street, $bodyInfo);
                      $bodyInfo = str_replace('{billing_city}', $customerInfo->billing_city, $bodyInfo);
                      $bodyInfo = str_replace('{billing_state}', $customerInfo->billing_state, $bodyInfo);
                      $bodyInfo = str_replace('{billing_zip_code}', $customerInfo->billing_zip_code, $bodyInfo);
                      $bodyInfo = str_replace('{billing_country}', $customerInfo->billing_country_id, $bodyInfo);                      
                      $bodyInfo = str_replace('{company_name}', Session::get('company_name'), $bodyInfo);
                      $bodyInfo = str_replace('{order_summery}', $itemsInformation, $bodyInfo);                     
                      $bodyInfo = str_replace('{currency}', Session::get('currency_symbol'), $bodyInfo);
                      $bodyInfo = str_replace('{total_amount}', $saleData->total, $bodyInfo); 
                      $bodyInfo = str_replace('{order_date}', formatDate($saleData->ord_date), $bodyInfo); 
                      ?>
                      <textarea id="compose-textarea" name="message" id='message' class="form-control editor" style="height: 200px">{{$bodyInfo}}</textarea>
                  </div>

                <div class="form-group">
                    <div class="checkbox">
                      <label><input type="checkbox" name="quotation_pdf" checked><strong>{{$orderInfo->reference}}</strong></label>
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
         @include('layouts.includes.content_right_option')
      </div>
    </section>
@include('layouts.includes.message_boxes')    
@endsection
@section('js')
<script type="text/javascript">

      $(function () {
        $(".editor").wysihtml5();
      });

    $('#sendOrderInfo').validate({
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

</script>
@endsection