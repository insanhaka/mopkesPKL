@extends('backend.layouts.template')

@section('css')
    {!! Html::style('assets/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css') !!}
    {!! Html::style('assets/vendors/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') !!}
    {!! Html::style('assets/css/lc_switch.css') !!}
    {{-- <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet"> --}}
    <style>
        .select-generatehide {
            visibility: hidden;
        }

        .select-generateshow {
            visibility: visible;
        }
    </style>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Pengusaha</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">{!! Html::decode(GHelper::breadcrumb('dashboard')) !!}</div>
            <div class="breadcrumb-item">{!! GHelper::breadcrumb('menu') !!}</div>
            <div class="breadcrumb-item">list</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">List</h2>
        <p class="section-lead">
            Daftar <b>pengusaha</b>.
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {{-- {!! Form::open(['url'=>\Request::path(),'class'=>'form-horizontal','id'=>'form-delete','method' => 'POST']) !!} --}}
                    <form action="/admin/business/generateall" method="POST">
                        @csrf
                    <div class="card-body">
                        <table class="table table-striped dt-responsive" id="simpledatatable">
                            <thead>
                                <tr>
                                    {{-- <th class="text-center no-sort" width="50px">
                                        <input type="checkbox" id="checkall" name="checkall" class="checkall"><span class="text"></span></label>
                                    </th> --}}
                                    <th></th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>Jumlah Usaha</th>
                                    <th>Data Usaha</th>
                                    <th>Aktiv ?</th>
                                    <th>QR Code</th>
                                    <th width="80" class="no-sort">Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($business as $data)
                                <tr>
                                    {{-- <td>{!! GHelper::cbDelete($data->id); !!}</td> --}}
                                    <td class="text-center no-sort" width="50px">
                                        <input class="cekbox" name="generate[]" type="checkbox" value="{!! $data->id !!}" id="cek{!! $data->id !!}">
                                    </td>
                                    {{-- <td>{{$loop->iteration}}</td> --}}
                                    <td>{!! $data->name !!}</td>
                                    <td>{!! $data->nik_id !!}</td>
                                    <td>
                                        @if ($data->is_active == 1)
                                        <input type="checkbox" id="{!!$data->id!!}" value="" class="lcs_check{!!$data->id!!}" checked="1" autocomplete="off" />
                                        @else
                                        <input type="checkbox" id="{!!$data->id!!}" value="" class="lcs_check{!!$data->id!!}" autocomplete="off" />
                                        @endif
                                    </td>
                                    <td>
                                        <div class="visible-print text-center">
                                            <a class="btn btn-primary" href="/admin/business/{!!$data->id!!}/generate" role="button">Generate QR Code</a>
                                        </div>
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
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-md-left text-center">
                                {!! GHelper::btnCreate() !!}
                                <button class="select-generatehide btn btn-primary" id="qrku" type="submit">Generate All QR Code (Max 6)</button>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    {!! Html::script('assets/js/lc_switch.js') !!}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>


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
        });
    </script>
    @foreach ($business as $v)
    <script>
        $(document).ready(function(){

            $('.lcs_check{!!$v->id!!}').lc_switch();

            // triggered each time a field changes status
            $('body').delegate('.lcs_check{!!$v->id!!}', 'lcs-statuschange', function(event) {
                var status = ($(this).is(':checked')) ? '1' : '0';
                var id = event.target.id;
                var is_active = status;

                axios.post('/api/businessactive', {
                    is_active: is_active,
                    id: id
                })
                  .then(function (response) {
                    iziToast.success({
                        title: 'Success',
                        message: 'Berhasil',
                        position: 'topRight'
                    });
                })
                  .catch(function (error) {
                    iziToast.warning({
                        title: 'Warning',
                        message: 'Gagal Diproses',
                        position: 'topRight'
                    });
                });
            });
        });

    </script>
    @endforeach

    @foreach ($business as $i)
    <script>

        $('#cek{!!$i->id!!}').click(function(event) {

            var favorite = [];
            $.each($("input[name='generate[]']:checked"), function(){
                favorite.push($(this).val());
            });
            // alert("My favourite sports are: " + favorite.join(", "));
            var terpilih = favorite.length;

            if(terpilih > 0){
                $('#qrku').removeClass("select-generatehide");
                $('#qrku').addClass("select-generateshow");
            }else {
                $('#qrku').removeClass("select-generateshow");
                $('#qrku').addClass("select-generatehide");
            }

        });

    </script>
    @endforeach

@endsection
