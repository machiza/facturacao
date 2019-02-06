
@php
$id =$supplierData->supplier_id ;
@endphp
<?php
require_once './conexao.php';
/*facturas*/
$sql_saldo = "select *, purch_orders.supplier_id,sum(total), sum(valor_pago) from suppliers
              inner join purch_orders on suppliers.supplier_id=purch_orders.supplier_id
              where purch_orders.supplier_id = '$id'";
$comando_saldo = $pdo->prepare($sql_saldo);
$comando_saldo->execute();
$resultado_saldo = $comando_saldo->fetch();
$total_facturas = $resultado_saldo ["sum(total)"];
$total_paid_amount= $resultado_saldo ["sum(valor_pago)"];
$total_saldos = 0;
$total_saldos = $total_facturas - $total_paid_amount;

//Saldo total (fact e debts):
$saldo_total = number_format($total_saldos,2);
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

        <div class="box">
           <div class="panel-body">
                <ul class="nav nav-tabs cus" role="tablist">
                    <li class="active">
                      <a href="{{url("edit-supplier/$supplierData->supplier_id")}}" >{{ trans('message.sidebar.profile') }}</a>
                    </li>
                    <li>
                      <a href="{{url("supplier/orders/$supplierData->supplier_id")}}" >{{ trans('message.extra_text.purchase_orders') }}</a>
                    </li>

                    <li>
                      <a href="{{url("supplier/current_account/$supplierData->supplier_id")}}" >{{ trans('message.extra_text.current_account') }}</a>
                    </li>

                    <li>
                      <a href="{{url("supplier/pendentes/$supplierData->supplier_id")}}" >{{ trans('message.extra_text.pendentes') }}</a>
                    </li>
                    <li>
                      <a href="{{url("supplier/payment_list/$supplierData->supplier_id")}}" >{{ trans('message.extra_text.payments') }}</a>
                    </li>
                    <li>
                    @if(Helpers::has_permission(Auth::user()->id, 'add_supplier'))
                    <a href="{{ url('create-supplier') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.table.add_new_supplier') }}</a>
                    @endif
                    </li>
               </ul>
              <div class="clearfix"></div>
           </div>
        </div>
        <h3>{{$supplierData->supp_name}}</h3>

      <!-- Default box -->
        
        <div class="box">
          <div class="box-body">
              <h4 class="text-info text-center">{{ trans('message.table.update_suppiler') }}</h4>
                <!-- form start -->
              <form action='{{ url("update-supplier/$supplierData->supplier_id") }}' method="post" id="supplier" class="form-horizontal">
              <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
              <div class="box-body">
              <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.table.supp_name') }}</label>
                  <div class="col-sm-6">
                    <input type="text" placeholder="{{ trans('message.form.full_name') }}" class="form-control" id="supp_name" name="supp_name" value="{{$supplierData->supp_name}}">
                    <span id="val_fname" style="color: red"></span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.email') }}</label>

                  <div class="col-sm-6">
                    <input type="text" placeholder="Supplier Short Name" class="form-control valdation_check" id="lname" name="email" value="{{$supplierData->email
                      }}" readonly>
                    <span id="val_lname" style="color: red"></span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.table.phone') }}</label>

                  <div class="col-sm-6">
                    <input type="text" placeholder="{{ trans('message.table.phone') }}" class="form-control valdation_check" id="name" name="contact" value="{{$supplierData->contact}}" maxlength="9">
                    <span id="val_name" style="color: red"></span>
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.extra_text.street') }}</label>
                  <div class="col-sm-6">
                    <input type="text" placeholder="{{ trans('message.extra_text.street') }}" class="form-control valdation_check" id="street" name="street" value="{{$supplierData->address}}">
                  </div>
                </div>

            
                <div class="form-group">
                  <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.extra_text.city') }}</label>
                  <div class="col-sm-6">
                    <input type="text" placeholder="{{ trans('message.extra_text.city') }}" class="form-control" id="city" name="city" value="{{$supplierData->city}}">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.extra_text.state') }}</label>
                  <div class="col-sm-6">
                    <input type="text" placeholder="{{ trans('message.extra_text.state') }}" class="form-control" id="state" name="state" value="{{$supplierData->state}}">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.extra_text.zipcode') }}</label>
                  <div class="col-sm-6">
                    <input type="text" placeholder="{{ trans('message.extra_text.zipcode') }}" class="form-control" id="zipcode" name="zipcode" value="{{$supplierData->zipcode}}">
                  </div>
                </div>

                <!--NUIT-->
                <div class="form-group">
                  <label class="col-sm-3 control-label" for="id_nuit">Nuit <span id="asterisco_nuit">*</span></label>
                  <div class="col-sm-6">
                    <input type="text" placeholder="Nuit" class="form-control" maxlength="9" 
                     id="id_nuit" name="nuit" value="{{$supplierData->nuit}}">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.extra_text.country') }}</label>
                  <div class="col-sm-6">
                        <select class="form-control select2" name="country" id="country">
                        <option value="">{{ trans('message.form.select_one') }}</option>
                        @foreach ($countries as $data)
                          <option value="{{$data->code}}" <?= ($data->code == $supplierData->country) ? 'selected' : ''?>>{{$data->country}}</option>
                        @endforeach
                        </select>
                  </div>
                </div> 
                <!--Início do saldo em aberto-->
                          <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.table.balance_amount') }}</label>
                            <div class="col-sm-6">
                              <input name="saldo" id="id_saldo" type="text" class="form-control"
                              value="<?php echo $saldo_total;?>" disabled>
                            </div>
                          </div>
                <!-- Fim do saldo em aberto-->
                
                <div class="form-group">
                  <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.status') }}</label>

                  <div class="col-sm-6">
                    <select class="form-control valdation_select" name="inactive" >
                      
                      <option value="0" <?=isset($supplierData->inactive) && $supplierData->inactive ==  0? 'selected':""?> >Active</option>
                      <option value="1"  <?=isset($supplierData->inactive) && $supplierData->inactive == 1 ? 'selected':""?> >Inactive</option>
                    </select>
                    

              <div>
                <br>
                <a href="{{ url('supplier') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                <button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
              </div>
            

                  </div>
                </div>

              </div>

              </div>

              </div>
              <!-- /.box-body -->

              <!-- /.box-footer -->
            </form>

          </div>
        </div>
    </section>
@endsection
@section('js')
    <script type="text/javascript">
    $(".select2").select2();
    $('#supplier').validate({
        rules: {
            supp_name: {
                required: true
            },
            email: {
                required: true
            },
            address:{
              required : true
            }, 
            city: {
                required: true
            },
            nuit: {
                required: true
            },
            country :{
              required : true
            }                               
        }
    });
    </script>
@endsection