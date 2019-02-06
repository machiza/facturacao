@extends('layouts.app')
@section('content')
  <section class="content">

      <!---Top Section Start-->
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
             <div class="top-bar-title">{{ trans('message.sidebar.vd') }}</div>
            </div>
            <div class="col-md-2">
             
                <a href="{{ url("sales/add_vd") }}" class="btn btn-block btn-default btn-flat btn-border-orange">{{ trans('message.extra_text.new_sales_vd') }}</a>
              
            </div>
          </div>
        </div>
      </div>
      <!---Top Section End-->

    <div class="row">
      <div class="col-md-8 right-padding-col8">
          <div class="box box-default">
              <div class="box-body">
                     @if($venda->status_vd=='Anulado')
                    <div class="btn-group pull-left">
                        <div class="btn-group">
                          <div class="btn-unpaid" >{{ trans('message.table.cancel_inf')}}</div>
                         </div> 
                     </div> 
                     @endif
                    <div class="btn-group pull-right">
                      @if($venda->status_vd!='Anulado')
                      <button title="{{ trans('message.table.cancel_vd')}}" type="button" class="btn btn-default btn-flat Danger-btn" data-toggle="modal" data-target="#Cancel_vd">{{ trans('message.table.cancel_vd')}}
                      </button>
                     @endif
                     <!--btn chamar print-->
                      <a target="_blank" href="{{URL::to('/')}}/invoice/pdf-vd-print/{{$saleDataInvoice->vd_no}}" title="PRINT" class="btn btn-default btn-flat">{{ trans('message.extra_text.print')  }}</a>

                      <!--btn chamar pfd-->
                      <a target="_blank" href="{{URL::to('/')}}/invoice/pdf-vd/{{$saleDataInvoice->vd_no}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
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
                  <strong>{{ trans('message.extra_text.vd_to') }}</strong>
                  <h5>{{$venda->name}} </h5>

                  <h5>{{-- $billing_street --}}
                  	</h5>
                  

                  <h5>Nuit:{{$nuit}}</h5>
                  </div>

                <div class="col-md-4">
                  <strong>{{ trans('message.table.vd_no') }} # {{$venda->reference_vd }}</strong>
                  <h5><strong>{{ trans('message.table.vd_date') }}: </strong> {{$venda->vd_date}}</h5>
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
                       $discountTotal=0;
                        $subTotal=0;
                      @endphp
                      
                       @php $subTotal = 0;$units = 0;  @endphp
                  
                        @foreach ($invoiceData as  $dados)
                       	   

                          @if($dados->quantity>0)
                            <tr>
                              <td class="text-center">{{$dados->description}}</td>
                              <td class="text-center">{{$dados->quantity}}</td>
                              <td class="text-center">{{number_format($dados->unit_price,2,'.',',')}}</td>
                              <td class="text-center">{{number_format($dados->tax_rate,2,'.',',')}}</td>
                              <td class="text-center">{{number_format($dados->discount_percent,2,'.',',')}}</td>
                              @php
                                $priceAmount = ($dados->quantity*$dados->unit_price);
                                $discount = ($priceAmount*$dados->discount_percent)/100;
                                $discountTotal+=$discount;
                                $newPrice = ($priceAmount-$discount);

                                $taxAmount = (($newPrice*$dados->tax_rate)/100);
                                $taxTotal += $taxAmount;
                                $subTotal += $newPrice;
                                $units += $dados->quantity;
                                $itemsInformation .= '<div>'.$dados->quantity.'x'.' '.$dados->description.'</div>';
                              @endphp
                              <td align="right">{{number_format($newPrice,2,'.',',') }}</td>
                            </tr>
                          @endif
                        @endforeach  
                         <tr class="tableInfos">
                          <td colspan="5" align="right">{{ trans('message.table.total_qty') }}</td>
                          <td align="right" colspan="2">{{$units}}</td>
                        </tr>

                        <tr class="tableInfos">
                          <td colspan="5" align="right">{{ trans('message.table.before_discount')}}</td>
                          <td align="right" colspan="2">  {{ Session::get('currency_symbol').number_format($discountTotal+$subTotal,2,'.',',') }}</td>
                        </tr>

                          <tr class="tableInfos">
                            <td colspan="5" align="right">{{ trans('message.table.discount')}}</td>
                            <td align="right" colspan="2">{{ Session::get('currency_symbol').number_format($discountTotal,2,'.',',') }}</td>
                          </tr>
                       <tr>
                        <td colspan="5" style="text-align: right;"><strong>{{ trans('message.invoice.sub_total') }}:</strong></td>
                        <td style="text-align: right;">{{ Session::get('currency_symbol').number_format($subTotal,2,'.',',') }}</td>
                       </tr>
                        
                        <tr>
                        <td colspan="5" style="text-align: right;"><strong>{{ trans('message.table.tax') }}:</strong></td>
                        <td style="text-align: right;">{{ Session::get('currency_symbol').number_format($venda->total-$subTotal,2,'.',',')}}</td>
                       </tr>

                       <tr>
                       	<td colspan="5" style="text-align: right;"><strong>{{ trans('message.table.amount')}}:</strong></td>
                       	<td style="text-align: right;">{{ Session::get('currency_symbol').number_format($venda->total,2,'.',',')}}</td>
                       </tr>

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


  <!-- Cancel Order Modal -->
  <div class="modal fade" id="Cancel_vd" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ trans('message.table.cancel_vd') }}</h4>
        </div>
        <div class="modal-body">
        <form class="form-horizontal" id="payForm" action="{{route('updateVD',$venda->vd_no)}}" method="POST">
          <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
          
          <input type="hidden" name="orderInvoiceId" value="">

           <div class="form-group">
            <label for="cliente" class="col-sm-3 control-label">{{ trans('message.table.vd_no')}}  </label>
            <div class="col-sm-6">
              <input type="number" name="cliente" value="" class="form-control" id="vd_ref" placeholder="{{$venda->reference_vd}}" readonly="">
            </div>
          </div>
                
          
          <div class="form-group">
            <label for="cliente" class="col-sm-3 control-label">{{ trans('message.table.vd_ower') }}  </label>
            <div class="col-sm-6">
              <input type="number" name="cliente" value="nome" class="form-control" id="cliente" placeholder="{{$venda->name}}" readonly="">
            </div>
          </div>

          <div class="form-group">
            <label for="cliente" class="col-sm-3 control-label">{{ trans('message.table.grand_total') }}</label>
            <div class="col-sm-6">
              <input type="number" name="cliente" value="{{ Session::get('currency_symbol').number_format($venda->total,2,'.',',') }}" class="form-control" id="cliente" placeholder="{{ Session::get('currency_symbol').number_format($venda->total,2,'.',',') }}" readonly="">
            </div> 
          </div>

          <div class="form-group">
            <label for="cliente" class="col-sm-3 control-label">{{ trans('message.form.description_vd') }}</label>
            <div class="col-sm-6">
                  <textarea class="form-control" name="description" rows="3" placeholder="{{ trans('message.form.description_vd') }}"></textarea>
             </div>     
          </div>

          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
              <button type="submit" class="btn btn-danger btn-flat" name="btn_pagar">{{ trans('message.table.cancel_vd') }}</button>
           
              <button type="submit" class="btn btn-Normal btn-flat" data-dismiss='modal'>{{ trans('message.form.cancel') }}</button>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
  <!--Pay Modal End-->



</section>


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