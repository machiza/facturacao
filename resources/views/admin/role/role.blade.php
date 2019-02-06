@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">
          @include('layouts.includes.company_menu')
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-default">
            <div class="box-body">
              <div class="row">
                <div class="col-md-9">
                 <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.user_role') }}</div>
                </div> 
                <div class="col-md-3">
               @if(Helpers::has_permission(Auth::user()->id, 'add_role'))
                    <a href="{{ url('role/create') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.table.add_new_role') }}</a>
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
                  <th>{{ trans('message.table.name') }}</th>
                  <th>{{ trans('message.extra_text.display_name') }}</th>
                  <th>{{ trans('message.table.description') }}</th>
                  <th width="5%">{{ trans('message.table.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roleData as $data)
                <tr>
               
                  <td><a href="{{ ($data->id != 1) ? url("role/edit/$data->id") :'#'}}">{{ $data->name }}</a></td>

                  <td>{{ $data->display_name }}</td>
                  <td>{{ $data->description }}</td>


                  <td>
                   @if ($data->id != 1)
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_role'))
                      <a title="{{ trans('message.form.edit') }}" class="btn btn-xs btn-primary" href='{{ url("role/edit/$data->id") }}'><span class="fa fa-edit"></span></a> &nbsp;
                    @endif
                    @if(Helpers::has_permission(Auth::user()->id, 'delete_role'))
                      <form method="POST" action="{{ url("role/delete") }}" accept-charset="UTF-8" style="display:inline">
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
                </tfoot>
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