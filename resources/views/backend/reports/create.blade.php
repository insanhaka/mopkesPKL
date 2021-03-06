@extends('backend.layouts.template')

@section('css')
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Report</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">{!! Html::decode(GHelper::breadcrumb('dashboard')) !!}</div>
            <div class="breadcrumb-item">{!! GHelper::breadcrumb('menu') !!}</div>
            <div class="breadcrumb-item">form</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Form</h2>
        <p class="section-lead">
            Form untuk menambah <b>report</b>
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    {!!Form::open(['route'=>'admin.report.store','class'=>'form-horizontal validate','id'=>'simpan','novalidate'=>''])!!}
                    <div class="card-body">
                        <div class="row">
                            {{-- Add Something Here --}}
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
{!! Html::script('assets/vendors/jquery-validation-1.19.1/dist/jquery.validate.min.js') !!}
{!! Html::script('js/pages/validate-init.js') !!}
    <script>
        $(document).ready(function(){
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
                                url = APP_URL_ADMIN +'/report';
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