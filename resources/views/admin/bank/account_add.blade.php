@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
           <div class="top-bar-title padding-bottom">{{ trans('message.bank.bank_account') }}</div>
          </div> 
        </div>
      </div>
    </div>

    <div class="box">
      <div class="box-body">
        <h4 class="text-info text-center">{{ trans('message.bank.new_account') }}</h4>
          <!-- form start -->
        <form action="{{ url('bank/save-account') }}" method="post" id="bank" class="form-horizontal">
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">

        <div class="box-body">
        <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.bank.account_name') }}</label>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('message.bank.account_name') }}" class="form-control" id="account_name" name="account_name">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.bank.account_type') }}</label>
            <div class="col-sm-6">
               <select class="form-control select2" name="account_type_id" id="account_type_id">
                <option value="">{{ trans('message.form.select_one') }}</option>
                @foreach($accountTypes as $data)
                  <option value="{{$data->id}}" >{{$data->name}}</option>
                @endforeach
                </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.bank.account_no') }}</label>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('message.bank.account_no') }}" class="form-control" id="account_no" name="account_no">
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.bank.bank_name') }}</label>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('message.bank.bank_name') }}" class="form-control" id="bank_name" name="bank_name">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.bank.opening_balance') }}</label>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('message.bank.opening_balance') }}" class="form-control" id="opening_balance" name="opening_balance" value="0">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.bank.bank_address') }}</label>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('message.bank.bank_address') }}" class="form-control" id="bank_address" name="bank_address">
            </div>
          </div>


          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.bank.default_account') }}</label>
            <div class="col-sm-6">
               <select class="form-control select2" name="default_account" id="default_account">
                <option value="1">Yes</option>
                <option value="0">No</option>
                </select>
            </div>
          </div>


          <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3">
             <div style="margin-top:10px;"> 
               
                <a href="{{ url('bank/list') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                <button class="btn btn-primary btn-flat pull-right" type="submit">{{ trans('message.form.submit') }}</button>                     
             </div>     
            </div>
          </div>                                                                

        </div>
        </div>
        </div>
      </form>
      </div>
    </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
    $(".select2").select2();
    $('#bank').validate({
        rules: {
            account_name: {
                required: true
            },
            account_type_id: {
                required: true
            },
            account_no:{
              required : true
            }, 
            bank_name: {
                required: true
            },
            opening_balance:{
               required: true
            }                             
        }
    });
    </script>
@endsection