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
        <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
            <div style="">

            </div>
        </div>
        <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
            <div class="row">
                @if($is_login)
                    <div class="col-md-12">
                        <div class="text-right">
                            <a href="{{url('/dataset/edit/'.$slug_url)}}">
                                <button type="submit" class="btn btn-primary"><span class="lnr lnr-cog"></span> Manage</button>
                            </a>
                        </div>
                    </div>
                @endif
                <div class="col-md-12" style="margin-bottom: 10px;">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="active"><a data-toggle="tab" href="#dataset">Home</a></li>
                        <li><a data-toggle="tab" href="#groups">Groups</a></li>
                        <li><a data-toggle="tab" href="#activity">Activity Stream</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="dataset" class="tab-pane fade in active">
                            @foreach($content as $k => $v)
                                <div class="row">
                                    <div class="col-md-6 col-xs-12"><h3>{{ $v->title }}</h3></div>
                                    @if(($is_login) && $v->status == "pv")
                                        <div class="col-md-6 col-xs-12 "><h3 class="text-right"> <span class="label label-primary"> <span class="lnr lnr-lock"></span> Private </span> </h3></div>
                                    @endif
                                </div>
                                <p>{{ $v->description }}</p>
                            @endforeach

                            <h4>Data and Resources</h4>
                            <div class="list-group">
                                @foreach($resource as $k => $v)
                                <div class="list-group-item list-group-item-action">
                                    <div class="row">
                                        <div class="col-md-6">
                                        @php
                                            $file_format = $v->file_format;
                                            if($v->file_format == "txt" || $v->file_format == "json"){
                                                $file_format = "text";
                                            }elseif($v->file_format == "png" || $v->file_format == "jpeg" || $v->file_format == "jpg"){
                                                $file_format = "image";
                                            }
                                        @endphp
                                            <h5> <i class="fa fa-file-{{ $file_format }}-o" aria-hidden="true"></i> {{ $v->file_name }} </h5>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-right">

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                    Explore <span class="caret"></span></button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{ url('/dataset/page/'.$slug_url.'/resource/'.$v->file_slug) }}"><span class="lnr lnr-picture"></span> Preview</a></li>
                                                        <li><a href="javascript:void(0)" class="download-file" data="{{ url($v->file_path) }}" data-id="{{ $v->res_id }}"><span class="lnr lnr-download"></span> Download</a></li>
                                                        @if($is_login)
                                                            <li><a href="{{ url('/dataset/page/'.$slug_url.'/resource_edit/'.$v->file_slug) }}"><span class="lnr lnr-pencil"></span> Edit</a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>
                        <div id="groups" class="tab-pane fade">
                            <h3>Menu 1</h3>
                            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                        <div id="activity" class="tab-pane fadee">
                            <h3>Menu 2</h3>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('shared.modal-download')
@endsection
