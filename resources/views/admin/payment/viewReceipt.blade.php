@php
$id = $paymentInfo->id;
@endphp

<!--nuit-->
@php
$supp_id = $paymentInfo->debtor_no;
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


//recibo
$comando_rec = $pdo->prepare("Select * from payment_history where id = '$id'");
$comando_rec->execute();
$resultado_rec = $comando_rec->fetch();
$rec = $resultado_rec ["reference"];

$sql_cc = "Select * from sales_cc
inner join payment_history on sales_cc.reference_doc=payment_history.reference where reference = '$rec'";
$comando_cc = $pdo->prepare($sql_cc);
$comando_cc->execute();
/*while($resultado_cc = $comando_cc->fetch(PDO::FETCH_ASSOC)){
  $ref_cc = $resultado_cc ["reference"];
  echo $ref_cc;
}*/

$sql_cc_ttl = "Select * from sales_cc
inner join payment_history on sales_cc.reference_doc=payment_history.reference where reference = '$rec'";
$comando_cc_ttl = $pdo->prepare($sql_cc_ttl);
$comando_cc_ttl->execute();
$resultado_cc_ttl = $comando_cc_ttl->fetch();
$rs_ttl_cc1 = $resultado_cc_ttl["amount_credito_doc"];
$rs_ttl_cc = $resultado_cc_ttl["amount_credito_doc"];
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
              <a href="{{ url('payment/new_payment') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.new_sales_payments') }}</a>
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
                      <a target="_blank" href="{{URL::to('/')}}/payment/print-receipt/{{$paymentInfo->id}}" title="Print" class="btn btn-default btn-flat">{{ trans('message.extra_text.print') }}</a>

                      <!--pdf-->
                      <a target="_blank" href="{{URL::to('/')}}/payment/create-receipt/{{$paymentInfo->id}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>

                       @if(!empty(Session::get('payment_delete')))
                      <form method="POST" action="{{ url("payment/delete") }}" accept-charset="UTF-8" style="display:inline">
                          {!! csrf_field() !!}
                          <input type="hidden" name="id" value="{{$paymentInfo->id}}">
                          <button class="btn btn-default btn-flat delete-btn" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_payment_header') }}" data-message="{{ trans('message.invoice.delete_payment') }}">
                            {{ trans('message.extra_text.delete') }}
                          </button>
                      </form>
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
                    <strong>{{ !empty($paymentInfo->name) ? $paymentInfo->name : '' }}</strong>
                    <h5>{{ !empty($paymentInfo->billing_street) ? $paymentInfo->billing_street : '' }}</h5>
                    <h5>{{ !empty($paymentInfo->billing_city) ? $paymentInfo->billing_city : '' }}{{ !empty($paymentInfo->billing_state) ? ', '.$paymentInfo->billing_state : '' }}</h5>
                    <h5>{{ !empty($paymentInfo->billing_country_id) ? $paymentInfo->billing_country_id : '' }}{{ !empty($paymentInfo->billing_zip_code) ? ', '.$paymentInfo->billing_zip_code: '' }}</h5>

                    <!--Nuit-->
                  <h5>Nuit: <?php echo $nuit;?></h5>
                  </div>

                  <div class="col-md-4">
                    <strong>{{ trans('message.extra_text.payment_receipt_id')}}</strong>
                    <h5 class="">{{ trans('message.extra_text.payment_receipt_no')}} # {{ $paymentInfo->reference }}</h5>
                    <h5 class="">{{ trans('message.invoice.payment_date2')}} : {{ formatDate($paymentInfo->payment_date) }}</h5>
                  </div>

                </div>

                <!--titulo recibo--><br><br>
                <h3 class="text-center">{{ trans('message.extra_text.payment_receipt_cli')}}</h3><br><br>
                  
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
                              @foreach ($dados as $dado)
                              <tr>
                                <!--<td width="20%" class="text-center">{{ $paymentInfo->order_reference }}</td>-->
                                <td width="20%" class="text-center">{{$dado->invoice_reference}}</td>
                                <td width="20%" class="text-center">{{ formatDate($dado->payment_date) }}</td>
                                <td width="20%" class="text-center">
                                {{ Session::get('currency_symbol').number_format($dado->amount,2,'.',',') }}
                                </td>
                              </tr>
                              @endforeach
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
                    $subjectText = str_replace('{invoice_reference_no}', $paymentInfo->invoice_reference, $subjectText);
                    $subjectText = str_replace('{company_name}', Session::get('company_name'), $subjectText);
                 ?>
                <div class="form-group">
                  <label for="subject">{{ trans('message.email.subject')}}:</label>
                  <input type="text" class="form-control" name="subject" id="subject" value="{{$subjectText}}">
                </div>
                  <div class="form-groupa">
                      <?php
                      
                      $bodyInfo = str_replace('{customer_name}', $paymentInfo->name, $emailInfo->body);
                      $bodyInfo = str_replace('{payment_id}', sprintf("%04d", $paymentInfo->id), $bodyInfo);
                      $bodyInfo = str_replace('{payment_method}', $paymentInfo->payment_method, $bodyInfo);
                      $bodyInfo = str_replace('{payment_date}', formatDate($paymentInfo->payment_date), $bodyInfo);
                      $bodyInfo = str_replace('{order_reference_no}', $paymentInfo->order_reference, $bodyInfo);
                      $bodyInfo = str_replace('{total_amount}', Session::get('currency_symbol').number_format($paymentInfo->amount,2,'.',','), $bodyInfo);                      
                      $bodyInfo = str_replace('{invoice_reference_no}', $paymentInfo->invoice_reference, $bodyInfo);
                      $bodyInfo = str_replace('{company_name}', Session::get('company_name'), $bodyInfo);
                      $bodyInfo = str_replace('{billing_state}', $paymentInfo->billing_state, $bodyInfo);                      
                      $bodyInfo = str_replace('{billing_street}', $paymentInfo->billing_street, $bodyInfo);                      
                      $bodyInfo = str_replace('{billing_city}', $paymentInfo->billing_state, $bodyInfo);                      
                      $bodyInfo = str_replace('{billing_zip_code}', $paymentInfo->billing_zip_code, $bodyInfo);                       
                      $bodyInfo = str_replace('{billing_country}', $paymentInfo->billing_country_id, $bodyInfo);
                      ?>
                      <textarea id="compose-textarea" name="message" id='message' class="form-control editor" style="height: 200px">{{$bodyInfo}}</textarea>

                      <div class="form-group">
                    <div class="checkbox">
                      <label><input type="checkbox" name="quotation_pdf" checked><strong>{{$paymentInfo->reference}}</strong></label>
                    </div>
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
        <!--rightpart-->
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