@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">
          @include('layouts.includes.sub_menu')
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-9">
             <div class="top-bar-title padding-bottom">{{ trans('message.transaction.income-expense-categories') }}</div>
            </div> 
            <div class="col-md-3 top-right-btn">
            @if(Helpers::has_permission(Auth::user()->id, 'add_income_expense_category'))
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add-category" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.table.add_new_category') }}</a>
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
                  <th>{{ trans('message.table.category') }}</th>
                  <th>{{ trans('message.transaction.type') }}</th>
                  <th width="5%">{{ trans('message.table.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categoryList as $data)
                <tr>
                  <td>{{ $data->name }}</td>
                  <td>{{ $data->type }}</td>
                  <td>
                @if(Helpers::has_permission(Auth::user()->id, 'edit_income_expense_category'))
                  <a title="{{ trans('message.form.edit') }}" href="javascript:void(0)" class="btn btn-xs btn-primary edit_category" id="{{$data->id}}"><span class="fa fa-edit"></span></a> &nbsp;
                @endif
                @if(Helpers::has_permission(Auth::user()->id, 'delete_income_expense_category'))
                  <form method="POST" action="{{ url("income-expense-category/delete/$data->id") }}" accept-charset="UTF-8" style="display:inline">
                      {!! csrf_field() !!}
                      <button title="{{ trans('message.form.Delete') }}" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.table.delete_category_header') }}" data-message="{{ trans('message.table.delete_category') }}">
                          <i class="glyphicon glyphicon-trash"></i> 
                      </button>
                  </form>
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

<div id="add-category" class="modal fade" role="dialog" style="display: none;">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">{{ trans('message.table.add_new') }}</h4>
      </div>
      <div class="modal-body">
        <form action="{{ url('income-expense-category/save') }}" method="post" id="myform1" class="form-horizontal">
            {!! csrf_field() !!}
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.category') }}</label>

            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('message.form.category') }}" class="form-control" name="name">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.transaction.type') }}</label>
            <div class="col-sm-6">
              <select class="form-control" name="type" >
              <option value="">{{ trans('message.form.select_one') }}</option>
              @foreach ($types as $key=>$data)
                <option value="{{$key}}" >{{$data}}</option>
              @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="btn_save" class="col-sm-3 control-label"></label>
            <div class="col-sm-6">
              <button type="button" class="btn btn-info btn-flat" data-dismiss="modal">{{ trans('message.form.close') }}</button>
              <button type="submit" class="btn btn-primary btn-flat pull-right">{{ trans('message.form.submit') }}</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<div id="edit-category" class="modal fade" role="dialog" style="display: none;">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">{{ trans('message.table.add_new') }}</h4>
      </div>
      <div class="modal-body">
        <form action="{{ url('income-expense-category/update') }}" method="post" id="editCat" class="form-horizontal">
            {!! csrf_field() !!}
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.category') }}</label>

            <div class="col-sm-6">
              <input type="text" placeholder="Name" class="form-control" id="name" name="name">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.transaction.type') }}</label>
            <div class="col-sm-6">
              <select class="form-control" name="type" id="type">
              @foreach ($types as $key=>$data)
                <option value="{{$key}}" >{{$data}}</option>
              @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="btn_save" class="col-sm-3 control-label"></label>
            <div class="col-sm-6">
              <button type="button" class="btn btn-info btn-flat" data-dismiss="modal">{{ trans('message.form.close') }}</button>
              <button type="submit" class="btn btn-primary btn-flat pull-right">{{ trans('message.form.submit') }}</button>
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
        });
      });


      $('.edit_category').on('click', function() {
        var id = $(this).attr("id");
        $.ajax({
            url: '{{ URL::to("income-expense-category/edit")}}',
            data:{  // data that will be sent
                id:id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                $('#name').val(data.name);
                $('#type').val(data.type);
                $('#id').val(data.id);
                $('#edit-category').modal();
            }
        });
      });

      $('#myform1').validate({
        rules: {
            name: {
                required: true
            },
            type: {
                required: true
            }                     
        }
    });

    $('#editCat').validate({
        rules: {
            name: {
                required: true
            },
            type: {
                required: true
            }                     
        }
    });
    </script>
@endsection