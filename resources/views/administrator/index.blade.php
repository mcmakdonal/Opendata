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
                        <?= link_to('/administrator/create', $title = 'เพิ่ม ผู้ดูแลระบบ', ['class' => 'btn btn-primary'], $secure = null); ?>
                    </div>
                </div>
                <table class="table table-bordered datatable">
                    <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>Username</th>
                        <th class="text-center" style="width: 5%;">แก้ไข</th>
                        <th class="text-center" style="width: 5%;">ลบ</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($administrator as $k => $v)
                            @if($v->admin_id != 1)
                                <tr>
                                    <td>{{$k + 1}}</td>
                                    <td>{{$v->first_name}}</td>
                                    <td>{{$v->last_name}}</td>
                                    <td>{{$v->username}}</td>
                                    <td>
                                        <a href="{{ url('/administrator/'.$v->admin_id.'/edit') }}">
                                            <button class="btn btn-warning">แก้ไข</button>
                                        </a>
                                    </td>
                                    <td>
                                        <button onclick="delete_admin(this)" class="btn btn-danger" data="{{$v->admin_id}}">ลบ</button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection