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
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">{{ trans('message.extra_text.system_info') }}</h3>
            </div><br>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ url('save-email-config') }}" method="post" id="myform1" class="form-horizontal">
            
                <div class="form-group">
                  <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.table.actual_version') }}</label>

                  <div class="col-sm-6">
                     <input type="text" value="{{Session::get('version')}}" class="form-control" readonly="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.table.update_date') }}</label>

                  <div class="col-sm-6">
                    <input type="text" value="{{Session::get('date_version')}}" class="form-control" readonly="">
                  </div>
                </div>
              
              <!-- /.box-body -->
              <div class="box-footer">
                  <a  class="btn btn-primary btn-flat pull-right" href="{{ URL::to("update/version/now")}}">{{ trans('message.form.update') }}</a>
              </div>
              <!-- /.box-footer -->
            </form>

          </div>
         
        
          

      </div>
      <!-- /.row -->

    </section>
    @include('layouts.includes.message_boxes')
@endsection

@section('js')
    <script type="text/javascript">

    
    </script>
@endsection