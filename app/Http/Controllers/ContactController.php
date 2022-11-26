<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    //
    public function index(){
        //trayendo todos los contactos
        $contacts=Contact::all();
        
        $data = [
            'code' => 200,
            'status' => 'success',
            'contacts' => $contacts
        ];

        //retornando json
        return response()->json($data,$data['code']);
    }

    public function search(Request $request){
        $contacts=new Contact();
        
        if(isset($request->search)){
            //filtrando por el parametro de busqueda
            $contacts= $contacts->orwhere('name','like','%'.$request->search.'%');
            $contacts=$contacts->orwhere('phone','like','%'.$request->search.'%');
            $contacts=$contacts->orwhere('email','like','%'.$request->search.'%');
        }
        
        $contacts=$contacts->get();


        $data = [
            'code' => 200,
            'status' => 'success',
            'contacts' => $contacts
        ];

        //retornando json
        return response()->json($data,$data['code']);
    }

    public function show($id){
        $contact=Contact::whereraw('id = ?',$id)->first();
    
        $data = [
            'code' => 200,
            'status' => 'success',
            'contact' => $contact
        ];

        //retornando json
        return response()->json($data,$data['code']);
    }
    public function store(Request $request){
        //valida los campos
        $validate=\Validator::make($request->all(), [      
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:5|max:10',
            'address' => 'required|string|max:400',
            'date_birth' => 'required|date|date_format:Y-m-d',
            'email' => 'required|email:rfc,dns|unique:contacts,email',
            ]);
        //retornando errores
        if ($validate->fails()) {
            $data = [
                'code' => 404,
                'status' => 'error',
                'errors' => $validate->errors()
            ];
         
            return response()->json($data,$data['code']);
        }

        //haciendo referencia a los parametros que vamos a guardar
        $contact=new Contact();
        $contact->name=$request->name;
        $contact->phone=$request->phone;
        $contact->address=$request->address;
        $contact->date_birth=$request->date_birth;
        $contact->email=$request->email;
        //en caso de que no guarde
        $data = [
            'code' => 400,
            'status' => 'error',
            'message' => 'Errores al guardar'
        ];
        //guardado con exito
        if($contact->save()){
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'guardado con exito' 
            ];

        }
        //retornando json
        return response()->json($data,$data['code']);
    }
    public function update(Request $request,$id){
        //valida los campos
        $data=$request->all();
        $data['id']=$id;
        
        $validate=\Validator::make($data, [      
            'phone' => 'required|string|min:5|max:10',
            'address' => 'required|string|max:400',
            'email' => 'required|email:rfc,dns|unique:contacts,email',
            'id'=>'required|exists:contacts,id'
            ]);
        //retornando errores
        if ($validate->fails()) {
            $data = [
                'code' => 404,
                'status' => 'error',
                'errors' => $validate->errors()
            ];
         
            return response()->json($data,$data['code']);
        }

        $contact=Contact::whereraw('id = ?',$id)->first();
        //en caso de que no guarde
        $data = [
            'code' => 400,
            'status' => 'error',
            'message' => 'El contacto no existe'
        ];
        //guardado con exito
        if(!empty($contact)){
             //haciendo referencia a los parametros que vamos a guardar
        
            $contact->phone=$request->phone;
            $contact->address=$request->address;
            $contact->email=$request->email;
            $contact->save();
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'guardado con exito' 
            ];

        }
        //retornando json
        return response()->json($data,$data['code']);
    }
    public function destroy($id){
        //valida los campos
       
        $data['id']=$id;
        
        $validate=\Validator::make($data, [      
            'id'=>'required|exists:contacts,id'
            ]);
        //retornando errores
        if ($validate->fails()) {
            $data = [
                'code' => 404,
                'status' => 'error',
                'errors' => $validate->errors()
            ];
         
            return response()->json($data,$data['code']);
        }

        $contact=Contact::whereraw('id = ?',$id)->first();
        //en caso de que no guarde
        $data = [
            'code' => 400,
            'status' => 'error',
            'message' => 'El contacto no existe'
        ];
        //guardado con exito
        if(!empty($contact)){
             //haciendo referencia a los parametros que vamos a guardar
        
        
            $contact->delete();
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Eliminado con exito' 
            ];

        }
        //retornando json
        return response()->json($data,$data['code']);
    }
}
