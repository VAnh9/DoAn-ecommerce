@php
  $address = json_decode($order->order_address);
  $shipping = json_decode($order->shipping_method);
  $coupon = json_decode($order->coupon);
@endphp

@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header justify-content-between">
            <h1>Order</h1>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Back</a>
          </div>

          <div class="section-body">
            <div class="invoice" id="invoice">
              <div class="invoice-print">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title">
                      <h2></h2>
                      <div class="invoice-number">Order #{{ $order->invoice_id }}</div>
                    </div>
                    <hr>
                    <div class="row invoice-info">
                      <div class="col-md-6">
                        <address>
                          <strong>Billed To:</strong><br>
                            <b>Name:</b> {{ $address->name }}<br>
                            <b>Email:</b> {{ $address->email }}<br>
                            <b>Phone:</b> {{ $address->phone }}<br>
                            <b>Address:</b> {{ $address->address }}<br>
                            {{ $address->district }}, {{ $address->city }}, {{ $address->country }}<br>
                            <b>Zip:</b> {{ $address->zip_code }}
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>Shipped To:</strong><br>
                            <b>Name:</b> {{ $address->name }}<br>
                            <b>Email:</b> {{ $address->email }}<br>
                            <b>Phone:</b> {{ $address->phone }}<br>
                            <b>Address:</b> {{ $address->address }}<br>
                            {{ $address->district }}, {{ $address->city }}, {{ $address->country }}<br>
                            <b>Zip:</b> {{ $address->zip_code }}
                        </address>
                      </div>
                    </div>
                    <div class="row invoice-info">
                      <div class="col-md-6">
                        <address>
                          <strong>Payment Information:</strong><br>
                          <b>Method:</b> {{ $order->payment_method }}<br>
                          <b>Transaction Id:</b> {{@$order->transaction->transaction_id}} <br>
                          <b>Status: </b> {{ $order->payment_status == 1 ? 'Complete' : 'Pending' }}
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>Order Date:</strong><br>
                          {{ date('d F, Y', strtotime($order->created_at)) }}<br><br>
                        </address>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="section-title">Order Summary</div>
                    <p class="section-lead">All items here cannot be deleted.</p>
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-md">
                        <tr>
                          <th data-width="40">#</th>
                          <th>Item</th>
                          <th>Variant</th>
                          <th>Shop Name</th>
                          <th class="text-center">Price</th>
                          <th class="text-center">Quantity</th>
                          <th class="text-right">Totals</th>
                        </tr>
                        @foreach ($order->orderProducts as $product )
                          @php
                            $variants = json_decode($product->variants)
                          @endphp
                          <tr>
                            <td>{{ ++$loop->index }}</td>
                            @if (isset($product->product->slug))
                              <td><a href="{{ route('product-detail', $product->product->slug) }}" target="_blank">{{ $product->product_name }}</a></td>
                            @else
                              <td>{{ $product->product_name }}</td>
                            @endif
                            <td>
                              @foreach ($variants as $key => $variant )
                                <b>{{ $key }}:</b> {{ $variant->name }} ({{ $order->currency_icon }}{{ $variant->price }})
                                <br>
                              @endforeach
                            </td>
                            <td>{{ $product->vendor->name }}</td>
                            <td class="text-center">{{ $order->currency_icon }}{{ $product->unit_price }}</td>
                            <td class="text-center">{{ $product->qty }}</td>
                            <td class="text-right">{{ $order->currency_icon }}{{($product->unit_price + $product->variant_total) * $product->qty}}</td>
                          </tr>
                        @endforeach
                      </table>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <div class="col-md-4">
                          <form action="{{ route('admin.order.change-order-status') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group" style="margin-bottom: 1rem">
                              <label for="">Order Status</label>
                              <input type="hidden" value="{{ $order->id }}" name="id">
                              <select name="order_status" id="order_status" data-id="{{ $order->id }}" class="form-control">
                                @foreach (config('order_status.order_status_admin') as $key => $orderStatus )
                                  <option {{ $order->order_status == $key ? 'selected' : '' }} value="{{ $key }}">{{ $orderStatus['status'] }}</option>
                                @endforeach
                              </select>
                            </div>

                            <div class="form-group {{ $order->order_status != 'shipping' ? 'd-none' : '' }}" style="margin-bottom: 1rem" id="choose_shipper">
                              <label for="">Shipper</label>
                              <select name="shipper" id="shipper" class="form-control">
                                <option value="">Select</option>
                                @foreach ($shippers as $shipper )
                                  <option {{ $order->shipper_id == $shipper->id ? 'selected' : '' }} value="{{ $shipper->id }}">{{ $shipper->name }}</option>
                                @endforeach
                              </select>
                              @if ($errors->has('shipper'))
                                <code>{{ $errors->first('shipper') }}</code>
                              @endif
                            </div>
                            <button class="btn btn-primary">Update</button>
                          </form>

                          <div class="form-group">
                            <label for="">Payment Status</label>
                            <select name="payment_status" id="payment_status" data-id="{{ $order->id }}" class="form-control">
                              <option {{ $order->payment_status == 0 ? 'selected' : '' }} value="0">Pending</option>
                              <option {{ $order->payment_status == 1 ? 'selected' : '' }} value="1">Completed</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4 text-right">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Subtotal</div>
                          <div class="invoice-detail-value">{{ $order->currency_icon }}{{ $order->sub_total }}</div>
                        </div>
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Shipping (+)</div>
                          <div class="invoice-detail-value">{{ $order->currency_icon }}{{ @$shipping->cost }}</div>
                        </div>
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Coupon (-)</div>
                          <div class="invoice-detail-value">{{ $order->currency_icon }}{{ @$coupon->discount ? calculateDiscountCoupon($order->sub_total, $coupon) : 0 }}</div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Total</div>
                          <div class="invoice-detail-value invoice-detail-value-lg">{{ $order->currency_icon }}{{ $order->amount }}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="text-md-right">
                <button class="btn btn-warning btn-icon icon-left print-btn"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </section>

