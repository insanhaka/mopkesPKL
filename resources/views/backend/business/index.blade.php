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
                    <form action="/admin/business/deleteall" method="POST">
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
                                    <th>Alamat KTP</th>
                                    <th>Alamat Domisili</th>
                                    <th>Jumlah Usaha</th>
                                    <th>Data Usaha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agreement as $person)
                                @foreach ($totbusiness as $tot)
                                @if ($person->id == $tot->nik_id)
                                    <tr>
                                        <td class="text-center no-sort" width="50px">
                                            <input class="cekbox" name="del[]" type="checkbox" value="{!! $person->id !!}" id="cek{!! $person->id !!}">
                                        </td>
                                        <td>{!! $person->name !!}</td>
                                        <td>{!! $person->nik !!}</td>
                                        <td>DESA {!! $person->village_ktp->name !!}, KEC. {!! $person->district_ktp->name !!}</td>
                                        <td>DESA {!! $person->village_dom->name !!}, KEC. {!! $person->district_dom->name !!}</td>
                                        <td>{!! $tot->total !!}
                                        <td>
                                            <div class="visible-print text-center">
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#bisnis{!!$person->id!!}">
                                                    view
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-md-left text-center">
                                {!! GHelper::btnCreate() !!}
                                <button class="select-generatehide btn btn-danger" id="dell-all" type="submit">Delete All</button>
                                {{-- {!! GHelper::btnDeleteAll() !!} --}}
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
@foreach ($agreement as $ag)
<div class="modal fade" id="bisnis{!!$ag->id!!}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Usaha {!!$ag->name!!}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/business/generateall" method="POST">
            @csrf
            <div class="modal-body" style="margin-left: 2%; margin-right:2%;">
                @foreach ($business as $data)
                    @if ($data->nik_id == $ag->id)
                    <div class="card mb-3" style="max-width: 100%; border: 1px solid #eee; padding: 2%;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="{{asset('foto_usaha/'.$data->photo)}}" class="card-img" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row" style="padding-left: 1%;">
                                            <div class="col-8">
                                                <h5 class="card-title">{!! $data->business_name !!}</h5>
                                            </div>
                                            <div class="col-4">
                                                <div class="row" style="margin-right: -30%;">
                                                    <div class="col-10" style="text-align: right; margin-right: -20px;">
                                                        <p style="font-size: 12px; font-weight: bold;">Check to generate QRCode</p>
                                                    </div>
                                                    <div class="col-2" style="padding-top: 5px;">
                                                        <input class="cekbox" name="generate[]" type="checkbox" value="{!! $data->id !!}" id="qrselect{!! $data->id !!}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-sm" style="width: 50%;">
                                            <tbody>
                                            <tr>
                                                <th scope="row"><img src="{{asset('assets/img/user.png')}}" style="width: 20px;"></th>
                                                <td>{!! $data->name !!}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><img src="{{asset('assets/img/pin.png')}}" style="width: 20px;"></th>
                                                <td>{!! $data->lapak_addr !!}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><img src="{{asset('assets/img/open.png')}}" style="width: 20px;"></th>
                                                <td>{!! $data->mulai_jual !!} - {!! $data->selesai_jual !!}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row"><img src="{{asset('assets/img/phone.png')}}" style="width: 20px;"></th>
                                                <td>{!! $data->contact !!}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer" style="margin-top: -50px;">
                                    <div class="row justify-content-between">
                                        <div class="col-12 text-md-right text-center">
                                            <a class="btn btn-warning" href="/admin/business/{!!$data->id!!}/edit" role="button">Edit</a>
                                            <a class="btn btn-danger" href="/admin/business/{!!$data->id!!}/delete" role="button">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    @endif
                @endforeach
            </div>
            <div class="modal-footer">
                <button class="select-generatehide btn btn-primary" id="qrgenerate{!!$ag->id!!}" type="submit">Generate QR Code</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
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

    @foreach ($agreement as $i)
    <script>

        $('#cek{!!$i->id!!}').click(function(event) {

            var favorite = [];
            $.each($("input[name='del[]']:checked"), function(){
                favorite.push($(this).val());
            });
            // alert("My favourite sports are: " + favorite.join(", "));
            var terpilih = favorite.length;
            console.log(terpilih);

            if(terpilih > 0){
                $('#dell-all').removeClass("select-generatehide");
                $('#dell-all').addClass("select-generateshow");
            }else {
                $('#dell-all').removeClass("select-generateshow");
                $('#dell-all').addClass("select-generatehide");
            }

        });

    </script>
    @endforeach

    @foreach ($business as $qr)
    <script>

        $('#qrselect{!!$qr->id!!}').click(function(event) {

            var favorite = [];
            $.each($("input[name='generate[]']:checked"), function(){
                favorite.push($(this).val());
            });
            // alert("My favourite sports are: " + favorite.join(", "));
            var terpilih = favorite.length;
            console.log(terpilih);

            if(terpilih > 0){
                $('#qrgenerate{!!$qr->nik_id!!}').removeClass("select-generatehide");
                $('#qrgenerate{!!$qr->nik_id!!}').addClass("select-generateshow");
            }else {
                $('#qrgenerate{!!$qr->nik_id!!}').removeClass("select-generateshow");
                $('#qrgenerate{!!$qr->nik_id!!}').addClass("select-generatehide");
            }

        });

    </script>
    @endforeach

@endsection
