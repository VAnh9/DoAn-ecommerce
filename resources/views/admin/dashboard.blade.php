@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header">
      <h1>Dashboard</h1>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.orders.index') }}">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Todays Orders</h4>
              </div>
              <div class="card-body">
                {{ $todayOrders }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.pending-orders.index') }}">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Todays Pending Orders</h4>
              </div>
              <div class="card-body">
                {{ $todayPendingOrders }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.orders.index') }}">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Orders</h4>
              </div>
              <div class="card-body">
                {{ $totalOrders }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.pending-orders.index') }}">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Pending Orders</h4>
              </div>
              <div class="card-body">
                {{ $totalPendingOrders }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.canceled-orders.index') }}">
          <div class="card card-statistic-1">
            <div class="card-icon bg-secondary">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Canceled Orders</h4>
              </div>
              <div class="card-body">
                {{ $totalCancelOrders }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.delivered-orders.index') }}">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Complete Orders</h4>
              </div>
              <div class="card-body">
                {{ $totalDeliveredOrders }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="javascript:;">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-money-bill"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Todays Earnings</h4>
              </div>
              <div class="card-body">
                {{ $settings->currency_icon }}{{ $todayEarnings }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="javascript:;">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-money-bill"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>This Months Earnings</h4>
              </div>
              <div class="card-body">
                {{ $settings->currency_icon }}{{ $monthEarnings }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="javascript:;">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-money-bill"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>This Years Earnings</h4>
              </div>
              <div class="card-body">
                {{ $settings->currency_icon }}{{ $yearEarnings }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="javascript:;">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-money-bill"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Earnings</h4>
              </div>
              <div class="card-body">
                {{ $settings->currency_icon }}{{ $totalEarnings }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.reviews.index') }}">
          <div class="card card-statistic-1">
            <div class="card-icon bg-info">
              <i class="fas fa-star"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Reviews</h4>
              </div>
              <div class="card-body">
                {{ $totalReview }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.brand.index') }}">
          <div class="card card-statistic-1">
            <div class="card-icon bg-info">
              <i class="fas fa-trademark"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Brands</h4>
              </div>
              <div class="card-body">
                {{ $totalBrand }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.product.index') }}">
          <div class="card card-statistic-1">
            <div class="card-icon bg-info">
              <i class="fas fa-box-open"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Products</h4>
              </div>
              <div class="card-body">
                {{ $totalProduct }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.blog.index') }}">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
              <i class="far fa-newspaper"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Blogs</h4>
              </div>
              <div class="card-body">
                {{ $totalBlog }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.subscribers.index') }}">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Subscribers</h4>
              </div>
              <div class="card-body">
                {{ $totalSubscriber }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.vendor-list.index') }}">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="fas fa-store"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Vendors</h4>
              </div>
              <div class="card-body">
                {{ $totalVendor }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="javascript:;">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="fas fa-store"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Best Selling Vendor</h4>
              </div>
              <div class="card-body">
                {{ $bestSellingVendor }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="{{ route('admin.customers.index') }}">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-users"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Total Users</h4>
              </div>
              <div class="card-body">
                {{ $totalUser }}
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <a href="javascript:;">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Featured User</h4>
              </div>
              <div class="card-body">
                {{ $featuredUser }}
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </section>

@endsection
