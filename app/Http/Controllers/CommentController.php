<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function save(Request $request){
        // Obtengo los datos del usuario logueado
        $user = \Auth::user();

        // Validación de los datos
        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content' => 'string|required'
        ]);

        // Obtengo los datos
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        //Asigno los datos
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        //Guardo los datos en la BD
        $comment->save();

        //Redirección
        return redirect()->route('images.detail', ['id' => $image_id])
                    ->with([
                        'message' => '¡Tu comentario ha sido publicado!',
                    ]);
    }

    public function delete($id){
        // Obtengo los datos del usuario logueado
        $user = \Auth::user();

        //Obtengo el objeto comentario
        $comment = Comment::find($id);

        //Comprobar si soy el dueño del comentario o de la publicación
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
            // Elimina el comentario
            $comment->delete();

            //Redirección
            return redirect()->route('images.detail', ['id' => $comment->image->id])
            ->with([
                'message' => '¡El comentario ha sido eliminado!',
            ]);
        }
    }
}
