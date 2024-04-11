@extends('frontend.layouts.master')

@section('title')
  {{ $settings->site_name }} || Wishlist
@endsection

@section('content')

    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
      <div class="wsus_breadcrumb_overlay">
          <div class="container">
              <div class="row">
                  <div class="col-12">
                      <h4>wishlist</h4>
                      <ul>
                          <li><a href="{{ url('/') }}">home</a></li>
                          <li><a href="#">product</a></li>
                          <li><a href="javascript:;">wishlist</a></li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!--============================
      BREADCRUMB END
  ==============================-->


  <!--============================
      Wishlist PAGE START
  ==============================-->
  <section id="wsus__cart_view">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <div class="wsus__cart_list wishlist">
                      <div class="table-responsive">
                          <table class="w-100">
                              <tbody>
                                  <tr class="d-flex">
                                      <th class="wsus__pro_img">
                                          product item
                                      </th>

                                      <th class="wsus__pro_name flex-grow-1">
                                          product details
                                      </th>

                                      <th class="wsus__pro_status">
                                          status
                                      </th>

                                      <th class="wsus__pro_tk flex-grow-1">
                                          price
                                      </th>

                                      <th class="wsus__pro_icon">
                                          action
                                      </th>
                                  </tr>
                                  @foreach ($wishlistProducts as $item )
                                    <tr class="d-flex">
                                        <td class="wsus__pro_img"><img src="{{ asset($item->product->thumb_image) }}" alt="product"
                                                class="img-fluid w-100">
                                            <a href="javascript:;" class="remove-from-wishlist" data-id="{{ $item->id }}"><i class="far fa-times"></i></a>
                                        </td>

                                        <td class="wsus__pro_name flex-grow-1">
                                            <p>{{ $item->product->name }}</p>
                                        </td>

                                        <td class="wsus__pro_status">
                                          @if ($item->product->quantity > 0)
                                            <p>in stock</p>
                                          @else
                                            <span>out of stock</span>
                                          @endif
                                        </td>

                                        <td class="wsus__pro_tk flex-grow-1">
                                            <h6>{{ $settings->currency_icon }}{{ $item->product->price }}</h6>
                                        </td>

                                        <td class="wsus__pro_icon">
                                            <a class="common_btn" href="{{ route('product-detail', $item->product->slug) }}">View Product</a>
                                        </td>
                                    </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!--============================
      Wishlist PAGE END
  ==============================-->

@endsection

@push('scripts')

<script>
  $(document).ready(function() {
    $('.remove-from-wishlist').on('click', function(e) {
      e.preventDefault();

      let id = $(this).data('id');
      let rowDelete = $(this).closest('tr');

      Swal.fire({
        text: "Are you sure to remove this product?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            method: 'DELETE',
            url: "{{ route('user.wishlist.destroy') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
              wishlistId: id,
            },
            success: function(data) {
              if(data.status == 'success') {
                rowDelete.remove();
                $('#wishlist-count').text(data.count);
                toastr.success(data.message);
              }
            },
            error: function(xhr, status, err) {
              console.log(err);
            }
          })
        }
      })

    })
  })
</script>

@endpush
