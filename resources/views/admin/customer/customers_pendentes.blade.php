@extends('layouts.app')
@section('content')

<!-- Main content -->
    <section class="content">
      <!-- Default box -->
       
        <h3>{{ trans('message.extra_text.Dados_pendent') }}</h3>  

    <div class="box">
      <!-- /.box-header -->
        <div class="box-body">

          <div class="btn-group pull-right">
            <!--btn chamar pfd-->
           
              <a target="_blank" href="{{ url('pendentes-reporte') }}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
          </div><br><br>

             
                
            

              <table id="example1" class="table table-bordered table-striped">
                <thead>

                  <tr>
                    <th>{{ trans('message.accounting.data') }}</th>
                    {{-- <th>{{ trans('message.table.customer_name') }}</th> --}}
                    <th>{{ trans('message.accounting.docs') }}</th>
                    <th>{{ trans('message.accounting.Expiration_date') }}</th>
                    <th>Dias vencidos</th>
                    <th>{{ trans('message.table.total_price') }}</th>
                    <th>{{ trans('message.table.paid_amount') }}</th>
                    <th>{{ trans('message.table.balance_amount') }}</th>
                  </tr>

                </thead>
                <tbody>

               @php

               $total=0;
               $saldo_doc = 0;
               $i = 0;
               
               @endphp
                 
                @foreach ($contas as $conta)
                @php
                  $sub_total= 0;
                  $total += $saldo_doc;
                  $saldo_doc = 0;
                  $i = 0;
                @endphp
                  @foreach($Pendentes as $dado)
                    
                    @if ($dado->name == $conta->name)
                      @if ($saldo_doc == 0)
                        <tr>
                          <th style="background-color: #5d98de;">{{ $dado->name }}</th>
                          <th style="background-color: #5d98de;"></th>
                          <th style="background-color: #5d98de;"></th>
                          <th style="background-color: #5d98de;"></th>
                          <th style="background-color: #5d98de;"></th>
                          <th style="background-color: #5d98de;"></th>
                          <th style="background-color: #5d98de;"></th>
                        </tr>
                      @endif
                      
                      @if($dado->status!='cancelado')
                        <tr>
                            <td>{{ $dado->ord_date_doc }}</td>
                            @php
                              $linha=explode('-',$dado->reference_doc);
                              $pago=$dado->amount_doc-$dado->saldo_doc;
                              $sub_total= $sub_total+$dado->saldo_doc;
                              
                              if ($linha[0]=='NC') {
                                $saldo_doc -= $dado->amount_credito_doc;
                              } else {
                                $saldo_doc += $dado->saldo_doc;
                              }
                              // $data_ord = formatDate(date('Y-m-d', $dado->ord_date_doc));
                              $data_due = (date('Y-m-d', strtotime("+".$dado->days_before_due."days", strtotime($dado->ord_date_doc))));
                              $data_h = date('y-m-d');

                              $datetime1 = new DateTime($data_due);
                              $datetime2 = new DateTime();
                              $interval = $datetime1->diff($datetime2);
                              $intervalo = (int)$interval->format('%R%a');
                              if($intervalo > 0) {
                                $intervalo = $interval->format('%a');
                              } else {
                                $intervalo = 0;
                              }
                              
                            @endphp
                            {{-- <td>
                            @if(Helpers::has_permission(Auth::user()->id, 'edit_customer'))
                            <a href="{{url("customer/edit/$dado->debtor_no")}}">{{ $dado->name }}</a>
                            @else 
                            {{ $dado->name }}
                            @endif
                            </td> --}}
                            <td>{{$dado->reference_doc}}</td>
                            <td>{{ $data_due }}</td> 
                            <td>{{ $intervalo }}</td>  

                            @if($linha[0]=='NC')
                            <td> {{Session::get('currency_symbol').number_format($dado->amount_credito_doc,2)}}</td>
                            @else
                            <td>{{ Session::get('currency_symbol').number_format($dado->amount_doc,2) }}</td> 
                            @endif   
                            <td>{{ Session::get('currency_symbol').number_format($pago,2) }}</td>                  
                            <td>{{ Session::get('currency_symbol').number_format($saldo_doc,2) }}</td>                  
                        </tr> 
                      @endif
                    @endif

                    @php
                        $i += 1;
                    @endphp
                  @endforeach
                  <tr>
                    <td></td>                  
                    {{-- <td></td>                   --}}
                    <td></td>                  
                    <td></td>
                    <td></td>  
                    <td></td>                   
                    <td id="soma"><strong>Sub Total:</strong></td>                  
                    <td>
                      <strong>{{ Session::get('currency_symbol').number_format($saldo_doc,2) }}</strong>
                    </td>                  
                  </tr> 
                @endforeach
                <tr>
                  @php
                    $total += $saldo_doc;
                  @endphp
                    <td></td>                  
                    {{-- <td></td>                   --}}
                    <td></td>  
                    <td></td>                
                    <td></td>  
                    <td></td>                   
                    <td id="soma"><strong>Total:</strong></td>                  
                    <td>
                      <strong>{{Session::get('currency_symbol').number_format($total,2)}}</strong>
                    </td>                  
                  </tr> 
              </table>
            
            
            </div>
            <!-- /.box-body -->
          </div>
        



        <!-- /.box-footer-->
    

    @include('layouts.includes.message_boxes')
    </section>
@endsection


@section('js')
    <script type="text/javascript">
      //var table = $('#example1').DataTable();
      var table="";

          $(function () {
             $("#example1").DataTable({
              "order": [],
              "columnDefs": [ {
                "targets": 5,
                "orderable": false
                } ],

                "language": '{{Session::get('dflt_lang')}}',
                "pageLength": '{{Session::get('row_per_page')}}'

            });
            
     //alert("Todos os dias "+table.column(5).data().sum());        
    });


    </script>
@endsection