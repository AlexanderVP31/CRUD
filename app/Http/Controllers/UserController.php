<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Listado de usuarios
    public function listar(){
        $data['users'] = Usuario::paginate(5);

        return view('usuarios.listar', $data);
    }

    //Formulario de usuarios
    public function userform(){
        return view('usuarios.userform');
    }

    //Guardar usuario
    public function save(Request $request){

        $validator = $this->validate($request, [
            'nombre'=> 'required|string|max:255',
            'email'=> 'required|string|max:255|email|unique:usuarios'

        ]);
        $userdata = request()->except('_token');
        Usuario::insert($userdata);


        return back()->with('usuarioGuardado','Usuario guardado');
    }

    //Eliminar usuarios
    public function delete($id){
        Usuario::destroy($id);

        return back()->with('usuarioEliminado','Usuario eliminado');
    }

    //Formulario para editar usuarios
    public function editform($id){
        $usuario = Usuario::findOrFail($id);

        return view('usuarios.editform', compact('usuario'));
    }

    //Edición de usuarios
    public function edit(Request $request, $id){
        $datosUsuario = request()->except((['_token', '_method']));
        Usuario::where('id', '=', $id)->update($datosUsuario);

        return back()->with('usuarioModificado','Usuario modificado');
    }
}
