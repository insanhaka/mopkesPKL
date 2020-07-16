<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <title>Generate QR Code</title>
  </head>
  <body>
    <div class="section" style="padding-top: 3%;">
    	<div class="qrcode text-center">
    		<h3>QR CODE</h3>
    		<hr>
                <div style="display: flex; justify-content: center; align-items: center;">
                    <div class="row justify-content-around">
                        @foreach ($pedagang as $d)
                        {{-- <div class="col-md-3"> --}}
                            <div id="qrcode{!!$d->id!!}"></div>
                        {{-- </div> --}}
                        @endforeach
                    </div>
    			</div>
    		<div class="save" style="margin-top: 5%;">
                <button type="button" class="btn btn-primary" id="tosave">Download</button>
    			<a class="btn btn-secondary" href="/admin/business" role="button">Back</a>
    		</div>
    	</div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
	{!! Html::script('assets/vendors/qrcode/easy-qrcode.js') !!}
	<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>


	@foreach ($pedagang as $i)

	<script>

	function showQr() {
	    new QRCode(document.getElementById("qrcode{!! $i->id !!}"), {
	        text : window.location.origin + "/qrcode/"+ {!! $i->nik_id !!},
	        width: 300,
	        height: 300,
	        colorDark: "#000000",
	        colorLight: "#ffffff",

	        title: "{!! $i->name !!}",
	        titleFont: "bold 18px Arial",
	        titleColor: "#004284",
	        titleBgColor: "#fff",
	        titleHeight: 70,
	        titleTop: 25,

	        subTitle: "{!! $i->Business_specific !!}",
	        subTitleFont: "14px Arial",
	        subTitleColor: "#004284",
	        subTitleTop: 40,

	        // logo:"logo-transparent.png", // LOGO
	        logo:"{{ asset('assets/img/logo-kabupaten-tegal.png') }}",
	        logoWidth:63, //
	        logoHeight:80,
	        logoBgColor:'#ffffff', // Logo backgroud color, Invalid when `logBgTransparent` is true; default is '#ffff

	        correctLevel: QRCode.CorrectLevel.H
	    });
	}
	showQr();

	$('#tosave').click(function() {

	    var element = document.getElementById("qrcode{!!$i->id!!}");

	    html2canvas(element).then(function(canvas) {
	        // Export the canvas to its data URI representation
	        var base64image = canvas.toDataURL("image/jpg");
	        var downloadLink = document.createElement("a");
	        downloadLink.href = base64image;
	        downloadLink.download = "{!!$i->name!!}.jpeg";
	        document.body.appendChild(downloadLink);
	        downloadLink.click();
	        document.body.removeChild(downloadLink);
	        // Open the image in a new window
	        // window.open(base64image , "_blank");
	    });



	});


	</script>

	@endforeach

  </body>
</html>
