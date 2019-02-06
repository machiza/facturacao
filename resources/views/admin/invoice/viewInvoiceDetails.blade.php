@extends('layouts.app')
@section('content')
  <section class="content">

      <!---Top Section Start-->
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
             <div class="top-bar-title">{{ trans('message.invoice.invoice') }}</div>
            </div>
            <div class="col-md-2">
             
                <a href="{{ url("sales/add") }}" class="btn btn-block btn-default btn-flat btn-border-orange">{{ trans('message.extra_text.new_sales_invoice') }}</a>
              
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
                @if($saleDataInvoice->status!='cancelado')  
                  @if($saleDataInvoice->total > 0)
                  @if($saleDataInvoice->paid_amount == 0)
                    <div class="btn-unpaid" >{{ trans('message.invoice.unpaid')}}</div>
                  @elseif($saleDataInvoice->paid_amount > 0 && $saleDataInvoice->total > $saleDataInvoice->paid_amount )
                    <div class="btn-paid-partial" >{{ trans('message.invoice.partially_paid')}}</div>
                  @elseif($saleDataInvoice->total <= $saleDataInvoice->paid_amount)
                    <div class="btn-paid" >{{ trans('message.invoice.paid')}}</div>
                  @endif

                  @else
                  <div class="btn-paid" >{{ trans('message.invoice.paid')}}</div>
                  @endif
                @else
                   <div class="btn-unpaid" >{{ trans('message.invoice.cancela_inf')}}</div>
                @endif  
                  </div>
                    <div class="btn-group pull-right">
                      <button title="Email" type="button" class="btn btn-default btn-flat" data-toggle="modal" data-target="#emailInvoice">{{ trans('message.extra_text.email') }}</button>
                      <a target="_blank" href="{{URL::to('/')}}/invoice/print/{{$saleDataOrder->order_no}}/{{$saleDataInvoice->order_no}}" title="Print" class="btn btn-default btn-flat">{{ trans('message.extra_text.print') }}</a>

                      <!--btn chamar pfd-->
                      <a target="_blank" href="{{URL::to('/')}}/invoice/pdf/{{$saleDataOrder->order_no}}/{{$saleDataInvoice->order_no}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>

                      <a href="{{URL::to('/')}}/sales/edit/{{$saleDataInvoice->order_no}}" title="Edit" class="btn btn-default btn-flat">Edit</a>


                     @if($saleDataInvoice->status!='cancelado')  

                      @if($saleDataInvoice->total > $saleDataInvoice->paid_amount and  $saleDataInvoice->paid_amount!=0)
                     
                        <button title="{{ trans('message.invoice.pay_now')}}" type="button" class="btn btn-default btn-flat success-btn " data-toggle="modal" data-target="#payModal">{{ trans('message.invoice.pay_now')}}</button>
                      @endif

                      @if($saleDataInvoice->paid_amount == 0)
                      <button title="{{ trans('message.invoice.pay_now')}}" type="button" class="btn btn-default btn-flat success-btn " data-toggle="modal" data-target="#payModal">{{ trans('message.invoice.pay_now')}}</button>

                       <button title="{{ trans('message.invoice.cancel')}}" type="button" class="btn btn-default btn-flat Danger-btn" data-toggle="modal" data-target="#Cancel_order">{{ trans('message.invoice.cancel')}}
                       </button>
                       @endif
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
                    <h5> Nuit:{{$nuit_company}}</h5>
                  </div>

                  <div class="col-md-4">
                  <strong>{{ trans('message.extra_text.fact_to') }}</strong>
                  <h5>{{ !empty($customerInfo->name) ? $customerInfo->name : ''}}</h5>

                  <h5>{{ !empty($customerInfo->billing_street) ? $customerInfo->billing_street : ''}} 
                  {{ !empty($customerInfo->billing_state) ? $customerInfo->billing_state : ''}}{{ !empty($customerInfo->billing_city) ? ', '.$customerInfo->billing_city : ''}}</h5>
                  <h5>{{ !empty($customerInfo->billing_country_id) ? $customerInfo->billing_country_id : ''}} {{ !empty($customerInfo->billing_zip_code) ? ', '.$customerInfo->billing_zip_code : ''}}</h5>

                  <!--Nuit-->
                  <h5>Nuit:{{$nuit}}</h5>
                  </div>

                <div class="col-md-4">
                  <strong>{{ trans('message.table.invoice_no').' # '.$saleDataInvoice->reference }}</strong>
                  <h5>{{ trans('message.extra_text.location')}} : {{$saleDataInvoice->location_name}}</h5>
                  <h5>{{ trans('message.invoice.invoice_date')}} : {{formatDate($saleDataInvoice->ord_date)}}</h5>
                  <h5>{{ trans('message.invoice.due_date')}} : {{formatDate($due_date)}}</h5>
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
                        <th width="10%" class="text-center">{{ trans('message.table.amount') }}({{Session::get('currency_symbol')}})</th>
                      </tr>
                      @php
                       $itemsInformation = '';
                       $taxAmount = 0;
                       $taxTotal = 0;
                      @endphp
                      @if(count($invoiceData)>0)
                       @php 
                          $subTotal = 0;$units = 0;$valueTotal=0; $discountTotal=0; 
                          $taxValue=0; $taxAmount=0;
                       @endphp
                        @foreach($invoiceData as $result)
                          @if($result['quantity']>0)
                            <tr>
                              <td class="text-center">{{$result['description']}}</td>
                              <td class="text-center">{{$result['quantity']}}</td>
                              <td class="text-center">{{number_format($result['unit_price'],2,'.',',') }}</td>
                              <td class="text-center">{{number_format($result['tax_rate'],2,'.',',')}}</td>
                              <td class="text-center">{{number_format($result['discount_percent'],2,'.',',')}}</td>
                              <?php
                                $priceAmount = ($result['quantity']*$result['unit_price']);
                                $discount = ($priceAmount*$result['discount_percent'])/100;
                                $newPrice = ($priceAmount-$discount);

                                $taxAmount = (($newPrice*$result['tax_rate'])/100);
                                $taxTotal += $taxAmount;
                                $subTotal += $newPrice;
                                $units += $result['quantity'];
                                $itemsInformation .= '<div>'.$result['quantity'].'x'.' '.$result['description'].'</div>';
                                 $value=$result['unit_price']*$result['quantity'];
                                $valueTotal+=$value;
                                $discountAmount=$result['quantity']*($result['unit_price']*$result['discount_percent'])/100;
                                $discountTotal+=$discountAmount;
                              ?>
                              <td align="right">{{number_format($newPrice,2,'.',',') }}</td>
                            </tr>
                            @endif
                        @endforeach
                        <tr class="tableInfos"><td colspan="5" align="right">{{ trans('message.table.total_qty') }}</td><td align="right" colspan="2">{{$units}}</td></tr>
                        <tr class="tableInfos"><td colspan="5" align="right">{{ trans('message.table.before_discount')}}</td>
                          <td align="right" colspan="2">  {{ Session::get('currency_symbol').number_format($valueTotal,2,'.',',') }}</td></tr>
                           <tr class="tableInfos"><td colspan="5" align="right">{{ trans('message.table.discount')}}</td>
                            <td align="right" colspan="2">{{ Session::get('currency_symbol').number_format($discountTotal,2,'.',',') }}</td></tr>

                      <tr class="tableInfos"><td colspan="5" align="right">{{ trans('message.table.sub_total') }}</td><td align="right" colspan="2">{{ Session::get('currency_symbol').number_format($subTotal,2,'.',',') }}</td></tr>


                      <tr><td colspan="5" align="right">Tax</td><td colspan="2" class="text-right">{{ Session::get('currency_symbol').number_format($taxTotal,2,'.',',') }}</td></tr>


                      <tr class="tableInfos"><td colspan="5" align="right"><strong>{{ trans('message.table.grand_total') }}</strong></td><td colspan="2" class="text-right"><strong>{{ Session::get('currency_symbol').number_format($subTotal+$taxTotal,2,'.',',') }}</strong></td></tr>
                      
                      <tr class="tableInfos"><td colspan="5" align="right">{{ trans('message.invoice.paid') }}</td><td colspan="2" class="text-right"> {{ Session::get('currency_symbol').number_format($saleDataInvoice->paid_amount,2,'.',',') }}</td></tr>
                      <tr class="tableInfos"><td colspan="5" align="right"><strong>{{ trans('message.invoice.due') }}</strong></td><td colspan="2" class="text-right"><strong>
                        @if(($subTotal+$taxTotal-$saleDataInvoice->paid_amount)<0)
                        -{{ Session::get('currency_symbol').number_format(abs($subTotal+$taxTotal-$saleDataInvoice->paid_amount),2,'.',',') }}
                        @else
                        {{ Session::get('currency_symbol').number_format(abs($subTotal+$taxTotal-$saleDataInvoice->paid_amount),2,'.',',') }}
                        @endif
                      </strong></td></tr>
                      @endif
                      </tbody>
                    </table>
                    </div>
                      {{ !empty($saleDataInvoice->comments) ? 'Nota: '.$saleDataInvoice->comments : ''}}
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

  <!-- Cancel Order Modal -->
  <div class="modal fade" id="Cancel_order" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ trans('message.invoice.cancel') }}</h4>
        </div>
        <div class="modal-body">
        <form class="form-horizontal" id="payForm" action="{{route('updateOrder',$saleDataInvoice->order_no)}}" method="POST">
          <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
          
          <input type="hidden" name="orderInvoiceId" value="{{$saleDataInvoice->order_reference_id}}">

           <div class="form-group">
            <label for="cliente" class="col-sm-3 control-label">{{ trans('message.table.invoice_no') }}  </label>
            <div class="col-sm-6">
              <input type="number" name="cliente" value="{{$saleDataInvoice->reference}}" class="form-control" id="cliente" placeholder="{{$saleDataInvoice->reference}}" readonly="">
            </div>
          </div>
 

          <div class="form-group">
            <label for="cliente" class="col-sm-3 control-label">{{ trans('message.extra_text.fact_to') }}  </label>
            <div class="col-sm-6">
              <input type="number" name="cliente" value="{{$customerInfo->name}}" class="form-control" id="cliente" placeholder="{{$customerInfo->name}}" readonly="">
            </div>
          </div>

          <div class="form-group">
            <label for="cliente" class="col-sm-3 control-label">{{ trans('message.table.grand_total') }}</label>
            <div class="col-sm-6">
              <input type="number" name="cliente" value="{{ Session::get('currency_symbol').number_format($subTotal+$taxTotal,2,'.',',') }}" class="form-control" id="cliente" placeholder="{{ Session::get('currency_symbol').number_format($subTotal+$taxTotal,2,'.',',') }}" readonly="">
            </div>
          </div>

          <div class="form-group">
            <label for="cliente" class="col-sm-3 control-label">{{ trans('message.form.description') }}</label>
            <div class="col-sm-6">
                  <textarea class="form-control" name="description" rows="3" placeholder="{{ trans('message.form.description') }}"></textarea>
             </div>     
          </div>

          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
              <button type="submit" class="btn btn-danger btn-flat" name="btn_pagar">{{ trans('message.invoice.cancel') }}</button>
           
              <button type="submit" class="btn btn-Normal btn-flat" data-dismiss='modal'>{{ trans('message.form.cancel') }}</button>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
  <!--Pay Modal End-->


  
  <!--Pay Modal Start-->
  <div class="modal fade" id="payModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ trans('message.table.new_payment') }}</h4>
        </div>
        <div class="modal-body">
        <form class="form-horizontal" id="payForm" action="{{url('payment/save')}}" method="POST">
          <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
          <input type="hidden" name="invoice_reference" value="{{$saleDataInvoice->reference}}">
          <input type="hidden" name="order_reference" value="{{$saleDataOrder->reference}}">
          <input type="hidden" name="customer_id" value="{{$customerInfo->debtor_no}}">

          <input type="hidden" name="order_no" value="{{$orderInfo->order_no}}">
          <input type="hidden" name="invoice_no" value="{{$invoice_no}}">

          <!--Hugo-->
          <input type="hidden" id="reference_no" class="form-control" name="idrecibo" value="RE-{{ sprintf("%04d", $invoice_count+1)}}/<?php echo $parte_ano;?>" type="text" readonly>
          
          
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
              <input type="number" name="amount" value="{{$saleDataInvoice->total-$saleDataInvoice->paid_amount}}" class="form-control" id="amount" placeholder="Amount">
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
              <input type="text" name="description" class="form-control" id="description" placeholder="{{ trans('message.table.description') }}" value="<?php echo "Payment for ".$saleDataInvoice->reference;?>" readonly>
            </div>
          </div>

          <div class="form-group">
            <label for="reference" class="col-sm-3 control-label">{{ trans('message.table.reference') }}  </label>
            <div class="col-sm-6">
              <input type="text" name="reference" class="form-control" id="reference" placeholder="{{ trans('message.table.reference') }}">
            </div>
          </div>

          <!--Hugo-->
          <input type="hidden" id="reference_no" class="form-control" name="idrecibo" value="RE-{{ sprintf("%04d", $invoice_count+1)}}/{{$parte_ano}}" type="text" readonly>

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




  <!--Modal start-->
    <div id="emailInvoice" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <form id="sendVoiceInfo" method="POST" action="{{url('invoice/email-invoice-info')}}">
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        <input type="hidden" value="{{$orderInfo->order_no}}" name="order_id" id="order_id">
        <input type="hidden" value="{{$invoice_no}}" name="invoice_id" id="invoice_id">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">{{ trans('message.email.email_invoice_info')}}</h4>
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
                  <label><input type="checkbox" name="invoice_pdf" checked><strong>{{$saleDataInvoice->reference}}</strong></label>
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