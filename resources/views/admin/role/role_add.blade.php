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
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">{{ trans('message.form.user_role_create') }}</h3>
            </div>
            
            <form action="{{ url('role/save') }}" method="post" id="addRole" class="form-horizontal">
               <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">

            <div class="box-body">
                <div class="form-group">
                  <label for="input_name" class="col-sm-3 control-label">{{ trans('message.table.name') }}<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
                    <input type="text" name="name" placeholder="Name" id="name" class="form-control">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input_display_name" class="col-sm-3 control-label">{{ trans('message.extra_text.display_name') }}<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
                    <input type="text" name="display_name" placeholder="Display Name" id="display_name" class="form-control">
                    <span class="text-danger">{{ $errors->first('display_name') }}</span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="input_description" class="col-sm-3 control-label">{{ trans('message.table.description') }}<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
                    <input type="text" name="description" placeholder="Description" id="description" class="form-control">
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">{{ trans('message.form.permission') }}</label>

                  <div class="col-sm-6">

                  <ul style="display: inline-block;list-style-type: none;padding:0; margin:0;">

                  @foreach($permissions as $row)
                  
                    <li class="checkbox" style="display: inline-block; min-width: 155px;">
                      <label>
                        <input type="checkbox" name="permission[]" value="{{ $row->id }}"> 
                        {{ $row->display_name }}
                      </label>
                    </li>

                  @endforeach

                  </ul>

                  </div>
                </div>
              </div>

              <div class="box-footer">
                <a href="{{ url('role/list') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
               
                <button class="btn btn-primary btn-flat pull-right" type="submit">{{ trans('message.form.submit') }}</button>
               
              </div>
            </form>
          </div>
      </div>
    </section>
    @include('layouts.includes.message_boxes')
@endsection

@section('js')
    <script type="text/javascript">
      $(document).ready(function(){
       $('#addRole').validate({
            rules: {
                name: {
                    required: true
                },
                symbol: {
                    required: true
                }                 
            }
        });
      });
    </script>
@endsection