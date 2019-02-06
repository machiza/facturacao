{{ -- backup modal notacredito para pagamento direct --}}
  <div class="modal fade" id="payModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ trans('message.table.new_payment') }}</h4>
        </div>
        <div class="modal-body">
        <form class="form-horizontal" id="payForm" action="{{url('payment_credit/save')}}" method="POST">
          <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
          <input type="hidden" name="invoice_reference" value="{{$saleDataInvoice->reference_credit}}"><!--ref fact-->
          <input type="hidden" name="order_reference" value="{{$saleDataOrder->reference}}"><!--Ref Cot-->
          <input type="hidden" name="customer_id" value="{{$customerInfo->debtor_no}}">

          <input type="hidden" name="order_no" value="{{$orderInfo->order_no}}"><!--id cot-->
          <input type="hidden" name="invoice_no" value="{{--$invoice_no--}}"><!--nr fact-->

          <input type="hidden" name="credit_no_id" value="{{--$SaleCredito->credit_no--}}"><!--id do deb-->

          <!--Hugo-->
          <input type="hidden" id="reference_no" class="form-control" name="idrecibo" value="RE-{{ sprintf("%04d", $credit_count+1)}}/<?php echo $parte_ano;?>" type="text" readonly>
          
          
          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.bank.account') }}</label>
            <div class="col-sm-6">
               <select style="width:100%" class="form-control select2" name="account_no" id="account_no">
                <option value="">{{ trans('message.form.select_one') }}</option>
                @foreach($accounts as $acc_no=>$acc_name)
                  <option value="{{$acc_no}}" >{{$acc_name}}</option>
                @endforeach
                </select>
            </div>
          </div>

          <div class="form-group">
            <label for="payment_type_id" class="col-sm-3 control-label require">{{ trans('message.form.payment_type') }} </label>
            <div class="col-sm-6">
              <select style="width:100%" class="form-control select2" name="payment_type_id" id="payment_type_id">
                @foreach($payments as $payment)
                <option value="{{$payment->id}}">{{$payment->name}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.table.category') }}</label>
            <div class="col-sm-6">
               <select style="width:100%" class="form-control select2" name="category_id" id="category_id">
                <option value="">{{ trans('message.form.select_one') }}</option>
                @foreach($incomeCategories as $cat_id=>$cat_name)
                  <option value="{{$cat_id}}" >{{$cat_name}}</option>
                @endforeach
                </select>
            </div>
          </div>


          <div class="form-group">
            <label for="amount" class="col-sm-3 control-label require">{{ trans('message.invoice.amount') }}  </label>
            <div class="col-sm-6">
              <input type="number" name="amount" value="<?php echo $credit_amount;?>" class="form-control" id="amount" placeholder="Amount">
            </div>
          </div>
          
          <!--saldo-->



          <div class="form-group">
            <label for="payment_date" class="col-sm-3 control-label require">{{ trans('message.form.date') }}  </label>
            <div class="col-sm-6">
              <input type="text" name="payment_date" class="form-control" id="payment_date" placeholder="{{ trans('message.invoice.paid_on') }}">
            </div>
          </div>

          <div class="form-group">
            <label for="reference" class="col-sm-3 control-label require">{{ trans('message.table.description') }} </label>
            <div class="col-sm-6">
              <input type="text" name="description" class="form-control" id="description" placeholder="{{ trans('message.table.description') }}" value="Payment for-.{{$SaleCredito->reference_credit}}" readonly>
            </div>      
                       
          </div>

          <div class="form-group">
            <label for="reference" class="col-sm-3 control-label">{{ trans('message.table.reference') }}  </label>
            <div class="col-sm-6">
              <input type="text" name="reference" class="form-control" id="reference" placeholder="{{ trans('message.table.reference') }}">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
              <button type="submit" class="btn btn-primary btn-flat" name="btn_pagar_credito">{{ trans('message.invoice.pay_now') }}</button>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
  <!--Pay Modal End-->
  <!--Modal start-->
    <div id="emailInvoice" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <form id="sendVoiceInfo" method="POST" action="{{url('invoice/email-invoice-info')}}">
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        <input type="hidden" value="{{$orderInfo->order_no}}" name="order_id" id="order_id">
        <input type="hidden" value="{{$invoice_no}}" name="invoice_id" id="invoice_id">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">{{ trans('message.email.email_invoice_info')}}</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="email">{{ trans('message.email.send_to')}}:</label>
              <input type="email" value="{{$customerInfo->email}}" class="form-control" name="email" id="email">
            </div>
            <?php
            $subjectInfo = str_replace('{order_reference_no}', $orderInfo->reference, $emailInfo->subject);
            $subjectInfo = str_replace('{invoice_reference_no}', $saleDataInvoice->reference, $subjectInfo);
            $subjectInfo = str_replace('{company_name}', Session::get('company_name'), $subjectInfo);
            ?>
            <div class="form-group">
              <label for="subject">{{ trans('message.email.subject')}}:</label>
              <input type="text" class="form-control" name="subject" id="subject" value="{{$subjectInfo}}">
            </div>
              <div class="form-groupa">
                  <?php
                  $bodyInfo = str_replace('{customer_name}', $customerInfo->name, $emailInfo->body);
                  $bodyInfo = str_replace('{order_reference_no}', $orderInfo->reference, $bodyInfo);
                  $bodyInfo = str_replace('{invoice_reference_no}',$saleDataInvoice->reference, $bodyInfo);
                  $bodyInfo = str_replace('{due_date}',$due_date, $bodyInfo);
                  $bodyInfo = str_replace('{billing_street}', $customerInfo->billing_street, $bodyInfo);
                  $bodyInfo = str_replace('{billing_city}', $customerInfo->billing_city, $bodyInfo);
                  $bodyInfo = str_replace('{billing_state}', $customerInfo->billing_state, $bodyInfo);
                  $bodyInfo = str_replace('{billing_zip_code}', $customerInfo->billing_zip_code, $bodyInfo);
                  $bodyInfo = str_replace('{billing_country}', $customerInfo->billing_country_id, $bodyInfo);                      
                  $bodyInfo = str_replace('{company_name}', Session::get('company_name'), $bodyInfo);
                  $bodyInfo = str_replace('{invoice_summery}', $itemsInformation, $bodyInfo);                     
                  $bodyInfo = str_replace('{currency}', Session::get('currency_symbol'), $bodyInfo);
                  $bodyInfo = str_replace('{total_amount}', $saleDataInvoice->total, $bodyInfo); 
                  ?>
                  <textarea id="compose-textarea" name="message" id='message' class="form-control editor" style="height: 200px">{{$bodyInfo}}</textarea>
              </div>

            <div class="form-group">
                <div class="checkbox">
                  <label><input type="checkbox" name="invoice_pdf" checked><strong>{{$saleDataInvoice->reference}}</strong></label>
                </div>
            </div>
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{ trans('message.email.close')}}</button><button type="submit" class="btn btn-primary btn-sm">{{ trans('message.email.send')}}</button>
          </div>
        </div>
        </form>
      </div>
    </div>--}}