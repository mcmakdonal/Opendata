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
                        @foreach($ogz as $k => $v)
                            @if($slug_sec)
                                <a  href="" class="list-group-item">
                            @else
                                <a  href="{{ '?slug='.$v->url }}" class="list-group-item">
                            @endif
                                <li class="">
                                    {{$v->title}} <span class="badge-primary badge-pill">({{$v->num}})</span>
                                    @if($slug_sec)
                                        <span class="badge" style="float: right;"><i class="fa fa-window-close" aria-hidden="true"></i></span>
                                    @endif
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
                        <a  href="?format={{$v->file_format}}"  class="list-group-item">
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
                        <a  href="?lcs={{$v->license}}"  class="list-group-item">
                            <li class="">
                                {{$v->license}} <span class="badge-primary badge-pill">({{$v->num}})</span>
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
            {!! Form::open(['url' => url()->current(),'class' => 'form-auth-small', 'method' => 'get']) !!}
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" value="" placeholder="ค้นหา" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Search</button>
                        <a href="/dataset"><button type="button" class="btn btn-warning">Reset</button></a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <div class="row">
                <div class="col-md-2 col-xs-3">
                    <p>Search : </p>
                </div>
                <div class="col-md-10 col-xs-9">
                    @foreach($param as $k => $v)
                        @if($v != "")
                            <span class="label label-default">{{$v}}</span>&nbsp;
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 featured-responsive">
                    <div class="list-group">
                        @foreach($get_join_dts as $k => $v)
                            <a href="{{ url('/dataset/page/'.$v->url) }}" class="list-group-item list-group-item-action">
                                <h5>
                                    @if($is_login)
                                        <span class="badge badge-secondary">{{ ($v->status == "pb")?"Public":"Private" }}
                                        </span> {{$v->title}} 
                                    @endif
                                </h5>
                                <p>{{ $v->description }}</p>
                                @foreach(explode(",",$v->format) as $f)
                                    <span class="label label-primary">{{$f}}</span>
                                @endforeach
                            </a>
                        @endforeach
                    </div>
                </div>
            <div>
        </div>
    </div>
</section>
@endsection