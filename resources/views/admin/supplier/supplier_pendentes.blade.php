@php
$id = $supplierData->supplier_id;
@endphp


@extends('layouts.app')
@section('content')

<!-- Main content -->
    <section class="content">
      <!-- Default box -->
        <div class="box">
           <div class="panel-body">
                <ul class="nav nav-tabs cus" role="tablist">
                	<li>
                      <a href="{{url("edit-supplier/$supplierData->supplier_id")}}" >{{ trans('message.sidebar.profile') }}</a>
                    </li>
                    <li>
                      <a href="{{url("supplier/orders/$supplierData->supplier_id")}}" >{{ trans('message.extra_text.purchase_orders') }}</a>
                    </li>

                    <li>
                      <a href="{{url("supplier/current_account/$supplierData->supplier_id")}}" >{{ trans('message.extra_text.current_account') }}</a>
                    </li>

                    <li class="active">
                      <a href="{{url("supplier/pendentes/$supplierData->supplier_id")}}" >{{ trans('message.extra_text.pendentes') }}</a>
                    </li>
                    <li>
                      <a href="{{url("supplier/payment_list/$supplierData->supplier_id")}}" >{{ trans('message.extra_text.payments') }}</a>
                    </li>
               </ul>
              <div class="clearfix"></div>
           </div>
        </div>
        <h3>{{$supplierData->supp_name}}</h3>  

    <div class="box">
      <!-- /.box-header -->
        <div class="box-body">

          <div class="btn-group pull-right">
            <!--btn chamar pfd-->
             @if(count($purchData) >= 1)
              <a target="_blank" href="{{URL::to('/')}}/supplier/pdf-pendente-pdf/{{$supplierData->supplier_id}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
            @endif
          </div><br><br>

              <table id="example1" class="table table-bordered table-striped">
                <thead>

                  <tr>
                    <th>{{ trans('message.accounting.data') }}</th>
                    <th>{{ trans('message.accounting.docs') }}</th>
                    <th>{{ trans('message.table.total_price') }}</th>
                    <th>{{ trans('message.table.paid_amount') }}</th>
                    <th>{{ trans('message.table.balance_amount') }}</th>
                  </tr>

                </thead>
                <tbody>
                @foreach($purchData as $data)                  
                  <tr>
                    <!--data-->
                    <td>{{$data->ord_date}}</td>

                    <!--documento-->
                    <td>
                    	<a href="{{URL::to('/')}}/purchase/view-purchase-details/{{$data->order_no}}" >
                    	    {{$data->reference}}
                    	</a>
                    </td>

                    <!--amount doc-->
                    <td>{{Session::get('currency_symbol').number_format($data->total,2)}}</td>
                    <td>{{Session::get('currency_symbol').number_format($data->valor_pago,2)}}</td>
                    <td>{{Session::get('currency_symbol').number_format($data->total - $data->valor_pago,2)}}</td>
                  </tr>               
                 @endforeach

                 @if(count($purchData) >= 1)
                  <tr>
                    <td></td>
                    <td><strong>Totais:</strong> </td>

                    <td>
                      <strong>
                        {{Session::get('currency_symbol').number_format($total->total_price,2)}}
                      </strong>
                    </td>

                    <td>
                      <strong>
                          {{Session::get('currency_symbol').number_format($saldo->total_saldo,2)}}
                      </strong>
                    </td>

                    <td>
                      <strong>
                          {{Session::get('currency_symbol').number_format($total->total_price - $saldo->total_saldo,2)}}
                      </strong>
                  </td>
                  </tr>
                 @endif

                 

                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        
        <!-- /.box-footer-->
    

    @include('layouts.includes.message_boxes')
    </section>
@endsection


@section('js')
    <script type="text/javascript">

    $(function () {
      
      
      $("#example1").DataTable({
        "order": [],
        "columnDefs": [ {
          "targets": 3,
          "orderable": false
          } ],

          "language": '{{Session::get('dflt_lang')}}',
          "pageLength": '{{Session::get('row_per_page')}}'
      });
      
    });

    </script>
@endsection