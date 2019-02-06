@extends('layouts.app')
@section('content')
<!-- Main content -->
    <section class="content">
      <div class="box box-default">
        <div class="box-body">
          <div class="row">
                    <div class="col-md-10">
                        <div class="top-bar-title padding-bottom">{{ trans('message.sidebar.cd') }}</div>
                    </div> 
                    <div class="col-md-2">
                    @if(Helpers::has_permission(Auth::user()->id, 'add_invoice'))
                    <a href="{{ url('purchase/add_vd') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.new_purchases_cd') }}</a>
                    @endif
                    </div>
                </div>
        </div>
      </div>

      <div class="box">
        <div class="box-body">
                <ul class="nav nav-tabs cus" role="tablist">
                    
                    <li  class="active">
                      <a href='{{url("sales/vd")}}' >{{ trans('message.extra_text.all') }}</a>
                    </li>

               </ul>
        </div>
       
      </div><!--Filtering Box End-->


            <!-- Default box -->
      <div class="box">
         <div class="box-header">
             <a href="{{ url('purchase/reportVD') }}"> <button class="btn btn-default btn-flat"><span class="fa fa-print"> &nbsp;</span>{{ trans('message.sidebar.report') }}</button></a>
          </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>{{ trans('message.table.cd_no') }}</th>
                    <th>{{ trans('message.form.supplier') }}</th>
                    <th>Nuit</th>
                    <th>{{ trans('message.table.total_price') }}</th>
                    <th>{{ trans('message.table.cd_date') }}</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($purchVDData as $data)               
                  <tr>
                    <td>
                      <a href="{{URL::to('/')}}/purchase/view-detail-vd/{{$data->vd_no}}">
                        {{$data->reference_vd}}
                      </a>
                    </td>

                  <td>
                    @if(Helpers::has_permission(Auth::user()->id, 'edit_customer'))
                    {{$data->supp_name}}
                    @else
                   {{$data->supp_name}}
                    @endif
                  </td>
                  <td>{{$data->nuit}}</td>

                  <td>
                    {{Session::get('currency_symbol').
                    number_format($data->total,2,'.',',') }}
                  </td>

                    <td>{{$data->vd_date}}</td>

                  </tr>
                  @endforeach
                 
                 </tbody>
                </table>
              </div>
            </div>

            <!-- /.box-body -->
          </div>
      <!-- /.box -->
    </section>
@endsection