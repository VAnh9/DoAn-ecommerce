<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BlogCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Str;

class BlogCategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(BlogCategoryDataTable $blogCategoryDataTable)
  {
    return $blogCategoryDataTable->render('admin.blog.category.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.blog.category.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => ['required', 'max:200', 'unique:blog_categories,name'],
      'status' => ['required']
    ], [
      'name.unique' => 'Category already exist!',
    ]);

    $category = new BlogCategory();

    $category->name = $request->name;
    /** @disregard P1009 */
    $category->slug = Str::slug($request->name);
    $category->status = $request->status;

    $category->save();

    toastr('Created Successfully!');

    return redirect()->route('admin.blog-category.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {

  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $category = BlogCategory::findOrFail($id);
    return view('admin.blog.category.edit', compact('category'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $request->validate([
      'name' => ['required', 'max:200', 'unique:blog_categories,name,'.$id],
      'status' => ['required']
    ], [
      'name.unique' => 'Category already exist!',
    ]);

    $category = BlogCategory::findOrFail($id);

    $category->name = $request->name;
    /** @disregard P1009 */
    $category->slug = Str::slug($request->name);
    $category->status = $request->status;

    $category->save();

    toastr('Updated Successfully!');

    return redirect()->route('admin.blog-category.index');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $category = BlogCategory::findOrFail($id);

    if(count($category->blogs) != 0) {
      return response(['status' => 'error', 'message' => 'This category contains blogs. Please delete blogs first!']);
    }

    $category->delete();

    return response(['status' => 'success', 'message' => 'Deleted Successfully!']);

  }

  public function changeStatus(Request $request) {

    $category = BlogCategory::findOrFail($request->id);

    $category->status = $request->isChecked == 'true' ? 1 : 0;

    $category->save();

    return response(['message' => 'Status has been updated!']);
  }
}
