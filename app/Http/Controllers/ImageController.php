<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Like;

class ImageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function create(){
        return view('images.create');
    }

    public function save(Request $request){
        // Validación de los datos
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'required|image'
        ]);

        // Recoger los datos
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        // Asignar valores al objeto
        $user = \Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        $image->description = $description;

        // Subir archivo
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        $image->save();

        return redirect()->route('home')
                        ->with([
                            'message' => 'La foto se subió correctamente.'
                        ]);
    }

    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    public function detail($id){
        $image = Image::find($id);

        return view('images.detail', [
            'image' => $image
        ]);
    }

    public function delete($id){
        $user = \Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        if(($user && $image) && ($image->user->id == $user->id)){
            // Elimina los comentarios
            if(count($comments) > 0){
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }

            // Elimina los likes
            if(count($likes) > 0){
                foreach ($likes as $like) {
                    $like->delete();
                }
            }

            // Elimina la imagen
            Storage::disk('images')->delete($image->image_path);

            // Elimina el registro de la imagen
            $image->delete();

            $message = array('message' => 'La imagen se ha borrado correctamente.');
        } else {
            $message = array('message' => 'La imagen no se ha borrado.');
        }

        // Redirecciona
        return redirect()->route('home')->with($message);
    }

    public function edit($id){
        $user = \Auth::user();
        $image = Image::find($id);

        if($user && $image && $image->user->id == $user->id){
            return view('images.edit', ['image' => $image]);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request){
        // Recoge los datos
        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        // Validación de los datos
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'image'
        ]);

        // Conseguir el objeto imagen
        $image = Image::find($image_id);
        $image->description = $description;

        // Subir archivo
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        // Actualiza la imagen y/o la descripción
        $image->update();

        // Redirecciona
        return redirect()->route('images.detail', ['id' => $image_id])
                                ->with(['message' => 'Foto actualizada correctamente.']);
    }
}