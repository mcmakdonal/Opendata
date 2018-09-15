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
        {{-- <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
            <div style="">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Firstname</th>
                        <th>Lastname</th>
                    </tr>
                </thead>
                    <tbody>
                        <tr>
                            <td>John</td>
                            <td>Doe</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> --}}
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
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
                                    <div class="col-md-6 col-xs-12"><h3>{{ $v->dts_title }}</h3></div>
                                    @if(($is_login) && $v->dts_status == "pv")
                                        <div class="col-md-6 col-xs-12 "><h3 class="text-right"> <span class="label label-primary"> <span class="lnr lnr-lock"></span> Private </span> </h3></div>
                                    @endif
                                </div>
                                <p>{{ $v->dts_description }}</p>
                            @endforeach

                            <h4>Data and Resources</h4>
                            <div class="row">
                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Field</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Organization</td>
                                                <td>{{ $content[0]->ogz_title }}</td>
                                            </tr>
                                            <tr>
                                                <td>Licenses</td>
                                                <td>{{ $content[0]->license }}</td>
                                            </tr>
                                            <tr>
                                                <td>หมวดหมู่</td>
                                                <td>{{ $content[0]->cat_title }}</td>
                                            </tr>
                                            <tr>
                                                <td>วันที่เพิ่มข้อมูล</td>
                                                <td>{{ \AppHelper::instance()->DateThai($content[0]->create_date) }}</td>
                                            </tr>
                                            <tr>
                                                <td>ขอบเขตเชิงภูมิศาสตร์</td>
                                                <td>{{ $content[0]->dts_scope_geo }}</td>
                                            </tr>
                                            <tr>
                                                <td>ป้ายกำกับ</td>
                                                <td>{{ $content[0]->dts_tag }}</td>
                                            </tr>
                                            <tr>
                                                <td>ชื่อผู้ติดต่อ</td>
                                                <td>{{ $content[0]->dts_contact_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>อีเมลผู้ติดต่อ</td>
                                                <td>{{ $content[0]->dts_contact_email }}</td>
                                            </tr>
                                            <tr>
                                                <td>ระดับการเข้าถึง</td>
                                                <td>{{ ($content[0]->dts_status == "pb")? "Public" : "Private" }}</td>
                                            </tr>

                                            <tr>
                                                <td>สิทธิ์ในการเข้าถึงข้อมูล</td>
                                                <td>{{ $content[0]->dts_permission }}</td>
                                            </tr>
                                            <tr>
                                                <td>ความถี่ในการปรับปรุงข้อมูล</td>
                                                <td>{{ $get_frequent[$content[0]->dts_frequent] }}</td>
                                            </tr>
                                            <tr>
                                                <td>วันที่ปรับปรุงข้อมูล</td>
                                                <td>{{ \AppHelper::instance()->DateThai($content[0]->update_date) }}</td>
                                            </tr>
                                            <tr>
                                                <td>คะแนนการเปิดเผย</td>
                                                <td>
                                                    @for($i = 0; $i < $content[0]->dts_res_point; $i++)
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    @endfor
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>เข้าชม</td>
                                                <td>{{ $content[0]->dts_view }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
