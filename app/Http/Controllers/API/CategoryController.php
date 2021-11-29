<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $category=Category::all();
        return response()->json([
            'status'=>200,
            'category'=>$category,
        ]);
    }

    public function allcategory()
    {
        $categorys=Category::where('status','1')->get();
        return response()->json([
            'status'=>200,
            'categorys'=>$categorys,
        ]);
    }
    public function edit($id)

    {
        $category=Category::find($id);
        if($category)
        {
            return response()->json([
                'status'=>200,
                'category'=>$category,
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'No category Id Found',
            ]);
        }
       
    }
   
   
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|max:191',
            'slug'=>'required|max:191',
            
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->errors(),
            ]);
        }
        else{
            $category =new Category;
            $category->name =$request->input('name');
            $category->description =$request->input('description');
            $category->slug =$request->input('slug');
            $category->status =$request->input('status')==true ? '1' : '0';
            $category->save();
            return response()->json([
                'status'=>200,
                'message'=>'Category Add Successfully',
            ]);
        }

       

    }

    public function update(Request $request,$id)

    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|max:191',
            'slug'=>'required|max:191',
            
        ]);
        if($validator->fails())
        {
            return response()->json([
                'status'=>422,
                'errors'=>$validator->errors(),
            ]);
        }
        else{
            $category =Category::find($id);
            if($category)
            {
                $category->name =$request->input('name');
                $category->description =$request->input('description');
                $category->slug =$request->input('slug');
                $category->status =$request->input('status')==true ? '1' : '0';
                $category->update();
                 return response()->json([
                'status'=>200,
                'message'=>'Category Add Successfully',
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'No Category ID Found',
                    ]);
            }
        }
       
    }

    public function destroy($id)

    {
        $category=Category::find($id);
        if($category)
        {
            $category->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Category Deleted Successfully',
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'No category Id Found',
            ]);
        }
       
    }
}