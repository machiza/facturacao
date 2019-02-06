@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-10">
             <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.purchases') }}</div>
            </div> 
            <div class="col-md-2">
              @if(Helpers::has_permission(Auth::user()->id, 'add_purchase'))
                <a href="{{ url('purchase/add') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.new_purchase') }}</a>
              @endif
            </div>

          </div>
        </div>
      </div>

        <div class="box">
          
           <div class="panel-body">
                <ul class="nav nav-tabs cus" role="tablist">
                    
                    <li  class="active">
                      <a href='{{url("purchase/list")}}' >{{ trans('message.extra_text.all') }}</a>
                    </li>
                    
                    <li>
                      <a href="{{url("purchase/filtering")}}" >{{ trans('message.extra_text.filter') }}</a>
                    </li>

               </ul>
              <div class="clearfix"></div>
           </div>
        </div> 
        

        <!-- Default box -->
        <div class="box">
          <div class="box-header">
             <a href="{{ url('purchase/report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table id="purchaseList" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>{{ trans('message.table.date') }}</th>
                    <th width="10%">{{ trans('message.extra_text.purchases') }} #</th>
                    <th>{{ trans('message.table.supp_name') }}</th>
                    
                    <!--NUIT-->
                    <th>Nuit</th>

                    <th>{{ trans('message.invoice.total') }}</th>

                    <!--VALOR PAGO-->
                    <th>{{ trans('message.table.paid_amount') }}</th>
                    <!--SALDO-->
                    <th>{{ trans('message.table.balance_amount') }}</th>
                    <th>{{ trans('message.table.paid_status') }}</th>
                    <th width="8%" class="hideColumn">{{ trans('message.table.action') }}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($purchData as $data)
                  <tr>
                     <td>{{ formatDate($data->ord_date)}}</td>
                    <td><a href="{{URL::to('/')}}/purchase/view-purchase-details/{{$data->order_no}}" >{{ $data->reference }}</a></td>
                    <td>
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_supplier'))
                    <a href="{{ url("edit-supplier/$data->supplier_id") }}">{{ $data->supp_name }}</a>
                    @else
                    {{ $data->supp_name }}
                    @endif
                    </td>

                    <td>{{ $data->nuit }}</td>
                    
                    <td>{{ Session::get('currency_symbol').number_format($data->total,2,'.',',') }}</td>

                    <!--Valor Pago:-->
                    <td>{{ Session::get('currency_symbol').number_format($data->valor_pago,2,'.',',') }}</td>
                    <!--SALDO:-->
                    <td>{{ Session::get('currency_symbol').number_format($data->total - $data->valor_pago,2,'.',',') }}</td>
                  
                    @if($data->valor_pago == 0)
                      <td><span class="label label-danger">{{ trans('message.invoice.unpaid')}}</span></td>
                    @elseif($data->valor_pago > 0 && $data->total > $data->valor_pago )
                      <td><span class="label label-warning">{{ trans('message.invoice.partially_paid')}}</span></td>
                    @elseif($data->valor_pago<=$data->valor_pago)
                      <td><span class="label label-success">{{ trans('message.invoice.paid')}}</span></td>
                    @endif


                    <td class="hideColumn">
                   @if(Helpers::has_permission(Auth::user()->id, 'edit_purchase'))
                        <a  title="edit" class="btn btn-xs btn-primary" href='{{ url("purchase/edit/$data->order_no") }}'><span class="fa fa-edit"></span></a> &nbsp;
                    @endif
                    @if(Helpers::has_permission(Auth::user()->id, 'delete_purchase'))
                        <form method="POST" action="{{ url("purchase/delete/$data->order_no") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!}
                            <button title="delete" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.table.delete_invoice_header') }}" data-message="{{ trans('message.table.delete_invoice') }}" disabled>
                                <i class="glyphicon glyphicon-trash"></i> 
                            </button>
                        </form>
                    @endif
                    </td>
                  </tr>
                 @endforeach
                  </tfoot>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>Totais</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
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
  $(function () {
    $("#purchaseList").DataTable({
      "order": [],
      "columnDefs": [ {
        "targets": 4,
        "orderable": false
        } ],

        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
  });
    </script>
@endsection