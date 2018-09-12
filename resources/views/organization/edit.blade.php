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
    
    <div class="text-right">
        <a href="{{url('/organization/page/'.$slug_url)}}">
            <button type="submit" class="btn btn-primary"><span class="lnr lnr-eye"></span> View Organization</button>
        </a>
    </div>

    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a data-toggle="tab" href="#edit"><span class="lnr lnr-pencil"></span> Edit</a></li>
        <li><a data-toggle="tab" href="#datasets"><span class="lnr lnr-cloud-download"></span> Datasets</a></li>
        <li><a data-toggle="tab" href="#member"><span class="lnr lnr-users"></span> Members</a></li>
    </ul>

    <div class="tab-content">
        <div id="edit" class="tab-pane fade in active">

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            {!! Form::open(['url' => '/organization/update','class' => 'form-auth-small', 'method' => 'put','files' => true]) !!}
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title" class="control-label">Title : </label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $content[0]->title }}" placeholder="ชื่อ" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="URL" class="control-label">Url : </label>
                        <div class="input-group">
                            <span class="input-group-addon">/organization/page/</span>
                            <input type="text" name="url" id="url" value="{{ $content[0]->url }}" class="form-control" placeholder="my-organization" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description" class="control-label">Description : </label>
                        <textarea class="form-control" id="description" name="description" rows="3" style="resize : none;">{{ $content[0]->description }}</textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="Image" class="control-label">Image : </label>
                        <input class="form-control" type="file" name="image" id="image">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="Image" class="control-label">Image : </label>
                        <img src="{{ url($content[0]->image) }}" class="img-responsive" style="width: 120px;">
                        <input type="hidden" value="{{$content[0]->image}}" name="old_image">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="control-label">สถานะ : </label>
                        <select class="form-control use-select2" name="status" id="status">
                            <option value="pb" {{ ($content[0]->status == "pb")? "selected" : "" }} >Public</option>
                            <option value="pv" {{ ($content[0]->status == "pv")? "selected" : "" }} >Private</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <button type="button" class="btn btn-danger" onclick="remove_ogz(this,'{{$slug_url}}')" data="{{ url('/organization/delete') }}" >Delete Organization</button>
                </div>

                <div class="col-md-6 text-right">
                    <input type="hidden" value="{{ $slug_url }}" name="slug_url">
                    <button type="submit" class="btn btn-success">Update Organization</button>
                    <?=link_to('/organization', $title = 'Cancel', ['class' => 'btn btn-warning'], $secure = null);?>
                </div>
            </div>
            {!! Form::close() !!}

        </div>

        <div id="datasets" class="tab-pane fade">
            <div class="row">
                <div class="col-md-12" style="margin-bottom: 10px;">
                    <?= link_to('/dataset/new?ogz='.$slug_url, $title = 'Add Daataset', ['class' => 'btn btn-primary'], $secure = null); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th><button type="button" class="btn btn-block" onclick="set_status_dts('pb')"><i class="fa fa-eye" aria-hidden="true"></i> Make Public</button></th>
                                <th><button type="button" class="btn btn-block" onclick="set_status_dts('pv')"><i class="fa fa-eye-slash" aria-hidden="true"></i> Make Private</button></th>
                                <th><button type="button" class="btn btn-block btn-danger" onclick="set_status_dts('del')"><i class="fa fa-chain-broken" aria-hidden="true"></i> Delete</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataset as $k => $v)
                            <tr>
                                <td>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="url" value="{{$v->url}}"></label>
                                    </div>
                                </td>
                                <td colspan="3">
                                    <h5> <span class="badge badge-secondary">{{ ($v->status == "pb")?"Public":"Private" }}</span> {{$v->title}} </h5>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div id="member" class="tab-pane fade">
            <h3>Menu 2</h3>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
        </div>

    </div>

</section>
@endsection