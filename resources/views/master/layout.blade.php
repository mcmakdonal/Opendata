<!doctype html>
<html lang="en">

<head>
    <title>Opendata - @yield('title')</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta property="og:url"  content="{{ url('/') }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	{{ \AppHelper::instance()->gen_script('css','backend/assets/vendor/bootstrap/css/bootstrap.min.css') }}
	{{ \AppHelper::instance()->gen_script('css','backend/assets/vendor/font-awesome/css/font-awesome.min.css') }}
	{{ \AppHelper::instance()->gen_script('css','backend/assets/vendor/linearicons/style.css') }}
	{{ \AppHelper::instance()->gen_script('css','backend/assets/vendor/chartist/css/chartist-custom.css') }}
	{{ \AppHelper::instance()->gen_script('css','backend/assets/vendor/jquery-tags-input/dist/jquery.tagsinput.min.css') }}
	<!-- VENDOR CSS DATATABLE -->
	{{ \AppHelper::instance()->gen_script('css','backend/assets/vendor/datatables/jquery.dataTables.css') }}
	{{ \AppHelper::instance()->gen_script('css','backend/assets/vendor/datatables/buttons.dataTables.min.css') }}
	<!-- VENDOR CSS DATETIMERANGE -->
	{{ \AppHelper::instance()->gen_script('css','backend/assets/vendor/daterangepicker/daterangepicker.css') }}
	<!-- MAIN CSS -->
	{{ \AppHelper::instance()->gen_script('css','backend/assets/css/main.css') }}
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	{{ \AppHelper::instance()->gen_script('css','backend/assets/css/demo.css') }}
	{{ \AppHelper::instance()->gen_script('css','backend/assets/vendor/select2/select2.min.css') }}
	<!-- GOOGLE FONTS -->
	{{ \AppHelper::instance()->gen_script('css','backend/assets/css/custom.css') }}


	

	<link href="https://fonts.googleapis.com/css?family=Pridi:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('backend/assets/img/apple-icon.png') }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('backend/assets/img/favicon.png') }}">
</head>

<body class="layout-fullwidth" >
<div class="preloader-wrapper">
    <div class="preloader">
        <img src="{{ asset('backend/assets/img/preloader.gif') }}" alt="NILA">
    </div>
</div>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top" style="background-image: url({{ url('backend/assets/img/header_bg.png') }});">
			<div class="brand">
				<a href="{{ url('/') }}"> <img src="{{ url('backend/assets/img/header_logo_.png') }}" class="img-responsive"> </a>
				
			</div>
			<div class="container-fluid">
			<div class="menu_mobile">

			</div>
			<img src="{{ url('backend/assets/img/header_fx.png') }}" class="img_right">
				<!-- <div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				 {!! Form::open(['url' => "/dataset",'class' => 'navbar-form navbar-left', 'method' => 'get']) !!}
					<div class="input-group">
						<input type="text" value="" name="title" class="form-control" placeholder="ค้นหา ชุดข้อมูล">
						<span class="input-group-btn"><button type="submit" class="btn btn-primary">ค้นหา</button></span>
					</div>
				{!! Form::close() !!} -->
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						
					<li>
					<a  href="{{ url('/dataset') }}" class="menu_button" style="padding-right:0">
					<img src="{{ url('backend/assets/img/btn_datasets.png') }}" >
					</a>
					</li>
					<li>
					<a  href="{{ url('/organization') }}" class="menu_button" >
					<img src="{{ url('backend/assets/img/btn_org.png') }}" >
					</a>
					</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle btn btn_pink" data-toggle="dropdown"><span> 
							<!-- <i class="fa fa-sliders" aria-hidden="true"></i>  {{ Cookie::get('name') }}  </span> 
							<i class="icon-submenu lnr lnr-chevron-down"></i> -->
							<i class="glyphicon glyphicon-cog"></i>
							</a>
							<ul class="dropdown-menu">
							
								@if (Cookie::get('token') !== null)
								<li><a href="/categories"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <span>หมวดหมู่</span></a></li>
								<li><a href="/administrator"><i class="fa fa-user" aria-hidden="true"></i> <span>ผู้ดูแลระบบ</span></a></li>
								<li><a href="/datamanagement"><i class="fa fa-database" aria-hidden="true"></i><span>บริหารจัดการข้อมูล</span></a></li>
								<li><a href="/log-download"><i class="fa fa-download" aria-hidden="true"></i><span>ประวัติการดาวน์โหลด</span></a></li>
								<li><a href="{{ url('logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i><span>ออกจากระบบ</span></a></li>
								@else
									<li><a href="{{ url('login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> <span>เข้าสู่ระบบ</span></a></li>
								@endif
							</ul>
						</li>
					
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="{{ url('/dataset') }}" class="{{ (strpos(url()->current(),'dataset') ) ? 'active' : '' }}"><i class="lnr lnr-home"></i> <span>ชุดข้อมูล</span></a></li>
						<li><a href="{{ url('/organization') }}" class="{{ (strpos(url()->current(),'organization') ) ? 'active' : '' }}"><i class="lnr lnr-user"></i> <span>องค์กร</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<div class="panel-body">
							<div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
									@yield('content')
								</div>
							</div>
						</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">&copy; 2018 Opendata. All Rights Reserved.</p>
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/jquery/jquery.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/bootstrap/js/bootstrap.min.js') }}

	{{ \AppHelper::instance()->gen_script('js','backend/assets/scripts/sweetalert.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/scripts/loadingoverlay.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/select2/select2.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/jquery-tags-input/dist/jquery.tagsinput.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/josecebe-twbs-pagination/jquery.twbsPagination.min.js') }}
	<!-- VENDOR CSS DATATABLE -->
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/datatables/jquery.dataTables.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/datatables/dataTables.buttons.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/datatables/buttons.flash.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/datatables/jszip.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/datatables/pdfmake.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/datatables/vfs_fonts.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/datatables/buttons.html5.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/datatables/buttons.print.min.js') }}

	<!-- VENDOR CSS DATETIMERANGE -->
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/daterangepicker/moment.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/daterangepicker/daterangepicker.min.js') }}

	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/vendor/chartist/js/chartist.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/scripts/klorofil-common.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/scripts/main.js') }}
	{{ \AppHelper::instance()->gen_script('js','backend/assets/scripts/module.js') }}
	<script>
		$(document).ready(function ($) {
			@yield('script')
		});
	</script>
</body>

</html>
