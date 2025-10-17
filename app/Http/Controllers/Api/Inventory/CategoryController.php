<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    public function index(){
        return response()->json(Category::all(),200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:50|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>'error',
                'message' =>'Validation Failed',
                'errors'=>$validator()->errors()
            ], 422);
        }

        $category =Category::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $category,
        ],201);


    }

    public function show(Category $category){
        return response()->json($category,200);
    }

    public function update(Request $request, Category $category){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:50|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>'error',
                'message' =>'Validation Failed',
                'errors'=>$validator()->errors()
            ], 422);
        }

        $category->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $category,
        ],200);


    }
    public function destroy(Category $category){
        $category->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully.',
        ],204);
    }
}
