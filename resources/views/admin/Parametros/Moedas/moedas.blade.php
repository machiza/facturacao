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
                    <a  href="{{ url('cambio/add') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus">&nbsp;</span>Nova Moeda</a>
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
                  <th>Nome da Moeda</th>
                  <th>Singular</th>
                  <th>Plural</th>
                  <th>Casa decimal Singular</th>
                  <th>Casa decimal Plural</th>
                  <th width="5%">Acção</th>
                </tr>
                </thead>
                <tbody>
                @foreach($moedas as $data)
                <tr> 
                  <td>{{ $data->nome }}</td>
                  <td>{{ $data->singular }}</td>
                  <td>{{ $data->plural}}</td> 
                  <td>{{ $data->casas_decimais_sing}}</td> 
                  <td>{{ $data->casas_decimais_plu}}</td> 
                  <td>
                   @if ($data->id != 0)
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_role'))
                      <a title="{{ trans('message.form.edit') }}" class="btn btn-xs btn-primary" href='{{ url("cambio/".$data->id) }}'><span class="fa fa-edit"></span></a> &nbsp;
                    @endif
                    @if(Helpers::has_permission(Auth::user()->id, 'delete_role'))
                      <form method="POST" action="{{ url("cambio/delete") }}" accept-charset="UTF-8" style="display:inline">
                          {!! csrf_field() !!}
                          <input type="hidden" name="id" value="{{$data->id}}">
                          <button title="{{ trans('message.form.Delete') }}" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.table.delete_role_header') }}" data-message="{{ trans('message.table.delete_role') }}">
                              <i class="glyphicon glyphicon-trash"></i> 
                          </button>
                      </form>
                    
                      @endif
                  @endif
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