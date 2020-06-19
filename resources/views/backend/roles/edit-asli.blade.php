@extends('backend.layouts.template')

@section('css')
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Roles</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">{!! Html::decode(GHelper::breadcrumb('dashboard')) !!}</div>
            <div class="breadcrumb-item">{!! GHelper::breadcrumb('menu') !!}</div>
            <div class="breadcrumb-item">form</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Form</h2>
        <p class="section-lead">
            Form untuk mengedit role
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    {{-- {!! dd($user) !!} --}}
                    {!! Form::model($role, ['route' => ['admin.role.update', $role->id],'class'=>'form-horizontal validate','id'=>'simpan','novalidate'=>'']) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-6 col-12">
                                {!! Form::label('role_name', 'Name') !!}
                                {!! Form::text('role_name', null ,['id'=>'role_name','class'=>'form-control','placeholder'=>'Name','required'=>'true']) !!}
                            </div>
                            <div class="form-group col-12">
                                {!! Form::label('role_description', 'Description') !!}
                                {!! Form::text('role_description', null ,['id'=>'role_description','class'=>'form-control','placeholder'=>'Description','required'=>'true']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header with-border">
                                        <h4>Permission Role</h4>
                                    </div>
                                    <div class="card-body no-padding">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Permissions</th>
                                                    @foreach($mans as $man)
                                                        <th width="150px">
                                                            <label>
                                                                <input type="checkbox" class="checkall" data-val="{!! $man !!}" value="1">
                                                                <span class="text">{!! $man !!}</span>
                                                            </label>
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pms as $pm)
                                                <tr>
                                                    <td>{!!$pm->name!!}</td>
                                                    @foreach($mans as $man)
                                                        @if(isset($mais[$pm->name][$man]))
                                                            <td align="center">
                                                                <label>
                                                                <input type="checkbox" class="{!! $man !!}" name="permissionrole[]" value="{!! $mais[$pm->name][$man] !!}" {{ (isset($rps[$mais[$pm->name][$man]]))?"checked":"" }}>
                                                                <span class="text"></span>
                                                                </label>
                                                            </td>
                                                        @else
                                                            <td align="center">
                                                                &nbsp;
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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
                            url = APP_URL_ADMIN+'/role';
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

        // Check All
        $(document).on("click", ".checkall", function(){ 
            var act = $(this).attr('data-val');
            $('.'+act).prop('checked', this.checked);
        });
    });
</script>
@endsection