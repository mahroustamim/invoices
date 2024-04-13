<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    function __construct()
    {
        // $this->middleware(['permission:المنتجات '], ['only' => ['index']]);
        $this->middleware(['permission:إضافة منتج'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:تعديل منتج'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:حذف منتج'], ['only' => ['destroy']]);
    }

    public function index()
    {
        $products = product::paginate(10);
        $sections = Section::all();
        return view('products.products', compact('sections', 'products'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'product_name' => 'required|unique:products,product_name|max:30',
            'section_id'   => 'required'
        ], [
            'product_name.required' => 'إسم المنتج مطلوب',
            'product_name.unique' => 'إسم المنتج مسجل مسبقا',
            'product_name.max' => 'يجب ألا تعدي 30 حرف',

            'section_id.required' => 'إسم القسم مطلوب',
        ]);
        

        Product::create([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);

        return redirect('/products')->with('success', 'تم إضافة المنتج بنجاح');
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'product_name' => 'required|max:30|unique:products,product_name,' . $id,
            'section_id'   => 'required'
        ], [
            'product_name.required' => 'إسم المنتج مطلوب',
            'product_name.unique' => 'إسم المنتج مسجل مسبقا',
            'product_name.max' => 'يجب ألا تعدي 30 حرف',

            'section_id.required' => 'إسم القسم مطلوب',
        ]);

        $product = Product::find($id);
        $product->update([
            'product_name' => $request->product_name,
            'section_id' => $request->section_id,
            'description' => $request->description,
        ]);

        return redirect('/products')->with('success', 'تم تعديل المنتج بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Product::find($id)->delete();
        return redirect('/products')->with('success', 'تم حذف المنتج بنجاح');
    }

}



