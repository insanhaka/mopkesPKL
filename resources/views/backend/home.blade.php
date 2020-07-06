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

    <div class="row justify-content-center" style="margin-top: 50px;">
        <div class="col-4">
            <div class="card" style="border-radius: 20px; padding: 3%;">
                <div class="card-header">
                    <h5>Peroleh Laporan Terbanyak</h5>
                </div>
                <div class="card-body" style="height: 300px;">
                    {{-- <ul class="list-group list-group-flush">
                        <li class="list-group-item">{!!$top->agreement->name!!} = {!!$top->count!!}</li>
                    </ul> --}}
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">NIK</th>
                            <th scope="col">Jumlah Laporan</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->take(10) as $top)
                            <tr>
                                <td>{!!$top->agreement->name!!}</td>
                                <td>{!!$top->count!!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
        <div class="col-8">
            <canvas id="myChart" width="400" height="150"></canvas>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>


    <script>
        $(document).ready(function(){
            getBusiness();
            getReport();
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

        function getReport() {
            var d = new Date();
            var months = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            var bulan1 = months[d.getMonth()-5];
            var bulan2 = months[d.getMonth()-4];
            var bulan3 = months[d.getMonth()-3];
            var bulan4 = months[d.getMonth()-2];
            var bulan5 = months[d.getMonth()-1];
            var bulan6 = months[d.getMonth()];
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
                    var data = res[i].created_at;
                    var getdate = new Date(data);
                    var mon = months[getdate.getMonth()]
                    // console.log(mon);
                    if( mon == bulan1){
                        report1[mon] = report1[mon] ? report[mon] + 1 : 1;
                    }else if(mon == bulan2){
                        report2[mon] = report2[mon] ? report2[mon] + 1 : 1;
                    }else if(mon == bulan3){
                        report3[mon] = report3[mon] ? report3[mon] + 1 : 1;
                    }else if(mon == bulan4){
                        report4[mon] = report4[mon] ? report4[mon] + 1 : 1;
                    }else if(mon == bulan5){
                        report5[mon] = report5[mon] ? report5[mon] + 1 : 1;
                    }else{
                        report6[mon] = report6[mon] ? report6[mon] + 1 : 1;
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

                var ctx = document.getElementById('myChart');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [bulan1,bulan2,bulan3,bulan4,bulan5,bulan6],
                        datasets: [{
                            label: 'Data Laporan Masuk',
                            data: [databulan1, databulan2, databulan3, databulan4, databulan5, databulan6],
                            backgroundColor: [
                                '#ff7675',
                                '#ff7675',
                                '#ff7675',
                                '#ff7675',
                                '#ff7675',
                                '#ff7675',
                            ],
                            borderColor: [
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });


            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });

        }

    </script>
@endsection
