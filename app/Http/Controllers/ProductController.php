<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //
    public function create(){
        $sellers = User::all();
        $categories = Category::all();
        return view('products.create',['sellers' => $sellers , 'categories' => $categories]);
    }

    public function store()
    {
       $data = request()->validate([
            'name'=>['required' , 'min:3'],
            'price'=>['required'],
            'file'=>['required'],
            'image'=>['required','max:10000','mimes:png,jpg,jpeg,gif'],
            'description'=>['required'],
            'seller'=>['required'],
            'category'=>['required']
            ]);
        $name = request()->name;
        $price = request()->price;
        $file = request()->file('file');
        $images = request()->file('image');
        $description = request()->description;
        $seller = request()->seller;
        $category = request()->category;

        $file = Storage::put('uploads',$file);

        $product =  Product::create([
            'name'=>$name,
            'price'=>$price,
            'description'=> $description,
            'file' => $file,
            'user_id'=>$seller,
            'category_id'=>$category
        ]);

        $images = Storage::put('uploads',$images);
        $project_id = $product->id;
        Image::create([
          'product_id' => $project_id,
          'image_name' => $images,
        ]);
        return view('products.success');
    }
    public function show()
    {
        $productFromDb = Product::all();
        $pp = $productFromDb ->all();
        $name = $productFromDb->name();
        return $name;
    }
}
