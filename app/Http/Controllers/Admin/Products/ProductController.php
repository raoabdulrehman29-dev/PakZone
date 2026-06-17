<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products\Product;
use App\Models\Products\Brand;
use App\Models\Products\Category;
use App\Http\Requests\Requests\Admin\StoreProductRequest;
use inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products=Product::with(['category','brand','images'])->orderBy('created_at','desc')->paginate(15);
        return inertia::render('Products/Index', ['products' => $products]);
    }
    public function create()
    {
    $categories=Category::all();
    $brands=Brand::all();
    }
    public function Store(StoreProductRequest $request)
    {
        $validated=$request->validated();
        if(empty($validated['slug']))
            {
           $validated['slug'] = Str::slug($validated['name']);
            }

            $product=Product::create($validated);
            if($request->hasfile('image'))
                {
                    foreach($request->file('image') as $index=>$image)
                        {
                        $path= $image->store('products','public');
                        $product->images->create([
                        'image'=> $path,
                        'is_primary' => $index===0,
                         'sort_order' =>$index,
                        ]);
                        }
                }
                if($request->has('varients'))
                    {
                        foreach($request->varienst as $varients){
                            $product->varients()->create($varients);


                        }
                    }
                    return redirect()->route('admin.products.index')->with('success','product created successfully');


    }
    public function edit($id)
    {
        $product=Product::with(['images','varients'])->findOrFail($id);
        $categories=Category::all();
        $brand=Brand::all();
        return inertia::render('Admin/Products/Edit',[
            'product'=> $product,
            'categories'=> $categories,
            'brand'=> $brand,
        ]);

    }

    public function update(UpdateProductRequest $request,$id)
    {
         $product=Product::findOrFail($id);
         $validated=$request->validated;
         if($request->has('name') && $request->name !== $product->name)
            {
                $validated['slug'] =Str::slug($request->name);

            }
            $product->update($validated);
            return redirect()->route('admin.products.index')->with('success','Product Updated Successfully');
    }

    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success','Product Deleted Successfully');

    }
    public function UpdateStatus($id,Request $request){
        $product=Product::findOrFail($id);
        $product->status=$request->status;
        $product->save();

        return response()->json(['success' => true]);


    }
}
