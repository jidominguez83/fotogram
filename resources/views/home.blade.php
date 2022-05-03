@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.message')

            @if (count($images) < 1)
                <h4>No existen fotos tuyas o de tus amigos. <a href="{{ route('images.create') }}">¡Publica una!</a></h4>
            @else
                @foreach ($images as $image)
                    @include('includes.image', ['image' => $image])
                @endforeach
            @endif

            <!-- Paginación -->
            <div class="clearfix"></div>
            {{ $images->links() }}

        </div>
    </div>
</div>
@endsection