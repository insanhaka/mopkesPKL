@extends('backend.layouts.template')

@section('css')
{!! Html::style('assets/vendors/select2/dist/css/select2.min.css') !!}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Users</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">{!! Html::decode(GHelper::breadcrumb('dashboard')) !!}</div>
            <div class="breadcrumb-item">{!! GHelper::breadcrumb('menu') !!}</div>
            <div class="breadcrumb-item">reset password</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Form</h2>
        <p class="section-lead">
            Form untuk mereset password akun pengguna
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    {{-- {!! dd($user) !!} --}}
                    {!! Form::model($user, ['route' => ['admin.user.updateresetpass', $user->id],'class'=>'form-horizontal validate','id'=>'simpan','novalidate'=>'']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                {!! Form::label('newpassword', 'Password Baru') !!}
                                {!! Form::password('newpassword',['id'=>'newpassword','class'=>'form-control','placeholder'=>'Password Baru','required'=>'true','minlength'=>6]) !!}
                            </div>
                            <div class="form-group col-md-6 col-12">
                                {!! Form::label('cnewpassword', 'Confirm Password Baru') !!}
                                {!! Form::password('cnewpassword',['id'=>'cnewpassword','class'=>'form-control','placeholder'=>'Confirm Password Baru','required'=>'true','equalTo'=>'#newpassword']) !!}
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
                            url = APP_URL_ADMIN+'/user';
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