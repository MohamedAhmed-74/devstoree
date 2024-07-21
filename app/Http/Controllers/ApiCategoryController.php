<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class ApiCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function all()
    {
       $categories = Category::all();
       return CategoryResource::collection($categories);
    }
    public function show($id){
        $category = Category::find($id);

        if($category == null)
        return response()->json(
    [
        "message" => "Category not found",
        "status_code" => 404,

    ],404);

            return new CategoryResource($category);
}

public function create(Request $request){
    $validator = Validator::make($request->all(),[
        'name' => 'required|string|max:255',
    ]);


    if($validator->fails()){
        return response()->json(
            [
                "message" =>$validator->errors(),
                "status_code" => 400,
            ] , 400 );
            }

        $result = Category::create(
                [
                    'name' => $request->name,
                ]
            );

       return response()->json(
        ["message" => "Category added Successfully",
        "status_code" => 200,
        ],200);

        }





    //     public function update(Request $request){
    //         $validator = Validator::make($request->all(),[
    //             'name' => 'required|string|max:255',
    //         ]);
    //         if($validator->fails()){
    //             return response()->json(
    //                 [
    //                     "message" =>$validator->errors(),
    //                     "status_code" => 400,
    //                 ] , 400 );

    //     }
    //     $category = Category::find($request->id);
    //     if ($category == null){
    //         return response()->json(
    //             [
    //                 "message" => "Category not found",
    //                 "status_code" => 404,
    //             ],404);
    //     }
    //     $category->update([
    //         'name' => $request->name,
    //     ]);

    //    return response()->json(
    //     ["message" => "Category updated Successfully",
    //     "status_code" => 200,
    //     ],200);

    // }
    // public function delete($id){
    //     $category = Category::find($id);
    //     if ($category == null){
    //         return response()->json(
    //             [
    //                 "message" => "Category not found",
    //                 "status_code" => 404,
    //             ],404);
    //     }
    //     $category->delete();

    //    return response()->json(
    //     ["message" => "Category deleted Successfully",
    //     "status_code" => 200,
    //     ],200);
    // }



    /**
     * Store a newly created resource in storage.
     */
//     public function store(Request $request)
//     {
//         //
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(Category $category)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, Category $category)
//     {
//         //
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(Category $category)
//     {
//         //
//     }
// }

}