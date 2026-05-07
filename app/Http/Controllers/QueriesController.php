<?php

namespace App\Http\Controllers;

use App\Http\Requests\QueriesRequest;
use Illuminate\Http\Request;
use Apps\Model\Query;

class QueriesController extends Controller
{
    public function index(){
        return view('pages.queries');
    }
    public function query_store(QueriesRequest $request){
        $datos = $request->validated();
        return redirect()->back()->with('success', 'Se ha enviado la consulta');
    }


}
