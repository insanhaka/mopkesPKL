<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    {{-- <div class="jumbotron jumbotron-fluid" style="background-image: url('{{asset('assets/img/header-preview.jpg')}}'); background-repeat: no-repeat; height: auto; background-size: cover;">
      <div class="container">
        <h1 class="display-4">Fluid jumbotron</h1>
        <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
      </div>
    </div> --}}
    <img src="{{asset('assets/img/header-preview.jpg')}}" style="width: 100%; height: auto;">
    <div class="container" style="margin-top: 5%;">
    @foreach($business as $data)
      <p style="font-size: 20px; font-weight: bold;">{!! $data->Business_specific !!}</p>
      <hr>
      <p>Nama pemilik :</p>
      <div class="row" style="margin-top: -3%;">
        <div class="col-1"><img src="{{asset('assets/img/user.png')}}" style="width: 20px;"></div>
        <div class="col-10">{!! $data->name !!}</div>
      </div>
      <hr>
      <p>Lokasi jualan :</p>
      <div class="row" style="margin-top: -3%;">
        <div class="col-1"><img src="{{asset('assets/img/pin.png')}}" style="width: 20px;"></div>
        <div class="col-10">{!! $data->lapak_addr !!}</div>
      </div>
      <hr>
      <p>Kategori bidang usaha :</p>
      <div class="row" style="margin-top: -3%;">
        <div class="col-1"><img src="{{asset('assets/img/list.png')}}" style="width: 20px;"></div>
        <div class="col-10">{!! $data->sector_name !!}</div>
      </div>
      <hr>

      <div class="lapor text-center">
        <a class="btn" href="/laporan/{!!$data->nik_id!!}" role="button" style="margin-top: 10%; margin-bottom: 10%; background-color: #5a61c1; color: #fff;">Buat Laporan</a>
      </div>
      @endforeach
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>
