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
        @if($is_login)
            <div class="col-md-12">
                <div class="text-right">
                    <a href="{{url('/organization/edit/'.$slug_url)}}">
                        <button type="submit" class="btn btn-primary"><span class="lnr lnr-cog"></span> Manage</button>
                    </a>
                </div>
            </div>
        @endif
        <div class="col-md-12" style="margin-bottom: 10px;">

                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a data-toggle="tab" href="#edit">Edit</a></li>
                    <li><a data-toggle="tab" href="#activity">Activity Stream</a></li>
                    <li><a data-toggle="tab" href="#about">About</a></li>
                </ul>

                <div class="tab-content">
                    <div id="edit" class="tab-pane fade in active"><br>
                        @if($is_login)
                            <div class="row">
                                <div class="col-md-12" style="margin-bottom: 10px;">
                                    <?= link_to('/dataset/new?ogz='.$slug_url, $title = 'Add Daataset', ['class' => 'btn btn-primary'], $secure = null); ?>
                                </div>
                            </div>
                        @endif
                        {!! Form::open(['url' => url()->current(),'class' => 'form-auth-small', 'method' => 'get']) !!}
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="title" name="title" value="{{$search}}" placeholder="คำค้นหา" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Search</button>
                                    <a href="{{ $real_url }} "><button type="button" class="btn btn-warning">Reset</button></a>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <div class="row">
                            <div class="col-md-12">
                            <h3> {{count($content)}} Datasets</h3>
                                <div class="list-group">
                                    @foreach($content as $k => $v)
                                        <a href="{{ url('/dataset/page/'.$v->dts_url) }}" class="list-group-item list-group-item-action">
                                            <h5> 
                                                @if($is_login) 
                                                    <span class="badge badge-secondary">{{ ($v->dts_status == "pb")?"Public":"Private" }}</span>
                                                @endif 
                                            {{$v->dts_title}} 
                                            </h5>
                                            <p>{{ $v->dts_description }}</p> 
                                        </a>
                                    @endforeach       
                                </div>            
                            </div>
                        </div>

                    </div>

                    <div id="activity" class="tab-pane fade"><br>
                        <h3>Menu 1</h3>
                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    </div>

                    <div id="about" class="tab-pane fade"><br>
                        <h3>Menu 2</h3>
                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                    </div>

                </div>
        </div>
    </div>

</section>
@endsection