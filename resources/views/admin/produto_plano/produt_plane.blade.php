@extends('layouts.app')
@section('content')
 <!-- Main content -->
  <section class="content">
    <div class="row">
        <div class="col-md-6">
         <div class="box box-default">
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                 <div class="top-bar-title padding-bottom">Listagem de Produtos</div>
                </div> 

               @if(Helpers::has_permission(Auth::user()->id, 'add_item_category'))
                  <div class="col-md-3 top-left-btn pull-right">
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#add-produt" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>Produto</a>
                  </div>
              @endif

              </div>
            </div>
          </div>

        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Descricao</th>
                  <th width="15%">{{ trans('message.table.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($produtos as $produto)    
                <tr>
                  <td>{{$produto->nome}}</td>
                  <td>{{$produto->detalhes}}</td>
                  <td>
                     <a title="{{ trans('message.form.edit') }}" href="javascript:void(0)" class="btn btn-xs btn-primary edit_produt" id="{{$produto->id}}"><span class="fa fa-edit"></span></a> &nbsp;

                      <form method="POST" action="{{ url("produto/delete/$produto->id") }}" accept-charset="UTF-8" style="display:inline">
                          {!! csrf_field() !!}
                          <button title="{{ trans('message.form.Delete') }}" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.table.delete_category_header') }}" data-message="{{ trans('message.table.delete_category') }}">
                              <i class="glyphicon glyphicon-trash"></i> 
                          </button>
                      </form>
                      
                  </td>
                </tr>
               @endforeach 
              </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-6">
          
          <div class="box box-default">
            <div class="box-body">
              <div class="row">
                <div class="col-md-6">
                 <div class="top-bar-title padding-bottom">Listagem dos Planos</div>
                </div> 

               @if(Helpers::has_permission(Auth::user()->id, 'add_item_category'))
               <div class="col-md-3 top-left-btn pull-right">
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#add-plano" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>Plano</a>
                  </div>
                @endif
              </div>
            </div>
          </div>

          <div class="box">
        
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome</th>
                  <th>Preco</th>
                  <th>Descricao</th>
                  <th width="15%">{{ trans('message.table.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($planos as $plano)    
                <tr>
                  <td>{{$plano->nome}}</td>
                  <td>{{$plano->valor}}</td>
                  <td>{{$plano->detalhes}}</td>
                  <td>
                     <a title="{{ trans('message.form.edit') }}" href="javascript:void(0)" class="btn btn-xs btn-primary edit_plano" id="{{$plano->id}}"><span class="fa fa-edit" id="{{$plano->id}}"></span></a> &nbsp;
                      <form method="POST" action="{{ url("plano/delete/$plano->id") }}" accept-charset="UTF-8" style="display:inline">
                          {!! csrf_field() !!}
                          <button title="{{ trans('message.form.Delete') }}" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.table.delete_category_header') }}" data-message="{{ trans('message.table.delete_category') }}">
                              <i class="glyphicon glyphicon-trash"></i> 
                          </button>
                      </form>
                      
                  </td>
                </tr>


               @endforeach 
              </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>

    <div id="add-produt" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title">Adicione novo Produto</h4>
          </div>
          <div class="modal-body">
              <form action="{{ url('save-produto') }}" method="post" id="myform1" class="form-horizontal">
                         {!! csrf_field() !!}
               <div class="form-group">
                 <label class="col-sm-3 control-label require" for="inputEmail3">Nome</label>
                 <div class="col-sm-6">
                  <input type="text" placeholder="nome" class="form-control" name="nome">
                </div>
              </div>
            
              <div class="form-group">
                <label class="col-sm-3 control-label" for="inputEmail3">Detalhes</label>
                <div class="col-sm-6">
                   <textarea placeholder="Detalhes do ..." rows="3" class="form-control valid" name="descricao"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="btn_save" class="col-sm-3 control-label"></label>
                <div class="col-sm-6">
                  <button type="button" class="btn btn-info btn-flat" data-dismiss="modal">Fechar</button>
                  <button type="submit" class="btn btn-primary btn-flat">Registar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

<!-- edicao do produto -->
<div id="edit-produt" class="modal fade" role="dialog" style="display: none;">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Edicao do Produto</h4>
      </div>
      <div class="modal-body">
        <form action="{{ url('update-produto') }}" method="post" id="editCat" class="form-horizontal">
            {!! csrf_field() !!}
          <input type="text" name="id_produto" id="id_produto" hidden="" value=""> 
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">Nome</label>

            <div class="col-sm-6">
              <input type="text" placeholder="Nome" class="form-control" id="nome_produto" name="nome_produto">
              <span id="val_name" style="color: red"></span>
            </div>
          </div>
         <div class="form-group">
                <label class="col-sm-3 control-label" for="inputEmail3">Detalhes</label>
                <div class="col-sm-6">
                   <textarea placeholder="Detalhes do ..." rows="3" class="form-control valid" name="detalhes_produto" id="detalhes_produto"></textarea>
                </div>
          </div>
         
          <div class="form-group">
            <label for="btn_save" class="col-sm-3 control-label"></label>
            <div class="col-sm-6">
              <button type="button" class="btn btn-info btn-flat" data-dismiss="modal">{{ trans('message.form.close') }}</button>
              <button type="submit" class="btn btn-primary btn-flat">{{ trans('message.form.submit') }}</button>
            </div>
          </div>
         
          
        </form>
      </div>
    </div>

  </div>
</div>

<!-- edicao do produto -->
<div id="edit-plano" class="modal fade" role="dialog" style="display: none;">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Edicao do Plano</h4>
      </div>
      <div class="modal-body">
        <form action="{{ url('update-plano') }}" method="post" id="editCat" class="form-horizontal">
            {!! csrf_field() !!}
          <input type="text" name="plano_id" id="plano_id" hidden="" value="">
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">Nome</label>

            <div class="col-sm-6">
              <input type="text" placeholder="Name" class="form-control" id="nome_plano" name="nome_plano">
              <span id="nome" style="color: red"></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">Preco</label>
              <div class="col-sm-6">
              <input type="text" placeholder="preco" class="form-control" id="valor_plano" name="valor_plano">
                   <span id="val_name" style="color: red"></span>
            </div>
          </div>

         <div class="form-group">
                <label class="col-sm-3 control-label require" for="inputEmail3">Detalhes</label>
            <div class="col-sm-6">
                <textarea placeholder="detalhes do planos ..." rows="3" class="form-control valid" name="detalhes_plano" id="detalhes_plano"></textarea>
            </div>
          </div>

          
          <div class="form-group">
            <label for="btn_save" class="col-sm-3 control-label"></label>
            <div class="col-sm-6">
              <button type="button" class="btn btn-info btn-flat" data-dismiss="modal">{{ trans('message.form.close') }}</button>
              <button type="submit" class="btn btn-primary btn-flat">{{ trans('message.form.submit') }}</button>
            </div>
          </div>
         
          
        </form>
      </div>
    </div>

  </div>
</div>



   <div id="add-plano" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title">Adicione novo Plano</h4>
          </div>
          <div class="modal-body">
            <form action="{{ url('save-plano') }}" method="post" id="myform1" class="form-horizontal">
                {!! csrf_field() !!}
              
              <div class="form-group">
                <label class="col-sm-3 control-label require" for="inputEmail3">Nome</label>

                <div class="col-sm-6">
                  <input type="text" placeholder="nome" class="form-control" name="nome">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label require" for="inputEmail3">Preco</label>

                <div class="col-sm-6">
                  <input type="text" placeholder="valor" class="form-control" name="valor">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="inputEmail3">Detalhes</label>
                <div class="col-sm-6">
                   <textarea placeholder="descrição do plano ..." rows="3" class="form-control valid" name="descricao"></textarea>
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
              <div class="form-group">
                <label for="btn_save" class="col-sm-3 control-label"></label>
                <div class="col-sm-6">
                  <button type="button" class="btn btn-info btn-flat" data-dismiss="modal">Fechar</button>
                  <button type="submit" class="btn btn-primary btn-flat">Registar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

@include('layouts.includes.message_boxes')
@endsection

@section('js')
    <script type="text/javascript">
      $(function () {
        $("#example1").DataTable({
          "columnDefs": [ {
            "targets": 2,
            "orderable": false
            } ],

            "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
            //"pageLength": 5
        });
        


         $("#example2").DataTable({
          "columnDefs": [ {
            "targets": 2,
            "orderable": false
            } ],

          "language": '{{Session::get('dflt_lang')}}',
          "pageLength": '{{Session::get('row_per_page')}}'
          //"pageLength": 5
        });

      });

      $('.edit_produt').on('click', function() {
        var id = $(this).attr("id");
         // alert("produto edit "+id);
      
        $.ajax({
            url: '{{ URL::to('edit-produto')}}',
            data:{  // data that will be sent
                id:id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
              console.log(data);
                $('#id_produto').val(id);
                $('#nome_produto').val(data.nome);
                var detalhes = data.detalhes;
                $('#detalhes_produto').text(detalhes);

                $('#edit-produt').modal();
            }
        });
        /* */
    });

  //edit_plano

      $('.edit_plano').on('click', function() {
        var id = $(this).attr("id");
          //alert("plano edit "+id);
        
        $.ajax({
            url: '{{ URL::to('edit-plano')}}',
            data:{  // data that will be sent
                id:id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {

              console.log(data);
                $('#plano_id').val(id);
                $('#nome_plano').val(data.nome);
                $('#valor_plano').val(data.valor);
                var detalhes = data.detalhes;
                $("#detalhes_plano").text(detalhes);
                $('#edit-plano').modal();
            }
        });

    });




      $('#myform1').validate({
        rules: {
            description: {
                required: true
            },
            dflt_units: {
                required: true
            }                     
        }
    });

    $('#editCat').validate({
        rules: {
            description: {
                required: true
            },
            dflt_units: {
                required: true
            }                     
        }
    });
    </script>
@endsection