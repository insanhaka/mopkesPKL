@extends('backend.layouts.template')

@section('css')
{!! Html::style('assets/vendors/select2/dist/css/select2.min.css') !!}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Permissions</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">{!! Html::decode(GHelper::breadcrumb('dashboard')) !!}</div>
            <div class="breadcrumb-item">{!! GHelper::breadcrumb('menu') !!}</div>
            <div class="breadcrumb-item">form</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Form</h2>
        <p class="section-lead">
            Form untuk mengedit permission
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    {{-- {!! dd($user) !!} --}}
                    {!! Form::model($permission, ['route' => ['admin.permission.update', $permission->id],'class'=>'form-horizontal validate','id'=>'simpan','novalidate'=>'']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-4 col-12">
                                {!! Form::label('menu_id', 'Menu') !!}
                                {!! Form::select('menu_id',$arrMenuChild,null,['class'=>'form-control select2','style'=>'width: 100%;','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-lg-8 col-12">
                                {!! Form::label('permission_name', 'Name') !!}
                                {!! Form::text('permission_name', null ,['id'=>'permission_name','class'=>'form-control','placeholder'=>'Name','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-12">
                                {!! Form::label('permission_description', 'Description') !!}
                                {!! Form::text('permission_description', null ,['id'=>'permission_description','class'=>'form-control','placeholder'=>'Description','required'=>'true']) !!}
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
                            url = APP_URL_ADMIN+'/permission';
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