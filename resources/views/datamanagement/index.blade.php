@extends('master.layout')
@section('title', $title )
@section('header', $header )

@section('content')
<section class="">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="">
            <div class="panel panel-primary box_gradient" style="padding-top:10px;padding-bottom: 10px;">
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 10px;">
                        <?= link_to('/datamanagement/create', $title = 'เพิ่ม บริหารจัดการข้อมูล', ['class' => 'btn btn-primary'], $secure = null); ?>
                    </div>
                </div>
                <table class="table table-bordered non-datatable">
                    <thead>
                    <tr>
                        <th style="width: 3%;">#</th>
                        <th>หัวข้อ</th>
                        <th>ผู้ให้ข้อมูล</th>
                        <th>Database View</th>
                        <th class="text-center" style="width: 5%;">แก้ไข</th>
                        <th class="text-center" style="width: 5%;">ลบ</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($content as $k => $v)
                            <tr>
                                <td>{{$k + 1}}</td>
                                <td>{{$v->ep_title}}</td>
                                <td>{{$v->ep_contact_name}}</td>
                                <td>{{$v->ep_view}}</td>
                                <td>
                                    <a href="{{ url('/datamanagement/'.$v->ep_id.'/edit') }}">
                                        <button class="btn btn-warning">แก้ไข</button>
                                    </a>
                                </td>
                                <td>
                                    <button onclick="delete_datamanagement(this)" class="btn btn-danger" data="{{$v->ep_id}}">ลบ</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="block-pagi">
                    {{ $content->links("pagination::pagination-default") }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection