@extends('master.layout')
@section('title', $title )
@section('header', $header )

@section('content')
<section class="">
    <div class="row">
        <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
            <div>
                <div class="panel panel-primary">
                    <div class="panel-heading" style="padding-top: 10px;padding-bottom: 10px;">
                        <h3><i class="fa fa-bars" aria-hidden="true"></i> Organizations </h3>
                    </div>
                    <ul class="list-group" style="list-style: none;">
                        @foreach($get_ogz_count as $k => $v)
                            <a  href="javascript:void(0)" class="list-group-item organization search-data" data-id={{ $v->ogz_id }}>
                                <li class="">
                                    {{$v->ogz_title}} <span class="badge-primary badge-pill">({{$v->num}})</span>
                                </li>
                            </a>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div>
                <div class="panel panel-primary">
                    <div class="panel-heading" style="padding-top: 10px;padding-bottom: 10px;">
                        <h3><i class="fa fa-file" aria-hidden="true"></i> Formats</h3>
                    </div>
                    <ul class="list-group" style="list-style: none;">
                        @foreach($file_format as $k => $v)
                        <a  href="javascript:void(0)"  class="list-group-item format search-data" data-id="{{$v->file_format}}">
                            <li class="">
                                {{$v->file_format}} <span class="badge-primary badge-pill">({{$v->num}})</span>
                            </li>
                        </a>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div>
                <div class="panel panel-primary">
                    <div class="panel-heading" style="padding-top: 10px;padding-bottom: 10px;">
                        <h3><i class="fa fa-filter" aria-hidden="true"></i> Licenses</h3>
                    </div>
                    <ul class="list-group" style="list-style: none;">
                        @foreach($get_lcs as $k => $v)
                        <a  href="javascript:void(0)"  class="list-group-item license search-data" data-id="{{$v->lcs_id}}">
                            <li class="">
                                {{$v->license}} <span class="badge-primary badge-pill">({{$v->num}})</span>
                            </li>
                        </a>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div>
                <div class="panel panel-primary">
                    <div class="panel-heading" style="padding-top: 10px;padding-bottom: 10px;">
                        <h3><i class="fa fa-filter" aria-hidden="true"></i> Categories</h3>
                    </div>
                    <ul class="list-group" style="list-style: none;">
                        @foreach($get_cat as $k => $v)
                        <a  href="javascript:void(0)"  class="list-group-item categories search-data" data-id="{{$v->cat_id}}">
                            <li class="">
                                {{$v->cat_title}} <span class="badge-primary badge-pill">({{$v->num}})</span>
                            </li>
                        </a>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
            @if($is_login)
            <div class="row">
                <div class="col-md-12" style="margin-bottom: 10px;">
                    <?=link_to('/dataset/new', $title = 'Add Dataset', ['class' => 'btn btn-primary'], $secure = null);?>
                </div>
            </div>
            @endif
            {!! Form::open(['url' => '#','class' => 'form-auth-small', 'method' => 'get']) !!}
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" value="" placeholder="ค้นหา" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-success search-data">Search</button>
                        <button type="button" class="btn btn-warning clear-data">Reset</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-4 col-md-offset-8">
                    <select class="form-control use-select2 search-data" id="order">
                        <option value="">การเรียกดู</option>
                        <option value="view">ความนิยม</option>
                        <option value="txt">ตัวอักษร</option>
                        <option value="update">แก้ไขล่าสุด</option>
                    </select>
                </div>
            </div>
            <div class="row" id="result-data">

            <div>
        </div>
    </div>
</section>
@endsection

@section('script')
get_data();
@endsection