<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index($search = null){
        if(!empty($search)){
            $users = User::where('nick', 'LIKE', '%'.$search.'%')
                        ->orWhere('name', 'LIKE', '%'.$search.'%')
                        ->orWhere('surname', 'LIKE', '%'.$search.'%')
                        ->orderBy('id', 'desc')->paginate(2);
        } else {
            $users = User::orderBy('id', 'desc')->paginate(5);
        }

        return view('user.index', [
            'users' => $users]);
    }

    public function config(){
        return view('user.config');
    }

    public function update(Request $request){
        // Identifica al usuario
        $user = \Auth::user();
        $id = $user->id;

        // Validación de los datos
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', Rule::unique('users', 'nick')->ignore($id, 'id')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($id, 'id')],
        ]);

        // Recibe los datos
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        // Asigna los nuevos valores al objeto usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        // Subir la imagen
        $image_path = $request->file('image_path');
        if($image_path){
            // Asigna un nombre único
            $image_path_name  = time().$image_path->getClientOriginalName();
            
            // Guarda en la carpeta storage (storage/app/users)
            Storage::disk('users')->put($image_path_name, File::get($image_path));

            // Seteo el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }

        // Ejecuta la actualización en la base de datos
        $user->update();

        // Redirige a la página de configuración con el mensaje de éxito
        return redirect()->route('config')
                        ->with(['message' => 'El usuario se ha actualizado correctamente.']);
    }

    // Obtengo la imagen en caso de tenerla
    public function getImage($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }

    public function profile($id){
        $user = User::find($id);

        return view('user.profile', [
            'user' => $user
        ]);
    }
}
