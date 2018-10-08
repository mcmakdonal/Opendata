@extends('master.layout')
@section('title', $title )
@section('header', $header )

@section('content')
<section class="">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="">
            <div class="panel panel-primary box_gradient" style="padding-top:10px;padding-bottom: 10px;">
                <table class="table table-bordered datatable">
                    <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th>ชื่อไฟล์</th>
                        <th>Download โดย</th>
                        <th>วันที่ Download</th>
                        <th class="text-center" style="width: 10%;">รายละเอียด</th>
                        <th class="text-center hidden">data</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($log as $k => $v)
                            <tr>
                                <td>{{ $v->dnl_id }}</td>
                                <td>{{ $v->file_name }}</td>
                                <td>{{ $v->first_name }}  {{ $v->last_name }} </td>
                                <td>{{ \AppHelper::instance()->DateThai($v->create_date) }}</td>
                                <td class="text-center"><button class="btn btn-info show-log-desc" data-id="{{ $v->dnl_id }}" type="button">Detail</button></td>
                                <td class="hidden" id="data_{{ $v->dnl_id }}">{{$v->description}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modal-log-desc" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Description</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => '','class' => 'form-cat', 'method' => 'post']) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cat_title" class="control-label">รายละเอียดการ Download : </label>
                            <textarea class="form-control" id="description_txt" rows="5" style="resize:none;" disabled></textarea>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">

            </div>
        </div>
        
    </div>
</div>

@endsection