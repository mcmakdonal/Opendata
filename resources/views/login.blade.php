<!doctype html>
<html lang="en">

<head>
  <title>Opendata - {{$title}}</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <link href="https://fonts.googleapis.com/css?family=Pridi:300,400,600,700" rel="stylesheet">
  <!------ Include the above in your HEAD tag ---------->
  <!-- ICONS -->
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('backend/assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('backend/assets/img/favicon.png') }}">
</head>
<style>
  @media only screen and (max-width: 700px) {
    .right-box {
      width: 100% !important;
    }
    .feed-box {
      display: none !important;
    }
  }

  .login-box-body {
    box-shadow: -30px 30px 50px rgba(0, 0, 0, 0.32);
    border-radius: 4px;
    text-align: center;
  }

  body {
    height: 100%;
    background: #dddddd;
    font-family: 'Pridi';
  }

  .right-box {
    float: right;
    width: 30%;
    height: 100%;
    padding: 10px 60px 0px;
  }

  .fedd-img {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    top: 0;
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: top center;
  }

  .feed-box {
    position: fixed;
    left: 0;
    /* right: 500px; */
    top: 0;
    bottom: 0;
    width: 70%;
    -webkit-transform: translateZ(0);
    transform: translateZ(0);
    overflow: hidden;
  }

  .caption {
    color: rgba(255, 255, 255, .75);
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 60px 60px 30px;
    font-size: 18px;
    z-index: 20;
    font-weight: 300;
    background: -moz-linear-gradient(top, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 1) 100%);
    background: -webkit-linear-gradient(top, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 1) 100%);
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0, rgba(0, 0, 0, 1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#000000', GradientType=0);
  }

  .caption-title {
    color: #fff;
    font-weight: 300;
    font-size: 36px;
  }

  .login {
    height: 46px;
    padding: 10px 16px;
    line-height: 1.3333333;
    border-radius: 6px;
  }

  .btn-login {
    font-size: 16px;
    line-height: 24px;
    padding: 10px 16px;
    background: #C42191;
    color: white;
  }

  #box-header {
    position: relative;
    font-size: 30px;
    margin-bottom: 15px;
    text-align: center;
  }

  #box-header>span>i {
    color: #009688;
  }

  #box-header>div {
    color: #707478;
    font-size: 16px;
  }

  .form-control-feedback {
    top: 5px !important;
    right: 5px !important;
  }

  hr {
    border: none;
    height: 1px;
    background: #f1f3f5;
    margin-top: 1rem;
    margin-bottom: 1rem;
    box-sizing: content-box;
    overflow: visible;
    display: block;
    unicode-bidi: isolate;
    -webkit-margin-before: 0.5em;
    -webkit-margin-after: 0.5em;
    -webkit-margin-start: auto;
    -webkit-margin-end: auto;
  }
</style>

<body>


  <div class="feed-box">
    <div class="fedd-img" style="background-image: url(/backend/assets/img/login_bg_.png)"></div>
  </div>

  <div class="right-box">
    <div id="box-header">
      <img src="/backend/assets/img/logo_login_.png">
    </div>
    {!! Form::open(['url' => '/chk_login','class' => 'form-auth-small', 'method' => 'post','files' => true]) !!}

    <div class="form-group has-feedback" id="id_pass" style="color: red;text-align: right;display:none;">
      Email หรือ Password ไม่ถูกต้อง
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div class="form-group has-feedback">
      <input type="text" id="username" class="form-control login" name="username" placeholder="ชื่อผู้ใช้">
      <span class="glyphicon glyphicon-envelope "></span>
    </div>
    <div class="form-group has-feedback">
      <input type="password" id="pass" name="password" class="form-control login" placeholder="รหัสผ่าน">
      <i class="glyphicon glyphicon-lock "></i>
    </div>
    <div class="col-xs-12" style="margin-top: 20px;">

      <button type="submit" class="btn  btn-block btn-login">เข้าสู่ระบบ</button>
    </div>
    <div class="col-xs-12">
      <div style="margin-top: 20px;color: #707478;">

      </div>
    </div>
    <div class="col-xs-12" style="margin-top:50px">
      <hr>
      <p class="text-center text-grey-darker">
        © Mculture
      </p>
    </div>
    {!! Form::close() !!}

  </div>