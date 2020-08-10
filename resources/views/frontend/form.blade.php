<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Form Pengaduan</title>
  </head>
  <body>
    {{-- <div class="jumbotron jumbotron-fluid" style="background-image: url('{{asset('assets/img/header-preview.jpg')}}'); background-repeat: no-repeat; height: auto; background-size: cover;">
      <div class="container">
        <h1 class="display-4">Fluid jumbotron</h1>
        <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
      </div>
    </div> --}}
    <img src="{{asset('assets/img/header-lapor-01.jpg')}}" style="width: 100%; height: auto;">
    <div class="container" style="margin-top: 5%;">
    	<form action="/kirim" method="POST">
        {{ csrf_field() }}
    		@foreach($laporan as $data)
              <input type="text" class="form-control" name="id" value="{!! $data->id !!}" style="visibility: hidden; margin-top: -5%;">
              <input type="text" class="form-control" name="ip" id="ip" style="visibility: hidden; margin-top: -10%;">
			  <div class="form-group">
			    <label>Perihal Laporan</label>
			    <input type="text" class="form-control" name="about">
			  </div>
			  <div class="form-group">
			    <label for="exampleFormControlTextarea1">Keterangan Laporan</label>
			    <textarea class="form-control" name="description" rows="3"></textarea>
			  </div>
			@endforeach
			<button class="btn btn-block" type="submit" style="margin-top: 5%; margin-bottom: 10%; background-color: #5a61c1; color: #fff;">Kirim</button>
		</form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script>
        function getIP(json) {
            console.log("My public IP address is: ", json.ip);
            document.getElementById("ip").value = json.ip;
        }
    </script>

    <script src="https://api.ipify.org?format=jsonp&callback=getIP"></script>

  </body>
</html>
