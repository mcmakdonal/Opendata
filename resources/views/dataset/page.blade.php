@extends('master.layout') 
@section('title', $title ) 
@section('header', $header ) 
@section('content')
<section class="">
    <style>
    </style>
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Metadata</h4>
                </div>
                <div class="modal-body">

                    <table class="table table-bordered" style="text-align:center">
                        <tr>
                            <td>Field name</td>
                            <td>Description</td>
                            <td>Field type</td>
                            <td>Unit</td>
                        </tr>
                        @php
                            $size =count($metadata); 
                        @endphp 
                        @if ($size>0) 
                            @foreach($metadata as $k => $v)
                            <tr>
                                <td>{{ $v->mtd_field_name }}</td>
                                <td>{{ $v->mtd_description }}</td>
                                <td>{{ $v->mtd_field_type }}</td>
                                <td>{{ $v->mtd_unit }}</td>
                            </tr>
                            @endforeach 
                        @else (session('status'))
                            <tr>
                                <td colspan="4">ไม่มีข้อมูล</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <div class="panel panel-primary">
        <div class="row">

            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                <div class="row">

                    <div class="col-md-12" style="margin-bottom: 10px;margin-top: 10px;">
                        <div class="box_headder">
                            <div class="text_box_title">
                                <img src="{{ url('backend/assets/img/icon_topic.png') }}"> ชุดข้อมูล
                            </div>
                            <img src="{{ url('backend/assets/img/topic_fx.png') }}" style="float:right">
                        </div>

                        @if($is_login)
                        <div class="col-md-12" style="margin-bottom:10px">
                            <div class="text-right">
                                <a href="{{url('/dataset/edit/'.$slug_url)}}">
                                    <button type="submit" class="btn btn-primary"><span class="lnr lnr-cog"></span> Manage</button>
                                </a>
                            </div>
                        </div>
                        @endif




                        <div class="col-md-12">
                            @foreach($content as $k => $v)
                            <div class="row">

                                <div class="col-md-12 col-xs-12">


                                    <iframe id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true" class="twitter-share-button twitter-share-button-rendered twitter-tweet-button"
                                        style="position: static; visibility: visible; width: 60px; height: 20px;float:right;margin-left:5px"
                                        title="Twitter Tweet Button" src="https://platform.twitter.com/widgets/tweet_button.4ddf50b7ac5c5f06f6679f003b742641.en.html#dnt=false&amp;lang=en&amp;original_referer=https%3A%2F%2Fdeveloper.twitter.com%2Fen%2Fdocs%2Ftwitter-for-websites%2Ftweet-button%2Foverview.html&amp;related=twitterapi%2Ctwitter&amp;size=m&amp;time=1538465345598&amp;type=share&amp;url=http%3A%2F%2Fopendata.mc%2Fdataset%2Fpage%2F{{ $v->dts_url }}"
                                        data-url="http%3A%2F%2Fopendata.mc%2Fdataset%2Fpage%2F{{ $v->dts_url }}"></iframe>
                                    <iframe style="float:right" src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fgoo.gl%2FHDWS3H&layout=button_count&size=small&mobile_iframe=true&appId=1740813262901995&width=64&height=20"
                                        width="72" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0"
                                        allowTransparency="true" allow="encrypted-media"></iframe>
                                    <div>
                                        <h3> <img src="{{ url('backend/assets/img/icon_items_pink.png') }}"> {{ $v->dts_title
                                            }} <span class="star"> {{ $v->dts_res_point }} </span> </h3>
                                        <p>{{ $v->dts_description }}</p>
                                        <p>หน่วยงาน : {{ $v->ogz_title }} - ลิขสิทธิ์ : {{ $v->license }} </p>
                                        <p>หมวดหมู่ : {{ $v->cat_title }} - วันที่ปรับปรุงข้อมูล : {{ \AppHelper::instance()->DateThai($v->update_date)
                                            }} </p>
                                        <p class="tags">{{ $v->dts_tag }}</p>
                                        <p>Metadata : <a href="/get_matadata/{{ $v->dts_id }}" target="_blank">ดูข้อมูล</a>
                                            <a href="/get_matadata/{{ $v->dts_id }}" style="margin-left:15px" target="_blank" download>downlaod</a>
                                        </p>
                                    </div>
                                </div>
                                @if(($is_login) && $v->dts_status == "pv")
                                <div class="col-md-12 col-xs-12 ">
                                    <h3 class="text-right"> <span class="label label-primary"> <span class="lnr lnr-lock"></span> ส่วนตัว </span>
                                    </h3>
                                </div>
                                @endif

                                <div class="col-md-12">
                                    <h4> <img src="{{ url('backend/assets/img/icon_items_pink.png') }}"> แหล่งข้อมูล</h4>
                                    <div class="list-group">
                                        @foreach($resource as $k => $v)
                                        <div class="list-group-item list-group-item-action">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    @php $file_format = "backend/assets/img/".$v->file_format.".png"; 
@endphp
                                                    <!-- <h5> <i class="fa fa-file-{{ $file_format }}-o" aria-hidden="true"></i> {{ $v->file_name }} </h5> -->
                                                    <h5> <img src="{{ url($file_format  ) }}"> {{ $v->file_name }} </h5>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-right">
                                                        @if($is_login)
                                                        <a href="{{ url('/dataset/page/'.$slug_url.'/resource_edit/'.$v->file_slug) }}">
                                                                <button type="button" class="btn btn-primary">Edit</button>
                                                            </a>                                                        @endif
                                                        <a href="javascript:void(0)" class="download-file" data="{{ url($v->file_path) }}" data-id="{{ $v->res_id }}">
                                                            <button type="button" class="btn btn-success">Download</button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <h4> <img src="{{ url('backend/assets/img/icon_items_pink.png') }}"> คำอธิบายเพิ่มเติม</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>หมวดหมู่</th>
                                                <th>คำอธิบาย</th>
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
                                                <td>{{ ($content[0]->dts_status == "pb")? "สาธารณะ" : "ส่วนตัว" }}</td>
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
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            @endforeach

                        </div>

                        <div class="col-md-2 hidden-xs hidden-sm"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    @include('shared.modal-download')
@endsection