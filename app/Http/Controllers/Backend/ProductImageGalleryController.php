<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductImageGalleryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class ProductImageGalleryController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ProductImageGalleryDataTable $dataTable)
    {
        $product = Product::findOrFail($request->product);
        return $dataTable->render('admin.product.image-gallery.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
          'image' => ['required'],
          'image.*' => ['required', 'image', 'max:2048']
        ]);

        $imagePaths = $this->uploadMultiImage($request, 'image', 'uploads/products/'.$request->product);

        foreach($imagePaths as $imagePath) {

          $productImageGallery = new ProductImageGallery();

          $productImageGallery->image = $imagePath;
          $productImageGallery->product_id = $request->product;

          $productImageGallery->save();
        }

        toastr('Uploaded Successfully!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productImageGallery = ProductImageGallery::findOrFail($id);

        $this->deleteImage($productImageGallery->image);

        $productImageGallery->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
