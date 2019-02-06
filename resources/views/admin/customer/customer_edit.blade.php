
@php
$id = $customerData->debtor_no;
@endphp

<?php
require_once './conexao.php';
//numero de linhas:
$sql = "Select * from cust_branch";
$comando = $pdo->prepare($sql);
$comando->execute();
$resultado = $comando->fetch();
$nuit = $resultado ["nuit"];

/*facturas*/
$sql_saldo = "select *, sales_orders.debtor_no,sum(total), sum(paid_amount) from debtors_master
              inner join sales_orders on debtors_master.debtor_no=sales_orders.debtor_no
              where sales_orders.debtor_no = '$id' AND invoice_type='directInvoice'";
$comando_saldo = $pdo->prepare($sql_saldo);
$comando_saldo->execute();
$resultado_saldo = $comando_saldo->fetch();
$total_facturas = $resultado_saldo ["sum(total)"];
$total_paid_amount= $resultado_saldo ["sum(paid_amount)"];
$total_saldos = 0;
$total_saldos = $total_facturas - $total_paid_amount;

/*debitos:*/
$sql_saldo_debit = "select *, sales_debito.debtor_no_debit, sum(debito),sum(paid_amount_debit)
              from debtors_master
              inner join sales_debito on debtors_master.debtor_no=sales_debito.debtor_no_debit
              where sales_debito.debtor_no_debit = '$id' AND invoice_type_debit='directInvoice'";
$comando_saldo_debit = $pdo->prepare($sql_saldo_debit);
$comando_saldo_debit->execute();

$resultado_saldo_debit = $comando_saldo_debit->fetch();
$counted_debito = $resultado_saldo_debit ["sum(debito)"];
$total_paid_amount = $resultado_saldo_debit ["sum(paid_amount_debit)"];
//total_saldos:
$saldo_debit = $counted_debito - $total_paid_amount;

/*creditos*/
$sql_saldo_credit = "select *, sum(credito) from sales_orders
              inner join sales_credito on sales_orders.order_no=sales_credito.order_no_id
              where sales_orders.debtor_no = '$id' AND invoice_type='directInvoice'";
$comando_saldo_credit = $pdo->prepare($sql_saldo_credit);
$comando_saldo_credit->execute();
$resultado_saldo_credit = $comando_saldo_credit->fetch();
$saldo_credit = $resultado_saldo_credit ["sum(credito)"] - $resultado_saldo_credit ["paid_amount_credit"] ;

//Saldo total (fact e debts):
$saldo_total = number_format(($total_saldos + $saldo_debit) - $saldo_credit,2);
?>

@extends('layouts.app')
@section('content')

<style type="text/css">
  #asterisco_nuit{
    color: red;
  }
