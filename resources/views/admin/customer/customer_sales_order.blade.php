@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!--Default box -->
        <div class="box">
           <div class="panel-body">
                <ul class="nav nav-tabs cus" role="tablist">
                    
                    <li>
                      <a href='{{url("customer/edit/$customerData->debtor_no")}}' >{{ trans('message.sidebar.profile') }}</a>
                    </li>
                    
                    <li class="active">
                      <a href="{{url("customer/order/$customerData->debtor_no")}}" >{{ trans('message.accounting.quotations') }}</a>
                    </li>
                    <li>
                      <a href="{{url("customer/invoice/$customerData->debtor_no")}}" >{{ trans('message.extra_text.invoices') }}</a>
                    </li>
                    <li>
                      <a href="{{url("customer/debit/$customerData->debtor_no")}}" >{{ trans('message.accounting.debitsss') }}</a>
                    </li>

                    <li>
                      <a href="{{url("customer/credit/$customerData->debtor_no")}}" >{{ trans('message.accounting.creditsss') }}</a>
                    </li>
                    
                    <li>
                      <a href="{{url("customer/payment/$customerData->debtor_no")}}" >{{ trans('message.extra_text.payments') }}</a>
                    </li>

                    <li>
                      <a href="{{url("customer/current_account/$customerData->debtor_no")}}" >{{ trans('message.extra_text.current_account') }}</a>
                    </li>

                    <li>
                      <a href="{{url("customer/pendentes/$customerData->debtor_no")}}" >{{ trans('message.extra_text.pendentes') }}</a>
                    </li>
               </ul>
              <div class="clearfix"></div>
           </div>
        </div> 
        <h3>{{$customerData->name}}</h3> 
        
        <div class="box">
      
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>{{ trans('message.accounting.quotation') }}</th>
                    <th>{{ trans('message.extra_text.quantity') }}</th>
                   
                    <th>{{ trans('message.invoice.total') }}</th>
                    <th>{{ trans('message.table.ord_date') }}</th>
                    <th width="11%">{{ trans('message.table.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($salesOrderData as $data)
                <tr>
                  <td><a href="{{URL::to('/')}}/order/view-order-details/{{$data->order_no}}">{{$data->reference }}</a></td>
                  <td>{{ $data->ordered_quantity }}</td>


                    <td>{{ Session::get('currency_symbol').number_format($data->order_amount,2,'.',',') }}</td>
                    <td>{{formatDate($data->ord_date)}}</td>

                  
                  <td class="text-center">
                   
                        <a title="View" class="btn btn-xs btn-primary" href={{ url("order/view-order-details/$data->order_no") }}><span class="fa fa-eye"></span></a> &nbsp;
                        
                        <!--REMOVED BY Hugo<a  title="Edit" class="btn btn-xs btn-info" href='{{ url("order/edit/$data->order_no") }}'><span class="fa fa-edit"></span></a> &nbsp;

                        <form method="POST" action="{{ url("customer/delete-sales-info") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!}
                            <input type="hidden" name="action_name" value="delete_order">
                            <input type="hidden" name="order_no" value="{{$data->order_no}}">
                            <input type="hidden" name="customer_id" value="{{$customerData->debtor_no}}">
                            <button title="delete" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_order') }}" data-message="{{ trans('message.invoice.delete_order_confirm') }}">
                                <i class="glyphicon glyphicon-trash"></i> 
                            </button>
                        </form>-->
                    
              
                  </td>
                </tr>
               @endforeach
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