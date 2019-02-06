@extends('layouts.customer_panel')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
            <div class="col-md-6 col-md-offset-3">
            <h4 class="text-center">Pay On Bank</h4>
              <form action='{{ url("customer_payments/bank-payment") }}' method="post" class="form-horizontal" enctype="multipart/form-data" id="myform1">
                  {!! csrf_field() !!}

                  <input type="hidden" value="{{$orderno}}" name="order_no">
                  <input type="hidden" value="{{$invoiceno}}" name="invoice_no">
                  <input type="hidden" value="{{$paymentMethod}}" name="method">

                  <div class="form-group">
                    <label class="col-sm-3 control-label require" for="inputName">{{ trans('message.table.amount') }}</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" value="{{$amount}}" id="amount" name="amount" required="true">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.transaction.attachment') }}</label>
                    <div class="col-sm-9">
                      <input type="file" class="form-control input-file-field" id="attachment" name="attachment" required="true">
                    </div>
                  </div>


                  <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                      <button class="btn btn-primary btn-flat" type="submit">Submit</button>
                    </div>
                  </div>
                </form>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
        <!-- /.box-footer-->
    </section>
@endsection
@section('js')
    <script type="text/javascript">

    </script>
@endsection