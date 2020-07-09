@extends('backend.layouts.template')

@section('css')
{!! Html::style('assets/vendors/select2/dist/css/select2.min.css') !!}
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

                            <div class="form-group col-lg-2 col-12">
                                {!! Form::label('ktpprov', 'Alamat KTP (Prov)') !!}
                                {{-- {!! Form::select('ktp_prov', $provparent, null,['id'=>'ktp_prov','class'=>'form-control selectku','style'=>'width: 100%;']) !!} --}}
                                <div>
                                    <select class="form-control selectku" id="ktp_prov" name="ktp_prov">
                                        @foreach ($provparent as $key => $i)
                                        <option value="{!! $key !!}">{!! $i !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-2 col-12">
                                {!! Form::label('ktpkab', 'Alamat KTP (Kab/Kota)') !!}
                                {!! Form::select('ktp_kab', [], null,['id'=>'ktp_kab','class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-2 col-12">
                                {!! Form::label('ktpkec', 'Alamat KTP (Kec)') !!}
                                {!! Form::select('ktp_kec', [], null,['id'=>'ktp_kec','class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-2 col-12">
                                {!! Form::label('ktpdes', 'Alamat KTP (Desa)') !!}
                                {!! Form::select('ktp_desa', [], null,['id'=>'ktp_desa','class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('ktpaddr', 'Alamat KTP Lengkap') !!}
                                {!! Form::text('ktp_addr', null ,['id'=>'ktp_addr','class'=>'form-control','placeholder'=>'Alamat sesuai KTP lengkap','required'=>'true']) !!}
                            </div>
                        </div>

                        <div class="row" style="padding-left: 2%;">
                            <div class="form-group col-lg-12 col-12">
                                <input class="form-check-input" type="checkbox" value="" id="sesuai" onclick="sesuaiktp()">
                                <label class="form-check-label" for="defaultCheck1">
                                  Alamat Domisili Sesuai KTP?
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-2 col-12">
                                {!! Form::label('domisiliprov', 'Domisili (Prov)') !!}
                                {{-- {!! Form::select('domisili_prov', $provparent, null,['id'=>'domisili_prov','class'=>'form-control selectku','style'=>'width: 100%;']) !!} --}}
                                <div>
                                    <select class="form-control selectdomprov" id="domisili_prov" name="domisili_prov">
                                        @foreach ($provparent as $key => $i)
                                        <option value="{!! $key !!}">{!! $i !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-2 col-12">
                                {!! Form::label('domisilikab', 'Domisili (Kab/Kota)') !!}
                                {!! Form::select('domisili_kab', [], null,['id'=>'domisili_kab','class'=>'form-control selectdomkab','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-2 col-12">
                                {!! Form::label('domisilikec', 'Domisili (Kec)') !!}
                                {!! Form::select('domisili_kec', [], null,['id'=>'domisili_kec','class'=>'form-control selectdomkec','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-2 col-12">
                                {!! Form::label('domisilides', 'Domisili (Desa)') !!}
                                {!! Form::select('domisili_desa',[], null,['id'=>'domisili_desa','class'=>'form-control selectdomdes', 'style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('domisiliaddr', 'Alamat Domisili Lengkap') !!}
                                {!! Form::text('domisili_addr', null ,['id'=>'domisili_addr','class'=>'form-control','placeholder'=>'Alamat domisili lengkap','required'=>'true']) !!}
                            </div>

                            {{-- <div class="form-group col-lg-2 col-12">
                                {!! Form::label('lapakprov', 'Lokasi Jual (Prov)') !!}
                                {!! Form::select('lapak_prov', $provparent, null,['id'=>'lapak_prov','class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-2 col-12">
                                {!! Form::label('lapakkab', 'Lokasi Jual (Kab/Kota)') !!}
                                {!! Form::select('lapak_kab', [], null,['id'=>'lapak_kab','class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div> --}}
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('lapakkec', 'Lokasi Jual (Kec)') !!}
                                {!! Form::select('lapak_kec', $kecparent, null,['id'=>'lapak_kec','class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('lapakdes', 'Lokasi Jual (Desa)') !!}
                                {!! Form::select('lapak_desa',[], null,['id'=>'lapak_desa','class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('lapakaddr', 'Alamat Lokasi Jual Lengkap') !!}
                                {!! Form::text('lapak_addr', null ,['id'=>'lapak_addr','class'=>'form-control','placeholder'=>'Alamat lokasi jualan lengkap','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('sector', 'Sektor Usaha') !!}
                                {!! Form::select('sector_id', $sectorparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('spesifikproduk', 'Nama Usaha') !!}
                                {!! Form::text('Business_specific', null ,['id'=>'Business_specific','class'=>'form-control','placeholder'=>'Tulis nama usaha','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('waktu_jualan', 'Waktu Jualan') !!}
                                <div class="col-lg-4 pl-0">
                                    {!! Form::select('waktu_jual', ['Pagi'=>'Pagi','Malam'=>'Malam'], null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        <div class="row">
                            <div class="col-md-12 text-md-right text-center">
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
@endsection

@section('js')
{!! Html::script('assets/vendors/select2/dist/js/select2.min.js') !!}
{!! Html::script('assets/vendors/jquery-validation-1.19.1/dist/jquery.validate.min.js') !!}
{!! Html::script('js/pages/validate-init.js') !!}

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>


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
        $(document).ready(function(){
            $.comboAjax('#domisili_prov','#domisili_kab',APP_URL_ADMIN+'/getRegenciesFromProvince');
            $.comboAjax('#domisili_kab','#domisili_kec',APP_URL_ADMIN+'/getDistrictsFromRegency');
			$.comboAjax('#domisili_kec','#domisili_desa',APP_URL_ADMIN+'/getVillagesFromDistrict');

            $.comboAjax('#ktp_prov','#ktp_kab',APP_URL_ADMIN+'/getRegenciesFromProvince');
            $.comboAjax('#ktp_kab','#ktp_kec',APP_URL_ADMIN+'/getDistrictsFromRegency');
			$.comboAjax('#ktp_kec','#ktp_desa',APP_URL_ADMIN+'/getVillagesFromDistrict');

            $.comboAjax('#lapak_prov','#lapak_kab',APP_URL_ADMIN+'/getRegenciesFromProvince');
            $.comboAjax('#lapak_kab','#lapak_kec',APP_URL_ADMIN+'/getDistrictsFromRegency');
			$.comboAjax('#lapak_kec','#lapak_desa',APP_URL_ADMIN+'/getVillagesFromDistrict');
            $(".selectku").select2();
            $(".selectdomprov").select2();
            $(".selectdomkab").select2();
            $(".selectdomkec").select2();
            $(".selectdomdes").select2();
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
            sesuaiktp()
        });

    </script>

    <script>
        function sesuaiktp(){
            var sama = document.getElementById("sesuai");
            if (sama.checked == true){
                // Make a request for a user with a given ID
                axios.get('/api/alamat')
                .then(function (response) {
                    var prov = response.data['prov'];
                    var kab = response.data['kab'];
                    var kec = response.data['kec'];
                    var des = response.data['des'];

                    var ktp_prov = document.getElementById("ktp_prov").value;
                    $(".selectdomprov").val(ktp_prov);
                    $(".selectdomprov").trigger('change');

                    var ktp_kab = document.getElementById("ktp_kab").value;
                    for (var n in kab) {
                        if (kab[n].id == ktp_kab){
                            $("#domisili_kab").html('<option value="' + kab[n].id + '">' + kab[n].name + '</option>');
                            // console.log(kab[n]);
                        }
                    }

                    var ktp_kec = document.getElementById("ktp_kec").value;
                    for (var n in kec) {
                        if (kec[n].id == ktp_kec){
                            $("#domisili_kec").html('<option value="' + kec[n].id + '">' + kec[n].name + '</option>');
                            // console.log(kec[n]);
                        }
                    }

                    var ktp_des = document.getElementById("ktp_desa").value;
                    for (var n in des) {
                        if (des[n].id == ktp_des){
                            $("#domisili_desa").html('<option value="' + des[n].id + '">' + des[n].name + '</option>');
                            // console.log(kab[n]);
                        }
                    }

                    var ktp_addr = document.getElementById("ktp_addr").value;
                    document.getElementById("domisili_addr").value = ktp_addr;


                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            } else {
                $(".selectdomprov").val(0).trigger('change');
                $(".selectdomkab").val(0).trigger('change');
                $(".selectdomkec").val(0).trigger('change');
                $(".selectdomdes").val(0).trigger('change');
                document.getElementById("domisili_addr").value = "";
            }
        }
    </script>


@endsection
