<?php
require_once './conexao.php';
$query = "Select * from sales_ge
inner join debtors_master on sales_ge.debtor_no_ge=debtors_master.debtor_no";
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
                        <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.del_guide') }}</div>
                    </div> 
                    <div class="col-md-2">
                    @if(Helpers::has_permission(Auth::user()->id, 'add_invoice'))
                    <a href="{{ url('sales/add_guiaentrega') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.new_sales_del_guide') }}</a>
                    @endif
                    </div>
                </div>
    		</div>
    	</div>

    	<div class="box">
        <div class="box-body">
                <ul class="nav nav-tabs cus" role="tablist">
                    
                    <li  class="active">
                      <a href='{{url("sales/guiaentrega")}}' >{{ trans('message.extra_text.all') }}</a>
                    </li>

               </ul>
        </div>
       
      </div><!--Filtering Box End-->


            <!-- Default box -->
      <div class="box">

            <div class="box-header">
              <a href="{{ url('guiaentrega-report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
           </div>



            <div class="box-body">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>{{trans('message.invoice.invoice_date_')}}</th>
                    <th>{{ trans('message.table.invoice_entrega_no') }}</th>
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
                    <td>{{$guia->ge_date}}</td>
                    <td>
                      <a href="{{URL::to('/')}}/sales/view_detail_ge/{{$guia->ge_no}}">
                        {{$guia->reference_ge}}
                      </a>
                    </td>
                    

                  <td>
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_customer'))
                    <a href="{{url("customer/edit/$guia->debtor_no_ge")}}">{{$guia->name}}</a>
                    @else
                      {{$guia->name}}
                    @endif
                  </td>

                    <td>{{$guia->local_entrega}}</td>
                    <td>{{$guia->motorista}}</td>
                    

                        @if(Helpers::has_permission(Auth::user()->id, 'delete_invoice'))
                        <td>
                            <form method="POST" action="{{ url("sales/delete_guiaentrega/$guia->ge_no") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!} 
                                <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.extra_text.del_guide')  }}" data-message="{{ trans('message.table.del_guide_info') }}">
                                <i class="fa fa-remove" aria-hidden="true"></i>
                                </button>

                                <a title="edit" class="btn btn-xs btn-primary"  href="{{url("sales/guiaentrega/$guia->ge_no/edit")}}"><span class="fa fa-edit"></span></a>

                            </form> 



                          </td> 
                    @endif

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