@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">
          @include('layouts.includes.finance_menu')
        </div>
        <div class="col-md-9">
          <div class="box box-default">
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                 <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.payment_gateway') }}</div>
                </div> 
              </div>
            </div>
          </div>
          <div class="box">
            <div class="box-body">
              <form action="{{ url('payment/gateway') }}" method="post" id="supplier" class="form-horizontal">
              <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
              <div class="box-body">
                <div class="form-group">
                  <label for="input_paypal_username" class="col-sm-3 control-label">{{ trans('message.extra_text.paypal_username') }}<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
                  <input type="text" placeholder="" class="form-control valdation_check" id="username" name="username" value="{{ $result[0]->value }}" required="true">
                    <span class="text-danger">{{ $errors->first('username') }}</span>
                  </div>
                </div>
              
                <div class="form-group">
                  <label for="input_paypal_password" class="col-sm-3 control-label">{{ trans('message.extra_text.paypal_password') }}<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
<input type="text" class="form-control valdation_check" id="password" name="password" value="{{ $result[1]->value }}" required="true">
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                  </div>
                </div>
              
              
                <div class="form-group">
                  <label for="input_paypal_signature" class="col-sm-3 control-label">{{ trans('message.extra_text.paypal_signature') }}<em class="text-danger">*</em></label>

                  <div class="col-sm-6">
<input type="text" class="form-control valdation_check" id="signature" name="signature" value="{{ $result[2]->value }}" required="true">

                    <span class="text-danger">{{ $errors->first('signature') }}</span>
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="input_paypal_mode" class="col-sm-3 control-label">{{ trans('message.extra_text.paypal_mode') }}</label>

                  <div class="col-sm-6">
               <select class="form-control" name="mode" id="mode" required="true">
                <option value="sandbox" <?= ( $result[3]->value == 'sandbox' )? 'selected' : ''?>>Sandbox</option>
                <option value="live" <?= ( $result[3]->value == 'live' )? 'selected' : ''?>>Live</option>
                </select>
                    <span class="text-danger">{{ $errors->first('mode') }}</span>
                  </div>
                </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-default" name="cancel" value="cancel">Cancel</button>
                <button type="submit" class="btn btn-info pull-right" name="submit" value="submit">Submit</button>
              </div>
              <!-- /.box-footer -->
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

    </script>
@endsection