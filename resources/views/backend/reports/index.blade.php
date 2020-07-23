@extends('backend.layouts.template')

@section('css')
    {!! Html::style('assets/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css') !!}
    {!! Html::style('assets/vendors/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') !!}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Report</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">{!! Html::decode(GHelper::breadcrumb('dashboard')) !!}</div>
            <div class="breadcrumb-item">{!! GHelper::breadcrumb('menu') !!}</div>
            <div class="breadcrumb-item">list</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">List</h2>
        <p class="section-lead">
            Daftar <b>report</b>.
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {!! Form::open(['url'=>\Request::path(),'class'=>'form-horizontal','id'=>'form-delete','method' => 'POST']) !!}
                    <div class="card-body">
                        <table class="table table-striped dt-responsive" id="simpledatatable">
                            <thead>
                                <tr>
                                    {{-- <th class="text-center no-sort" width="50px">
                                        <input type="checkbox" id="checkall" name="checkall" class="checkall"><span class="text"></span></label>
                                    </th> --}}
                                    <th>No</th>
                                    <th>Name Pelaku Usaha</th>
                                    <th>NIK</th>
                                    <th>Nama Usaha</th>
                                    <th>Lokasi Usaha</th>
                                    <th>Tentang Laporan</th>
                                    <th>Waktu Laporan</th>
                                    <th>Preview</th>
                                    <th width="80" class="no-sort">Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $data)
                                <tr>
                                    {{-- <td>{!! GHelper::cbDelete($data->id); !!}</td> --}}
                                    <td>{{$loop->iteration}}</td>
                                    <td>{!! $data->business->name !!}</td>
                                    <td>{!! $data->business->nik_id !!}</td>
                                    <td>{!! $data->business->business_name !!}</td>
                                    <td>{!! $data->business->lapak_addr !!}</td>
                                    <td>{!! $data->about !!}</td>
                                    <td>{!! $data->created_at !!}</td>
                                    <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong{!! $data->id !!}">
                                            Baca Laporan
                                        </button>
                                    </td>
                                    <td align="center">
                                        <div class="dropdown d-inline">
                                            <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu">
                                                {!! GHelper::btnEdit($data->id) !!}
                                                {!! GHelper::btnDelete($data->id) !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-md-left text-center">
                                {!! GHelper::btnCreate() !!}
                                {!! GHelper::btnDeleteAll() !!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
@foreach ($reports as $d)
<div class="modal fade" id="exampleModalLong{!! $d->id !!}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <img src="{{asset('assets/img/laporan-01.jpg')}}" style="width: 100%; height: auto;">
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <p>Nama :</p>
                        <div class="row" style="margin-top: -3%;">
                            <div class="col-1"><img src="{{asset('assets/img/user.png')}}" style="width: 20px;"></div>
                            <div class="col-10">{!! $d->business->name !!}</div>
                        </div>
                        <hr>
                        <p>Nama Usaha :</p>
                        <div class="row" style="margin-top: -3%;">
                            <div class="col-1"><img src="{{asset('assets/img/shop.png')}}" style="width: 25px;"></div>
                            <div class="col-10">{!! $d->business->business_name !!}</div>
                        </div>
                        <hr>
                        <p>Lokasi jualan :</p>
                        <div class="row" style="margin-top: -3%;">
                            <div class="col-1"><img src="{{asset('assets/img/pin.png')}}" style="width: 20px;"></div>
                            <div class="col-10">{!! $d->business->lapak_addr !!}</div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <h5 class="modal-title" id="exampleModalLongTitle">{!! $d->about !!}</h5>
                        <hr>
                        {!! $d->description !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endforeach
@endsection

@section('js')
    {!! Html::script('assets/vendors/datatables/media/js/jquery.dataTables.min.js') !!}
    {!! Html::script('assets/vendors/datatables/media/js/jquery.dataTables.responsive.min.js') !!}
    {!! Html::script('assets/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') !!}
    {!! Html::script('js/pages/datatables-init.js') !!}


    <script type="text/javascript">
        @if ($message = Session::get('success'))
            iziToast.success({
                        title: 'Success',
                        message: 'Data Berhasil Disimpan',
                        position: 'topRight'
                    });
        @elseif ($message = Session::get('warning'))
            iziToast.warning({
                        title: 'Success',
                        message: 'Data Berhasil Dihapus',
                        position: 'topRight'
                    });
        @endif
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            var table = InitiateSimpleDataTable.init();
            // $('#simpledatatable').on('click','.btn-hapus',function(e){
            //     e.preventDefault();
            //     var $this =$(this);
            //     bootbox.confirm({size: "small",message: "Are you sure?",callback: function(confirm){
            //         if (confirm) {
            //             $.ajax({
            //                 url: $this.attr('data-url') + '/delete',
            //                 type: 'POST',
            //                 data: {
            //                     'id' : $this.attr('data-id'),
            //                     '_token' : '{{csrf_token()}}'
            //                 },
            //                 success: function(response) {
            //                     if(response.data.status){
            //                         $this.closest('tr').fadeOut(300,function(){
            //                             $this.remove();
            //                         });
            //                         iziToast.success({
            //                             title: 'Success',
            //                             message: 'Data berhasil dihapus',
            //                             position: 'topRight'
            //                         });
            //                     }else{
            //                         iziToast.error({
            //                             title: 'Failed',
            //                             message: 'Data gagal dihapus',
            //                             position: 'topRight'
            //                         });
            //                     }
            //                 }
            //             });
            //         }
            //     }
            //     });
            // });
        });
    </script>
@endsection