</style>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
        <div class="box">
          
           <div class="panel-body">
                <ul class="nav nav-tabs cus" role="tablist">
                    <li class="active">
                      <a href='{{url("customer/edit/$customerData->debtor_no")}}' >{{ trans('message.sidebar.profile') }}</a>
                    </li>
                    <li>
                      <a href="{{url("customer/order/$customerData->debtor_no")}}" >{{ trans('message.accounting.quotations') }}</a>
                    </li>
                    <li>
                      <a href="{{url("customer/invoice/$customerData->debtor_no")}}" >{{ trans('message.extra_text.invoices') }}</a>
                    </li>
                    <li>
                      <a href="{{url("customer/debit/$customerData->debtor_no")}}" >{{ trans('message.accounting.debitsss') }}</a>
                    </li>

                    <li>
                      <a href="{{url("customer/credit/$customerData->debtor_no")}}" >{{ trans('message.accounting.creditsss') }}</a>
                    </li>
                    
                    <li>
                      <a href="{{url("customer/payment/$customerData->debtor_no")}}" >{{ trans('message.extra_text.payments') }}</a>
                    </li>

                    <li>
                      <a href="{{url("customer/current_account/$customerData->debtor_no")}}" >{{ trans('message.extra_text.current_account') }}</a>
                    </li>

                    <li>
                      <a href="{{url("customer/pendentes/$customerData->debtor_no")}}" >{{ trans('message.extra_text.pendentes') }}</a>
                    </li>
                    <li>
                      @if(Helpers::has_permission(Auth::user()->id, 'add_customer'))
                      <a href="{{ url('create-customer') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.form.add_new_customer') }}</a>
                      @endif
                    </li>

               </ul>
                
              <div class="clearfix"></div>
           </div>
        </div>

        <h3>{{$customerData->name}}</h3>
        <div class="box">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="tabs" style="font-size:12px">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">{{ trans('message.table.general_settings') }}</a></li>
              <!--
              @if(!empty($customerData->password))
              <li><a href="#tab_3" data-toggle="tab" aria-expanded="false">{{ trans('message.form.update_password') }}</a></li>
              @else
              <li><a href="#tab_3" data-toggle="tab" aria-expanded="false">{{ trans('message.form.set_password') }}</a></li>
              @endif
            -->
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade in active" id="tab_1">
                  <form action='{{ url("update-customer/$customerData->debtor_no") }}' method="post" class="form-horizontal" id="customerAdd">

                <div class="row">
                <div class="col-md-6">      
                  <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                        <div class="box-body">
                          
                          <div class="form-group">
                            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.name') }}</label>
                            <div class="col-sm-7">
                              <input type="text" placeholder="{{ trans('message.form.full_name') }}" class="form-control valdation_check" id="name" name="name" value="{{$customerData->name}}">
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.email') }}</label>
                            <div class="col-sm-7">
                              <input type="text" placeholder="{{ trans('message.table.email') }}" class="form-control valdation_check" id="email" name="email" value="{{$customerData->email}}">
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.table.phone') }}</label>
                            <div class="col-sm-7">
                              <input type="text" placeholder="{{ trans('message.table.phone') }}" class="form-control" id="phone" maxlength="9" name="phone" value="{{$customerData->phone}}">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.invoice.street') }}</label>
                            <div class="col-sm-7">
                              <input name="bill_street" id="bill_street" type="text" class="form-control" value="{{$cusBranchData->billing_street}}">
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.invoice.city') }}</label>
                            <div class="col-sm-7">
                              <input name="bill_city" id="bill_city" type="text" class="form-control" value="{{$cusBranchData->billing_city}}">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.invoice.state') }}</label>
                            <div class="col-sm-7">
                              <input name="bill_state" id="bill_state" type="text" class="form-control" value="{{$cusBranchData->billing_state}}">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>
                            <div class="col-sm-3">
                              <input name="bill_zipCode" id="bill_zipCode" type="text" class="form-control" name="bill_zipCode" value="{{$cusBranchData->billing_zip_code}}">
                            </div>
                            <label class="col-sm-1 control-label" for="inputEmail3">Nuit <span id="asterisco_nuit">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="nuit" id="nuit" maxlength="9" value="{{$cusBranchData->nuit}}">
                            </div>
                          </div>

                        <div class="form-group">
                           <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.tax_except') }} <span class="text-danger"> </label>
                       
                           <div class="col-sm-1">
                              <label >
                               {{ trans('message.form.no') }}
                               @if($cusBranchData->imposto==0)
                                <input type="radio" name="imposto" value="0" class="minimall" checked>
                               @else
                               <input type="radio" name="imposto" value="0" class="minimall"> 
                               @endif
                              </label>
                            </div>
                         <div class="col-sm-1">
                          <label>
                            {{ trans('message.form.yes') }}
                            @if($cusBranchData->imposto==1)
                            <input type="radio" name="imposto" value="1" class="minimall" checked>
                           @else
                           <input type="radio" name="imposto" value="1" class="minimall"> 
                           @endif
                          </label>
                         </div>
                       
                        <label class="col-sm-3">{{ trans('message.form.discount_percent') }} <span class="text-danger"> *</label>
                          <div class="col-sm-2">
                             <input type="text" placeholder="{{ trans('message.form.discount_percent') }}" class="form-control" name="discounto" value="{{isset($cusBranchData->discounto) ? $cusBranchData->discounto : 0}}" required="true">
                          </div>
                      </div> 

                      <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.invoice.motivation') }}</label>
                            <div class="col-sm-7">
                              @if($cusBranchData->motivation!="")
                             <input type="text" class="form-control" name="info" value="{{$cusBranchData->motivation}}" id="info">
                             @else
                             <input type="text" class="form-control" name="info" value="{{$cusBranchData->motivation}}" id="info" disabled="">
                             @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputEmail3">Tipo de Cliente</label>
                            <div class="col-sm-7">
                              <select class="form-control select2" name="tipo_cliente" id="tipo_cliente">
                                <option value="normal" <?=isset($customerData->tipo_cliente) && $customerData->tipo_cliente ==  'normal'? 'selected':""?> >Normal</option>
                                <option value="parceiro"  <?=isset($customerData->tipo_cliente) && $customerData->tipo_cliente == 'parceiro' ? 'selected':""?> >Parceiro</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.status') }}</label>
                            <div class="col-sm-7">
                              <select class="form-control select2" name="status" id="status">
                                <option value="0" <?=isset($customerData->inactive) && $customerData->inactive ==  0? 'selected':""?> >Active</option>
                                <option value="1"  <?=isset($customerData->inactive) && $customerData->inactive == 1 ? 'selected':""?> >Inactive</option>
                              </select>
                            </div>
                          </div>

                      </div>
                  </div>
                 
                  <div class="col-md-6">
                             <!--Início do saldo em aberto-->
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.table.balance_amount') }}</label>
                            <div class="col-sm-7">
                              <input name="saldo" id="id_saldo" type="text" class="form-control"
                              value="<?php echo number_format("$saldoCustomer",2).' '.Session::get('currency_symbol'); ?>" disabled>
                            </div>
                          </div>
                          <!-- Fim do saldo em aberto-- saldo_total-->
                   </div>       



                          
                          <!--
                          <h4 class="text-info text-center">{{ trans('message.invoice.shipping_address') }}<button id="copy" class="btn btn-default btn-xs" type="button">{{ trans('message.table.copy_address') }}</button></h4>
                          
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.invoice.street') }}</label>
                            <div class="col-sm-7">
                              <input name="ship_street" id="ship_street" type="text" class="form-control" value="{{$cusBranchData->shipping_street}}">
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.invoice.city') }}</label>
                            <div class="col-sm-7">
                              <input name="ship_city" id="ship_city" type="text" class="form-control" value="{{$cusBranchData->shipping_city}}">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.invoice.state') }}</label>
                            <div class="col-sm-7">
                              <input name="ship_state" id="ship_state" type="text" class="form-control" value="{{$cusBranchData->shipping_state}}">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>
                            <div class="col-sm-7">
                              <input name="ship_zipCode" id="ship_zipCode" type="text" class="form-control" value="{{$cusBranchData->shipping_zip_code}}">
                            </div>
                          </div>


                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.invoice.country') }}</label>
                            <div class="col-sm-7">
                              <select class="form-control select2" name="shipping_country_id" id="shipping_country_id">
                              <option value="">{{ trans('message.form.select_one') }}</option>
                              @foreach ($countries as $data)
                                <option value="{{$data->code}}" <?= ($cusBranchData->shipping_country_id == $data->code) ? 'selected' : '' ?>>{{$data->country}}</option>
                              @endforeach
                              </select>
                            </div>
                          </div>
                  </div>
              -->

              </div>
              
             
              <div class="row">
                <div class="col-md-12">
                 
                    <div style="margin-top:10px">
                      <a href="{{ url('customer/list') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                      <button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
                    </div>
                  
                </div>
              </div>
              </form>
            </div>

        
              <div class="tab-pane" id="tab_3">
                    <div class="row">
                      <div class="col-md-6">
                          <form action='{{url("customer/update-password")}}' class="form-horizontal" id="password-form" method="POST">
                            <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                            <input type="hidden" value="{{$customerData->debtor_no}}" name="customer_id">
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.password') }}</label>

                              <div class="col-sm-8">
                              <input type="password" class="form-control" name="password" id="password">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.confirm_password') }}</label>

                              <div class="col-sm-8">
                              <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                              <br>
                              @if(!empty(Session::get('customer_edit')))
                              <button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
                              @endif
                              </div>
                            </div>
                          </form>
                      </div>
              </div>
            </div>
            <!-- /.tab-content -->
          </div>
        </div>

    @include('layouts.includes.message_boxes')
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


    $('.select2').select2();
    $(function () {
      $("#example1").DataTable({
        "order": [],
        "columnDefs": [{
          "targets": 3,
          "orderable": false
          } ],

          "language": '{{Session::get('language')}}'
      });
        var type = window.location.hash.substr(1);
    });

    $('#customerAdd').validate({
        rules: {
            name: {
                required: true
            },

            bill_street: {
                required: true
            },
            bill_city:{
                required: true
            },
            nuit:{
                required: true
            }     
        }
    });

    $('#password-form').validate({
        rules: {
            password: {
                required: true,
                minlength: 5
            },
            password_confirmation: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            }
        }
    });




    $('#copy').on('click', function() {
        $('#ship_street').val($('#bill_street').val());
        $('#ship_city').val($('#bill_city').val());
        $('#ship_state').val($('#bill_state').val());
        $('#ship_zipCode').val($('#bill_zipCode').val());

       var billing_country_id = $('#billing_country_id').val();
       $("#shipping_country_id").val(billing_country_id).change();
    })

jQuery(function($) {
    var index = 'qpsstats-active-tab';
    //  Define friendly data store name
    var dataStore = window.sessionStorage;
    var oldIndex = 0;
    //  Start magic!
    try {
        // getter: Fetch previous value
        oldIndex = dataStore.getItem(index);
    } catch(e) {}
 
    $( "#tabs" ).tabs({        active: oldIndex,
        activate: function(event, ui) {
            //  Get future value
            var newIndex = ui.newTab.parent().children().index(ui.newTab);
            //  Set future value
            try {
                dataStore.setItem( index, newIndex );
            } catch(e) {}
        }
    });
});


    </script>
@endsection