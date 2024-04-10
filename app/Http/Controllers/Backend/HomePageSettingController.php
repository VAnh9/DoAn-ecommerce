<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HomePageSetting;
use Illuminate\Http\Request;

class HomePageSettingController extends Controller
{
  public function index()
  {
    $categories = Category::where('status', 1)->get();
    $popularCategorySection = HomePageSetting::where('key', 'popular_category_section')->first();
    $productSliderOne = HomePageSetting::where('key', 'product_slider_section_one')->first();
    $productSliderTwo = HomePageSetting::where('key', 'product_slider_section_two')->first();
    $productSliderThree = HomePageSetting::where('key', 'product_slider_section_three')->first();
    return view('admin.home-page-setting.index', compact('categories', 'popularCategorySection', 'productSliderOne', 'productSliderTwo','productSliderThree'));
  }

  public function updatePopularCategorySection(Request $request)
  {
    $request->validate([
      'cat_one' => ['required'],
      'cat_two' => ['required'],
      'cat_three' => ['required'],
      'cat_four' => ['required'],
    ], [
      'cat_one.required' => 'Category field is required',
      'cat_two.required' => 'Category field is required',
      'cat_three.required' => 'Category field is required',
      'cat_four.required' => 'Category field is required',
    ]);

    $data = [
      [
        'category' => $request->cat_one,
        'sub_category' => $request->sub_cat_one,
        'child_category' => $request->child_cat_one,
      ],

      [
        'category' => $request->cat_two,
        'sub_category' => $request->sub_cat_two,
        'child_category' => $request->child_cat_two,
      ],

      [
        'category' => $request->cat_three,
        'sub_category' => $request->sub_cat_three,
        'child_category' => $request->child_cat_three,
      ],

      [
        'category' => $request->cat_four,
        'sub_category' => $request->sub_cat_four,
        'child_category' => $request->child_cat_four,
      ],
    ];

    HomePageSetting::updateOrCreate(
      [
        'key' => 'popular_category_section'
      ],
      [
        'value' => json_encode($data)
      ]
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }

  public function updateProductSliderOne(Request $request)
  {
    $request->validate([
      'category_one' => ['required'],
    ], [
      'category_one.required' => 'Category field is required'
    ]);

    $data = [

      'category' => $request->category_one,
      'sub_category' => $request->sub_category_one,
      'child_category' => $request->child_category_one,
    ];

    HomePageSetting::updateOrCreate(
      [
        'key' => 'product_slider_section_one'
      ],
      [
        'value' => json_encode($data)
      ]
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }

  public function updateProductSliderTwo(Request $request)
  {
    $request->validate([
      'category_two' => ['required'],
    ], [
      'category_two.required' => 'Category field is required'
    ]);

    $data = [

      'category' => $request->category_two,
      'sub_category' => $request->sub_category_two,
      'child_category' => $request->child_category_two,
    ];

    HomePageSetting::updateOrCreate(
      [
        'key' => 'product_slider_section_two'
      ],
      [
        'value' => json_encode($data)
      ]
    );

    toastr('Updated Successfully!');

    return redirect()->back();
  }

  public function updateProductSliderThree(Request $request)
  {

    $request->validate([
      'cate_one' => ['required'],
      'cate_two' => ['required'],
    ], [
      'cate_one.required' => 'Part 1 category field is required',
      'cate_two.required' => 'Part 2 category field is required'
    ]);

    $data = [
      [
        'category' => $request->cate_one,
        'sub_category' => $request->sub_cate_one,
        'child_category' => $request->child_cate_one,
      ],

      [
        'category' => $request->cate_two,
        'sub_category' => $request->sub_cate_two,
        'child_category' => $request->child_cate_two,
      ],
    ];

    HomePageSetting::updateOrCreate(
      [
        'key' => 'product_slider_section_three'
      ],
      [
        'value' => json_encode($data)
      ]
    );

    toastr('Updated Successfully!');

    return redirect()->back();

  }
}
