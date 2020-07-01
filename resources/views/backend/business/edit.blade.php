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
            Form untuk edit <b>pengusaha</b>
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    {!! Form::model($business, ['route' => ['admin.business.update', $business->id],'class'=>'form-horizontal validate','id'=>'simpan','novalidate'=>'']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('nik_id', 'NIK (*)') !!}
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
                                <input class="form-control" type="text" id="name" name="name" readonly value="{!!$business->name!!}">
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('domisilikec', 'Domisili (Kecamatan)') !!}
                                {!! Form::select('domisili_kec', $kecparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('domisilides', 'Domisili (Desa)') !!}
                                {!! Form::select('domisili_desa', $desparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('domisiliaddr', 'Alamat Domisili Lengkap') !!}
                                {!! Form::text('domisili_addr', null ,['id'=>'domisili_addr','class'=>'form-control','placeholder'=>'Alamat domisili lengkap','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('ktpkec', 'Alamat sesuai KTP (Kecamatan)') !!}
                                {!! Form::select('ktp_kec', $kecparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('ktpdes', 'Alamat sesuai KTP (Desa)') !!}
                                {!! Form::select('ktp_desa', $desparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('ktpaddr', 'Alamat Sesuai KTP Lengkap') !!}
                                {!! Form::text('ktp_addr', null ,['id'=>'ktp_addr','class'=>'form-control','placeholder'=>'Alamat sesuai KTP lengkap','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('lapakkec', 'Lokasi Jualan (Kecamatan)') !!}
                                {!! Form::select('lapak_kec', $kecparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('lapakdes', 'Lokasi Jualan (Desa)') !!}
                                {!! Form::select('lapak_desa', $desparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('lapakaddr', 'Alamat Lokasi Jualan Lengkap') !!}
                                {!! Form::text('lapak_addr', null ,['id'=>'lapak_addr','class'=>'form-control','placeholder'=>'Alamat lokasi jualan lengkap','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('sector', 'Jenis produk') !!}
                                {!! Form::select('sector_id', $sectorparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('spesifikproduk', 'Spesifik Jenis Produk') !!}
                                {!! Form::text('product_specific', null ,['id'=>'spesifik_produk','class'=>'form-control','placeholder'=>'Tulis sepesifik produk','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('waktu_jualan', 'Waktu Jualan') !!}
                                <div class="col-lg-4 pl-0">
                                    {!! Form::select('waktu_jual', ['Pagi'=>'Pagi','Malam'=>'Malam'], null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <p style="margin-top: 10%; font-size: 12px; color: #e84118;">Tanda (*) wajib di input ulang</p>
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
        $(".selectku").select2();
        // SAVE
        $.validator.setDefaults({
            submitHandler: function () {
                var $this = $('form#simpan');
                $.ajax({
                    url : $this.attr('action'),
                    type : 'PUT',
                    data : $this.serialize(),
                    success:function(response){
                        console.log(response);
                        if(response.data.status){
                            url = APP_URL_ADMIN+'/business';
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
@endsection
