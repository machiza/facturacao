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
                 {{-- @if($saleDataInvoice->total > 0)
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
                  --}}
                  </div>
                    <div class="btn-group pull-right">
                      
                      <button title="Email" type="button" class="btn btn-default btn-flat" data-toggle="modal" data-target="#emailInvoice">
                        {{ trans('message.extra_text.email') }}
                      </button>

                      <a target="_blank" href="{{URL::to('/')}}/invoice/print-debito/{{$SaleDebito->debit_no}}" title="Print" class="btn btn-default btn-flat">{{ trans('message.extra_text.print') }}</a>

                      <!--btn chamar pfd-->
                      <a target="_blank" href="{{URL::to('/')}}/invoice/pdf-debito/{{$SaleDebito->debit_no}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
                      
                     {{--
                      <!--btn chamar pfd-->
                      <a target="_blank" href="{{URL::to('/')}}/invoice/pdf-credito/{{$SaleDebito->debit_no}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
                      
                     
                      <a href="{{URL::to('/')}}/sales/edit/{{$saleDataInvoice->order_no}}" title="Edit" class="btn btn-default btn-flat">{{ trans('message.extra_text.edit') }}</a>
                     

                     
                      <a href="{{ URL::to('/')}}/invoice/delete-invoice/{{$saleDataInvoice->order_no}}" class="btn btn-default btn-flat delete-btn delete_data" type="button">
                            {{ trans('message.extra_text.delete') }}
                      </a>
                      
                      @if($saleDataInvoice->total > $saleDataInvoice->paid_amount)
                        <button title="{{ trans('message.invoice.pay_now')}}" type="button" class="btn btn-default btn-flat success-btn" data-toggle="modal" data-target="#payModal">{{ trans('message.invoice.pay_now')}}
                        </button>
                       @endif
                      --}}
                    </div>
              </div>

            <div class="box-body">
              <div class="row">
                
                  <div class="col-md-4">
                    <strong>{{ Session::get('company_name') }}</strong>
                    <h5 class="">{{ Session::get('company_street') }}</h5>
                    <h5 class="">{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</h5>
                    <h5 class="">{{ Session::get('company_country_id') }}, Nuit: {{$empresa->value}}</h5>
                  </div>

                  <div class="col-md-4">
                  <strong>{{ trans('message.extra_text.bill_to') }}</strong>
                  <h5>{{ !empty($customerInfo->name) ? $customerInfo->name : ''}}</h5>

                  <h5>{{ !empty($customerInfo->billing_street) ? $customerInfo->billing_street : ''}} </h5>
                  <h5>{{ !empty($customerInfo->billing_state) ? $customerInfo->billing_state : ''}}{{ !empty($customerInfo->billing_city) ? ', '.$customerInfo->billing_city : ''}}</h5>
                  <h5>{{ !empty($customerInfo->billing_country_id) ? $customerInfo->billing_country_id : ''}} {{ !empty($customerInfo->billing_zip_code) ? ', '.$customerInfo->billing_zip_code : ''}}</h5>
                  
                  <!--Nuit-->
                  <h5>Nuit:{{$customerInfo->nuit}}</h5>
                  </div>

                <!--Coluna fact-debt  DebitoData -->

               <div class="col-md-4">
                  <strong>{{ trans('message.invoice_pdf.invoice_debit_no').' # '. $DebitoData->reference_debit }} {{($DebitoData->reference_debit)}} ({{ trans('message.table.invoice_no') }} )</strong>
                    <h5>{{ trans('message.invoice.invoice_date_debit')}} : {{formatDate($DebitoData->debit_date)}}</h5>

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
                      @php
                       $itemsInformation = '';
                       $taxAmount = 0;
                       $taxTotal = 0;
                       $DiscountTotal=0;
                       $subTotal = 0;$units = 0;
                      @endphp
                      @if(count($DebitoDetalhes)>0)
                          @foreach($DebitoDetalhes as $produto)
                            
                            <tr>
                              <td class="text-center">{{$produto->description}}</td>
                              <td class="text-center">{{$produto->quantity}}</td>
                              <td class="text-center">{{number_format($produto->unit_price,2)}}</td>
                              <td class="text-center">{{number_format($produto->tax_rate,2,'.',',')}}</td>
                              <td class="text-center">{{number_format($produto->discount_percent,2)}}

                              </td>
                              @php
                                $priceAmount = ($produto->quantity*$produto->unit_price);
                                $discount = ($priceAmount*$produto->discount_percent)/100;
                                $newPrice = ($priceAmount-$discount);

                                $taxAmount = (($newPrice*$produto->tax_rate)/100);
                                $taxTotal += $taxAmount;
                                $subTotal += $newPrice;
                                $units += $produto->quantity;
                                
                                $itemsInformation .= '<div>'.$produto->quantity.'x'.' '.$produto->description.'</div>';
                              @endphp
                              <td align="right">{{number_format($newPrice,2,'.',',') }}</td>
                            </tr>
                             
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

                       <!--titulo preco pois-credito-->
                      <tr class="tableInfos">
                        <td colspan="5" align="right"><strong>Descontos</strong>
                      </td>

                       <!--titulo preco pois-credito-->
                      <tr class="tableInfos">
                        <td colspan="5" align="right"><strong>{{ trans('message.table.price') }}</strong>
                      </td>
                      <!--rs preco pois-debit-->
                      <td colspan="2" class="text-right">
                        <strong>{{ Session::get('currency_symbol').number_format($subTotal+$taxTotal,2,'.',',') }}</strong></td>
                      </tr>

                      <tr class="tableInfos">
                        <td colspan="5" align="right">{{ trans('message.invoice.paid') }}</td>
                        <td colspan="2" class="text-right"> {{--Session::get('currency_symbol').number_format($saleDataInvoice->paid_amount_debit,2,'.',',') --}}
                        </td>
                      </tr>

                      <tr class="tableInfos"><td colspan="5" align="right">
                        <strong>{{ trans('message.invoice.due') }}</strong>
                      </td>

                        <td colspan="2" class="text-right">
                          <strong>
                        @if(($subTotal+$taxTotal-$DebitoData->paid_amount_debit)<0)
                        -{{ Session::get('currency_symbol').number_format(abs($subTotal+$taxTotal-$DebitoData->paid_amount_debit),2,'.',',') }}
                        @else
                        {{ Session::get('currency_symbol').number_format(abs($subTotal+$taxTotal-$DebitoData->paid_amount_debit),2,'.',',') }}
                        @endif
                      </strong>
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
     {{-- @include('layouts.includes.content_right_option') --}}
      </div>
  </section>

  <!--Pay Modal Start-->

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