@extends('layouts.app')
@section('content')
  <section class="content">

      <!---Top Section Start-->
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
             <div class="top-bar-title">{{ trans('message.extra_text.del_guide') }}</div>
            </div>
            <div class="col-md-2">
             @if(Helpers::has_permission(Auth::user()->id, 'add_invoice'))
                    <a href="{{ url('sales/add_guiaentrega') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.new_sales_del_guide') }}</a>
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

                    <div class="btn-group pull-right">
                     

                      <!--btn chamar print-->
                      <a target="_blank" href="{{URL::to('/')}}/invoice/pdf-ge-print/{{$ge}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.print')  }}</a>

                      <!--btn chamar pfd-->
                      <a target="_blank" href="{{URL::to('/')}}/invoice/pdf-ge/{{$ge}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
                      
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
                  <strong>{{ trans('message.extra_text.ge_to') }}</strong>
                  <h5>{{ !empty($customerInfo->name) ? $customerInfo->name : ''}}</h5>

                  <h5>{{ !empty($customerInfo->billing_street) ? $customerInfo->billing_street : ''}} 
                  {{ !empty($customerInfo->billing_state) ? $customerInfo->billing_state : ''}}{{ !empty($customerInfo->billing_city) ? ', '.$customerInfo->billing_city : ''}}</h5>
                  <h5>{{ !empty($customerInfo->billing_country_id) ? $customerInfo->billing_country_id : ''}} {{ !empty($customerInfo->billing_zip_code) ? ', '.$customerInfo->billing_zip_code : ''}}</h5>

                  <!--Nuit-->
                  <h5>
                    {{ !empty($customerInfo->nuit) ? $customerInfo->nuit : ''}} 
                  </h5>
                  </div>

                <div class="col-md-4">
                  <strong>{{ trans('message.table.ge_no') }} #{{$ref_ge}}</strong>
                  <h5>{{ trans('message.transaction.del_gui_local')}} :{{$local_entrega}}</h5>
                  <h5>{{ trans('message.form.data_entrega')}} :{{$ge_date}}</h5>
                <h5>Motaorista :{{$motorista}}</h5>    
                  
                    
                </div>

              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="box-body no-padding">
                    <div class="table-responsive">
                    <table class="table table-bordered" id="salesInvoice">
                      <tbody>
                      <tr class="tbl_header_color dynamicRows">
                        <th width="30%" class="text-center">Item</th>
                        <th width="10%" class="text-center">{{ trans('message.table.price') }}({{Session::get('currency_symbol')}})</th>
                        <th width="10%" class="text-center">{{ trans('message.table.quantity') }}</th>
                        <th width="10%" class="text-center">{{ trans('message.table.total_price') }}({{Session::get('currency_symbol')}})</th>
                      </tr>

                      @foreach($DataDetalhes as $dados)
                        <tr style="text-align: center">
                          <td>{{$dados->description}}</td>
                          <td>{{$dados->unit_price}}</td>
                          <td>{{$dados->quantity}}</td>
                          <td>{{$dados->unit_price * $dados->quantity}}</td>
                        </tr>
                      @endforeach
                      
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
      <!--include-->
      </div>
  </section>
  
@include('layouts.includes.message_boxes') 
@endsection
@section('js')

@endsection