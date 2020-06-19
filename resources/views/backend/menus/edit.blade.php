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
            <div class="breadcrumb-item">form</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Form</h2>
        <p class="section-lead">
            Form untuk menambah menu
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    {{-- {!! dd($user) !!} --}}
                    {!! Form::model($menu, ['route' => ['admin.menu.update', $menu->id],'class'=>'form-horizontal validate','id'=>'simpan','novalidate'=>'']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12">
                                {!! Form::label('menuparent', 'Menu Parent') !!}
                                <div class="col-lg-4 pl-0">
                                    {!! Form::select('menu_parent',$arrMenuParent,null,['class'=>'form-control select2','style'=>'width: 100%;']) !!}
                                </div>
                            </div>
                            <div class="form-group col-sm-6 col-12">
                                {!! Form::label('menuname', 'Menu Name') !!}
                                    {!! Form::text('menu_name', null ,['id'=>'menu_name','class'=>'form-control','placeholder'=>'Menu Name','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-sm-6 col-12">
                                {!! Form::label('menuuri', 'Menu Uri') !!}
                                    {!! Form::text('menu_uri', null ,['id'=>'menu_uri','class'=>'form-control','placeholder'=>'Menu Uri','required'=>'true','readonly'=>'true']) !!}
                            </div>
                            <div class="form-group col-sm-6 col-12">
                                {!! Form::label('menutarget', 'Menu Target') !!}
                                    {!! Form::select('menu_target',[''=>'','_BLANK'=>'Buka Tab Baru'],null,['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group col-sm-6 col-12">
                                {!! Form::label('menugroup', 'Menu Group') !!}
                                {!! Form::select('menu_group',Config::get('gconfig.menugroup'),null,['class'=>'form-control']) !!}
                            </div>
                            <div class="form-group col-12">
                                {!! Form::label('menuicon', 'MenuIcon') !!}
                                <div class="input-group col-lg-6 pl-0">
                                {!! Form::text('menu_icon', null ,['id'=>'menu_icon','class'=>'form-control','placeholder'=>'Menu Icon']) !!}
                                <div class="input-group-append">
                                    {!! Form::button('Icon', ['class' => 'btn btn-outline-secondary', 'title' => 'Click to Search Icon', 'onClick' => "window.open('https://fontawesome.com/icons?d=gallery')"]) !!}
                                </div>
                                </div>
                            </div>
                            <div class="form-group mb-0 col-12">
                                {!! Form::label('menu_active', 'Active') !!}
                                <div class="col-lg-1 pl-0">
                                    {!! Form::select('menu_active', ['0'=>'Tidak','1'=>'Ya'], null, ['class'=>'form-control']) !!}
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
        $(".select2").select2();
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
                            url = APP_URL_ADMIN+'/menu';
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