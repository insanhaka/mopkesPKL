@extends('backend.layouts.template')

@section('css')
    {!! Html::style('assets/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css') !!}
    {!! Html::style('assets/vendors/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') !!}
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Agreement</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">{!! Html::decode(GHelper::breadcrumb('dashboard')) !!}</div>
            <div class="breadcrumb-item">{!! GHelper::breadcrumb('menu') !!}</div>
            <div class="breadcrumb-item">list</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">List</h2>
        <p class="section-lead">
            Daftar <b>agreement</b>.
        </p>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {!! Form::open(['url'=>\Request::path(),'class'=>'form-horizontal','id'=>'form-delete','method' => 'POST']) !!}
                    <div class="card-body">
                        <table class="table table-striped dt-responsive" id="simpledatatable">
                            <thead>
                                <tr>
                                    <th class="text-center no-sort" width="50px">
                                        <input type="checkbox" id="checkall" name="checkall" class="checkall"><span class="text"></span></label>
                                    </th>
                                    {{-- <th>No.</th> --}}
                                    <th>Nama Pihak Yang Menyetujui</th>
                                    <th>Kelompok / Individu</th>
                                    <th>Bukti</th>
                                    <th>Display</th>
                                    <th>Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agreements as $data)
                                <tr>
                                    <td>{!! GHelper::cbDelete($data->id); !!}</td>
                                    {{-- <td>{{$loop->iteration}}</td> --}}
                                    <td>{!! $data->name !!}</td>
                                    <td>{!! $data->status !!}</td>
                                    <td><a href="{{asset('agreement_file/'.$data->attachment)}}" alt="Image description" target="_blank" style="display: inline-block; width: 100%; height: 100%;">Preview</a></td>
                                    <td><img src="{{asset('agreement_file/'.$data->attachment)}}" class="card-img-top" style="width: 50px; height: 50px;" alt="..."></td>
                                    <td align="center">
                                        <div class="dropdown d-inline">
                                            <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                            </button>
                                            <div class="dropdown-menu" style="width: 60px;">
                                                {!! GHelper::btnEdit($data->id) !!}
                                                {!! GHelper::btnDelete($data->id) !!}
                                                {{-- <a class="dropdown-item has-icon bg-danger text-white btn-hapus" href="/agreement/{{$data->id}}/delete" title="Delete"><i class="far fa-trash-alt"></i> Delete</a> --}}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-md-left text-center">
                                {!! GHelper::btnCreate() !!}
                                {!! GHelper::btnDeleteAll() !!}
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
    {!! Html::script('assets/vendors/datatables/media/js/jquery.dataTables.min.js') !!}
    {!! Html::script('assets/vendors/datatables/media/js/jquery.dataTables.responsive.min.js') !!}
    {!! Html::script('assets/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') !!}
    {!! Html::script('js/pages/datatables-init.js') !!}

    {{-- <script type="text/javascript">
        @if ($message = Session::get('success'))
            iziToast.success({
                        title: 'Success',
                        message: 'Data Berhasil Dihapus',
                        position: 'topRight'
                    });
            @endif
    </script> --}}


    <script type="text/javascript">
        $(document).ready(function(){
            var table = InitiateSimpleDataTable.init();
            $('#simpledatatable').on('click','.btn-hapus',function(e){
                e.preventDefault();
                var $this =$(this);
                bootbox.confirm({size: "small",message: "Are you sure?",callback: function(confirm){
                    if (confirm) {
                        $.ajax({
                            url: $this.attr('data-url') + '/delete',
                            type: 'POST',
                            data: {
                                'id' : $this.attr('data-id'),
                                '_token' : '{{csrf_token()}}'
                            },
                            success: function(response) {
                                if(response){
                                    $this.closest('tr').fadeOut(300,function(){
                                        $this.remove();
                                    });
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
                }
                });
            });

            //Hapus Semua
            // $('#form-delete').on('submit',function(e){
            //     e.preventDefault();
            //     var $this = $(this);
            //     bootbox.confirm({size: "small",message: "Hapus data ditandai?",callback: function(confirm){
            //         if(confirm){
            //             $.ajax({
            //                 url : $this.attr('action') + '/delete',
            //                 type : 'POST',
            //                 data : $this.serialize(),
            //                 success:function(response){
            //                     // console.log(response);
            //                     if(response.data.status){
            //                         iziToast.success({
            //                             title: 'Success',
            //                             message: response.data.message,
            //                             position: 'topRight'
            //                         });
            //                         $this.find('input[type=checkbox]').each(function (t){
            //                             if($(this).is(':checked')){
            //                                 $(this).closest('tr').fadeOut(100,function(){
            //                                     $(this).remove();
            //                                 });
            //                             }
            //                         });
            //                         $('#deleteall').fadeOut(300);
            //                     }else{
            //                         iziToast.error({
            //                             title: 'Failed',
            //                             message: response.data.message,
            //                             position: 'topRight'
            //                         });
            //                     }
            //                 }
            //             });
            //         }
            //     }
            //     });
            // });
        });
    </script>
@endsection
