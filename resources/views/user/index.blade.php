@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Buscar amigos</h1>
            <form method="GET" action="{{ route('user.index') }}" id="buscador">
                <div class="row">
                    <div class="form-group col">
                        <input type="text" id="search" class="form-control" placeholder="Buscar...">
                    </div>
                    <div class="form-group col btn-search">
                        <input type="submit" value="Buscar" class="btn btn-success">
                    </div>
                </div>   
            </form>
            <hr>
            @foreach ($users as $user)        
                <div class="profile-user">
                    <div class="container-avatar">
                        @if ($user->image)
                            <img src="{{ route('user.avatar', ['filename' => $user->image]) }}" class="avatar">
                        @endif
                    </div>
                    <div class="user-info">
                        <h2>{{ $user->name." ".$user->surname }}</h2>
                        <h4>{{ '@'.$user->nick }}</h4>
                        <p>Se unió desde: {{ \FormatTime::LongTimeFilter($user->created_at) }}</p>
                        <a href="{{ route('profile', ['id' => $user->id]) }}" class="btn btn-success">Ver perfil</a>
                    </div>
                </div>
                <hr>
            @endforeach

            <!-- Paginación -->
            <div class="clearfix"></div>
            {{ $users->links() }}

        </div>
    </div>
</div>
@endsection