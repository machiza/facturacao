@extends('layouts.app')
@section('content')
 <!-- Main content -->
  <section class="content">
    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-10">
           <div class="top-bar-title padding-bottom">Subscriçoes</div>
          </div> 
          <div class="col-md-2">
           @if(Helpers::has_permission(Auth::user()->id, 'add_invoice'))
              <a href="{{ url('subscrition/create') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>Nova Subscrição</a>
           @endif
          </div>
        </div>
      </div>
    </div>
    <div class="box">
        <div class="box-body">
                <ul class="nav nav-tabs cus" role="tablist">
                    <li  class="active">
                      <a href='#' >{{ trans('message.extra_text.all') }}</a>
                    </li>
               </ul>
         </div>
       
      </div><!--Filtering Box End-->
      
        <!-- Default box -->
        <div class="box">
          <!-- /.box-header -->
          <div class="box-header">
            <a href="#"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
         </div>


            <div class="box-body">
              <div class="table-responsive"> 
                <table id="example1" class="table table-hover">
                  <thead>
                  <tr>
                   {{-- <th>Data</th>--}}
                    <th>Codigo</th>
                    <th>Produto</th>
                    <th>Plano</th>
                    <th>Valor</th>
                    {{--
                    <th>Data Inicio</th>
                    <th>Data Fim</th>
                    --}}
                    <th>Parceiro</th>
                    <th>Cliente Final</th>
                     <th>Estado</th>  
                    @if(Helpers::has_permission(Auth::user()->id, 'delete_invoice'))
                    <th width="15%">{{ trans('message.table.action') }}</th>
                    @endif   

                   </tr>
                  </thead>
                  <tbody>
                  @foreach($subscricoes as $data)
                   {{-- <td>formatDate($data->created_at)</td>--}}
                    <td>{{$data->ordem}}</td>
                    <td>{{$data->nome}}</td>
                    <td>{{$data->plano}}</td>
                    <td>    {{number_format($data->valor,2,'.',',').' '.Session::get('currency_symbol')}}
                    </td>
                    {{--<td>{{$data->data_inicio}}</td>
                    <td>{{$data->data_fim}}</td>--}}
                    <td>{{$data->cliente}}</td>
                    <td>{{$data->cliente_final}}</td>
                    <td>{{$data->estado}}</td>

                  @if(Helpers::has_permission(Auth::user()->id, 'delete_invoice'))
                    <td>
                            
                          <a title="View" class="btn btn-xs btn-primary show_sub" href="javascript:void(0)" id="{{$data->ordem}}"><span class="fa fa-eye"></span></a> &nbsp;
                         

                            <a title="View" class="btn btn-xs btn-primary edit_sub" href="javascript:void(0)"  id="{{$data->ordem}}"><span class="fa fa-edit"></span></a> &nbsp;

                            <form method="POST" action="{{ url("subscrition/delete/$data->ordem") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!}
                            <button class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_sub_header') }}" data-message="{{ trans('message.invoice.delete_sub') }}">
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


      <!-- edicao do produto -->
<div id="edit-sub" class="modal fade" role="dialog" style="display: none;">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
         <div id="cabecalho">
           <h4 class="modal-title">Edição da Subscricão</h4>
         </div> 
      </div>
      
      <div class="modal-body">
        <form  action="{{ url('subscrition-update') }}" method="post" id="edit-sub-form" class="form-horizontal">
            {!! csrf_field() !!}
          <div class="form-group">
               <label class="col-sm-3 control-label" for="inputEmail3">Parceiro</label>
               <div class="col-sm-6">
                <select class="form-control select2" name="customer" id="customer" ui-select2="{width:'resolve',dropdownAutoWidth:true}" style="width:100%">
                   <option value="">Selecione</option>
                 @foreach($patners as $customer)
                   <option value="{{$customer->debtor_no}}">{{$customer->name}}</option>
                  @endforeach
                </select>
               </div> 
            </div>

       <div class="form-group" id="cliente_final">
                        <label class="col-sm-3 control-label" for="inputEmail3"></label>
                         <label class="col-sm-4 control-label" for="inputEmail3">O Cliente 
                         E' Cliente Final?</label>
             <div class="col-sm-4">
                <label>SIM
                      <input type="radio" name="r_tipoCliente" value="0" class="minimall" checked="">
                 </label>
                <label>
                 Não 
                  <input type="radio" value="1"  name="r_tipoCliente" value="1" class="minimall">
                </label>
            </div>
        </div>

          <div class="form-group" id="loc_cliente_final"  style="display: none;">
               <label class="col-sm-3 control-label" for="inputEmail3">Cliente</label>
               <div class="col-sm-6">
                <select class="form-control select2" name="cliente_final_id" id="cliente_final_id" ui-select2="{width:'resolve',dropdownAutoWidth:true}" style="width:100%">
                   <option value="">Selecione</option>
                 @foreach($customers as $customer)
                   <option value="{{$customer->debtor_no}}">{{$customer->name}}</option>
                  @endforeach
                </select>
               </div> 
          </div>
          <div class="form-group">
             <label class="col-sm-3 control-label" for="inputEmail3">Produto</label>
             <div class="col-sm-6">
              <select class="form-control select2" name="produto_id" id="produto_id" ui-select2="{width:'resolve',dropdownAutoWidth:true}" style="width:100%"> <option value="">Selecione</option>
               @foreach($produtos as $produto)
                 <option value="{{$produto->id}}">{{$produto->nome}}</option>
                @endforeach
              </select>
             </div> 
          </div>

        <div class="form-group">
         <label class="col-sm-3 control-label" for="inputEmail3">Plano</label>
         <div class="col-sm-6">
          <select class="form-control select2" name="plano_id" id="plano_id" ui-select2="{width:'resolve',dropdownAutoWidth:true}" style="width:100%">
            <option value="">Selecione</option>
            @foreach($planos as $plano)
            <option value="{{$plano->id}}">{{$plano->nome}}</option>
            @endforeach 
           </select>
         </div> 
        </div>
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">Preco</label>
              <div class="col-sm-6">
              <input type="text" placeholder="preco" class="form-control" id="valor" name="valor">
                   <span id="val_name" style="color: red"></span>
            </div>
          </div>

          <div class="form-group" >
              <label class="col-sm-3 control-label" for="inputEmail3">Periodo</label>
                <div class="col-sm-3">
                    <input type="text" placeholder="data inicio" class="form-control" id="datepicker" name="data_inicio">
                </div>
              <div class="col-sm-3">
                 <input type="text" placeholder="data fim" class="form-control" id="datepicker1" name="data_fim">
             </div>
          </div>

          <!--   -->
          <div id="mostar_detalhes"  style="display: none;">
            
            <div class="form-group"  >
              <label class="col-sm-3 control-label require" for="inputEmail3">Registado Por</label>
              <div class="col-sm-6">
                  <input type="text" placeholder="preco" class="form-control" id="user_name" name="user_name">
               </div>
            </div>
          </div>
           <div class="form-group">

               <label class="col-sm-3 control-label" for="inputEmail3">Estado</label>
               <div class="col-sm-6">
                <select class="form-control select2" name="estado" id="estado">
                  <option value="activo">Activo</option>
                  <option value="desactivo">Desactivo</option>
                </select>
               </div> 
            </div>
         
           <div id="rodape">
            <div class="form-group">
              <label for="btn_save" class="col-sm-3 control-label"></label>
              <div class="col-sm-6">
                <button type="button" class="btn btn-info btn-flat" data-dismiss="modal">{{ trans('message.form.close') }}</button>
                <button type="submit" class="btn btn-primary btn-flat">{{ trans('message.form.submit') }}</button>
              </div>
            </div>
            <input type="text" name="codigo" id="codigo" hidden="">
          </div>
         </form>
      </div>
     </div>
   </div>
 </div>
