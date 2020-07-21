<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;

class CategoriesController extends Controller
{
    public function createCategory(Request $request){
        $category = Categories::create($request->all());
        return response()->json($category);
    }

    public function getCategories(){
        $categories = Categories::all();
        return response()->json($categories);
    }

    public function updateCategory(Request $request, $id){
        $category = Categories::where('id',$id)
            ->update($request->all());
        return response()->json($category);
    }

    public function deleteCategory($id){
        $category = Categories::where('id',$id);
        return $category->delete();
    }
}
