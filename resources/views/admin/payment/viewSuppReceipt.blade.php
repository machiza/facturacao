@php
$id = $paymentInfo->id;
@endphp


<?php
require_once './conexao.php';

$sql_company = "Select * from preference where id=20";
$comando_company = $pdo->prepare($sql_company);
$comando_company->execute();
$rs_company = $comando_company->fetch();
$nuit_company = $rs_company ["value"];

//recibo
$comando_rec = $pdo->prepare("Select * from payment_purchase_history where id = '$id'");
$comando_rec->execute();
$resultado_rec = $comando_rec->fetch();
$rec = $resultado_rec ["reference"];

$sql_cc = "Select * from payment_purchase_history where reference = '$rec'";
$comando_cc = $pdo->prepare($sql_cc);
$comando_cc->execute();

$sql_cc_ttl = "Select sum(amount) from payment_purchase_history where reference = '$rec'";
$comando_cc_ttl = $pdo->prepare($sql_cc_ttl);
$comando_cc_ttl->execute();
$resultado_cc_ttl = $comando_cc_ttl->fetch();
$rs_ttl_cc = $resultado_cc_ttl["sum(amount)"];
?>

@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
             <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.payment') }}</div>
            </div>
            <div class="col-md-2">
           @if(Helpers::has_permission(Auth::user()->id, 'add_invoice'))
              <a href="{{ url('payment_supplier/new_payment') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.new_sales_payments') }}</a>
           @endif
          </div>
          </div>
        </div>
      </div>

      <!-- Default box -->
    <div class="row">
        <div class="col-md-8 right-padding-col8">
            <div class="box box-default">
              <div class="box-body">
                    <div class="btn-group pull-right">
                      <button title="Email" type="button" class="btn btn-default btn-flat" data-toggle="modal" data-target="#emailReceipt">{{ trans('message.extra_text.email') }}</button>
                      
                      <a target="_blank" href="{{URL::to('/')}}/payment/print-receipt-supp/{{$paymentInfo->id}}" title="Print" class="btn btn-default btn-flat">{{ trans('message.extra_text.print') }}</a>

                      <!--pdf-->
                      <a target="_blank" href="{{URL::to('/')}}/payment/create-receipt-supp/{{$paymentInfo->id}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>

                       @if(!empty(Session::get('payment_delete')))
                      <!--<form method="POST" action="{{ url("payment/delete") }}" accept-charset="UTF-8" style="display:inline">
                          {!! csrf_field() !!}
                          <input type="hidden" name="id" value="{{$paymentInfo->id}}">
                          <button class="btn btn-default btn-flat delete-btn" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_payment_header') }}" data-message="{{ trans('message.invoice.delete_payment') }}">
                            {{ trans('message.extra_text.delete') }}
                          </button>
                      </form>-->
                      @endif
                    </div>
              </div>

              <div class="box-body">
                <div class="row">
                  
                  <div class="col-md-4">
                    <strong>{{ Session::get('company_name') }}</strong>
                    <h5 class="">{{ Session::get('company_street') }}</h5>
                    <h5 class="">{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</h5>
                    <h5 class="">{{ Session::get('company_country_id') }}, Nuit: <?php echo $nuit_company;?></h5>
                  </div>                 

                  <div class="col-md-4">
                    <strong>{{ !empty($paymentInfo->supp_name) ? $paymentInfo->supp_name : '' }}</strong>
                    
                    <h5>{{ !empty($paymentInfo->city) ? $paymentInfo->city : '' }}{{ !empty($paymentInfo->country) ? ', '.$paymentInfo->country : '' }}</h5>
                    <h5>{{ !empty($paymentInfo->address) ? $paymentInfo->address : '' }}{{ !empty($paymentInfo->nuit) ? ', Nuit: '.$paymentInfo->nuit: '' }},</h5>
                    <h5>{{ !empty($paymentInfo->contact) ? $paymentInfo->contact : '' }}</h5>
                    <h5>{{ !empty($paymentInfo->email) ? $paymentInfo->email : '' }}</h5>

                   
                  </div>

                  <div class="col-md-4">
                    <strong>{{ trans('message.extra_text.payment_receipt_id')}}</strong>
                    <h5 class="">{{ trans('message.extra_text.payment_receipt_no')}} # {{ $paymentInfo->reference }}</h5>
                    <h5 class="">{{ trans('message.invoice.payment_date2')}} : {{ formatDate($paymentInfo->payment_date) }}</h5>
                  </div>

                </div>

                <!--titulo recibo--><br><br>
                <h3 class="text-center">{{ trans('message.extra_text.payment_receipt_for')}}</h3><br><br>
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
                          <table class="table table-bordered">
                            <tbody>
                              <tr class="tbl_header_color dynamicRows">
                                <!--<th width="20%" class="text-center">{{ trans('message.quotation.quotation_no') }}</th>-->
                                <th width="20%" class="text-center">{{ trans('message.invoice.invoice_no') }}</th>
                                <th width="20%" class="text-center">{{ trans('message.invoice.invoice_date') }}</th>
                                <!--<th width="20%" class="text-center">{{ trans('message.invoice.invoice_amount') }}</th>-->
                                <th width="20%" class="text-center">{{ trans('message.invoice.paid_amount') }}</th>
                              </tr>
                              <?php while($resultado_cc = $comando_cc->fetch(PDO::FETCH_ASSOC)){
                                $ref_cc = $resultado_cc ["order_reference"];
                                $amount_cc = $resultado_cc ["amount"];
                                $rec_cc = $resultado_cc ["reference"];
                                ?>
                              <tr>
                                <!--<td width="20%" class="text-center">{{ $paymentInfo->order_reference }}</td>-->
                                <td width="20%" class="text-center"><?php echo $ref_cc;?></td>
                                <td width="20%" class="text-center">{{ formatDate($paymentInfo->invoice_date) }}</td>
                                
                                <td width="20%" class="text-center">
                                {{ Session::get('currency_symbol').number_format($amount_cc,2,'.',',') }}
                                </td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                      </div>
                      </div>
                  </div>
                

                <br><br>
                <div class="row">
                    <div class="col-md-6">
                        <strong>{{ trans('message.invoice.payment_on')}} : {{ $paymentInfo->payment_method }}</strong>
                    </div>

                    <div class="col-md-6 pull-right">
                      <div class="well well-lg  text-center"><strong>{{ trans('message.invoice.total_amount')}}<br/>
                      <?php echo Session::get('currency_symbol').number_format($rs_ttl_cc,2,'.',',') ?></strong></div>
                    </div>
                </div>

              </div>

            </div>
        </div>
        <!--Modal start-->
        <div id="emailReceipt" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <form id="sendPaymentReceipt" method="POST" action="{{url('payment/email-payment-info')}}">
            <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
            <input type="hidden" value="{{$paymentInfo->id}}" name="id" id="token">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('message.email.email_payment_receipt')}}</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="email">{{ trans('message.email.send_to')}}:</label>
                  <input type="email" value="{{ $paymentInfo->email }}" class="form-control" name="email" id="email">
                </div>
                <?php
                    $subjectText = str_replace('{order_reference_no}', $paymentInfo->order_reference, $emailInfo->subject);
                    
                    $subjectText = str_replace('{company_name}', Session::get('company_name'), $subjectText);
                 ?>
                <div class="form-group">
                  <label for="subject">{{ trans('message.email.subject')}}:</label>
                  <input type="text" class="form-control" name="subject" id="subject" value="{{$subjectText}}">
                </div>
                  <div class="form-groupa">
                      <?php
                      
                      $bodyInfo = str_replace('{customer_name}', $paymentInfo->supp_name, $emailInfo->body);
                      $bodyInfo = str_replace('{payment_id}', sprintf("%04d", $paymentInfo->id), $bodyInfo);
                      $bodyInfo = str_replace('{payment_method}', $paymentInfo->payment_method, $bodyInfo);
                      $bodyInfo = str_replace('{payment_date}', formatDate($paymentInfo->payment_date), $bodyInfo);
                      $bodyInfo = str_replace('{order_reference_no}', $paymentInfo->order_reference, $bodyInfo);
                      $bodyInfo = str_replace('{total_amount}', Session::get('currency_symbol').number_format($paymentInfo->amount,2,'.',','), $bodyInfo);                      
                      $bodyInfo = str_replace('{invoice_reference_no}', $paymentInfo->order_reference, $bodyInfo);
                      $bodyInfo = str_replace('{company_name}', Session::get('company_name'), $bodyInfo);
                      $bodyInfo = str_replace('{billing_state}', $paymentInfo->address, $bodyInfo);                      
                      $bodyInfo = str_replace('{billing_street}', $paymentInfo->city, $bodyInfo);                      
                      $bodyInfo = str_replace('{billing_city}', $paymentInfo->state, $bodyInfo);                      
                      $bodyInfo = str_replace('{billing_zip_code}', $paymentInfo->country, $bodyInfo);                       
                      $bodyInfo = str_replace('{billing_country}', $paymentInfo->nuit, $bodyInfo);
                      ?>
                      <textarea id="compose-textarea" name="message" id='message' class="form-control editor" style="height: 200px">{{$bodyInfo}}</textarea>
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
        <!--rightpart-->
        
      </div>
    </section>
    @include('layouts.includes.message_boxes')
@endsection

@section('js')
    <script type="text/javascript">
      $(function () {
        $(".editor").wysihtml5();
      });

    $('#sendPaymentReceipt').validate({
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