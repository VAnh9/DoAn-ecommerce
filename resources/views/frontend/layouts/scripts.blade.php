<script>

  $(document).ready(function() {

    // add product to cart
    $(document).on('submit', '.shopping-cart-form', function(e) {
      e.preventDefault();

      let formData = $(this).serialize();
      $.ajax({
        method: 'POST',
        url: "{{ route('add-to-cart') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: formData,
        success: function(data) {
          if(data.status == 'success') {
            getCartCount();
            fetchSidebarCartProduct();
            $('.mini_cart_actions').removeClass('d-none');
            toastr.success(data.message);
          }
          else if(data.status == 'error') {
            toastr.error(data.message);
          }
        },
        error: function(xhr, status, err) {
          console.log(err);
        }
      })

    })

    // get cart count
    function getCartCount() {
      $.ajax({
        method: 'GET',
        url: "{{ route('cart-count') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(data) {
          $('#cart-count').text(data);
        },
        error: function(xhr, status, err) {
          console.log(err);
        }
      })
    }

    // get all cart products
    function fetchSidebarCartProduct() {
      $.ajax({
        method: 'GET',
        url: "{{ route('cart-products') }}",
        success: function(data) {
          $('.mini_cart_wrapper').html("");
          var html = '';
          for(let item in data) {
            let product = data[item];
            html += `<li id="mini_cart_${product.rowId}">
                        <div class="wsus__cart_img">
                            <a href="{{ url('product-detail')}}/${product.options.slug}"><img src="{{asset('/')}}${product.options.image}" alt="product" class="img-fluid w-100"></a>
                            <a class="wsis__del_icon remove_sidebar_product" data-rowid="${product.rowId}" href="javascript:;"><i class="fas fa-minus-circle"></i></a>
                        </div>
                        <div class="wsus__cart_text">
                            <a class="wsus__cart_title" href="{{ url('product-detail')}}/${product.options.slug}">${product.name}</a>
                            <p>{{ $settings->currency_icon }}${product.price}</p>
                            <small>Variants total: {{ $settings->currency_icon }}${product.options.variants_total_price}</small>
                            <br>
                            <small>Qty: ${product.qty}</small>
                        </div>
                      </li>`;
          }
          $('.mini_cart_wrapper').html(html);

          getSidebarCartSubTotal();

        },
        error: function(xhr, status, err) {
          console.log(err);
        }
      })
    }

    // remove product from sidebar
    $('body').on('click', '.remove_sidebar_product', function(e) {
      e.preventDefault();
      let rowId = $(this).data('rowid');
      let url = "{{ route('cart.remove-product', ['rowId' => ':rowId']) }}";
      url = url.replace(':rowId', rowId);
      $.ajax({
        method: 'DELETE',
        url: url,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        success: function(data) {
          let productId = '#mini_cart_' + rowId;
          $(productId).remove();
          getCartCount();
          getSidebarCartSubTotal();
          if(data.countProduct == 0) {
            $('.mini_cart_actions').addClass('d-none');
            $('.mini_cart_wrapper').html('<li class="text-center">Your shopping cart is empty!</li>')
          }
          toastr.success(data.message);
        },
        error: function(xhr, status, err) {
          console.log(err);
        }
      })
    })


    // get sidebar cart sub total
    function getSidebarCartSubTotal() {
      $.ajax({
        method: 'GET',
        url: "{{ route('cart.sidebar-product-total') }}",
        success: function(data) {
          $('#mini_cart_subtotal').text("{{$settings->currency_icon}}"+data);
        },
        error: function(data) {

        }
      })
    }

    // add product to wishlist
    $(document).on('click', '.wishlist-btn', function(e) {
      e.preventDefault();

      let id = $(this).data('id');

      $.ajax({
        method: 'POST',
        url: "{{ route('user.wishlist.store') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
          id: id,
        },
        success: function(data) {
          if(data.status == 'success') {
            $('#wishlist-count').text(data.count);
            toastr.success(data.message);
          }
          else if(data.status == 'error') {
            toastr.error(data.message);
          }
        },
        error: function(xhr, status, err) {
          console.log(err);
          if(err == 'Unauthorized') {
            toastr.error('Login before add a product to wishlist!');
          }
        }
      })
    })

    // newsletter request
    $('#newsletter-form').on('submit', function(e) {
      e.preventDefault();
      let data = $(this).serialize();

      $.ajax({
        method: 'POST',
        url: "{{ route('newsletter-request') }}",
        data: data,
        beforeSend: function() {
          $('.subscribe-btn').text('Loading...');
          $('.subscribe-btn').attr('disabled', true);

        },
        success: function(data) {
          if(data.status == 'success') {
            $('.subscribe-btn').text('Subscribe');
            $('.subscribe-btn').attr('disabled', false);
            $('.newsletter_email').val('');
            toastr.success(data.message);
          }
          else if(data.status == 'error') {
            $('.subscribe-btn').text('Subscribe');
            $('.subscribe-btn').attr('disabled', false);
            toastr.error(data.message);
          }
        },
        error: function(data) {
          let errors = data.responseJSON.errors;
          if(errors) {
            $.each(errors, function(key, value) {
              toastr.error(value);
            })
          }
          $('.subscribe-btn').text('Subscribe');
          $('.subscribe-btn').attr('disabled', false);

        }
      })
    })

    // show product modal
    $('.show_product_modal').on('click', function() {
      let id = $(this).data('id');

      $.ajax({
        method: 'GET',
        url: "{{ route('show-product-modal', ':id') }}".replace(':id', id),
        beforeSend: function() {
          $('.product_modal_content').html('<span class="loader"></span>')
        },
        success: function(response) {
          $('.product_modal_content').html(response);
          $(document).ready(function () {
            $('.select_2').select2();
            loadModalScripts();
          });

        },
        error: function(xhr, status, err) {
          console.log(err);
        },
        complete: function() {

        }
      })
    })

    function loadModalScripts() {
      $.fn.spinner = function() {
        this.each(function() {
          var el = $(this);

          // add elements
          el.wrap('<span class="spinner"></span>');
          el.before('<span class="sub">-</span>');
          el.after('<span class="add">+</span>');

          // substract
          el.parent().on('click', '.sub', function () {
            if (el.val() > parseInt(el.attr('min')))
              el.val( function(i, oldval) { return --oldval; });
          });

          // increment
          el.parent().on('click', '.add', function () {
            if (el.val() < parseInt(el.attr('max')))
              el.val( function(i, oldval) { return ++oldval; });
            });
          });
        };
      $('.number_area_product_modal').spinner();

    }

  })

</script>
