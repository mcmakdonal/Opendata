@extends('master.layout')
@section('title', $title )
@section('header', $header )

@section('content')
<section class="">

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
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="" name="" value="" placeholder="" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-block">Search</button>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        <div class="row">
                            <div class="col-md-12">
                            <h3> {{count($content)}} Datasets found</h3>
                                <div class="list-group">
                                    @foreach($content as $k => $v)
                                        <a href="{{ url('/dataset/page/'.$v->url) }}" class="list-group-item list-group-item-action"> 
                                            <h5> <span class="badge badge-secondary">{{ ($v->status == "pb")?"Public":"Private" }}</span> {{$v->title}} </h5>
                                            <p>{{ $v->description }}</p> 
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