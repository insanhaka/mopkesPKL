@extends('backend.layouts.template')

@section('css')
{!! Html::style('assets/vendors/select2/dist/css/select2.min.css') !!}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Pengusaha</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">{!! Html::decode(GHelper::breadcrumb('dashboard')) !!}</div>
            <div class="breadcrumb-item">{!! GHelper::breadcrumb('menu') !!}</div>
            <div class="breadcrumb-item">form</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Form</h2>
        <p class="section-lead">
            Form untuk menambah <b>pengusaha</b>
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">

                    {!!Form::open(['route'=>'admin.business.store','class'=>'form-horizontal validate','id'=>'simpan','novalidate'=>''])!!}
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-lg-6 col-12">
                                {!! Form::label('nik_id', 'NIK') !!}
                                <div>
                                    {{-- {!! Form::select('menu_kelompok', ['0'=>'Tidak','1'=>'ya'], null, ['id'=>'menu_kelompok', 'class'=>'form-control', 'onchange'=>'menu_kelompok()'])  !!} --}}
                                    <select class="form-control selectku" id="selected_nik" name="nik_id" onchange="nik()">
                                        @foreach ($nikparent as $item)
                                        <option value="{!! $item !!}">{!! $item !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 col-12">
                                {!! Form::label('name', 'Nama') !!}
                                {{-- {!! Form::text('name', null ,['id'=>'name','class'=>'form-control','placeholder'=>'Nama','required'=>'true']) !!} --}}
                                <input class="form-control" type="text" id="name" name="name" readonly>
                            </div>

                        </div>

                            <br>
                            <h6>Data Usaha 1</h6>
                            <hr style="border: solid 1px #4b7bec; margin-bottom: 3%;">

                            <div class="row">

                                <div class="form-group col-lg-4 col-12">
                                    {!! Form::label('sector', 'Sektor Usaha') !!}
                                    {!! Form::select('sector_id', $sectorparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                                </div>
                                <div class="form-group col-lg-4 col-12">
                                    {!! Form::label('spesifikproduk', 'Nama Usaha') !!}
                                    {!! Form::text('Business_specific', null ,['id'=>'Business_specific','class'=>'form-control','placeholder'=>'Tulis nama usaha','required'=>'true']) !!}
                                </div>
                                <div class="form-group col-lg-2 col-12">
                                    {!! Form::label('mulai_jual', 'Mulai Jualan') !!}
                                    <div class="col-lg-12 pl-0">
                                        {!! Form::select('mulai_jual', ['Pagi'=>'Pagi', 'Siang'=>'Siang', 'Sore'=>'Sore', 'Malam'=>'Malam'], null, ['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group col-lg-2 col-12">
                                    {!! Form::label('selesai_jual', 'Selesai Jualan') !!}
                                    <div class="col-lg-12 pl-0">
                                        {!! Form::select('selesai_jual', ['Pagi'=>'Pagi', 'Siang'=>'Siang', 'Sore'=>'Sore', 'Malam'=>'Malam'], null, ['class'=>'form-control']) !!}
                                    </div>
                                </div>

                                <div class="form-group col-lg-4 col-12">
                                    {!! Form::label('lapakkec', 'Lokasi Jual (Kec)') !!}
                                    {{-- {!! Form::select('lapak_kec', $kecparent, null,['id'=>'lapak_kec','class'=>'form-control selectku','style'=>'width: 100%;']) !!} --}}
                                    <div>
                                        <select class="form-control selectku" id="lapak_kec" name="lapak_kec" onchange="lapakkec()">
                                            @foreach ($kecparent as $key=>$i)
                                            <option value="{!! $key !!}">{!! $i !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4 col-12">
                                    {!! Form::label('lapakdes', 'Lokasi Jual (Desa)') !!}
                                    {!! Form::select('lapak_desa', [], null,['id'=>'lapak_desa','class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                                </div>
                                <div class="form-group col-lg-4 col-12">
                                    {!! Form::label('lapakaddr', 'Alamat Lokasi Jual Lengkap') !!}
                                    {!! Form::text('lapak_addr', null ,['id'=>'lapak_addr','class'=>'form-control','placeholder'=>'Alamat lokasi jualan lengkap','required'=>'true']) !!}
                                </div>

                                <div class="form-group col-lg-4 col-12">
                                    {!! Form::label('contact', 'Nomor HP') !!}
                                    <input class="form-control" type="tel" placeholder="ex : 087712345432" id="contact" name="contact">
                                </div>
                                <div class="form-group col-lg-8 col-12" style="margin: 7px;">
                                    {!! Form::label('photo', 'Foto Usaha (jpeg/png/jpg | max:2MB)') !!}
                                    <br>
                                    <input type="file" id="photo" name="photo" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                    <img id="blah" alt="your image" width="100" height="100" />
                                </div>

                            </div>

                    </div>
                    <div class="card-footer border-top">
                        <div class="row justify-content-between">
                            <div class="col-4 text-md-left text-center">
                                <button type="button" class="btn btn-primary" id="tambahusaha">Tambah Data Usaha</button>
                            </div>
                            <div class="col-4 text-md-right text-center">
                                {!! GHelper::btnSave() !!}
                                {!! GHelper::btnCancel() !!}
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
@endsection

@section('js')
{!! Html::script('assets/vendors/select2/dist/js/select2.min.js') !!}
{!! Html::script('assets/vendors/jquery-validation-1.19.1/dist/jquery.validate.min.js') !!}
{!! Html::script('js/pages/validate-init.js') !!}

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>


    <script>
        $(document).ready(function(){

            $.comboAjax('#lapak_prov','#lapak_kab',APP_URL_ADMIN+'/getRegenciesFromProvince');
            $.comboAjax('#lapak_kab','#lapak_kec',APP_URL_ADMIN+'/getDistrictsFromRegency');
            $.comboAjax('#lapak_kec','#lapak_desa',APP_URL_ADMIN+'/getVillagesFromDistrict');
            $(".selectku").select2();
            //SAVE
            $.validator.setDefaults({
                submitHandler: function () {
                    var $this = $('form#simpan');
                    $.ajax({
                        url : $this.attr('action'),
                        type : 'POST',
                        data : $this.serialize(),
                        dataType: 'json',
                        success:function(response){
                            console.log(response.data.status);
                            if(response.data.status){
                                url = APP_URL_ADMIN +'/business';
                                history.pushState(null, null, url);
                                load(url);
                                iziToast.success({
                                    title: 'Success',
                                    message: response.data.message,
                                    position: 'topRight'
                                });
                            }else{
                                iziToast.error({
                                    title: 'Failed',
                                    message: response.data.message,
                                    position: 'topRight'
                                });
                            }
                        }
                    });
                }
            });
            InitiateSimpleValidate.init();
        });

    </script>


    <script>
        function nik() {
            var x = document.getElementById("selected_nik").value;

            // Make a request for a user with a given ID
            axios.get('/api/data-agreement')
            .then(function (response) {
                var val = response.data.value;

                for (var n in val) {
                    if (val[n].nik == x){
                        document.getElementById("name").value=val[n].name;
                    }
                }
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });

        }
    </script>

    <script>
        function lapakkec() {
            var i = document.getElementById("lapak_kec").value;

            console.log(i);

        }
    </script>


@endsection
