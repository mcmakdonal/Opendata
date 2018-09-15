@extends('master.layout')
@section('title', $title )

@section('content')
<section class="">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="text-right">
        <a href="{{url('/dataset/page/'.$slug_url)}}">
            <button type="button" class="btn btn-primary"><span class="lnr lnr-eye"></span> View Dataset</button>
        </a>
    </div>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#dataset"><span class="lnr lnr-pencil"></span> Edit metadata</a></li>
        <li><a data-toggle="tab" href="#resouce"><span class="lnr lnr-cloud-download"></span> Resource</a></li>
    </ul>

    <div class="tab-content">
        <div id="dataset" class="tab-pane fade in active"><br>

            {!! Form::open(['url' => '/dataset/update','class' => 'form-auth-small', 'method' => 'put','files' => true]) !!}
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title" class="control-label">ชื่อ Dataset : </label>
                            <input type="text" class="form-control" id="dts_title" name="dts_title" value="{{ $tbl_dataset[0]->dts_title }}" placeholder="ชื่อ Dataset" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="URL" class="control-label">Url : </label>
                            <div class="input-group">
                                <span class="input-group-addon">/dataset/page/</span>
                                <input type="text" name="dts_url" id="dts_url" value="{{ $tbl_dataset[0]->dts_url }}" class="form-control" placeholder="my-dataset" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description" class="control-label">รายละเอียด : </label>
                            <textarea class="form-control" id="dts_description" name="dts_description" rows="3" style="resize : none;">{{ $tbl_dataset[0]->dts_description }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="dts_scope_geo" class="control-label">ขอบเขตภูมิศาสตร์ : </label>
                            <input type="text" class="form-control" id="dts_scope_geo" name="dts_scope_geo" value="{{ $tbl_dataset[0]->dts_scope_geo }}" placeholder="ขอบเขตภูมิศาสตร์" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="dts_tag" class="control-label">ป้ายกำกับ : </label>
                            <input type="text" class="form-control tag-input" id="dts_tag" name="dts_tag" value="{{ $tbl_dataset[0]->dts_tag }}" placeholder="ป้ายกำกับ">
                            <span class="label label-warning">ใส่คำที่ต้องการจากนั้นกด enter</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dts_contact_name" class="control-label">ชื่อผู้ใช้ข้อมูล : </label>
                            <input type="text" class="form-control" id="dts_contact_name" name="dts_contact_name" value="{{ $tbl_dataset[0]->dts_contact_name }}" placeholder="ชื่อผู้ใช้ข้อมูล" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dts_contact_email" class="control-label">อีเมลผู้ให้ข้อมูล : </label>
                            <input type="email" class="form-control" id="dts_contact_email" name="dts_contact_email" value="{{ $tbl_dataset[0]->dts_contact_email }}" placeholder="อีเมลผู้ให้ข้อมูล" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dts_permission" class="control-label">สิทธิ์ในการเข้าถึงข้อมูล : </label>
                            <input type="text" class="form-control" id="dts_permission" name="dts_permission" value="{{ $tbl_dataset[0]->dts_permission }}" placeholder="สิทธิ์ในการเข้าถึงข้อมูล" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dts_frequent" class="control-label">ความถี่ในการปรับปรุง : </label>
                            <select class="form-control use-select2" name="dts_frequent" id="dts_frequent" required>
                                @foreach ($get_frequent as $k => $v )
                                    <option value="{{$k}}" {{ ($tbl_dataset[0]->dts_frequent == $k)? "selected" : "" }} >{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <hr style="display:none;" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">License : </label>
                            <select class="form-control use-select2" name="lcs_id" id="lcs_id" required>
                                @foreach($get_lcs as $k => $v)
                                    <option value="{{ $v->lcs_id }}" {{ ($tbl_dataset[0]->lcs_id == $v->lcs_id)? "selected" : "" }} >{{ $v->license }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Organization : </label>
                            <select class="form-control use-select2" name="ogz_id" id="ogz_id" required>
                                @foreach($get_ogz as $k => $v)
                                    <option value="{{ $v->ogz_id }}" {{ ($tbl_dataset[0]->ogz_id == $v->ogz_id)? "selected" : "" }} >{{ $v->ogz_title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Categories : </label>
                            <select class="form-control use-select2" name="cat_id" id="cat_id" required>
                                @foreach($get_cat as $k => $v)
                                    <option value="{{ $v->cat_id }}" {{ ($tbl_dataset[0]->cat_id == $v->cat_id)? "selected" : "" }} >{{ $v->cat_title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">สถานะ : </label>
                            <select class="form-control use-select2" name="dts_status" id="dts_status">
                                <option value="pb" {{ ($tbl_dataset[0]->dts_status == "pb")? "selected" : "" }} >Public</option>
                                <option value="pv" {{ ($tbl_dataset[0]->dts_status == "pv")? "selected" : "" }} >Private</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <button class="btn btn-danger" type="button" onclick="remove_dts(this,'{{$slug_url}}')" data="{{ url('/dataset/delete') }}">Delete Dataset</button>
                    </div>

                    <div class="col-md-6 text-right">
                        <input type="hidden" value="{{ $tbl_dataset[0]->dts_id }}" name="dts_id">
                        <button type="submit" class="btn btn-success">Update Dataset</button>
                        <?=link_to('/dataset/page/'.$slug_url, $title = 'Cancel', ['class' => 'btn btn-warning'], $secure = null);?>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
        <div id="resouce" class="tab-pane fade"><br>
            <div class="row">
                <div class="col-md-12 featured-responsive">
                    <?=link_to('/resource/new_resource/' . $slug_url, $title = 'Add New Resource', ['class' => 'btn btn-primary'], $secure = null);?>
                    <div class="list-group" style="margin-top: 10px;">
                        @foreach($resource as $k => $v)
                        <div class="list-group-item list-group-item-action">
                            <div class="row">
                                <div class="col-md-12">
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
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection