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
                 <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.team_member') }}</div>
                </div> 
                <div class="col-md-3">
                  @if(Helpers::has_permission(Auth::user()->id, 'add_team_member'))
                    <a href="{{ url('create-user') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.add_new_user') }}</a>
                  @endif
                </div>
              </div>
            </div>
          </div>

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="userList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>{{ trans('message.form.name') }}</th>
                  <th>{{ trans('message.table.email') }}</th>
                  <th>{{ trans('message.header.role') }}</th>
                  <th>{{ trans('message.table.phone') }}</th>
                  
                  <th width="15%">{{ trans('message.table.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($userData as $data)
                <tr>
                  <td>{{ $data->real_name }}</td>
                  <td>{{ $data->email }}</td>
                  <td>{{ $data->role }}</td>
                  <td>{{ $data->phone }}</td>
                  <td>
                  @if(!in_array($data->id,[1]))
                   @if(Helpers::has_permission(Auth::user()->id, 'edit_team_member'))
                      <a title="{{ trans('message.form.edit') }}" class="btn btn-xs btn-primary" href='{{ url("edit-user/$data->id") }}'><span class="fa fa-edit"></span></a> &nbsp;
                    @endif
                
                  @endif

                  
                    @if ($data->id != Auth::user()->id)
                   @if(Helpers::has_permission(Auth::user()->id, 'delete_team_member'))
                      <form method="POST" action="{{ url("delete-user/$data->id") }}" accept-charset="UTF-8" style="display:inline">
                          {!! csrf_field() !!}
                          <button title="{{ trans('message.form.Delete') }}" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.table.delete_user_header') }}" data-message="{{ trans('message.table.delete_user') }}">
                              <i class="glyphicon glyphicon-trash"></i> 
                          </button>
                      </form>
                    @endif
                  @endif
                  </td>
                </tr>
               @endforeach
                </tbody>
              </table>
            </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      </div>

    </section>
@include('layouts.includes.message_boxes')

@endsection

@section('js')
    <script type="text/javascript">

  $(function () {
    $("#userList").DataTable({
      "order": [],
      "columnDefs": [ {
        "targets": 3,
        "orderable": false
        } ],

        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });

    </script>
@endsection