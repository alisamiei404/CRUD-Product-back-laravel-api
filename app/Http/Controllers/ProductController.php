<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateProductImageRequest;
use App\Models\Product;


class ProductController extends Controller
{
    public function allProduct()
    {
        $products = Product::orderByDesc('id')->get();

        return response()->json([
            'products' => $products
        ]);
    }

    public function singleProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'product' => $product
        ]);
    }

    public function createProduct(CreateProductRequest $request)
    {
      $name = '';
      if($request->has('image')){
        $image = $request->file('image');

        $name = time().'.'.$image->getClientOriginalExtension();
        $image->move('images/',$name);
      }
      $product = Product::create([
          'title' => $request->title,
          'slug' => $request->slug,
          'image' => $name,
          'price' => $request->price,
          'count' => $request->count,
          'status' => $request->status === "true" ? 1 : 0
      ]);

      return true;
    }

    public function updateProduct(UpdateProductRequest $request, $id)
    {
      $product = Product::findOrFail($id);
      $product->title = $request->title;
      $product->slug = $request->slug;
      $product->price = $request->price;
      $product->count = $request->count;
      $product->status =$request->status ? 1 : 0;
      $product->save();
      return $product;
    }

    public function updateProductImage(UpdateProductImageRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $name = '';
        if($request->has('image')){
          $image = $request->file('image');

          $name = time().'.'.$image->getClientOriginalExtension();
          $image->move('images/',$name);

          if($product->image)
          {
            $image_path = "images/".$product->image;
            if (File::exists(public_path($image_path))) 
            {
              File::delete(public_path($image_path));
            }
          }

          $product->image = $name;
          $product->save();
        }
        
        return $product;
    }

    public function deleteProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if($product->image)
        {
          $image_path = "images/".$product->image;
          if (File::exists(public_path($image_path))) 
          {
            File::delete(public_path($image_path));
          }
        }
        
        return $product->delete();
    }
}
