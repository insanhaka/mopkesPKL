@extends('backend.layouts.template')

@section('css')
    {!! Html::style('assets/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css') !!}
    {!! Html::style('assets/vendors/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') !!}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Seller</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">{!! Html::decode(GHelper::breadcrumb('dashboard')) !!}</div>
            <div class="breadcrumb-item">{!! GHelper::breadcrumb('menu') !!}</div>
            <div class="breadcrumb-item">list</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">List</h2>
        <p class="section-lead">
            Daftar <b>seller</b>.
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {!! Form::open(['url'=>\Request::path(),'class'=>'form-horizontal','id'=>'form-delete','method' => 'POST']) !!}
                    <div class="card-body">
                        <table class="table table-striped dt-responsive" id="simpledatatable">
                            <thead>
                                <tr>
                                    <th class="text-center no-sort" width="50px">
                                        <input type="checkbox" id="checkall" name="checkall" class="checkall"><span class="text"></span></label>
                                    </th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>Alamat Domisili</th>
                                    <th>Alamat KTP</th>
                                    <th>Alamat Lapak</th>
                                    <th>Produk</th>
                                    <th>Waktu Jualan</th>
                                    <th>Kelompok</th>
                                    <th width="80" class="no-sort">Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sellers as $data)
                                <tr>
                                    <td>{!! GHelper::cbDelete($data->id); !!}</td>
                                    <td>{!! $data->name !!}</td>
                                    <td>{!! $data->nik !!}</td>
                                    <td>DESA {!! $data->village_dom->name !!}, KECAMATAN {!! $data->district_dom->name !!}</td>
                                    <td>DESA {!! $data->village_ktp->name !!}, KECAMATAN {!! $data->district_ktp->name !!}</td>
                                    <td>DESA {!! $data->village_lapak->name !!}, KECAMATAN {!! $data->district_lapak->name !!}</td>
                                    <td>{!! $data->product->product_name !!}</td>
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
@endsection

@section('js')
    {!! Html::script('assets/vendors/datatables/media/js/jquery.dataTables.min.js') !!}
    {!! Html::script('assets/vendors/datatables/media/js/jquery.dataTables.responsive.min.js') !!}
    {!! Html::script('assets/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') !!}
    {!! Html::script('js/pages/datatables-init.js') !!}


    {{-- <script type="text/javascript">
        @if ($message = Session::get('success'))
            iziToast.success({
                        title: 'Success',
                        message: 'Data Berhasil Disimpan',
                        position: 'topRight'
                    });
            @endif
    </script> --}}


    <script type="text/javascript">
        $(document).ready(function(){
            var table = InitiateSimpleDataTable.init();
            $('#simpledatatable').on('click','.btn-hapus',function(e){
                e.preventDefault();
                var $this =$(this);
                bootbox.confirm({size: "small",message: "Are you sure?",callback: function(confirm){
                    if (confirm) {
                        $.ajax({
                            url: $this.attr('data-url') + '/delete',
                            type: 'POST',
                            data: {
                                'id' : $this.attr('data-id'),
                                '_token' : '{{csrf_token()}}'
                            },
                            success: function(response) {
                                if(response.data.status){
                                    $this.closest('tr').fadeOut(300,function(){
                                        $this.remove();
                                    });
                                    iziToast.success({
                                        title: 'Success',
                                        message: 'Data berhasil dihapus',
                                        position: 'topRight'
                                    });
                                }else{
                                    iziToast.error({
                                        title: 'Failed',
                                        message: 'Data gagal dihapus',
                                        position: 'topRight'
                                    });
                                }
                            }
                        });
                    }
                }
                });
            });
        });
    </script>
@endsection
