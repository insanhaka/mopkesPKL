@extends('backend.layouts.modal')

@section('css')
@endsection

@section('content')
<div class="modal-dialog modal-md modal-default">
    <div class="modal-content">
        {!! Form::open(['route'=>['admin.user.updatechangepass'],'class'=>'form-horizontal validate','novalidate'=>'','id'=>'simpan-modal']) !!}
        <div class="modal-header bg-whitesmoke">
            <h5 class="modal-title">Change Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('oldpassword', 'Password Lama') !!}
                {!! Form::text('oldpassword', null ,['id'=>'oldpassword','class'=>'form-control','placeholder'=>'Password Lama','required'=>'true']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('newpassword', 'Password Baru') !!}
                {!! Form::password('newpassword',['id'=>'newpassword','class'=>'form-control','placeholder'=>'Password Baru','required'=>'true','minlength'=>6]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('cnewpassword', 'Confirm Password Baru') !!}
                {!! Form::password('cnewpassword',['id'=>'cnewpassword','class'=>'form-control','placeholder'=>'Confirm Password Baru','required'=>'true','equalTo'=>'#newpassword']) !!}
            </div>
        </div>
        <div class="modal-footer bg-whitesmoke">
            <div class="row">
                <div class="col-md-12 text-md-right text-center">
                    {!! GHelper::btnSave() !!}
                    {!! GHelper::btnCancel() !!}
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
@endsection

@section('js')
{!! Html::script('assets/vendors/jquery-validation-1.19.1/dist/jquery.validate.min.js') !!}
{!! Html::script('js/pages/validate-init.js') !!}
<script>
    $(document).ready(function(){
        // SAVE
        $.validator.setDefaults({
            submitHandler: function () {
                var $this = $('form#simpan-modal');
                $.ajax({
                    url : $this.attr('action'),
                    type : 'POST',
                    data : $this.serialize(),
                    dataType: 'json',
                    success:function(response){
                        if(response.data.status){
                            $('#myModal').modal('hide');
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
