<?php

namespace App\Http\Controllers;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiProductController extends Controller
{
    public function show($id){
        $product = Product::find($id);

        if($product == null)
        return response()->json(
    [
        "message" => "product not found",
        "status_code" => 404,

    ],404);

            return new ProductResource($product);
}

}
