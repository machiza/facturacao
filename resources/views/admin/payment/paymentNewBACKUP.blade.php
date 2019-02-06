<?php
//data para id:
$dt = date("Y/m/d");
$parte_ano = substr($dt,  0, 4);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script>
    function getFacturas(val) {
        $.ajax({
            type: "POST",
                url: "{{url('payment/get-inv')}}",
                 data: 'debtor_no=' + val,
                success: function (data) {
                    $("#table").html(data);
            }
        });
    }
</script>

<style type="text/css">
	#docs{
		text-decoration: underline;
	}
</style>

@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

 <!-- Default box -->
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default">
        <!-- /.box-header -->
        <div class="box-body">
          <h4 class="modal-title">{{ trans('message.table.new_payment') }}</h4><br>
        
        <form action="{{url('payment/save_newpayment')}}" method="POST" id="payForm">  
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        <div class="row">
            <!--account-->
            <div class="col-md-3">
                <div class="form-group">
                <label  for="inputEmail3">{{ trans('message.bank.account') }}<span class="text-danger"> *</span></label>
                    <select style="width:100%" class="form-control select2" name="account_no" id="account_no">
                       <option value="">{{ trans('message.form.select_one') }}</option>
                       @foreach($accounts as $acc_no=>$acc_name)
                       <option value="{{$acc_no}}" >{{$acc_name}}</option>
                       @endforeach
                    </select>
                </div>
            </div>

            <!--met-->
            <div class="col-md-3">
              <div class="form-group">
                  <label for="exampleInputEmail1">{{ trans('message.extra_text.payment_method') }}<span class="text-danger"> *</span></label>
                     <select class="form-control select2" name="payment_type_id">
                    
                    @foreach($payments as $payment)
                      <option value="{{$payment->id}}" <?= ($payment->defaults =="1" ? 'selected':'')?>>{{$payment->name}}</option>
                    @endforeach
                    </select>
              </div>
            </div>

            <!--cat-->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="inputEmail3">{{ trans('message.table.category') }}<span class="text-danger"> *</span></label>
                    <select style="width:100%" class="form-control select2" name="category_id" id="category_id">
                    <option value="">{{ trans('message.form.select_one') }}</option>
                    @foreach($incomeCategories as $cat_id=>$cat_name)
                    <option value="{{$cat_id}}" >{{$cat_name}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
 
            <!--amount-->
            <!--<div class="col-md-3">
               <div class="form-group">
                  <label for="amount">{{ trans('message.quotation.amount') }}<span class="text-danger"> *</span></label>
                  <input type="number" name="amounts"  class="form-control" id="amount" placeholder="Amount" min="1" step="0.5">
               </div> 
            </div>-->
        </div><!--end row1-->

        <div class="row"><br>
            <!--cli-->
            <div class="col-md-3">
              <div class="form-group">
                <label for="exampleInputEmail1">{{ trans('message.form.customer') }}<span class="text-danger"> *</span></label>
                <select class="form-control select2" name="debtor_no" id="customer" onChange="getFacturas(this.value);">
                <option value="">{{ trans('message.form.select_one') }}</option>
                @foreach($customerData as $data)
                  <option value="{{$data->debtor_no}}">{{$data->name}}</option>
                @endforeach
                </select>
              </div>
            </div>

            <!--data-->
            <div class="col-md-3">
              <div class="form-group">
                <label>{{ trans('message.table.date') }}</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input class="form-control" id="datepicker" type="text" name="payment_date" id="payment_date">
                </div>
                <!-- /.input group -->
              </div>
            </div>


            <div class="col-md-3" style="display: none">
              <div class="form-group">
                  <label for="exampleInputEmail1">{{ trans('message.form.sales_type') }}</label>
                   <select class="form-control select2" name="sales_type" id="sales_type_id">
                  
                    @foreach($salesType as $key=>$saleType)
                      <option value="{{$saleType->id}}" <?= ($saleType->id== 1 )?'selected':''?>>{{$saleType->sales_type}}</option>
                    @endforeach
                    </select>
              </div>
            </div>


            <!--id-->
            <div class="col-md-3">
              <div class="form-group">
                  <label for="exampleInputEmail1">{{ trans('message.table.reference') }}</label>
                  <!--<div class="input-group">
                     <div class="input-group-addon">RE-</div>-->
                     <input id="reference_no" class="form-control" name="idrecibo" value="RE-{{ sprintf("%04d", $invoice_count+1)}}/<?php echo $parte_ano;?>" type="text" readonly>
                     <input type="hidden"  name="reference" id="reference_no_write" value="">
                  <!--</div>-->
                  <span id="errMsg" class="text-danger"></span>
              </div>
            </div>
            <!--end-->
        </div>

        <!--tbl--><br>
        <p id="docs">{{ trans('message.payment.docs_pagar') }}</p>
        <div class="row">
            <div class="col-md-12">
              <!-- /.box-header -->
              <div class="box-body no-padding">
                <div class="table-responsive">
                <table class="table table-bordered" id="table">
                  <tbody>

                  <tr class="tbl_header_color dynamicRows">
                    <th width="30%" class="text-center">{{ trans('message.accounting.docs') }}</th>
                    <th width="10%" class="text-center">{{ trans('message.accounting.data') }}</th>
                    <th width="10%" class="text-center">{{ trans('message.table.total_price') }}</th>
                    <th width="15%" class="text-center">{{ trans('message.table.balance_amount') }}</th>
                    <th width="10%" class="text-center">{{ trans('message.quotation.amount') }}</th>
                  </tr>

                  </tbody>
                </table>
                </div>
                <br><br>
              </div>
            </div>
              <!-- /.box-body -->
              <div class="col-md-12">

                <a href="{{url('/payment/list')}}" class="btn btn-info btn-flat">
                {{ trans('message.form.cancel') }}
                </a>
                
                <button type="submit" name="btn_newpayment" class="btn btn-primary btn-flat pull-right" id="btnSubmit">
                {{ trans('message.form.submit') }}
                </button>
              </div>
        </div>
                </form>
            <!-- /.col -->
            
            <!-- /.col -->
      </div>
          <!-- /.row -->
    </div>
        <!-- /.box-body -->
      <!-- /.box -->

</section>
@endsection

@section('js')
<script type="text/javascript">

    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2({});

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: '{{Session::get('date_format_type')}}'
        });
        $('#datepicker').datepicker('update', new Date());

        $('.ref').val(Math.floor((Math.random() * 100) + 1));
       });


    // Item form validation
    /*$('#payForm').validate({
        rules: {
            account_no:{
              required: true
            },
            payment_type_id: {
                required: true
            },
            category_id:{
            required: true
           },
           amount: {
                required: true
            },
          debtor_no:{
            required: true
          }                   
        }
    });*/
    </script>
@endsection