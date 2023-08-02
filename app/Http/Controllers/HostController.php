<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Http;
class HostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('hosts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hosts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $http = new Http();
        $body = [
            'url' => $request->url,
        ];
        $respuesta = $http -> post('hosts',$body);
        if($respuesta->res=='true'){
            $success = $respuesta->msg;
            return redirect()->route('hosts.index')->with('success',$success);
        }else{
            $error = $respuesta->errors->url[0];
            return redirect()->route('hosts.index')->with('error',$error);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $http = new Http();
        $respuesta = $http -> get('hosts/'.$id);
        if($respuesta->res=='true'){
            return view('hosts.edit',compact('respuesta','id'));
        }else{
            $error = $respuesta->error;
            return redirect()->route('hosts.index')->with('error',$error);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $http = new Http();
        $body = [
            'url' => $request->url
        ];
        $respuesta = $http -> upd('hosts/'.$id,$body);
        if($respuesta->res=='true'){
            $success = $respuesta -> msg;
            return redirect()->route('hosts.index')->with('success',$success);
        }else{
            $error = $respuesta->errors->url[0];
            return redirect()->route('hosts.index')->with('error',$error);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $http = new Http();
        $respuesta = $http -> del('hosts/'.$id);
        if($respuesta->res=='true'){
            $success = $respuesta->msg;
            return redirect()->route('hosts.index')->with('success',$success);
        }else{
            $error = $respuesta->error;
            return redirect()->route('hosts.index')->with('error',$error);
        }
    }
}
