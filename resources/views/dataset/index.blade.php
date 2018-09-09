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
                        <h3><i class="fa fa-bars" aria-hidden="true"></i> Organizations</h3>
                    </div>
                    <ul class="list-group" style="list-style: none;">
                        @foreach($ogz as $k => $v)
                        @php
                            $url = "?slug=".$v->url;
                            $blank_url = "/dataset";
                        @endphp
                        <a  href="{{ ($slug_sec)? $blank_url : $url }}" class="list-group-item">
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
            @csrf
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <input type="text" class="form-control" id="" name="" value="" placeholder="" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Search</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <div class="row">
                <div class="col-md-12 featured-responsive">
                    <div class="list-group">
                        @foreach($get_dts as $k => $v)
                            <a href="{{ url('/dataset/page/'.$v->url) }}" class="list-group-item list-group-item-action">
                                <h5> <span class="badge badge-secondary">{{ ($v->status == "pb")?"Public":"Private" }}</span> {{$v->title}} </h5>
                                <p>{{ $v->description }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            <div>
        </div>
    </div>
</section>
@endsection