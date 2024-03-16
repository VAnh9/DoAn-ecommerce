<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.sub-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status',1)->get();
        return view('admin.sub-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
          'name' => ['required', 'max:200', 'unique:sub_categories,name'],
          'category' => ['required'],
          'status' => ['required']
        ]);

        $subCategory = new SubCategory();

        $subCategory->name = $request->name;
        $subCategory->category_id = $request->category;
        /** @disregard P1009 */
        $subCategory->slug = Str::slug($request->name);
        $subCategory->status = $request->status;

        $subCategory->save();

        toastr('Created Successfully!');

        return redirect()->route('admin.sub-category.index');
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
        $subCategory = SubCategory::findOrFail($id);
        $categories = Category::where('status', 1)->get();
        return view('admin.sub-category.edit', compact('subCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
          'name' => ['required', 'max:200', 'unique:sub_categories,name,'.$id],
          'category' => ['required'],
          'status' => ['required']
        ]);

        $subCategory = SubCategory::findOrFail($id);

        $subCategory->name = $request->name;
        $subCategory->category_id = $request->category;
        /** @disregard P1009 */
        $subCategory->slug = Str::slug($request->name);
        $subCategory->status = $request->status;

        $subCategory->save();

        toastr()->success('Updated Successfully!');

        return redirect()->route('admin.sub-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subCategory = SubCategory::findOrFail($id);

        $childCategory = ChildCategory::where('sub_category_id', $subCategory->id)->count();

        if($childCategory > 0) {
          return response(['status' => 'error', 'message' => 'This item contains sub items for delete this you have to delete the sub items first!']);
        }

        $subCategory->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }

    public function changeStatus(Request $request) {

        $subCategory = SubCategory::findOrFail($request->id);

        $subCategory->status = $request->isChecked == 'true' ? 1 : 0;


        $subCategory->save();

        return response(['message' => 'Status has been updated']);
    }
}