@endsection

@push('scripts')

<script>
  $(document).ready(function() {
    // change order status
    // $('body').on('change', '#order_status', function() {
    //   let orderStatus = $(this).val();
    //   let id = $(this).data('id');
    //   let shipperId = null;

    //   //show select box to choose shipper
    //   if(orderStatus != 'shipping') {
    //     $('#choose_shipper').addClass('d-none');
    //   }
    //   else {
    //     $('#choose_shipper').removeClass('d-none');
    //   }

    //   if (orderStatus == 'shipping') {
    //     shipperId = $('#shipper').val();

    //     if (!shipperId) {
    //       return;
    //     }
    //   }

    //   $.ajax({
    //     url: "{{ route('admin.order.change-order-status') }}",
    //     method: 'PUT',
    //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //     data: {
    //       id: id,
    //       shipperId: shipperId,
    //       status: orderStatus
    //     },
    //     success: function(data) {
    //       if(data.status == 'success') {
    //         toastr.success(data.message);
    //       }
    //     },
    //     error: function(xhr, status, err) {
    //       console.log(err);
    //     }
    //   })
    // })

    // show select option to choose shipper
    $('body').on('change', '#order_status', function() {
      let orderStatus = $(this).val();
      if(orderStatus != 'shipping') {
        $('#choose_shipper').addClass('d-none');
      }
      else {
        $('#choose_shipper').removeClass('d-none');
      }
    })

    // change payment status
    $('body').on('change', '#payment_status', function() {
      let paymentStatus = $(this).val();
      let id = $(this).data('id');

      $.ajax({
        url: "{{ route('admin.order.change-payment-status') }}",
        method: 'PUT',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
          id: id,
          status: paymentStatus
        },
        success: function(data) {
          if(data.status == 'success') {
            toastr.success(data.message);
          }
        },
        error: function(xhr, status, err) {
          console.log(err);
        }
      })
    })


    // print order
    $('.print-btn').on('click', function() {
      let printContent = $('.invoice-print').html();

      // let originalContent = $('body').html();

      // $('body').html(printContent);

      // window.print();

      // $('body').html(originalContent);

      let http = "http://127.0.0.1:8000";

      var css= `<link rel=\"stylesheet\" href=\"${http}/backend/assets/modules/bootstrap/css/bootstrap.min.css\"><link rel=\"stylesheet\" href=\"${http}/backend/assets/modules/fontawesome/css/all.min.css\"><link rel=\"stylesheet\" href=\"${http}/backend/assets/css/style.css\"><link rel=\"stylesheet\" href=\"${http}/backend/assets/css/components.css\">`;

         var anotherWindow = window.open('', 'Print-Window');
         anotherWindow.document.open();
         anotherWindow.document.write('<html><body onload="window.print()">' + printContent + '</body></html>');
         anotherWindow.document.head.innerHTML = css;
         anotherWindow.document.close();
         setTimeout(function() {
            anotherWindow.close();
         }, 5);
    })


  })


</script>

@endpush

<style>
  a:hover {
    text-decoration: none !important;
}
@media print {
  body {
    visibility: hidden;
  }
  #invoice, #invoice * {
    visibility: visible !important;
  }
  .invoice-info {
    display: flex;
    justify-content: space-between;
  }
}
</style>
