@extends('backend.layouts.template')

@section('css')
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
            Form untuk menambah <b>agreement</b>
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    {!!Form::open(['route'=>'admin.agreement.store','class'=>'validate', 'method'=>'POST', 'enctype'=>'multipart/form-data', 'id'=>'simpan','novalidate'=>''])!!}
                    {{-- <form action="{{ route('admin.agreement.store') }}" method="POST" enctype="multipart/form-data"> --}}
                        {{-- @csrf --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('Nama pihak yang menyetujui', 'Nama pihak yang menyetujui') !!}
                                {!! Form::text('name', null ,['id'=>'name','class'=>'form-control','placeholder'=>'Nama','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-3 col-12">
                                {!! Form::label('menu_kelompok', 'Kelompok / Individu') !!}
                                <div class="col-lg-5 pl-0">
                                    {!! Form::select('menu_kelompok', ['0'=>'Kelompok','1'=>'Individu'], null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group col-lg-8 col-12" style="margin: 7px;">
                                {!! Form::label('Bukti', 'Bukti') !!}
                                {!! Form::file('attachment', null ,['id'=>'attachment','class'=>'form-control','placeholder'=>'Attachment','required'=>'true']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-top">
                        <div class="row">
                            <div class="col-md-12 text-md-right text-center">
                                {{-- <button type="submit" class="btn btn-success">Upload</button> --}}
                                {!! GHelper::btnSave() !!}
                                {!! GHelper::btnCancel() !!}
                            </div>
                        </div>
                    </div>
                    {{-- </form> --}}
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

            // @if ($message = Session::get('success'))
            // // url = APP_URL_ADMIN +'/agreement';
            // // history.pushState(null, null, url);
            // // load(url);
            // iziToast.success({
            //             title: 'Success',
            //             message: 'Data Berhasil Disimpan',
            //             position: 'topRight'
            //         });
            // @endif

            $(".select2").select2();
            // SAVE
            $.validator.setDefaults({
                submitHandler: function (e) {
                    e.preventDefault();
                    // var $this = $('form#simpan');
                    var dataku = new FormData($(this)[0]);
                    console.log(dataku);
                    $.ajax({
                        url : $this.attr('action'),
                        type : 'POST',
                        data : dataku,
                        dataType: 'json',
                        success:function(response){
                            console.log(response.data.status);
                            if(response.data.status){
                                url = APP_URL_ADMIN +'/agreement';
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
