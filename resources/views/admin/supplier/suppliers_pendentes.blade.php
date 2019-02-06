@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <h3>{{ trans('message.invoice_pdf.supp_invoice') }}</h3>

        <div class="box">
            <div class="box-body">

                <div class="btn-group pull-right">
                <!--btn chamar pfd-->
                
                    <a target="_blank" href="{{ url('suppliers/pendentes_reporte') }}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
                
                </div><br><br>

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{{ trans('message.accounting.data') }}</th>
                            <th>{{ trans('message.accounting.docs') }}</th>
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
                                // x$total += $saldo_doc;
                                $saldo_doc = 0;
                                $i = 0;
                            @endphp

                            @foreach($Pendentes as $dado)

                                @if ($dado->supp_name == $conta->supp_name)

                                    @if ($saldo_doc == 0)
                                        <tr>
                                            <th style="background-color: #5d98de;">{{ $dado->supp_name }}</th>
                                            <th style="background-color: #5d98de;"></th>
                                            <th style="background-color: #5d98de;"></th>
                                            <th style="background-color: #5d98de;"></th>
                                            <th style="background-color: #5d98de;"></th>
                                        </tr>
                                    @endif
                                    @php
                                        $linha=explode('-',$dado->reference_doc);
                                        
                                        $pago = 0;

                                        if ($dado->saldo_doc != null) {
                                            $pago = $dado->amount_doc - $dado->saldo_doc;
                                        } 

                                        $sub_total= $sub_total+$dado->saldo_doc;

                                        $saldo_doc += $dado->amount_doc;
                                        
                                    @endphp
                                    <tr>
                                        <td>{{ $dado->ord_date_doc }}</td>
                                        <td>{{ $dado->reference_doc }}</td>
                                        <td>{{ Session::get('currency_symbol').number_format($dado->amount_doc,2) }}</td>
                                        <td>{{ $pago }}</td>
                                        <td>{{ Session::get('currency_symbol').number_format($saldo_doc,2) }}</td>
                                    </tr>
                                @endif

                            @endforeach

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong>Sub Total:</strong></td>
                                <td><strong>{{ Session::get('currency_symbol').number_format($saldo_doc,2) }}</strong></td>
                            </tr>

                        @endforeach
                        @php
                            $total += $saldo_doc;
                        @endphp
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Total:</strong></td>
                            <td><strong>{{ Session::get('currency_symbol').number_format($total,2) }}</strong></td>
                        </tr>
                        
                    </tbody>
                </table>

            </div>
        </div>
        <!-- /Default box -->
    </section>
    <!-- /Main content -->
@endsection

@section('js')
    <script type="text/javascript">

        var table="";

        $(function () {
            $("#example1").DataTable({
            "order": [],
            "columnDefs": [ {
            "targets": 3,
            "orderable": false
            } ],

            "language": '{{Session::get('dflt_lang')}}',
            "pageLength": '{{Session::get('row_per_page')}}'
        });
    </script>
@endsection