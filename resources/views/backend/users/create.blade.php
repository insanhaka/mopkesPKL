@extends('backend.layouts.template')

@section('css')
{!! Html::style('assets/vendors/select2/dist/css/select2.min.css') !!}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>User</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">{!! Html::decode(GHelper::breadcrumb('dashboard')) !!}</div>
            <div class="breadcrumb-item">{!! GHelper::breadcrumb('menu') !!}</div>
            <div class="breadcrumb-item">form</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Form</h2>
        <p class="section-lead">
            Form untuk menambah akun pengguna
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    {!!Form::open(['route'=>'admin.user.store','class'=>'validate','id'=>'simpan','novalidate'=>''])!!}
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('username', 'Username') !!}
                                {!! Form::text('username', null ,['id'=>'username','class'=>'form-control','placeholder'=>'Username','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-8 col-12">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text('name', null ,['id'=>'name','class'=>'form-control','placeholder'=>'Nama','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-6 col-12">
                                {!! Form::label('password', 'Password') !!}
                                {!! Form::password('password',['id'=>'password','class'=>'form-control','placeholder'=>'Password','required'=>'true','minlength'=>6]) !!}
                            </div>
                            <div class="form-group col-md-6 col-12">
                                {!! Form::label('cpassword', 'Confirm Password') !!}
                                {!! Form::password('cpassword',['id'=>'cpassword','class'=>'form-control','placeholder'=>'Confirm Password','required'=>'true','equalTo'=>'#password']) !!}
                            </div>
                            <div class="form-group col-lg-6 col-12">
                                {!! Form::label('role_id', 'Role') !!}
                                {!! Form::select('role_id', $data['arrRoles'], null, ['class'=>'form-control select2','id'=>'role_id','required'=>'true','style'=>'width: 100%;']) !!}
                            </div>
                            <div class="form-group mb-0 col-12">
                                {!! Form::label('is_active', 'Active') !!}
                                <div class="col-lg-1 pl-0">
                                    {!! Form::select('is_active', ['0'=>'Tidak','1'=>'Ya'], null, ['class'=>'form-control']) !!}
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
            $(".select2").select2({
                placeholder: "Select an Option",
            });
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
                                url = APP_URL_ADMIN +'/user';
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
