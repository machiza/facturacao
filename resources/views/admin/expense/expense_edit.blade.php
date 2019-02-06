@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
           <div class="top-bar-title padding-bottom">{{ trans('message.transaction.expense') }}</div>
          </div> 
        </div>
      </div>
    </div>

    <div class="box">
      <div class="box-body">
        <h4 class="text-info text-center">{{ trans('message.transaction.edit_deposit') }}</h4>
          <!-- form start -->
        <form action="{{ url('expense/update') }}" method="post" id="expense" class="form-horizontal" enctype="multipart/form-data">
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        <input type="hidden" value="{{$depositInfo->id}}" name="id" id="id">

        <div class="box-body">
        <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.bank.account') }}</label>
            <div class="col-sm-6">
               <select class="form-control select2" name="account_no" id="account_no">
                @foreach($accounts as $acc_no=>$acc_name)
                  <option value="{{$acc_no}}" <?= ($acc_no==$depositInfo->id) ? 'selected' : '' ?>>{{$acc_name}}</option>
                @endforeach
                </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.date') }}</label>
            <div class="col-sm-6">
            <input type="text" class="form-control" id="trans_date" name="trans_date" value="{{formatDate($depositInfo->trans_date)}}">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.table.description') }}</label>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('message.table.description') }}" class="form-control" id="description" name="description" value="{{$depositInfo->description}}">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.table.amount') }}</label>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('message.table.amount') }}" class="form-control" id="amount" name="amount" min="0" value="{{abs($depositInfo->amount)}}" readonly>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.table.category') }}</label>
            <div class="col-sm-6">
               <select class="form-control select2" name="category_id" id="category_id">
                @foreach($incomeCategories as $cat_id=>$cat_name)
                  <option value="{{$cat_id}}" <?= ($cat_id==$depositInfo->category_id) ? 'selected' : '' ?>>{{$cat_name}}</option>
                @endforeach
                </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.extra_text.payment_method') }}</label>
            <div class="col-sm-6">
               <select class="form-control select2" name="payment_method" id="payment_method">
                @foreach($payment_methods as $method_id=>$method_name)
                  <option value="{{$method_id}}" <?= ($method_id==$depositInfo->payment_method) ? 'selected' : '' ?> >{{$method_name}}</option>
                @endforeach
                </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.table.reference') }}</label>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('message.table.reference') }}" class="form-control" id="reference" name="reference" value="{{$depositInfo->reference}}">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.transaction.attachment') }}</label>
            <div class="col-sm-6">
              <input type="file" class="form-control input-file-field" id="attachment" name="attachment">
              
              @if(!empty($depositInfo->attachment))
              <input type="hidden" name="old_attachment" value="{{$depositInfo->attachment}}">
              <br>
              <a href='{{url("uploads/attachment/$depositInfo->attachment")}}' class="btn btn-success btn-sm">Download</a>
              @endif
            </div>
          </div>          

          <div class="form-group">
            <div class="col-sm-6 col-sm-offset-3">
             <div style="margin-top:10px;"> 
                <a href="{{ url('expense/list') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
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
    $('#trans_date').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });
    //$('#trans_date').datepicker('update', new Date());

    $('#expense').validate({
        rules: {
            account_no: {
                required: true
            },
            trans_date: {
                required: true
            },
            description:{
              required : true
            }, 
            amount:{
                required: true
            },
            category_id:{
               required: true
            },
            payment_method:{
              required: true
            }
        }
    });
    </script>
@endsection