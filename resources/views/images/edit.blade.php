@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @if ($errors->has('image_path'))
            <div class="alert alert-success">
                {{ $errors->first('image_path') }}
            </div>
        @endif
            <div class="card">
                <div class="card-header">Editar mi foto</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('image.update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="image_id" value="{{ $image->id }}">
                        <div class="row mb-3">
                            <label for="image_path" class="col-md-4 col-form-label text-md-end">{{ __('Foto actual') }}</label>

                            <div class="col-md-6">
                                @if ($image->user->image)
                                    <div class="container-avatar">
                                        <img src="{{ route('image.file', ['filename' => $image->image_path]) }}" class="avatar">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="image_path" class="col-md-4 col-form-label text-md-end">{{ __('Cambia la foto') }}</label>

                            <div class="col-md-6">
                                <input id="image_path" type="file" class="form-control @error('image_path') is-invalid @enderror" name="image_path" autocomplete="image_path">

                                @error('image_path')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Cambia el pie de foto') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" >{{ $image->description }}</textarea>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Actualizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection