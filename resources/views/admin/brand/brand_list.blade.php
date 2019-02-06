@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">
          @include('layouts.includes.item_sub_menu')
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
             <div class="top-bar-title padding-bottom">{{ trans('message.sidebar.item_brand') }}</div>
            </div> 

           @if(Helpers::has_permission(Auth::user()->id, 'add_item_category'))
            <div class="col-md-3 top-left-btn">
                <a href="{{ URL::to('brandimport') }}" class="btn btn-block btn-default btn-flat btn-border-purple"><span class="fa fa-upload"> &nbsp;</span>{{ trans('message.extra_text.import_new_brand') }}</a>
            </div>

            <div class="col-md-3 top-right-btn">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#add-category" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.table.add_new_brand') }}</a>
            </div>
            @endif

          </div>
        </div>
      </div>

          <div class="box">
            <div class="box-header">
              <a href="{{ URL::to('branddownloadExcel/xls') }}"><button class="btn btn-default btn-flat btn-border-info"><span class="fa fa-download"> &nbsp;</span>{{ trans('message.table.downolad_xls') }}</button></a>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="10%">{{ trans('message.table.codigo') }}</th>
                  <th width="80%">{{ trans('message.table.brand') }}</th>
                  <th width="10%">{{ trans('message.table.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($brandData as $data)
                <tr>
                  <td>{{ $data->id }}</td>
                  <td>{{ $data->description }}</td>
                  <td>
                  @if(Helpers::has_permission(Auth::user()->id, 'edit_item_category'))
                  
                      <a title="{{ trans('message.form.edit') }}" href="javascript:void(0)" class="btn btn-xs btn-primary edit_category" id="{{$data->id}}"><span class="fa fa-edit"></span></a> &nbsp;
                  @endif

                  @if(Helpers::has_permission(Auth::user()->id, 'delete_item_category') )
                      <form method="POST" action="{{ url("delete-brand/$data->id") }}" accept-charset="UTF-8" style="display:inline">
                          {!! csrf_field() !!}
                          <button title="{{ trans('message.form.Delete') }}" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.table.delete_brand_header') }}" data-message="{{ trans('message.table.delete_brand') }}">
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
        <form action="{{ url('save-brand') }}" method="post" id="myform1" class="form-horizontal">
            {!! csrf_field() !!}
          
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.brand') }}</label>

            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('message.form.brand') }}" class="form-control" name="description">
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


<div id="edit-category" class="modal fade" role="dialog" style="display: none;">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">{{ trans('message.table.add_new') }}</h4>
      </div>
      <div class="modal-body">
        <form action="{{ url('update-brand') }}" method="post" id="editCat" class="form-horizontal">
            {!! csrf_field() !!}
          
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.brand') }}</label>

            <div class="col-sm-6">
              <input type="text" placeholder="Name" class="form-control" id="name" name="description">
              <span id="val_name" style="color: red"></span>
            </div>
          </div>
        
          <input type="hidden" name="brand_id" id="brand_id">
     
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
        
      });


      $('.edit_category').on('click', function() {
        var id = $(this).attr("id");

        $.ajax({
            url: '{{ URL::to('edit-brand')}}',
            data:{  // data that will be sent
                id:id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
              
                $('#name').val(data.description);
                $('#brand_id').val(data.id);

                $('#edit-category').modal();

                console.log("o nome eh "+data.name);
            }
        });

    });

      $('#myform1').validate({
        rules: {
            description: {
                required: true
            }                    
        }
    });

    $('#editCat').validate({
        rules: {
            description: {
                required: true
            }                  
        }
    });
    </script>
@endsection