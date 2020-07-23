@extends('backend.layouts.template')

@section('css')
{!! Html::style('assets/vendors/select2/dist/css/select2.min.css') !!}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Kelompok</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">{!! Html::decode(GHelper::breadcrumb('dashboard')) !!}</div>
            <div class="breadcrumb-item">{!! GHelper::breadcrumb('menu') !!}</div>
            <div class="breadcrumb-item">form</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Form</h2>
        <p class="section-lead">
            Form untuk edit <b>kelompok</b>
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    {!! Form::model($communities, ['route' => ['admin.communities.update', $communities->id],'class'=>'form-horizontal validate','id'=>'simpan','novalidate'=>'']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('communities_name', 'Nama Kelompok') !!}
                                {!! Form::text('name', null ,['id'=>'name','class'=>'form-control','placeholder'=>'Tulis Nama Kelompok','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('chairman_name', 'Nama Ketua') !!}
                                {!! Form::text('chairman_name', null ,['id'=>'chairman_name','class'=>'form-control','placeholder'=>'Nama Ketua']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('chairman_nik', 'NIK Ketua') !!}
                                {!! Form::text('chairman_nik', null ,['id'=>'chairman_nik','class'=>'form-control','placeholder'=>'NIK Ketua']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('officekec', 'Alamat (Kec)') !!}
                                {!! Form::select('office_kec', $kecparent, null,['id'=>'office_kec','class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('officedes', 'Alamat (Desa)') !!}
                                {!! Form::select('office_desa', [], null,['id'=>'office_desa','class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('officeaddr', 'Alamat Lengkap') !!}
                                {!! Form::text('office_addr', null ,['id'=>'office_addr','class'=>'form-control','placeholder'=>'Alamat lokasi jualan lengkap','required'=>'true']) !!}
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
        $.comboAjax('#office_kec','#office_desa',APP_URL_ADMIN+'/getVillagesFromDistrict');
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
                            url = APP_URL_ADMIN+'/communities';
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
