<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Dashboard &mdash; Shopnest</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('backend/assets/css/bootstrap-iconpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css')}}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css') }}">
    <link rel="icon" type="image/png" href="{{ asset( $logoSettings->favicon ) }}">

    <script>
      const USER = {
        id: "{{ Auth::user()->id }}",
        name: "{{ Auth::user()->name }}",
        image: "{{ asset(Auth::user()->image) }}",
      }
    </script>
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            <!-- Navbar Content -->
            @include('admin.layouts.navbar')
            <!-- Navbar Content End -->

            <!-- Sidebar Content -->
            @include('admin.layouts.sidebar')
            <!-- Sidebar Content End -->

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('backend/assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/popper.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('backend/assets/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/chart.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/select2/dist/js/select2.full.min.js')}}"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> --}}
    <script src="{{ asset('backend/assets/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
    <!-- Page Specific JS File -->
    {{-- <script src="{{ asset('backend/assets/js/page/index-0.js') }}"></script> --}}

    <!-- Template JS File -->
    <script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('backend/assets/js/custom.js') }}"></script>

    {{-- <script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}")
        @endforeach
    @endif
  </script> --}}

    <!-- Dynamic Delete Alert -->
    <script>
        window.onload = function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        $(document).ready(function() {

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });

            $('body').on('click', '.delete-item', function(event) {
                event.preventDefault();

                let deleteUrl = $(this).attr('href');
                var rowDelete = $(this).closest('tr');
                let dataTableId = $(this).attr('data-tableId')

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
                                    window.LaravelDataTables[dataTableId].ajax.reload();
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
    @stack('scripts')
</body>
<style>
    .field-required {
        color: red;
    }

    div.dt-container .dt-paging .dt-paging-button:hover,
    div.dt-container .dt-paging .dt-paging-button:active {
        background: linear-gradient(to bottom, #ffffff 0%, #ffffff 100%);
        border-color: transparent;
        box-shadow: none;
    }

    div.dt-container .dt-paging .dt-paging-button.disabled,
    div.dt-container .dt-paging .dt-paging-button.disabled:hover,
    div.dt-container .dt-paging .dt-paging-button.disabled:active {
        cursor: pointer;
    }

    table.dataTable thead>tr>th.dt-orderable-asc,
    table.dataTable thead>tr>th.dt-orderable-desc,
    table.dataTable thead>tr>td.dt-orderable-asc,
    table.dataTable thead>tr>td.dt-orderable-desc {
        text-align: left !important;
    }

    /* #toast-container>.toast:before {
        position: absolute;
        left: 17px;
        top: 20px;
        font-family: "Font Awesome 5 Free" !important;
        font-size: 24px;
        line-height: 18px;
        color: #fff;
    }

    #toast-container>.toast-success {
        background-image: none !important;
    }

    #toast-container>.toast-success:before {
        content: "\2714" !important;
    }

    #toast-container>.toast-info:before {
        content: "\2139" !important;
        color: #000;
    }

    #toast-container>.toast-warning:before {
        content: "\26A0" !important;
    }

    #toast-container>.toast-error:before {
        content: "\26A0" !important;
    } */
</style>

</html>
