@extends('frontend.dashboard.layouts.master')

@section('title')
  {{ $settings->site_name }} || Address
@endsection

@section('content')

<section id="wsus__dashboard">
    <div class="container-fluid">
      @include('frontend.dashboard.layouts.sidebar')
      <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
          <div class="dashboard_content">
            <h3><i class="fal fa-gift-card"></i> address</h3>
            <div class="wsus__dashboard_add">
              <div class="row">
                @foreach ($addresses as $address )
                  <div class="col-xl-6 address-bar">
                    <div class="wsus__dash_add_single">
                      <h4>Billing Address</h4>
                      <ul>
                        <li><span>name :</span> {{ $address->name }}</li>
                        <li><span>Phone :</span> {{ $address->phone }}</li>
                        <li><span>email :</span> {{ $address->email }}</li>
                        <li><span>country :</span> {{ $address->country }}</li>
                        <li><span>city :</span> {{ $address->city }}</li>
                        <li><span>district :</span> {{ $address->district }}</li>
                        <li><span>zip code :</span> {{ $address->zip_code }}</li>
                        <li><span>address :</span> {{ $address->address }}</li>
                      </ul>
                      <div class="wsus__address_btn">
                        <a href="{{ route('user.address.edit', $address->id) }}" class="edit"><i class="fal fa-edit"></i> edit</a>
                        <a href="{{ route('user.address.destroy', $address->id) }}" class="del delete-item ms-1"><i class="fal fa-trash-alt"></i> delete</a>
                      </div>
                    </div>
                  </div>
                @endforeach
                <div class="col-12">
                  <a href="{{ route('user.address.create') }}" class="add_address_btn common_btn"><i class="far fa-plus"></i>
                    add new address</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
  <script>
    // window.onload = function() {
    //       $.ajaxSetup({
    //           headers: {
    //               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //           }
    //       });
    //   }

      $(document).ready(function() {

          // $.ajaxSetup({
          //     headers: {
          //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          //     }
          // });

          $('body').on('click', '.delete-item', function(event) {
              event.preventDefault();

              let deleteUrl = $(this).attr('href');
              var rowDelete = $(this).closest('.address-bar');

              Swal.fire({
                  title: "Are you sure?",
                  text: "You won't be able to revert this!",
                  icon: "warning",
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                  if (result.isConfirmed) {

                      $.ajax({
                          type: 'DELETE',
                          url: deleteUrl,
                          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                          success: function(data) {
                              if (data.status == 'success') {
                                  Swal.fire(
                                      'Deleted!',
                                      data.message,
                                      'success'
                                  )
                                  // window.location.reload();
                                  rowDelete.remove();

                              } else if (data.status == 'error') {
                                  Swal.fire(
                                      "Can't Delete!",
                                      data.message,
                                      'error'
                                  )
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
