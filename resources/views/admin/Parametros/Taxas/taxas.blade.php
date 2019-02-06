@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

      <div class="row">
        {{-- <div class="col-md-3">
          @include('layouts.includes.company_menu')
        </div> --}}
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-default">
            <div class="box-body">
              <div class="row">
                <div class="col-md-9">
                 <div class="top-bar-title padding-bottom">Taxas de Câmbio</div>
                </div> 
                <div class="col-md-offset-1 col-md-2">
               @if(Helpers::has_permission(Auth::user()->id, 'add_role'))
                    <a  href="{{ url('taxas/add') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus">&nbsp;</span>Nova Moeda</a>
               @endif
                </div>
              </div>
            </div>
          </div>

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr> 
                  <th>Data do Cambio</th>
                  <th>Moeda</th>
                  <th>Compra</th>
                  <th>Venda</th> 
                  <th width="5%">Acção</th>
                </tr>
                </thead>
                <tbody>
                @foreach($taxas as $data)
                <tr> 
                  <td>{{ $data->data_cambio}}</td>
                  <td>{{ $data->moeda}}</td>
                  <td>{{ $data->compra}}</td> 
                  <td>{{ $data->venda}}</td>  
                  <td> 
                      <a title="{{ trans('message.form.edit') }}" class="btn btn-xs btn-primary" href='{{ url("taxas/".$data->id) }}'><span class="fa fa-edit"></span></a> &nbsp;
                      
                      <form method="POST" action="{{ url("taxas/delete/".$data->id) }}" accept-charset="UTF-8" style="display:inline">
                          {!! csrf_field() !!}
                          <input type="hidden" name="id" value="{{$data->id}}">
                          <button title="{{ trans('message.form.Delete') }}" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.table.delete_role_header') }}" data-message="{{ trans('message.table.delete_role') }}">
                              <i class="glyphicon glyphicon-trash"></i> 
                          </button>
                      </form> 
                  </td>

                </tr>
               @endforeach
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    @include('layouts.includes.message_boxes')
@endsection

@section('js')
    <script type="text/javascript">
      $(function () {
        $("#example1").DataTable({
          "columnDefs": [ {
            "targets": 3,
            "orderable": false
            } ],

            "language": '{{Session::get('dflt_lang')}}'
        });
        
      });
    </script>
@endsection