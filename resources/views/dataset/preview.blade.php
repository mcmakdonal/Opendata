@extends('master.layout')
@section('title', $title )
@section('header', $header )

@section('content')
<section class="">
    <div class="row">
        <div class="col-md-12">
            <div class="text-right">
                @if($is_login)
                    <a href="{{url('/dataset/page/'.$slug_url.'/resource_edit/'.$res_slug)}}">
                        <button type="button" class="btn btn-primary"><span class="lnr lnr-cog"></span> จัดการ</button>
                    </a>
                @endif
                <a class="download-file" href="javascript:void(0)" data="{{ url($get_res[0]->file_path) }}" data-id="{{ $get_res[0]->res_id }}">
                    <button type="button" class="btn btn-default"><span class="lnr lnr-download"></span> ดาวน์โหลด</button>
                </a>
            </div>
        </div>

        <div class="col-md-12" style="margin-bottom: 10px;margin-top: 10px;">
            <h3>{{ $get_res[0]->file_name }}</h3>
            <h4>ลิงก์ถาวร : <a href="javascript:void(0)" class="download-file" data="{{ url($get_res[0]->file_path) }}" data-id="{{ $get_res[0]->res_id }}" style="cursor: pointer;">{{ url($get_res[0]->file_path) }}</a> </h4>
            <p>{{ $get_res[0]->file_desc }}</p>
        </div>

        <div class="col-md-12" style="margin-bottom: 10px;margin-top: 10px;">
            <iframe src="{{ url($get_res[0]->file_path) }}" style="width: 100%;height: 600px;">
            </iframe>
        </div>

    </div>
</section>
@include('shared.modal-download')
@endsection
