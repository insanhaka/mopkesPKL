@extends('backend.layouts.template')

@section('css')
    {!! Html::style('assets/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css') !!}
    {!! Html::style('assets/vendors/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') !!}
    <style>
        .select-generatehide {
            visibility: hidden;
        }

        .select-generateshow {
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
                    <form action="/admin/agreement/deleteall" method="POST">
                    @csrf
                    <div class="card-body">
                        <table class="table table-striped dt-responsive" id="tableserverside">
                            <thead>
                                <tr>
                                    {{-- <th class="text-center no-sort" width="50px">
                                        <input type="checkbox" id="checkall" name="checkall" class="checkall"><span class="text"></span></label>
                                    </th> --}}
                                    {{-- <th></th> --}}
                                    <th>Nama Pihak Yang Menyetujui</th>
                                    <th>NIK</th>
                                    <th>Alamat KTP</th>
                                    <th>Alamat Domisili</th>
                                    <th>Kelompok/Individu</th>
                                    <th>Nama Kelompok</th>
                                    <th>Bukti</th>
                                    <th>View</th>
                                    <th>Act</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 text-md-left text-center">
                                {!! GHelper::btnCreate() !!}
                                <button class="select-generatehide btn btn-danger" id="dell-all" type="submit">Delete All</button>
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

    <script type="text/javascript">
        @if ($message = Session::get('success'))
            iziToast.success({
                        title: 'Success',
                        message: 'Data Berhasil Disimpan',
                        position: 'topRight'
                    });
        @elseif ($message = Session::get('warning'))
            iziToast.warning({
                        title: 'Success',
                        message: 'Data Berhasil Dihapus',
                        position: 'topRight'
                    });
        @elseif ($message = Session::get('error'))
            iziToast.error({
                        title: 'Ups',
                        message: 'Proses gagal',
                        position: 'topRight'
                    });
        @endif
    </script>


    <script type="text/javascript">
        $(document).ready(function(){
            var table = InitiateSimpleDataTable.init();
        });
    </script>

{{-- @foreach ($agreements as $i)
<script>

    $('#cek{!!$i->id!!}').click(function(event) {

        var favorite = [];
        $.each($("input[name='del[]']:checked"), function(){
            favorite.push($(this).val());
        });
        // alert("My favourite sports are: " + favorite.join(", "));
        var terpilih = favorite.length;

        if(terpilih > 0){
            $('#dell-all').removeClass("select-generatehide");
            $('#dell-all').addClass("select-generateshow");
        }else {
            $('#dell-all').removeClass("select-generateshow");
            $('#dell-all').addClass("select-generatehide");
        }

    });

</script>
@endforeach --}}

<script type="text/javascript">
    $(function () {
      
      var table = $('#tableserverside').DataTable({
          processing: true,
          serverSide: true,
          ajax: APP_URL_ADMIN +"/agreement/getdataserverside",
          columns: [
            // {data: 'checkall',name: 'checkall'},
            {data: 'name',name: 'name'},
            {data: 'nik',name: 'nik'},
            {data: 'ktp',name: 'ktp'},
            {data: 'domisili',name: 'domisili'},
            {data: 'status',name: 'status'},
            {data: 'nama-kelompok',name: 'nama-kelompok'},
            {data: 'attachment',name: 'attachment'},
            {data: 'viewlink',name: 'viewlink'},
            {data: 'act',name: 'act',orderable: false, searchable: false}
          ]
      });
      
    });
</script>

@endsection
