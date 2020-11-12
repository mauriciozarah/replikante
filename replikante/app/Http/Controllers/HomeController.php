<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('status', '1')->orderBy('user_id', 'desc')->get();
        return response()->json(['users' => $users]);
    }

    public function save(Request $request){

        $this->validate($request, [
            'name' => 'required|min:3|max:191',
            'email' => 'required|min:3|max:191|email|unique:users',
            'password_confirmation' => 'required_with:password|same:password|min:3|max:191'
        ]);

        $user = new User();

        $user->name          = $request->name;
        $user->email         = $request->email;
        $user->password      = $request->password;
        $user->status        = "1";

        $user->save();


    }


    public function addExe(Request $request){
        //$this->validate($request, $this->rule($request));

        $this->validate($request, [
            'name'  => 'required|min:3|max:191',
            'email' => 'required|email|min:3|max:191|unique:users',
            'password_confirmation' => 'required_with:password|same:password|min:3|max:191'
        ]);
        
        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = $request->password;
        $user->status   = "1";
        $user->save();
        
     

        return response()->json(['resp' => "Cadastrado com Sucesso"], 200);
    }


    public function callEdit(Request $request){
        
            $id   = $request->query('hash');
            //$id   = $request->hash();
            $user = User::find($id);
            
            return response()->json(["user" => $user], 200);
            //echo json_encode(['user' => 'testando']);
        
    }



    public function editExe(Request $request)
    {
        //$this->validate($request, $this->rule2($request));
        $this->validate($request, [
            'name'  => 'required|min:3|max:191',
            'email' => 'required|email|min:3|max:191'
        ]);

        $ID = $request['c_edit'];




        /**
         * 
         *  Regra: se o E-mail novo for diferente do e-mail antigo eh necessario que se verifique se o novo e-mail ja nao consta na base de dados
         *         se ja constar na base de dados invalida a edicao
         * 
        */

        
        if($request['email'] != $request['email_old']):
            $res = User::where('email', '=', $request['email'])->first();
            if($res):
                return response()->json(['resp' => 'Este E-mail ja existe no nosso banco de dados.'], 203);
                exit;
            endif;
        endif;
        
        

        /**
         * 
         *  Atualizando o usuario
         * 
         */
        
            

        $user = User::find($ID);
        $user->name  = $request['name'];
        $user->email = $request['email'];
 
        if($request['password'] != ""):
            $user->password = $request['password'];
        endif;


        $user->save();
       

        return response()->json(['resp' => "Editado com Sucesso"], 200);
    }




    public function ajax(Request $request){
        
            $order = "asc";
            $field = "name";
  
            if($request->query('order')):
                $order = $request->query('order');
            endif;
            if($request->query('field')):
                $field = $request->query('field');
            endif;

            $resultSet = User::where('status','1')->orderBy($field, $order)->get();
            
            return response()->json(['resultSet' => $resultSet]);
        
    }

    public function search(Request $request){
        
            $order = "asc";
            $field = "name";
            $search = $request->query('search');
            
            if($request->query('order')):
                $order = $request->query('order');
            endif;
            if($request->query('field')):
                $field = $request->query('field');
            endif;

            $resultSet = User::where(function ($query) use ($search) {
                $query->where('status','=','1');
            })->where(function ($query) use ($search){
                $query->where('email', 'like', '%' . $search . '%')
                       ->orWhere('name', 'like', '%' . $search . '%');
            })->orderBy($field, $order)->get();
            
            return response()->json(['resultSet' => $resultSet], 200);
            //return response()->json(['search' => $request->query('search'), 'result' => 'success']);
        
    }


    public function delete(Request $request){
        //Telefone::where('id_user', '=', $request->query('code'))->delete();
        //User::where('user_id', '=', $request->query('code') )->delete();
        //return response()->json(['resp' => 'Deletado com sucesso.'], 200);

        $user = User::where('user_id', '=', $request->query('code'))->first();
        $user->status = "0";
        $user->save();
        return response()->json(['status', 'Deletado com Sucesso']);
    }


    public function rule(){
        return [
            "name"     => "required|max:255|string",
            "email"    => "required|email|max:255|unique:users",
            "password" => "required|min:8|confirmed"
        ];
    }

    public function rule2(){
        return [
            "name"       => "required|max:255|string",
            "email"      => "required|email|max:255",
            "email_old"  => "required|email|max:255",
            "c_edit"     => "required|string"
        ];
    }


    public function rule1(){
        return [
            "email" => "required|email|max:50"
        ];
    }
}
