<?php
require_once './conexao.php';
$query = "Select * from sales_gt, debtors_master
where sales_gt.debtor_no_gt=debtors_master.debtor_no";
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
                        <div class="top-bar-title padding-bottom">{{ trans('message.sidebar.transportation_guide') }}</div>
                    </div> 
                    <div class="col-md-2">
                    @if(Helpers::has_permission(Auth::user()->id, 'add_invoice'))
                    <a href="{{ url('sales/add_guiatransporte') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.new_sales_trans_guide') }}</a>
                    @endif
                    </div>
                </div>
    		</div>
    	</div>

    	<div class="box">
        <div class="box-body">
                <ul class="nav nav-tabs cus" role="tablist">
                    
                    <li  class="active">
                      <a href='{{url("sales/guiatransporte")}}' >{{ trans('message.extra_text.all') }}</a>
                    </li>

               </ul>
        </div>
       
      </div><!--Filtering Box End-->


            <!-- Default box -->
      <div class="box">
            <!-- /.box-header -->
              <div class="box-header">
              <a href="{{ url('guiatransporte-report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
           </div>

            <div class="box-body">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>{{ trans('message.invoice.invoice_date_trans_guide') }}</th>
                    <th>{{ trans('message.sidebar.transportation_guide') }}</th>
                    <th>{{ trans('message.table.customer_name') }}</th>
                    <th>{{ trans('message.transaction.del_gui_local') }}</th>
                    <th>{{ trans('message.transaction.del_gui_Motorista') }}</th>
                    @if(Helpers::has_permission(Auth::user()->id, 'delete_invoice'))
                      <th>{{ trans('message.table.action') }}</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                @foreach($guias as $guia)           
                  <tr>
                     <td>{{$guia->gt_date}}</td>
                     
                    <td>
                      <a href="{{URL::to('/')}}/sales/view_detail_gt/{{$guia->gt_no}}">
                        {{$guia->reference_gt}}
                      </a>
                    </td>
                  <td>
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_customer'))
                      <a href="{{url("customer/edit/$guia->debtor_no_gt")}}">{{$guia->name}}</a>
                    @else
                    {{$guia->name}}
                    @endif
                  </td>

                    <td>{{$guia->local_entrega}}</td>
                    <td>{{$guia->motorista}}</td>
 
                    @if(Helpers::has_permission(Auth::user()->id, 'delete_invoice'))
                        <td>
                            <form method="POST" action="{{ url("sales/delete_guiatransporte/$guia->gt_no") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!} 
                                <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.extra_text.del_guide')  }}" data-message="{{ trans('message.table.trans_guide_info') }}">
                                <i class="fa fa-remove" aria-hidden="true"></i>
                                </button>
                            </form> 
                             <a title="edit" class="btn btn-xs btn-primary"  href="{{url("sales/add_guiatransporte/$guia->gt_no/edit")}}"><span class="fa fa-edit"></span></a>
                          </td> 
                    @endif
                  </tr>
                 @endforeach
                 </tbody>/4/edit
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
    $("#example1").DataTable({
      "order": [],
      "columnDefs": [ {
        //"targets": 5,
        "orderable": false
        } ],

        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });

    </script>
@endsection