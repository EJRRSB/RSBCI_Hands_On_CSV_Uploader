@extends('layouts.app')  
        
@section('content')
<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div> 
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> -->


<div class="container">
    <div class="row">  

        <div class="col-3 p-5">
            <img src="{{$user->profile->profileImage()}}" class="w-100 rounded-circle"/> 
        </div> 

        <div class="col-9 p-5">


            <div class="d-flex justify-content-between align-items-basline">
                
                <div class="d-flex align-items-center pb-4">
                    <h1>{{ $user->username }}</h1>

                    <button class="btn btn-primary ml-4">Follow</button>
                </div>  

                 
                @can('update', $user->profile)
                    <a href ="/post/create" class="btn btn-primary" style ="height:40px;">Add New Post</a>
                @endcan
            </div>

            @can('update', $user->profile)
                <a href = "/profile/{{$user->id}}/edit">Edit Profile</a>
            @endcan

            <div class ="d-flex">
                <div class="pr-5"><strong>{{ $user->post->count() }}</strong> posts</div> 
                <div class="pr-5"><strong>127</strong> followers</div> 
                <div class="pr-5"><strong>127</strong> following</div> 
            </div>

            <div class = "pt-4 font-weigth-bold">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <div><a href ="#">{{ $user->profile->url }}</a></div>


            <div class ="row">
 
                @foreach($user->post as $postinfo)
                    <div class="col-4">
                        <a href="/post/{{ $postinfo->id }}">
                            <img src ="/storage/{{ $postinfo->image }}" class ="w-100 h-50">
                        </a>
                    </div> 
                @endforeach

            </div>

        </div>
    </div>

</div>
@endsection