<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;



class ProductController extends Controller

{
    public function index()
    {
        $product = Product::all();
        return response()->json([
            'status' => 200,
            'product' => $product,
        ]);
    }

    public function edit($id)

    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                'status' => 200,
                'product' => $product,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Product Id Found',
            ]);
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'slug' => 'required|max:191',
            'category_id' => 'required|max:191',
            'qty' => 'numeric',


            'img01' => 'required|image|mimes:jpeg,jpg,png',
            'img02' => 'required|image|mimes:jpeg,jpg,png',

            'orginal_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'qty' => 'required|numeric',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ]);
        } else {
            $product = new Product;
            $product->name = $request->input('name');
            $product->category_id = $request->input('category_id');
            $product->description = $request->input('description');
            $product->slug = $request->input('slug');
            $product->qty = $request->input('qty');

            $product->orginal_price = $request->input('orginal_price');
            $product->selling_price = $request->input('selling_price');


            $product->popular = $request->input('popular') == true ? '1' : '0';
            $product->featured = $request->input('featured') == true ? '1' : '0';
            $product->status = $request->input('status') == true ? '1' : '0';
            if ($request->hasFile('img02')) {

             
                $file = $request->file('img02');

                $extension = $file->getClientOriginalExtension();

                $filename = time() + 1 . '.' . $extension;

                $file->move('uploads/product/', $filename);

                $product->img02 = 'uploads/product/' . $filename;
            }

            if ($request->hasFile('img01')) {
              
                $file = $request->file('img01');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/product/', $filename);
                $product->img01 = 'uploads/product/' . $filename;
            }

            $product->save();
            return response()->json([
                'status' => 200,
                'message' => 'Category Add Successfully',
            ]);
        }
    }

    public function update(Request $request,$id)

    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'slug' => 'required|max:191',
            'category_id' => 'required|max:191',
            'qty' => 'numeric',


        

            'orginal_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'qty' => 'required|numeric',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors(),
            ]);
        } else {
            $product = Product::find($id);
            if ($product) {
                $product->name = $request->input('name');
                $product->category_id = $request->input('category_id');
                $product->description = $request->input('description');
                $product->slug = $request->input('slug');
                $product->qty = $request->input('qty');

                $product->orginal_price = $request->input('orginal_price');
                $product->selling_price = $request->input('selling_price');


                $product->popular = $request->input('popular') == true ? '1' : '0';
                $product->featured = $request->input('featured') == true ? '1' : '0';
                $product->status = $request->input('status') == true ? '1' : '0';
                if ($request->hasFile('img02')) {

                    $path = $product->img02;
                    if(File::exists($path))
                    {
                        File::delete($path);
    
                    }
                    $file = $request->file('img02');

                    $extension = $file->getClientOriginalExtension();

                    $filename = time() + 1 . '.' . $extension;

                    $file->move('uploads/product/', $filename);

                    $product->img02 = 'uploads/product/' . $filename;
                }

                if ($request->hasFile('img01')) {

                    $path = $product->img01;
                    if(File::exists($path))
                    {
                        File::delete($path);
    
                    }
                    $file = $request->file('img01');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/product/', $filename);
                    $product->img01 = 'uploads/product/' . $filename;
                }

                $product->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Category Product Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Category ID Found',
                ]);
            }
        }
    }
    //
}