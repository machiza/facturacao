<?php
require_once './conexao.php';
$query = "Select * from sales_vd
inner join debtors_master on sales_vd.debtor_no_vd=debtors_master.debtor_no";
$comando_query = $pdo->prepare($query);
$comando_query->execute();
?>

@extends('layouts.app')
@section('content')
<!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
                    <div class="col-md-10">
                        <div class="top-bar-title padding-bottom">{{ trans('message.sidebar.vd') }}</div>
                    </div> 
                    <div class="col-md-2">
                    @if(Helpers::has_permission(Auth::user()->id, 'add_invoice'))
                    <a href="{{ url('sales/add_vd') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.new_sales_vd') }}</a>
                    @endif
                    </div>
                </div>
        </div>
      </div>

      <div class="box">
        <div class="box-body">
                <ul class="nav nav-tabs cus" role="tablist">
                    
                    <li  class="active">
                      <a href='{{url("sales/vd")}}' >{{ trans('message.extra_text.all') }}</a>
                    </li>

               </ul>
        </div>
       
      </div><!--Filtering Box End-->


            <!-- Default box -->
      <div class="box">
        <div class="box-header">
          <a href="{{ url('sales/vd-report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
        </div>

            <div class="box-body">
              <div class="table-responsive">
                <table id="example1" class="table table-hover">
                  {{--class="table table-bordered table-striped"--}}
                  
                  <thead>
                    @php
                      $total=0;
                    @endphp
                  <tr>
                    <th>{{ trans('message.table.vd_date') }}</th>
                    <th>{{ trans('message.table.vd_no') }}</th>
                    <th>{{ trans('message.table.customer_name') }}</th>
                    <th>{{ trans('message.table.total_price') }}</th>
                    <th>{{-- trans('message.table.vd_date') --}}Status</th>
                    @if(Helpers::has_permission(Auth::user()->id, 'delete_invoice'))
                    <th width="5%">{{ trans('message.table.action') }}</th>
                    @endif
                  </tr>
                  </thead>
                  <tbody>
                @foreach($vendas as $venda)
                   

                  @if($venda->status_vd=='Anulado')
                      {{--<tr  bgcolor="#FF0000">--}}
                        <tr>
                  @else
                     <tr>
                  @endif 
                  <td>{{$venda->vd_date}}</td>
                    <td>
                      <a href="{{URL::to('/')}}/invoice/view-detail-vd/{{$venda->vd_no}}">
                        {{$venda->reference_vd}}
                      </a>
                    </td>

                  <td>
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_customer'))
                    <a href="{{url("customer/edit/$venda->debtor_no_vd")}}">{{$venda->name}}</a>
                    @else
                      {{$venda->name}}
                    @endif
                  </td>

                  <td>
                    {{Session::get('currency_symbol').number_format($venda->total, 2)}}
                    
                    @if($venda->status_vd!='Anulado')
                      @php
                      $total=$total+$venda->total;
                      @endphp
                    @endif
                  </td>
                  
                  <td>{{$venda->status_vd}}</td>
                     @if(Helpers::has_permission(Auth::user()->id, 'delete_invoice'))
                        <td>
                            <form method="POST" action="{{ url("sales/vd-delete/$venda->vd_no") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!}
                                <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.table.delete_vd') }}" data-message="{{ trans('message.table.delete_vd_info') }}">
                                <i class="fa fa-remove" aria-hidden="true"></i>
                                </button>
                            </form> 
                          </td> 
                      @endif
                    
                  </tr>

                  @endforeach  
                  <tr>
                    <td></td>
                    <td></td>
                    <td><strong>Total</strong></td>
                    <td>{{Session::get('currency_symbol').number_format($total, 2)}}</td>
                    <td></td>
                    
                    @if(Helpers::has_permission(Auth::user()->id, 'delete_invoice'))
                        <td>
                        </td>  
                    @endif
                  </tr>  
                 <!--end while-->
                 
                 </tbody>
                </table>
              </div>
            </div>

            <!-- /.box-body -->
          </div>
      <!-- /.box -->
    </section>
@endsection
@include('layouts.includes.message_boxes')
@section('js')
    <script type="text/javascript">

  $(function () {
    $("#example1").DataTable({
      "order": [],
      "columnDefs": [ {
       // "targets": 5,
        "orderable": false
        } ],

        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });

    </script>
@endsection