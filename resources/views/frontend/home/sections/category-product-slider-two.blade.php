@php
  $categoryProductSliderTwo = json_decode($categoryProductSliderTwo->value);
  $lastKey = [];
  $type = '';

  foreach ($categoryProductSliderTwo as $key => $category) {
    if($category == null) {
      break;
    }

    $lastKey = [$key => $category];
  }

  if(array_keys($lastKey)[0] == 'category') {
    $category = \App\Models\Category::find($lastKey['category']);
    $products = \App\Models\Product::withAvg('productReviews as review_rating', 'rating')
      ->withCount('productReviews as review_count')
      ->with(['productImageGalleries', 'category', 'variants', 'variants.productVariantItems'])
      ->where('category_id', $category->id)
      ->orderBy('id', 'DESC')->take(8)->get();
    $type = 'category';
  }
  else if(array_keys($lastKey)[0] == 'sub_category') {
    $category = \App\Models\SubCategory::find($lastKey['sub_category']);
    $products = \App\Models\Product::withAvg('productReviews as review_rating', 'rating')
      ->withCount('productReviews as review_count')
      ->with(['productImageGalleries', 'category', 'variants', 'variants.productVariantItems'])
      ->where('sub_category_id', $category->id)
      ->orderBy('id', 'DESC')->take(8)->get();
    $type = 'subcategory';
  }
  else {
    $category = \App\Models\ChildCategory::find($lastKey['child_category']);
    $products = \App\Models\Product::withAvg('productReviews as review_rating', 'rating')
      ->withCount('productReviews as review_count')
      ->with(['productImageGalleries', 'category', 'variants', 'variants.productVariantItems'])
      ->where('child_category_id', $category->id)
      ->orderBy('id', 'DESC')->take(8)->get();
    $type = 'childcategory';
  }

@endphp

<section id="wsus__electronic2">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__section_header">
                    <h3>{{ $category->name }}</h3>
                    <a class="see_btn" href="{{ route('products.index', [$type => $category->slug]) }}">see more <i class="fas fa-caret-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row flash_sell_slider">
          @foreach ($products as $product )
            <div class="col-xl-3 col-sm-6 col-lg-4">
              <x-product-card :product="$product" />
            </div>
          @endforeach
        </div>
    </div>
</section>


