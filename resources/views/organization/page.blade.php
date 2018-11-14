@extends('master.layout')
@section('title', $title )
@section('header', $header )

@section('content')
<section class="">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        @if($is_login)
            <div class="col-md-12">
                <div class="text-right">
                    <a href="{{url('/organization/edit/'.$slug_url)}}">
                        <button type="submit" class="btn btn-primary"><span class="lnr lnr-cog"></span> จัดการ </button>
                    </a>
                </div>
            </div>
        @endif
        <div class="col-md-12" style="margin-bottom: 10px;margin-top: 10px;">
            <div class="row">
                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                    <div>
                        <div class="panel panel-primary">
                            <img src="{{ url('backend/assets/img/menu_fx.png') }}" class="img_top" >
                            <div class="panel-heading" style="padding-top: 10px;padding-bottom: 10px;">
                                <h3><img src="{{ url('backend/assets/img/icon_datasets.png') }}" > หมวดหมู่</h3>
                            </div>
                            <ul class="list-group" style="list-style: none;">
                                @foreach($get_cat as $k => $v)
                                <a  href="javascript:void(0)"  class="list-group-item categories search-data" data-id="{{$v->cat_id}}">
                                    <li class="">
                                        <img src="{{ url('backend/assets/img/icon_items.png') }}">  {{$v->cat_title}} <span class="badge-primary badge-pill">({{$v->num}})</span>
                                    </li>
                                </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="hidden">
                        <a href="javascript:void(0)" class="list-group-item organization search-data menu-active" data-id="{{ $ogz_id }}" ></a>
                        <input type="hidden" value="" id="unfilter">
                    </div>
                </div>

                <div class="col-md-9 col-lg-9 col-sm-12 col-xs-12" style="padding-left:0">
                    <div class="panel panel-primary box_gradient" style="padding-top:10px">
                        @if($is_login)
                            <div class="row">
                                <div class="col-md-12" style="margin-bottom: 10px;">
                                    <?=link_to('/dataset/new', $title = 'เพิ่ม ' . Define::DTS , ['class' => 'btn btn-primary'], $secure = null);?>
                                </div>
                            </div>
                        @endif
                        {!! Form::open(['url' => '#','class' => 'form-auth-small', 'method' => 'get']) !!}
                        <div class="row ">
                            <div class="col-md-7 col-xs-7" style="padding-right:10px">
                                <div class="form-group">
                                    <input type="text" class="form-control form_style" id="title" name="title" value="" placeholder="ค้นหา" required>
                                </div>
                            </div>
                            <div class="col-md-5 col-xs-5" style="padding-left:0px;padding-right: 20px;">
                                <div class="input-group my-colorpicker2 colorpicker-element box_select_search">
                                    <select class="form-control use-select2 search-data form_style" id="dts-order" >
                                        <option value="">การเรียกดู</option>
                                        <option value="view">ความนิยม</option>
                                        <option value="txt">ตัวอักษร</option>
                                        <option value="update">แก้ไขล่าสุด</option>
                                    </select>
                                    <div class="input-group-addon box_btn_search">
                                        <button type="button" class="btn search-data btn_search">
                                            <img  src="{{ url('backend/assets/img/icon_search.png') }}" > ค้นหา
                                        </button>
                                        <button type="button" class="btn clear-data btn_search" style="margin-left:5px">
                                            <img  src="{{ url('backend/assets/img/icon_reset.png') }}" > ค่าเริ่มต้น
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <div class="row" style="margin-bottom: 10px;display:none">
                            <div class="col-md-4 col-md-offset-8">
                                <select class="form-control use-select2 search-data" id="order">
                                    <option value="">การเรียกดู</option>
                                    <option value="view">ความนิยม</option>
                                    <option value="txt">ตัวอักษร</option>
                                    <option value="update">แก้ไขล่าสุด</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 featured-responsive">
                                <div class="box_headder">
                                    <div class="text_box_title" >
                                        <img src="{{ url('backend/assets/img/icon_topic.png') }}" >   {{ $ogz_title }}
                                    </div>   
                                    <img src="{{ url('backend/assets/img/topic_fx.png') }}" style="float:right">
                                </div>
                            </div>
                        </div>
                        <div class="row" id="result-data">

                        </div>
                        <div class="row">
                            <ul id="pagination" class="pagination pull-right"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
get_data();
@endsection