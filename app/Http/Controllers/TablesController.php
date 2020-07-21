<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tables;

class TablesController extends Controller
{
    public function createTable(Request $request){
        $tavolo = Tables::create($request->all());
        return response()->json($tavolo);
    }

    public function getTables(){
        $tavoli = Tables::all();
        return response()->json($tavoli);
    }

    public function updateTable(Request $request, $id){
        $tavolo = Tables::where('id',$id)
            ->update($request->all());
        return response()->json($tavolo);
    }

    public function deleteTable($id){
        $tavolo = Tables::where('id',$id);
        return $tavolo->delete();
    }
}
