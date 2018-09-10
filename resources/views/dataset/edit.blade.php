@extends('master.layout')
@section('title', $title )

@section('content')
<section class="">

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
                            <label for="title" class="control-label">Title : </label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $tbl_dataset[0]->title }}" placeholder="ชื่อ" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="URL" class="control-label">Url : </label>
                            <div class="input-group">
                                <span class="input-group-addon">/dataset/page/</span>
                                <input type="text" name="url" id="url" value="{{ $tbl_dataset[0]->url }}" class="form-control" placeholder="my-dataset" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description" class="control-label">Description : </label>
                            <textarea class="form-control" id="description" name="description" rows="3" style="resize : none;">{{ $tbl_dataset[0]->description }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="control-label">License : </label>
                            <select class="form-control use-select2" name="lcs_id" id="lcs_id" required>
                                @foreach($get_lcs as $k => $v)
                                    <option value="{{ $v->lcs_id }}" {{ ($tbl_dataset[0]->lcs_id == $v->lcs_id)? "selected" : "" }} >{{ $v->license }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="control-label">Organization : </label>
                            <select class="form-control use-select2" name="ogz_id" id="ogz_id" required>
                                @foreach($get_ogz as $k => $v)
                                    <option value="{{ $v->ogz_id }}" {{ ($tbl_dataset[0]->ogz_id == $v->ogz_id)? "selected" : "" }} >{{ $v->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="control-label">สถานะ : </label>
                            <select class="form-control use-select2" name="status" id="status">
                                <option value="pb" {{ ($tbl_dataset[0]->status == "pb")? "selected" : "" }} >Public</option>
                                <option value="pv" {{ ($tbl_dataset[0]->status == "pv")? "selected" : "" }} >Private</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <button class="btn btn-danger" type="button" onclick="remove_dts(this,'{{$slug_url}}')" data="{{ url('/dataset/delete') }}">Delete Dataset</button>
                    </div>

                    <div class="col-md-6 text-right">
                        <input type="hidden" value="{{ $tbl_dataset[0]->dts_id }}" name="dts_id">
                        <button type="submit" class="btn btn-success">Update Dataset</button>
                        <?=link_to('/dataset', $title = 'Cancel', ['class' => 'btn btn-warning'], $secure = null);?>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
        <div id="resouce" class="tab-pane fade"><br>
            <div class="row">
                <div class="col-md-12 featured-responsive">
                    <?=link_to('/dataset/new_resource/' . $slug_url, $title = 'Add New Resource', ['class' => 'btn btn-primary'], $secure = null);?>
                    <div class="list-group" style="margin-top: 10px;">
                        @foreach($resource as $k => $v)
                        <div class="list-group-item list-group-item-action">
                            <div class="row">
                                <div class="col">
                                    <h5 style="margin-left: 5px;"> <span class="badge badge-secondary">{{ strtoupper($v->file_format) }}</span> {{ $v->file_name }} </h5>
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