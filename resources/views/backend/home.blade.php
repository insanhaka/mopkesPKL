@extends('backend.layouts.template')

@section('css')
<!-- CSS Libraries -->
{!! Html::style('assets/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css') !!}
{!! Html::style('assets/vendors/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') !!}
{!! Html::style('assets/vendors/jqvmap/dist/jqvmap.min.css') !!}
{!! Html::style('assets/vendors/weathericons/css/weather-icons.min.css') !!}
{!! Html::style('assets/vendors/weathericons/css/weather-icons-wind.min.css') !!}
{!! Html::style('assets/vendors/summernote/dist/summernote-bs4.css') !!}
<style>
    .dash {
        padding-top: 5%;
    }
    .box {
        height: 100%;
        width: 100%;
        background-color: #ffff;
        border-radius: 15px;
        /* padding: 5%; */
    }
</style>
@endsection

@section('content')

<div class="dash">
    <div class="row justify-content-between">
        <div class="col-4">
            <div class="box">
                <div class="row justify-content-center">
                    <div class="col-5">
                        <img src="{{asset('assets/img/shop-01.png')}}" style="width: 80%; height: auto;">
                    </div>
                    <div class="col-6 text-center" style="margin-left: -50px; color: #10ac84; padding-top: 5%;">
                        <h6>Total Usaha Terdaftar</h6>
                        <p style="font-size: 50px; font-weight: bold; margin-top: 15%;" id="usahaterdaftar"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="box">
                <div class="row justify-content-center">
                    <div class="col-5">
                        <img src="{{asset('assets/img/shopactive-01.png')}}" style="width: 80%; height: auto;">
                    </div>
                    <div class="col-6 text-center" style="margin-left: -50px; color: #2e86de; padding-top: 5%;">
                        <h6>Total Usaha Aktif</h6>
                        <p style="font-size: 50px; font-weight: bold; margin-top: 15%;" id="usahaaktif"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="box">
                <div class="row justify-content-center">
                    <div class="col-5">
                        <img src="{{asset('assets/img/report-01.png')}}" style="width: 80%; height: auto;">
                    </div>
                    <div class="col-6 text-center" style="margin-left: -50px; color: #ff9f43; padding-top: 5%;">
                        <h6>Total Laporan Masuk</h6>
                        <p style="font-size: 50px; font-weight: bold; margin-top: 15%;" id="laporanmasuk"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center" style="margin-top: 20px;">
        <div class="col-12">
            <div class="card" style="border-radius: 20px;">
                <div class="card-body">
                    <div id="hightchart"></div>
                </div>
              </div>
        </div>
    </div>

    <div class="row justify-content-center" style="margin-top: 5px;">
        <div class="col-12">
            <div class="card" style="border-radius: 20px; padding-bottom: 5%; padding-top: 1%">
                <div class="card-header text-primary">
                    <h5>Peroleh Laporan Terbanyak</h5>
                </div>
                <div class="card-body" style="height: auto;">
                    {{-- <ul class="list-group list-group-flush">
                        <li class="list-group-item">{!!$top->agreement->name!!} = {!!$top->count!!}</li>
                    </ul> --}}
                    <table class="table table-sm table-striped">
                        <thead>
                          <tr>
                            <th scope="col">Nama Usaha</th>
                            <th scope="col">Nama Pemilik</th>
                            <th scope="col">No.HP</th>
                            <th scope="col">Jumlah</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->take(10) as $top)
                            @foreach ($business as $b)
                            @if ( $b->id == $top->nik_id)
                            <tr>
                                <td>{!!$b->business_name!!}</td>
                                <td>{!!$b->name!!}</td>
                                <td>{!!$b->contact!!}</td>
                                <td>{!!$top->count!!}</td>
                            </tr>
                            @endif
                            @endforeach
                            @endforeach
                        </tbody>
                      </table>
                      <div class="seeall text-center">
                          <a class="btn btn-primary" href="{!! url('/admin/report') !!}" role="button">Lihat Semua Laporan</a>
                      </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

@endsection

@section('js')

{{-- <script src="https://unpkg.com/axios/dist/axios.min.js"></script> --}}

<script src="{{asset('assets/js/axios.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>


    <script>
        $(document).ready(function(){
            getBusiness();
        });

        function getBusiness() {
            // Make a request
            axios.get('/api/business')
            .then(function (response) {
                var val = response.data['business'];
                var active = {};
                var nonactive = {};

                for (var n = 0; n < val.length; n++){
                    var num = val[n].is_active;
                    if(num == 1){
                        active[num] = active[num] ? active[num] + 1 : 1;
                    }else{
                        nonactive[num] = nonactive[num] ? nonactive[num] + 1 : 1;
                    }
                }

                var usahaaktif = 0;
                for (var tambah of Object.values(active)){
                    usahaaktif += tambah;
                }
                var usahanonaktif = 0;
                for (var tambah of Object.values(nonactive)){
                    usahanonaktif += tambah;
                }
                // console.log(active);

                $('#usahaterdaftar').html(val.length);
                $('#usahaaktif').html(usahaaktif);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
        }


    </script>

    <script>
        $(document).ready(function(){

            var d = new Date();
            var months = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            var bulan1 = months[d.getMonth()-5];
            var bulan2 = months[d.getMonth()-4];
            var bulan3 = months[d.getMonth()-3];
            var bulan4 = months[d.getMonth()-2];
            var bulan5 = months[d.getMonth()-1];
            var bulan6 = months[d.getMonth()];

            var cat_nilai = [1,2,3,4,5];
            var sangat_buruk = cat_nilai[0];
            var buruk = cat_nilai[1];
            var cukup_baik = cat_nilai[2];
            var baik = cat_nilai[3];
            var sangat_baik = cat_nilai[4];

            var report1 = {};
            var report2 = {};
            var report3 = {};
            var report4 = {};
            var report5 = {};
            var report6 = {};
            // Make a request
            axios.get('/api/report')
            .then(function (response) {
                var res = response.data['report'];
                $('#laporanmasuk').html(res.length);

                for(var i = 0; i < res.length; i++){
                    var rating = res[i].rating;

                    if(rating == sangat_buruk){
                        var data_sangat_buruk = res[i];
                    }else if(rating == buruk){
                        var data_buruk = res[i];
                    }else if(rating == cukup_baik){
                        var data_cukup_baik = res[i];
                    }else if(rating == baik){
                        var data_baik = res[i];
                    }else {
                        var data_sangat_baik = res[i].created_at;
                        // console.log(data_sangat_baik);
                        var getdate = new Date(data_sangat_baik);
                        var mon = months[getdate.getMonth()]
                        // console.log(mon);
                        if( mon == bulan1){
                            report1_sangat_baik[mon] = report1_sangat_baik[mon] ? report1_sangat_baik[mon] + 1 : 1;
                        }else if(mon == bulan2){
                            report2_sangat_baik[mon] = report2_sangat_baik[mon] ? report2_sangat_baik[mon] + 1 : 1;
                        }else if(mon == bulan3){
                            report3_sangat_baik[mon] = report3_sangat_baik[mon] ? report3_sangat_baik[mon] + 1 : 1;
                        }else if(mon == bulan4){
                            report4_sangat_baik[mon] = report4_sangat_baik[mon] ? report4_sangat_baik[mon] + 1 : 1;
                        }else if(mon == bulan5){
                            report5_sangat_baik[mon] = report5_sangat_baik[mon] ? report5_sangat_baik[mon] + 1 : 1;
                        }else{
                            report6_sangat_baik[mon] = report6_sangat_baik[mon] ? report6_sangat_baik[mon] + 1 : 1;
                        }
                    }

                }

                var databulan1 = 0;
                for (var tambah of Object.values(report1)){
                    databulan1 += tambah;
                }
                var databulan2 = 0;
                for (var tambah of Object.values(report2)){
                    databulan2 += tambah;
                }
                var databulan3 = 0;
                for (var tambah of Object.values(report3)){
                    databulan3 += tambah;
                }
                var databulan4 = 0;
                for (var tambah of Object.values(report4)){
                    databulan4 += tambah;
                }
                var databulan5 = 0;
                for (var tambah of Object.values(report5)){
                    databulan5 += tambah;
                }
                var databulan6 = 0;
                for (var tambah of Object.values(report6)){
                    databulan6 += tambah;
                }

                Highcharts.chart('hightchart', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Grafik Laporan Dari Masyarakat'
                    },
                    subtitle: {
                        text: 'Total perbulan berdasarkan kelompok nilai'
                    },
                    xAxis: {
                        categories: [
                        bulan1,
                        bulan2,
                        bulan3,
                        bulan4,
                        bulan5,
                        bulan6
                        ],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Jumlah Laporan'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y:.f} Laporan</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [{
                        name: 'Sangat buruk',
                        data: [databulan1, databulan2, databulan3, databulan4, databulan5, databulan6],
                        color: '#ff7979',
                    }, {
                        name: 'Buruk',
                        data: [databulan1, databulan2, databulan3, databulan4, databulan5, databulan6],
                        color: '#ffbe76',
                    }, {
                        name: 'Cukup Baik',
                        data: [databulan1, databulan2, databulan3, databulan4, databulan5, databulan6],
                        color: '#badc58',
                    }, {
                        name: 'Baik',
                        data: [databulan1, databulan2, databulan3, databulan4, databulan5, databulan6],
                        color: '#7ed6df',
                    },{
                        name: 'Sangat Baik',
                        data: [databulan1, databulan2, databulan3, databulan4, databulan5, databulan6],
                        color: '#686de0',
                    }]
                });

            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });

        });
    </script>
@endsection
