@extends('layouts.app')
@section('content')

<style type="text/css">
  #asterisco_nuit{
    color: red;
  }
</style>

    <!-- Main content -->
    <section class="content">

    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
           <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.customer') }}</div>
          </div> 
        </div>
      </div>
    </div> 
        
        <div class="box">
                <!-- form start -->
                      <form action="{{ url('save-customer') }}" method="post" id="customerAdd" class="form-horizontal">
                      
                      <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                      <div class="box-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="col-md-6">
                            <h4 class="text-info text-center">{{ trans('message.invoice.customer_info') }}</h4>
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.name') }}</label>

                              <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" value="{{old('name')}}">
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.email') }}</label>

                              <div class="col-sm-8">
                                <input type="email" value="{{old('email')}}" class="form-control" name="email">
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.table.phone') }}</label>

                              <div class="col-sm-8">
                                <input type="text" value="{{old('phone')}}" class="form-control" name="phone" maxlength="9">
                              </div>
                            </div>

                            <div class="form-group">
                                  <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_street" value="{{old('bill_street')}}" id="bill_street">
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_city" value="{{old('bill_city')}}" id="bill_city">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_state" value="{{old('bill_state')}}" id="bill_state">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_zipCode" value="{{old('bill_zipCode')}}" id="bill_zipCode">
                                  </div>
                                </div>

                                <!--NUIT-->
                                <div class="form-group">
                                  <label class="col-sm-4 control-label" for="inputEmail3">Nuit <span id="asterisco_nuit">*</span></label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nuit" id="nuit" maxlength="9">
                                  </div>
                                </div>
                          <!--   impost e discontos-->
                                <div class="form-group">
                                <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.form.tax_except') }} <span class="text-danger"> </label>

                                      <div class="col-sm-1">
                                          <label >
                                          {{ trans('message.form.no') }}
                                          <input type="radio" name="imposto" value="0" class="minimall" checked>
                                          </label>
                                      </div>
                                      <div class="col-sm-1">
                                          <label>
                                          {{ trans('message.form.yes') }}
                                          <input type="radio" name="imposto" value="1" class="minimall"> 
                                          </label>
                                      </div>

                                      <label class="col-sm-4">{{ trans('message.form.discount_percent') }} <span class="text-danger"> *</label>
                                          <div class="col-sm-2">
                                               <input type="text" placeholder="0" class="form-control" name="discounto">
                                          </div>
                                </div> 
                                   
                                <div class="form-group">
                                  <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.invoice.motivation') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="info" value="{{old('info')}}" id="info" disabled="">
                                  </div>
                                </div>

                                        
                                        
                                        

                                    <input type="text" name="ship_country_id" id="ship_country_id" value="" hidden>
                                    <input type="text" name="bill_country_id" id="bill_country_id"  value="MZ" hidden>
                                    <input type="text" name="shipping_street"  id="ship_street" value="" hidden> 
                                    <input type="text" name="ship_street" id="ship_street" value="" hidden> 
                                    <input type="text" name="ship_city" id="ship_city"  value="" hidden> 
                                    <input type="text" name="ship_state" id="ship_state"  value="" hidden> 
                                    <input type="text" name="ship_zipCode" id="ship_zipCode" value="" hidden> 
                                  <!--

                                
                                <div class="form-group">
                                  <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.country') }}</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" name="bill_country_id" id="bill_country_id">
                                    <option value="">{{ trans('message.form.select_one') }}</option>
                                    @foreach ($countries as $data)
                                      <option value="{{$data->code}}">{{$data->country}}</option>
                                    @endforeach
                                    </select>
                                  </div>
                                </div>-->

                          </div>
                          <!--
                          <div class="col-md-6">
                              <h4 class="text-info text-center">{{ trans('message.invoice.shipping_address') }} <button id="copy" class="btn btn-default btn-xs" type="button">{{ trans('message.table.copy_address') }}</button></h4>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_street" name="ship_street">
                                  </div>
                                </div>
                                
                                <div class="form-group">
                                  <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_city" name="ship_city">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_state" name="ship_state">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_zipCode" name="ship_zipCode">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.invoice.country') }}</label>

                                  <div class="col-sm-8">
                                    <select class="form-control select2" name="ship_country_id" id="ship_country_id">
                                    <option value="">{{ trans('message.form.select_one') }}</option>
                                    @foreach ($countries as $data)
                                      <option value="{{$data->code}}">{{$data->country}}</option>
                                    @endforeach
                                    </select>
                                  </div>
                                </div>
                          </div>
                      -->
                        </div>
                      </div><br>
                      </div>
                        <!-- /.box-body -->
                        
                        <div class="box-footer">
                          <a href="{{ url('customer/list') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                          <button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
                        </div>
                        <!-- /.box-footer -->
                      </form>
          
        </div>
        
        <!-- /.box-footer-->
      
      <!-- /.box -->

    </section>
@endsection

@section('js')
  <script type="text/javascript">

     $('input[type=radio][name=imposto]').change(function() {
          if (this.value == '0') {
               $('#info').val("");
               $('#info').prop('disabled',true);
          }
          else if (this.value == '1') {
           
              $('#info').prop('disabled',false);
          }
      });



    $(".select2").select2();
      // Item form validation
    $('#customerAdd').validate({
        rules: {
            name: {
                required: true
            },
            /*email:{
                required: true
            },*/

            bill_street: {
                required: true
            },
            bill_city:{
                required: true
            },
            nuit:{
                required: true
            },
           /* bill_country_id:{
               required: true
            },*/
        }
    });

    $('#copy').on('click', function() {

        $('#ship_street').val($('#bill_street').val());
        $('#ship_city').val($('#bill_city').val());
        $('#ship_state').val($('#bill_state').val());
        $('#ship_zipCode').val($('#bill_zipCode').val());

       var bill_country = $('#bill_country_id').val();
       $("#ship_country_id").val(bill_country).change();

    });
    </script>
@endsection