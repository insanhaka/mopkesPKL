@extends('backend.layouts.template')

@section('css')
<style>
    .select-kelompokhide {
        visibility: hidden;
    }

    .select-kelompokshow {
        visibility: visible;
    }
</style>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Agreement</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">{!! Html::decode(GHelper::breadcrumb('dashboard')) !!}</div>
            <div class="breadcrumb-item">{!! GHelper::breadcrumb('menu') !!}</div>
            <div class="breadcrumb-item">form</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Form</h2>
        <p class="section-lead">
            Form untuk edit <b>agreement</b>
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    {!! Form::model($agreement, ['route' => ['admin.agreement.update', $agreement->id],'class'=>'form-horizontal validate', 'method'=>'PUT', 'enctype'=>'multipart/form-data', 'id'=>'simpan','novalidate'=>'']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-6 col-12">
                                {!! Form::label('Nama pihak yang menyetujui', 'Nama pihak yang menyetujui') !!}
                                {!! Form::text('name', null ,['id'=>'name','class'=>'form-control','placeholder'=>'Nama','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-6 col-12">
                                {!! Form::label('nik', 'NIK') !!}
                                {!! Form::text('nik', null ,['id'=>'nik','class'=>'form-control','placeholder'=>'NIK','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-2 col-12">
                                {!! Form::label('menu_communities', 'Kelompok / Individu (*)') !!}
                                <div>
                                    {{-- {!! Form::select('menu_kelompok', ['0'=>'Tidak','1'=>'ya'], null, ['id'=>'menu_kelompok', 'class'=>'form-control', 'onchange'=>'menu_kelompok()'])  !!} --}}
                                    <select class="form-control" id="status_kelompok" name="menu_communities" onchange="menukelompok()">
                                        <option value="Individu">Individu</option>
                                        <option value="Kelompok">Kelompok</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group select-kelompokhide col-lg-4 col-12" id="select_kelompok">
                                {!! Form::label('kelompok', 'Nama Kelompok (*)') !!}
                                {!! Form::select('community_id', $communitiesparent, null,['class'=>'form-control selectku','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group col-lg-8 col-12" style="margin: 7px;">
                                {!! Form::label('bukti', 'Bukti (*)') !!}
                                {!! Form::file('attachment', null ,['id'=>'attachment','class'=>'form-control','placeholder'=>'Attachment','required'=>'true']) !!}
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
{!! Html::script('assets/vendors/jquery-validation-1.19.1/dist/jquery.validate.min.js') !!}
{!! Html::script('js/pages/validate-init.js') !!}
<script>
    // $(document).ready(function(){
    //     // SAVE
    //     $.validator.setDefaults({
    //         submitHandler: function () {
    //             var $this = $('form#simpan');
    //             $.ajax({
    //                 url : $this.attr('action'),
    //                 type : 'PUT',
    //                 data : $this.serialize(),
    //                 success:function(response){
    //                     console.log(response);
    //                     if(response.data.status){
    //                         url = APP_URL_ADMIN+'/agreement';
    //                         history.pushState(null, null, url);
    //                         load(url);
    //                         iziToast.success({
    //                             title: 'Success',
    //                             message: response.data.message,
    //                             position: 'topRight'
    //                         });
    //                         }else{
    //                         iziToast.error({
    //                             title: 'Failed',
    //                             message: response.data.message,
    //                             position: 'topRight'
    //                         });
    //                     }
    //                 }
    //             });
    //         }
    //     });
    //     InitiateSimpleValidate.init();
    // });
</script>

<script>
    function menukelompok() {
        var i = document.getElementById("status_kelompok").value;
        console.log(i);
        if(i === "Kelompok"){
            $('#select_kelompok').removeClass("select-kelompokhide");
            $('#select_kelompok').addClass("select-kelompokshow");
        }else {
            $('#select_kelompok').removeClass("select-kelompokshow");
            $('#select_kelompok').addClass("select-kelompokhide");
        }
    }
</script>
@endsection
