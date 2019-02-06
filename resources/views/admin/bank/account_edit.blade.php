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


   <div style="font-weight: bold;font-size:18px;padding: 15px 0px;">{{ $accountInfo->account_name }}</div>


      <div class="box">
          <div class="nav-tabs-custom" id="tabs">
            <ul class="nav nav-tabs">
              <li class="<?= ($tab=='edit') ? 'active' :'' ?>"><a href="#tabEdit" data-toggle="tab" aria-expanded="false">{{ trans('message.bank.edit_account') }}</a></li>
              <li class="<?= ($tab=='transaction') ? 'active' :'' ?>"><a href="#tabTransaction" data-toggle="tab" aria-expanded="false">{{ trans('message.transaction.transaction') }}</a></li>
            </ul>
            <div class="tab-content">
              <!-- /.tab-pane -->
<div class="tab-pane <?= ($tab=='edit') ? 'active' :'' ?>" id="tabEdit">
  <div class="row">
    <div class="col-md-12">
    <div class="box">
      <div class="box-body">
        <h4 class="text-info text-center">{{ trans('message.bank.edit_account') }}</h4>
          <!-- form start -->
        <form action="{{ url('bank/update-account') }}" method="post" id="bank" class="form-horizontal">
        <input type="hidden" value="{{csrf_token()}}" name="_token">
        <input type="hidden" value="{{$accountInfo->id}}" name="id">

        <div class="box-body">
        <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.bank.account_name') }}</label>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('message.bank.account_name') }}" class="form-control" id="account_name" name="account_name" value="{{$accountInfo->account_name}}">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.bank.account_type') }}</label>
            <div class="col-sm-6">
               <select class="form-control" name="account_type_id" id="account_type_id">
                @foreach($accountTypes as $data)
                  <option value="{{$data->id}}" <?= ($data->id==$accountInfo->account_type_id)? 'selected' : ''?>>{{$data->name}}</option>
                @endforeach
                </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.bank.account_no') }}</label>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('message.bank.account_no') }}" class="form-control" id="account_no" name="account_no" value="{{$accountInfo->account_no}}">
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.bank.bank_name') }}</label>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('message.bank.bank_name') }}" class="form-control" id="bank_name" name="bank_name" value="{{$accountInfo->bank_name}}">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.bank.bank_address') }}</label>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('message.bank.bank_address') }}" class="form-control" id="bank_address" name="bank_address" value="{{$accountInfo->bank_address}}">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.bank.default_account') }}</label>
            <div class="col-sm-6">
               <select class="form-control" name="default_account" id="default_account">
                <option value="1" <?= ( $accountInfo->default_account == 1 )? 'selected' : ''?>>Yes</option>
                <option value="0" <?= ( $accountInfo->default_account == 0 )? 'selected' : ''?>>No</option>
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
    </div>
  </div>
</div>

<!-- /.tab-pane -->
<div class="tab-pane <?= ($tab=='transaction') ? 'active' :'' ?>" id="tabTransaction">
  <div class="row">
    <div class="col-md-12">
    <div class="box-body">
                <form class="form-horizontal" action='{{ url("bank/edit-account/transaction/$account_id") }}' method="GET" id='transactionReport'>
              
              <div class="col-md-3">
                  <label for="exampleInputEmail1">{{ trans('message.report.from') }}</label>
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control" id="from" type="text" name="from" value="<?= isset($startDate) ? formatDate($startDate) : '' ?>" required>
                  </div>
              </div>
              <div class="col-md-3">
                  <label for="exampleInputEmail1">{{ trans('message.report.to') }}</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input class="form-control" id="to" type="text" name="to" value="<?= isset($endDate) ? formatDate($endDate) : '' ?>" required>
                  </div>
              </div>

              <div class="col-md-1" style="line-height: 80px;">
                <button type="submit" name="btn" class="btn btn-primary btn-flat">{{ trans('message.extra_text.filter') }}</button>
              </div>
            </form>
    </div>
   </div>
  </div>  


  <div class="row">
    <div class="col-md-12">
    <div class="box-body">
            <div class="table-responsive">
              <table id="transactionList" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th class="text-center">{{ trans('message.table.date') }}</th>
                  <th class="text-center">{{ trans('message.table.type') }}</th>
                  <th class="text-center">{{ trans('message.table.description') }}</th>
                  <th>{{ trans('message.transaction.debit') }}({{Session::get('currency_symbol')}})</th>
                  <th>{{ trans('message.transaction.credit') }}({{Session::get('currency_symbol')}})</th>
                   <th class="text-center">{{ trans('message.bank.balance') }}({{Session::get('currency_symbol')}})</th>
                </tr>
                </thead>
                <tbody>
                
                <tr>
                  <th colspan="3" class="text-right">Opening Balance On {{ formatDate($startDate) }}</th>
                  <th class="text-center">
                    
                    @if($transactionList['amount'] <= 0)
                      {{ abs($transactionList['amount']) }}
                    @endif                    
                  </th>
                  <th class="text-center">
                    
                    @if($transactionList['amount'] >= 0)
                      {{ abs($transactionList['amount']) }}
                    @endif                       
                  </th>
                  <th></th>
                </tr>
                <?php
                $totalCredit = 0;
                $totalDebit = 0;
                ?>
                @foreach($transactionList['result'] as $key=>$data)
               
                <?php
                  if($key==0){
                    $openingBalance = $transactionList['amount'];
                  } 
                  $newBalance = $openingBalance+$data->amount;
                  $openingBalance = $newBalance;

                  if($data->amount < 0){
                    $totalDebit += $data->amount;
                  }else{
                    $totalCredit += $data->amount;
                  }

                ?>

                <tr>
                  <td class="text-center">{{ formatDate($data->trans_date) }}</td>
                  <td class="text-center">
                    @if($data->amount <= 0)
                      Expense
                    @else
                      Income
                    @endif
                  </td>
                 
                  <td class="text-center">{{ $data->description }}</td>
                  <td class="text-center">
                    
                    @if($data->amount <= 0)
                      {{abs($data->amount)}}
                    @else
                      0
                    @endif

                  </td>
                  <td class="text-center">
                    
                    @if($data->amount > 0)
                      {{abs($data->amount)}}
                    @else
                      0
                    @endif                    

                  </td>
                   <td class="text-center">{{ $newBalance }}</td>
                </tr>
               @endforeach
                </tbody>

  <tfoot>
    <tr>
      <th colspan="3" class="text-right">Ending Balance On {{formatDate(date('Y-m-d'))}}</th>
      <th class="text-center">{{abs($totalDebit)}}</th>
      <th class="text-center">{{abs($totalCredit)}}</th>
      <th class="text-center">{{$totalCredit+$totalDebit+$transactionList['amount']}}</th>
    </tr>
  </tfoot>

              </table>
            </div>    
    </div>
    </div>
  </div>
</div>
            </div>
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
            }                              
        }
    });
  /*
  $(function () {
    $("#transactionList").DataTable({
      "order": [],
      "columnDefs": [ {
        "orderable": true
        } ],

        "language": '{{Session::get('language')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });*/

    $('#from').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });
   
    $('#to').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });

    </script>
@endsection