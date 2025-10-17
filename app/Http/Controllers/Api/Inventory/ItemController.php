<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    //
    public function index(Request $request){
        $query = Item::query();

        // 1. Search Feature Logic
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('name','like',"%{$searchTerm}%")->orWhere('description','like',"%{$searchTerm}%");
        }
        // 2. Eager load the category relationship
        $items = $query->with('category')->get();

        return ItemResource::collection($items);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'category_id' => "nullable|exists:categories,id",
            'stock_level' => "required|integer|min:0",
            'price' => "required|numeric|min:0.01",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>'error',
                'message' =>'Validation Failed',
                'errors'=>$validator()->errors()
            ], 422);
        }

        $item = Item::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Item created successfully.',
            'data' => new ItemResource($item->load('category'))
        ],201);

    }

    public function show(Item $item){
        return new ItemResource($item->load('category'));
    }

    public function update(Request $request, Item $item){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'category_id' => "nullable|exists:categories,id",
            'stock_level' => "required|integer|min:0",
            'price' => "required|numeric|min:0.01",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>'error',
                'message' =>'Validation Failed',
                'errors'=>$validator()->errors()
            ], 422);
        }

        $item->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Item created successfully.',
            'data' => new ItemResource($item->load('category'))
        ],200);
    }


    public function destroy(Item $item){
            $item->delete();
            return response()->json([
            'status' => 'success',
            'message' => 'Item created successfully.',
            ],200);
    }
}