</section>
@include('layouts.includes.message_boxes')
@endsection
@section('js')
<script type="text/javascript">

   $('#edit-sub-form').validate({
        rules: {
            customer: {
                required: true
            },
            produto_id: {
                required: true
            },
            plano_id:{
                required: true
            },
            valor:{
                required: true
            },
          
        }
    });



  $('document').ready(function(){ 
     // $("#Kind_customer").hide();
  });

  $('input[type=radio][name=r_tipoCliente]').change(function() {
          if (this.value == '0') {
             $('#loc_cliente_final').hide();
          }
          else if (this.value == '1') {
            $('#loc_cliente_final').show();
          }
    });

  $(function () {
    $("#example1").DataTable({
      "order": [],
      "columnDefs": [ {
       // "targets": 6,
        "orderable": false
        } ],

        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });


   $('.edit_sub').on('click', function() {
        var id = $(this).attr("id");
       var   rows='<h4 class="modal-title">Edição da Subscricão</h4>';
         $('#cabecalho').html(rows);
          $("#rodape").show();
         $('#codigo').val(id);
         buscar_dados(id); 
    });

//Mostar os detalhes da subscricao realisada
 $('.show_sub').on('click', function() {
  var id = $(this).attr("id");
  // alterar o cabecalho 

  var rows='<h4 class="modal-title">Detalhes da Subscricão</h4>';
  $('#cabecalho').html(rows);
  $("#rodape").hide();
  $("#mostar_detalhes").show();
  buscar_dados(id);

});   


$(function () {
    //Initialize Select2 Elements
    $(".select2").select2({});
    //$('#datepicker').datepicker('update', new Date());
});

   function buscar_dados(id){
      var settar=id;

     $.ajax({
            url: '{{ URL::to('edit-subcription')}}',
            data:{  
                id:id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
              console.log(data);
                $('#plano_id').val(data.plano_id).trigger('change');
                $('#produto_id').val(data.produto_id).trigger('change');
                $('#produto_id').val(data.produto_id).trigger('change');
                $('#valor').val(data.valor);
                $('#codigo').val(settar);
                $('#customer').val(data.customer_id).trigger('change');
                $('#user_name').val(data.usuario);
                 // 2018-08-21 2011,12,11
                var dia=data.data_inicio.split('-');
                var dia1=data.data_fim.split('-');
                console.log("data de inicio eh "+dia[0]);
                $('#datepicker').datepicker("setDate", new Date(dia[0],dia[1],dia[2]));
                $('#datepicker1').datepicker("setDate", new Date(dia1[0],dia1[1],dia1[2]));
                $('#user_id').val(data.user_id);

                 // loc_cliente_final 
                if(data.customer_id==data.cliente_final_id){
                  // $("#Kind_customer").show();
                   $('input[type=radio][name=r_tipoCliente]').val(['0']);
                    console.log("o Parceiro e' cliente final  cliente"+data.cliente_final_id);
                    $("#cliente_final").show();
                }else{
                    $('input[type=radio][name=r_tipoCliente]').val(['1']);
                     $('#cliente_final_id').val(data.cliente_final_id).trigger('change');
                    $('#loc_cliente_final').show();
                }

                  $('#edit-sub').modal();
            }
        });

   }

</script>
@endsection





