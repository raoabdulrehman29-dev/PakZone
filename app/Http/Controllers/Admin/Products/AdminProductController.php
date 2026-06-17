<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Models\Products\Product;
use App\Models\Products\Category;
use App\Models\Products\Brand;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class AdminProductController extends Controller  // ← Changed from ProductController
{
    public function index()
    {
        $products = Product::with(['category', 'brand', 'images'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Admin/Products/Index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();

        return Inertia::render('Admin/Products/Create', [
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                $product->variants()->create($variant);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::with(['images', 'variants'])->findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();

        return Inertia::render('Admin/Products/Edit', [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $validated = $request->validated();

        if ($request->has('name') && $request->name !== $product->name) {
            $validated['slug'] = Str::slug($request->name);
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
