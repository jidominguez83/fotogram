@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="profile-user">
                <div class="container-avatar">
                    @if ($user->image)
                        <img src="{{ route('user.avatar', ['filename' => $user->image]) }}" class="avatar">
                    @endif
                </div>
                <div class="user-info">
                    <h1>{{ $user->name." ".$user->surname }}</h1>
                    <h3>{{ '@'.$user->nick }}</h3>
                    <p>Se unió desde: {{ \FormatTime::LongTimeFilter($user->created_at) }}</p>
                </div>
            </div>
            <hr>
            <div class="clearfix"></div>

            @foreach ($user->images as $image)        
                @include('includes.image', ['image' => $image])
            @endforeach
        </div>
    </div>
</div>
@endsection