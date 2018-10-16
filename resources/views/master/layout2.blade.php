<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <title>Opendata - @yield('title')</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- Page Title -->
    <title>OpenData - @yield('title')</title>
    <!-- Bootstrap CSS -->
    {{ \AppHelper::instance()->gen_script('css','assets/css/bootstrap.min.css') }}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Pridi:300,400,600,700" rel="stylesheet">
    <!-- Simple line Icon -->
    {{ \AppHelper::instance()->gen_script('css','assets/css/simple-line-icons.css') }}
    <!-- Themify Icon -->
    {{ \AppHelper::instance()->gen_script('css','assets/css/themify-icons.css') }}
    <!-- Hover Effects -->
    {{ \AppHelper::instance()->gen_script('css','assets/css/set1.css') }}
    <!-- Main CSS -->
    {{ \AppHelper::instance()->gen_script('css','assets/css/style.css') }}

    {{ \AppHelper::instance()->gen_script('css','assets/vendor/select2/select2.min.css') }}
</head>

<body>
    <!--============================= HEADER =============================-->
    <div class="nav-menu">
        <div class="bg transition">
            <div class="container-fluid fixed">
                <div class="row">
                    <div class="col-md-12">
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <a class="navbar-brand" href="index.html">OpenData</a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="icon-menu"></span>
                            </button>
                            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                                <ul class="navbar-nav">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="{{ url('/dataset') }}">ชุดข้อมูล</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/organization') }}">Organization</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('head')

    <!--//END HEADER -->

    @yield('content')

    <!--============================= FOOTER =============================-->
    <footer class="main-block dark-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <p>Copyright &copy; 2018 Listing. All rights reserved | This template is made with <i class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a></p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        <ul>
                            <li><a href="#"><span class="ti-facebook"></span></a></li>
                            <li><a href="#"><span class="ti-twitter-alt"></span></a></li>
                            <li><a href="#"><span class="ti-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--//END FOOTER -->

    <!-- jQuery, Bootstrap JS. -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    {{ \AppHelper::instance()->gen_script('js','assets/js/jquery-3.2.1.min.js') }}
    {{ \AppHelper::instance()->gen_script('js','assets/js/popper.min.js') }}
    {{ \AppHelper::instance()->gen_script('js','assets/js/bootstrap.min.js') }}
    {{ \AppHelper::instance()->gen_script('js','assets/js/config.js') }}
    {{ \AppHelper::instance()->gen_script('js','assets/vendor/select2/select2.min.js') }}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(window).scroll(function() {
            // 100 = The point you would like to fade the nav in.

            if ($(window).scrollTop() > 100) {

                $('.fixed').addClass('is-sticky');

            } else {

                $('.fixed').removeClass('is-sticky');

            };
        });
    </script>
</body>

</html>
