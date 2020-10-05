<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Mutan - Monitoring Kepatuhan Protokol Kesehatan</title>

    <!-- General CSS Files -->
    {!! Html::style('assets/vendors/bootstrap/css/bootstrap.min.css') !!}
    {!! Html::style('assets/vendors/fontawesome/css/all.min.css') !!}
    {!! Html::style('assets/vendors/izitoast/dist/css/iziToast.min.css') !!}
    <div id="css">
        @yield('css')
    </div>

    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

    <!-- Template CSS -->
    {!! Html::style('assets/css/style.css') !!}
    {!! Html::style('assets/css/components.css') !!}
    {!! Html::style('assets/css/custom.css') !!}
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="loading-container">
                <div class="lds-hourglass"></div>
            </div>
            <div class="navbar-bg"></div>
            {{-- HEADER --}}
            @include('backend.layouts._header')

            @include('backend.layouts._leftbar')

            <!-- Main Content -->
            <div id="utama" class="main-content">
                @yield('content')
            </div>
            {{-- FOOTER --}}
            @include('backend.layouts._footer')
        </div>
    </div>

    {!! Html::script('assets/vendors/jquery/dist/jquery.min.js') !!}
    {!! Html::script('assets/vendors/popper/popper.min.js') !!}
    {!! Html::script('assets/vendors/bootstrap/js/bootstrap.min.js') !!}
    {!! Html::script('assets/vendors/jquery.nicescroll/jquery.nicescroll.min.js') !!}
    {!! Html::script('assets/vendors/bootbox/bootbox.min.js') !!}
    {!! Html::script('assets/vendors/izitoast/dist/js/iziToast.min.js') !!}
    {!! Html::script('assets/js/stisla.js') !!}
    {!! Html::script('assets/js/scripts.js') !!}
    {!! Html::script('assets/js/custom.js') !!}

    <script type="text/javascript">
        var APP_URL_ADMIN = {!! json_encode(url('/'.\Request::route()->getPrefix().'/')) !!};

        var load = function (url) {
            $.get(url, function(data) {
                $('#css').html(data.css);
                $('#utama').html(data.content);
                $('#js').html(data.js);
            })
        };

        $(document).ready(function() {
            $(document).on('click', '[data-request="push"]', function (e) {
                e.preventDefault();
                var $this = $(this),
                li = $this.parent(),
                url = $this.attr("href"),
                title = $this.attr('title');

                // Give Mark to Menu after Click
                $(".main-sidebar .sidebar-menu li").removeClass("active");
                li.addClass("active");

                history.pushState({
                    url: url,
                    title: title
                }, title, url);

                load(url);
            });


            // $(document).ajaxError(function(event, xhr, settings, thrownError) {
            //     alert("Session Expired. You'll be take to login page");
            //     location.href = url('/login');
            // });

        });
    </script>
    <div id="js">
        @yield('js')
    </div>
</body>

</html>
