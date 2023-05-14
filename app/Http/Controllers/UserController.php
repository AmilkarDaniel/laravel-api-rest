<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        $inputs["password"] = Hash::make(trim($request->passport));
        $e = User::create($inputs);
        return response()->json([
            'data'=>$e,
            'mensaje'=>'Creado.',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $e = User::find($id);
        if(isset($e)){
            return response()->json([
                'data'=>$e,
                'mensaje'=>'Encontrado.',
            ]);
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>'No existe.',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $e = User::find($id);
        if(isset($e)){
            $e->first_name = $request->first_name;
            $e->last_name = $request->last_name;
            $e->email = $request->email;
            $e->password = Hash::make($request->passport);
            if($e->save()){
                return response()->json([
                    'data'=>$e,
                    'mensaje'=>'Actualizado.',
                ]);
            }else{
                return response()->json([
                    'error'=>true,
                    'mensaje'=>'No actualizo.',
                ]);
            }
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>'No existe.',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $e = User::find($id);
        if(isset($e)){
            $res = User::destroy($id);
            if($res){
                return response()->json([
                    'data'=>$e,
                    'mensaje'=>'Eliminado.',
                ]);
            }else{
                return response()->json([
                    'data'=>[],
                    'mensaje'=>'No Encontrado.',
                ]);
            }
            
        }else{
            return response()->json([
                'error'=>true,
                'mensaje'=>'No existe.',
            ]);
        }
    }
}
