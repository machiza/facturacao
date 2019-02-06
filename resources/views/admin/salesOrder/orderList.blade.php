<?php
require_once './conexao.php';

$sql = "select * from sales_orders
inner join sales_order_details on sales_orders.order_no=sales_order_details.order_no
inner join debtors_master on sales_orders.debtor_no=debtors_master.debtor_no
where order_reference_id=0";
$comando = $pdo->prepare($sql);
$comando->execute();
?>

@extends('layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">

    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-10">
           <div class="top-bar-title padding-bottom">{{ trans('message.accounting.quotations') }}</div>
          </div> 
          <div class="col-md-2">
            @if(Helpers::has_permission(Auth::user()->id, 'add_quotation'))
              <a style="margin-left:-50px; width:200px" href="{{ url('order/add') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.accounting.add_new_quotation') }}</a>
            @endif
          </div>
        </div>
      </div>
    </div>
      <div class="box">
        <div class="box-body">
                <ul class="nav nav-tabs cus" role="tablist">
                    
                    <li  class="active">
                      <a href='{{url("order/list")}}' >{{ trans('message.extra_text.all') }}</a>
                    </li>
                    
                    <li>
                      <a href="{{url("order/filtering")}}" >{{ trans('message.extra_text.filter') }}</a>
                    </li>

               </ul>
        </div>
      </div>
      <!--Filtering Box End-->


      <div class="box">
          <!-- /.box-header -->
            <div class="box-header">
              <a href="{{ url('sales_orders-report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
           </div>

            <div class="box-body">
              <div class="table-responsive">
                <table id="orderList" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                     <th>{{ trans('message.table.ord_date') }}</th>
                    <th width="12%">{{ trans('message.accounting.quotation_no') }}</th>
                    <th>{{ trans('message.table.customer_name') }}</th>
                    <th>{{ trans('message.extra_text.quantity') }}</th>
                    <th>{{ trans('message.table.total') }}</th>
                    <th width="8%">{{ trans('message.table.action') }}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($orderData as $data)
                 
                  <tr>
                     <td>{{formatDate($data->ord_date)}}</td>
                    <td><a href="{{URL::to('/')}}/order/view-order-details/{{$data->order_no}}">{{$data->reference }}</a></td>
                    
                    <td>
                    @if( $data->status_debtor!='desactivo')
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_customer'))
                    <a href="{{URL::to('/')}}/customer/edit/{{$data->debtor_no}}">{{ $data->name }}</a>
                    @else
                         {{ $data->name }}
                    @endif
                    @else
                           {{ $data->name }}
                    @endif
                    </td>
                    

                    <td>{{ $data->qty }}</td>

                    <td>{{ Session::get('currency_symbol').number_format($data->order_amount,2,'.',',') }}</td>
                   
                    <td>
                    
                  @if(Helpers::has_permission(Auth::user()->id, 'edit_quotation'))
                        <a  title="Edit" class="btn btn-xs btn-primary" href='{{ url("order/edit/$data->order_no") }}'><span class="fa fa-edit"></span></a> &nbsp;

                  @endif
                  @if(Helpers::has_permission(Auth::user()->id, 'delete_quotation'))
                        <form method="POST" action="{{ url("order/delete/$data->order_no") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!}
                            
                            <button title="delete" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_order') }}" data-message="{{ trans('message.invoice.delete_order_confirm') }}">
                                <i class="glyphicon glyphicon-trash"></i> 
                            </button>
                        </form>
                   @endif
                    </td>
                  </tr>
                  
                 @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
      <!-- /.box -->

    </section>

@include('layouts.includes.message_boxes')

@endsection

@section('js')
    <script type="text/javascript">
    $('.select2').select2({});
    $('#from').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });

    $('#to').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });

  $(function () {
    $("#orderList").DataTable({
      "order": [],
      "columnDefs": [ {
        "targets": 5,
        "orderable": false
        } ],

        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });

    </script>
@endsection