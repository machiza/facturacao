@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">
          @include('layouts.includes.company_menu')
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-default">
            <div class="box-body">
              <div class="row">
                <div class="col-md-9">
                 <div class="top-bar-title padding-bottom">Contas Bancárias</div>
                </div> 
                <div class="col-md-3">
               @if(Helpers::has_permission(Auth::user()->id, 'add_role'))
                    <a  style="color:white; padding-left:0px; padding-right:0px; background-color:#006DEF" class=" btn btn-block  btn-border-orange"  href="{{ url('/bank_account/add') }}"><i class="fa fa-plus btn-border-orang"></i>&nbsp;Nova Conta</a>
               @endif
                </div>
              </div>
            </div>
          </div>

          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nome do Banco</th>
                  <th>Numero de Conta</th>
                  <th>NIB</th>
                  <th>Swift</th>
                  <th>Acções</th>
                </tr>
                </thead>
                <tbody>
                @foreach($contas as $data)
                <tr>
               
                  <td><a href="{{ ($data->id != 1) ? url("bank_account/".$data->id) :'#'}}">{{ $data->nome }}</a></td>
                  <td>{{ $data->nr_conta }}</td>
                  <td>{{ $data->nib }}</td>
                  <td>{{ $data->swift}}</td>
                
                     <td align="center">
                                                    <a class="btn btn-info" href="{{url('/bank_account/'.$data->id)}}"><i class="fa fa-edit"></i>&nbsp;</a>
                                                    <form method="POST" action="{{url('bank_account/delete/'.$data->id)}}" accept-charset="UTF-8" style="display:inline">
                                                        {!! csrf_field() !!}
                                                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_invoice') }}" data-message="{{ trans('message.invoice.delete_invoice_confirm') }}">
                                                            {{-- <i class="fa fa-remove" aria-hidden="true"></i> --}}
                                                             <i class="glyphicon glyphicon-trash" aria-hidden="true"></i> 
                                                        </button>
                                                    </form>
                                                </td>
                </tr>
               @endforeach
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    @include('layouts.includes.message_boxes')
@endsection

@section('js')
    <script type="text/javascript">
      $(function () {
        $("#example1").DataTable({
          "columnDefs": [ {
            "targets": 3,
            "orderable": false
            } ],

            "language": '{{Session::get('dflt_lang')}}'
        });
        
      });
    </script>
@endsection