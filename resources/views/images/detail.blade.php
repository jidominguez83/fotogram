@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('includes.message')    
                <div class="card pub_image pub_image_detail">
                    <div class="card-header">
                        @if ($image->user->image)
                            <div class="container-avatar">
                                <img src="{{ route('user.avatar', ['filename' => $image->user->image]) }}" class="avatar">
                            </div>
                        @endif
                        <div class="data-user">
                            {{ $image->user->name.' '.$image->user->surname }} 
                            <span class="nickname">
                                {{ ' | @'.$image->user->nick }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="image-container-detail">
                            <img src="{{ route('image.file', ['filename' => $image->image_path]) }}">
                        </div>
                        @if ($image->user->id == Auth::user()->id)
                        <div class="actions">
                            <a href="" class="btn btn-sm btn-primary">Actualizar</a>
                            
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#myModal">
                                Borrar
                            </button>

                            <!-- The Modal -->
                            <div class="modal" id="myModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">¿Deseas continuar?</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            Estas a punto de borrar definitivamente la foto, ¿deseas continuar?
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-success" data-bs-dismiss="modal">Cancelar</button>
                                            <a href="{{ route('image.delete',  ['id' => $image->id]) }}" class="btn btn-sm btn-danger">Borrar definitivamente</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                        </div>
                        <div class="description">
                            <span class="nickname">
                                {{ '@'.$image->user->nick.' | '.\FormatTime::LongTimeFilter($image->created_at) }}
                            </span>
                            <p>{{ $image->description }}</p>
                        </div>

                        <div class="likes">
                            <?php $user_like = false; ?>
                            @foreach ($image->likes as $like)
                                @if ($like->user->id == Auth::user()->id)
                                    <?php $user_like = true; ?>
                                @endif
                            @endforeach

                            @if ($user_like)
                                <img src="{{ asset('img/heart-red.png') }}" data-id="{{ $image->id }}" class="btn-dislike">
                            @else
                                <img src="{{ asset('img/heart-gray.png') }}" data-id="{{ $image->id }}" class="btn-like">
                            @endif
                            
                            <span class="number-likes">{{ count($image->likes) }}</span>
                        </div>

                        <div class="clearfix"></div>

                        <div class="comments">
                            <h3>Comentarios ({{ count($image->comments) }})</h2>
                            <hr>
                            <form method="POST" action="{{ route('comment.save') }}">
                                @csrf
                                <input type="hidden" name="image_id" value="{{ $image->id }}">
                                <p>
                                    <textarea name="content" id="content" class="form-control {{ $errors->first('content') ? 'is-invalid' : '' }}" placeholder="Añade un comentario..." required></textarea>
                                    @if($errors->has('content'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('content') }}</strong>
                                        </span>
                                    @endif
                                </p>
                                <button type="submit" class="btn btn-success">Publicar</button>
                            </form>
                            <hr>
                            @foreach ($image->comments as $comment)
                                <div class="comment">
                                    <span class="nickname">
                                        {{ '@'.$comment->user->nick.' | '.\FormatTime::LongTimeFilter($comment->created_at) }}
                                    </span>
                                    <p>
                                        {{ $comment->content }}
                                        @if (Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                            &nbsp;&nbsp;<a href="{{ route('comment.delete', ['id' => $comment->id]) }}"><img src="{{ asset('img/delete.png') }}" name="delete" title="Borrar comentario"></a>
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection