<?php

namespace App\Http\Controllers;

use Validator, Hash, DB;
use App\Models\evento;
use App\Models\User;
use Illuminate\Http\Request;

class EventoController extends Controller{

    public function create(Request $request){
        $temp_documento = $request->get('documento');
        $exit = User::where('numero_documento', $request->get('documento'))->count();
        $datos_persona = DB::select(DB::raw("SELECT `id` FROM `users` WHERE `numero_documento` = $temp_documento"));
        
        if($exit != 0){
            $id_persona = $datos_persona[0]->id;
        }else{
            $id_persona = null;
        }

        $validator = Validator::make($request->all(),[
            'id_empresa'=>'required',
            'temp'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        

        $evento = evento::create([
            'id_empresa' => $request->get('id_empresa'),
            'id_persona' => $id_persona,
            'temp_doc' => $request->get('documento'),
            'temp' => $request->get('temp'),
        ]);
        return response()->json(['status'=>'200','Message'=>'Dato registrado correctamente']);
    }
    public function list(){
        $evento = evento::all();
        return $evento;
    }
    public function list_persona($id_persona){
        $lista_persona = DB::select(DB::raw("SELECT persona.name AS nombre_persona, empresa.name AS nombre_empresa, empresa.direccion, evento.temp, evento.created_at FROM users AS persona, users AS empresa, evento WHERE evento.id_persona='$id_persona' AND persona.id =evento.id_persona AND empresa.id= evento.id_empresa"));
        return $lista_persona;
    }
    public function list_persona_doc($doc_persona){
        $exit = User::where('numero_documento', $doc_persona)->count();

        if($exit != 0){
            $lista_persona = DB::select(DB::raw("SELECT persona.name AS nombre_persona, empresa.name AS nombre_empresa, empresa.direccion, evento.temp, evento.created_at FROM users AS persona, users AS empresa, evento WHERE evento.temp_doc='$doc_persona' AND persona.id =evento.id_persona AND empresa.id= evento.id_empresa"));
            return $lista_persona;
        }else{
            $lista_persona = DB::select(DB::raw("SELECT empresa.name AS nombre_empresa, empresa.direccion, evento.temp, evento.temp_doc AS documento_persona, evento.created_at FROM users AS empresa, evento WHERE evento.temp_doc='$doc_persona' AND empresa.id= evento.id_empresa"));
            return $lista_persona;
        }
    }
    public function list_empresa($id_empresa){
        $lista_empresa = DB::select(DB::raw("SELECT persona.name AS nombre_persona, empresa.name AS nombre_empresa, empresa.direccion, evento.temp, evento.created_at FROM users AS persona, users AS empresa, evento WHERE evento.id_empresa='$id_empresa' AND persona.id =evento.id_persona AND empresa.id= evento.id_empresa"));
        return $lista_empresa;
    }
}

