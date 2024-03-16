<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ChildCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Str;

class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ChildCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.child-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::has('subCategories')->where('status', 1)->get();
        return view('admin.child-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
          'name' => ['required', 'max:200', 'unique:child_categories,name'],
          'category' => ['required'],
          'sub_category' => ['required'],
          'status' => ['required']
        ]);

        $childCategory = new ChildCategory();

        $childCategory->name = $request->name;
        /** @disregard P1009 */
        $childCategory->slug = Str::slug($request->name);
        $childCategory->category_id = $request->category;
        $childCategory->sub_category_id = $request->sub_category;
        $childCategory->status = $request->status;

        $childCategory->save();

        toastr('Created Successfully!');

        return redirect()->route('admin.child-category.index');
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
        $childCategory = ChildCategory::findOrFail($id);
        $categories = Category::has('subCategories')->where('status', 1)->get();
        $subCategories = SubCategory::where('category_id', $childCategory->category_id)->where('status', 1)->get();
        return view('admin.child-category.edit', compact('childCategory', 'categories', 'subCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
          'name' => ['required', 'max:200', 'unique:child_categories,name,'.$id],
          'category' => ['required'],
          'sub_category' => ['required'],
          'status' => ['required']
        ]);

        $childCategory = ChildCategory::findOrFail($id);

        $childCategory->name = $request->name;
        /** @disregard P1009 */
        $childCategory->slug = Str::slug($request->name);
        $childCategory->category_id = $request->category;
        $childCategory->sub_category_id = $request->sub_category;
        $childCategory->status = $request->status;

        $childCategory->save();

        toastr('Updated Successfully!');

        return redirect()->route('admin.child-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $childCategory = ChildCategory::findOrFail($id);

        $childCategory->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    /**
     * Get sub categories
     */
    public function getSubCategories(Request $request) {

      $subCategories = SubCategory::where('category_id', $request->id)->where('status', 1)->get();
      return $subCategories;
    }

    public function changeStatus(Request $request) {

      $childCategory = ChildCategory::findOrFail($request->id);

      $childCategory->status = $request->isChecked == 'true' ? 1 : 0;

      $childCategory->save();

      return response(['message' => 'Status has been updated!']);

    }
}
