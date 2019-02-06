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
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-2">
                <div class="form-group" style="margin-right: 5px">
                  <label for="exampleInputEmail1">{{ trans('message.report.from') }}</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control" id="from" type="text" name="from" value="{{$from}}" required>
                  </div>
                </div>
              </div> 
  
  
              <div class="col-md-2">
                <div class="form-group" style="margin-right: 5px">
                  <label for="exampleInputEmail1">{{ trans('message.report.from') }}</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control" id="dataFim" name="dataFim" value="{{$to}}" required>
                  </div>
                </div>
              </div>
  
              <div class="col-md-2">
                <div class="form-group" style="margin-right: 5px">
                  <label for="sel1">{{ trans('message.form.customer') }}</label>
                  <div class="input-group">
                    <select class="form-control select2" name="customer" id="customer">
                      <option value="all">All</option>
                      @if(!empty($customerList))
                        @foreach($customerList as $customerItem)
                          <option value="{{$customerItem->debtor_no}}" <?= ($customerItem->debtor_no == $customer) ? 'selected' : ''?>>{{$customerItem->name}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                </div>
              </div>
  
              <div class="col-md-2">
                <div class="form-group" style="margin-right: 5px">
                  <label for="">.</label>
                  <div class="input-group">
                      <button type="submit" id="Rfiltro" class="btn btn-primary btn-flat">{{ trans('message.extra_text.filter') }}</button>
                  </div>
                </div>
              </div> 
              
            </div>  
          </div>
        </div>
      </div><!--Filtering Box End-->


            <!-- Default box -->
      <div class="box">
            <!-- /.box-header -->
            <div class="box-header">
              <a id="report" target="_blank" href="{{ url('guiatransporte-report') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
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
                    <td class="{{ $guia->gt_date }}">{{ formatDate($guia->gt_date) }}</td>
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

    $('.select2').select2({});
    $('#from').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });

    $('#dataFim').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });

    $('#Rfiltro').click(function() {
  
      var dataIni, dataFim, clienteId, cliente, table, tr, tdData, tdCliente, i;

      dataIni  = $('#from').val();
      dataFim = $('#dataFim').val();
      clienteId  = $('#customer').val() != 'all' ? $('#customer').val() : 'all';
      cliente = $('#customer option:selected').text();
      table = $('#example1');
      tr = table.find("tr");

      dataIniISO = dataIni.split("/");
      dataFimISO = dataFim.split("/");

      var di = dataIniISO[2]+'-'+dataIniISO[1]+'-'+dataIniISO[0];
      var df = dataFimISO[2]+'-'+dataFimISO[1]+'-'+dataFimISO[0];

      baseUrl = $('#baseUrl').val();

      $("#report").attr("href", SITE_URL+"/guiatransporte-report/"+di+"/"+df+"/"+clienteId);

      for (i = 0; i < tr.length; i++) {
        tdData = tr[i].getElementsByTagName("td")[0];
        clienteNome = tr[i].getElementsByTagName("td")[2]; 
        if(cliente != "All") {
          // console.log(clienteNome);
          if (tdData) {
            txtValue = clienteNome.textContent || clienteNome.innerText;

            fDate = new Date(dataIniISO[2]+'-'+dataIniISO[1]+'-'+dataIniISO[0]);   
            lDate = new Date(dataFimISO[2]+'-'+dataFimISO[1]+'-'+dataFimISO[0]);  
            cDate =  new Date(tdData.className+"");
          
            if(cDate >= fDate && cDate <= lDate && txtValue.trim() == cliente) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
            
          }
        } else {
          if (tdData) {
            txtValue = new Date(tdData.className);

            fDate = new Date(dataIniISO[2]+'-'+dataIniISO[1]+'-'+dataIniISO[0]);   
            lDate = new Date(dataFimISO[2]+'-'+dataFimISO[1]+'-'+dataFimISO[0]);  
            cDate =  new Date(tdData.className+"");
          
            if(cDate >= fDate && cDate <= lDate) {
              tr[i].style.display = "";
            } else {
              tr[i].style.display = "none";
            }
            
          }
        }
        
      }
    });

  </script>
@endsection