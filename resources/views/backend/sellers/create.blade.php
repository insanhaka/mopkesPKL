@extends('backend.layouts.template')

@section('css')
{!! Html::style('assets/vendors/select2/dist/css/select2.min.css') !!}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Seller</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">{!! Html::decode(GHelper::breadcrumb('dashboard')) !!}</div>
            <div class="breadcrumb-item">{!! GHelper::breadcrumb('menu') !!}</div>
            <div class="breadcrumb-item">form</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Form</h2>
        <p class="section-lead">
            Form untuk menambah <b>seller</b>
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    {!!Form::open(['route'=>'admin.seller.store','class'=>'form-horizontal validate','id'=>'simpan','novalidate'=>''])!!}
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-8 col-12">
                                {!! Form::label('nama', 'Nama') !!}
                                {!! Form::text('name', null ,['id'=>'name','class'=>'form-control','placeholder'=>'Nama','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('nik', 'NIK') !!}
                                {!! Form::text('nik', null ,['id'=>'nik','class'=>'form-control','placeholder'=>'nik','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('domisilikec', 'Domisili (Kecamatan)') !!}
                                {!! Form::select('name', $kecparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('domisilides', 'Domisili (Desa)') !!}
                                {!! Form::select('name', $desparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('domisiliaddr', 'Alamat Domisili Lengkap') !!}
                                {!! Form::text('domisili_addr', null ,['id'=>'domisili_addr','class'=>'form-control','placeholder'=>'Alamat domisili lengkap','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('ktpkec', 'Alamat sesuai KTP (Kecamatan)') !!}
                                {!! Form::select('name', $kecparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('ktpdes', 'Alamat sesuai KTP (Desa)') !!}
                                {!! Form::select('name', $desparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('ktpaddr', 'Alamat Sesuai KTP Lengkap') !!}
                                {!! Form::text('ktp_addr', null ,['id'=>'ktp_addr','class'=>'form-control','placeholder'=>'Alamat sesuai KTP lengkap','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('lapakkec', 'Lokasi Jualan (Kecamatan)') !!}
                                {!! Form::select('name', $kecparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('lapakdes', 'Lokasi Jualan (Desa)') !!}
                                {!! Form::select('name', $desparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('lapakaddr', 'Alamat Lokasi Jualan Lengkap') !!}
                                {!! Form::text('lapak_addr', null ,['id'=>'lapak_addr','class'=>'form-control','placeholder'=>'Alamat lokasi jualan lengkap','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('product', 'Jenis produk') !!}
                                {!! Form::select('product_name', $productparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('spesifikproduk', 'Spesifik Jenis Produk') !!}
                                {!! Form::text('spesifik_produk', null ,['id'=>'spesifik_produk','class'=>'form-control','placeholder'=>'Tulis sepesifik produk','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('waktu_jualan', 'Waktu Jualan') !!}
                                <div class="col-lg-4 pl-0">
                                    {!! Form::select('waktu_jualan', ['0'=>'Pagi','1'=>'Malam'], null, ['class'=>'form-control']) !!}
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
    <script>
        $(document).ready(function(){
            $(".selectku").select2();
            // SAVE
            $.validator.setDefaults({
                submitHandler: function () {
                    var $this = $('form#simpan');
                    $.ajax({
                        url : $this.attr('action'),
                        type : 'POST',
                        data : $this.serialize(),
                        dataType: 'json',
                        success:function(response){
                            if(response.data.status){
                                url = APP_URL_ADMIN +'/seller';
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
