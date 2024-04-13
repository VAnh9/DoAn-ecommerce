@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Advertisements</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-3">
                        <div class="list-group" id="list-tab" role="tablist">
                          <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#general-settings" role="tab">Homepage banner section one</a>
                          <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab">Homepage banner section two</a>
                          <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab">Homepage banner section three</a>
                          <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab">Homepage banner section four</a>
                          <a class="list-group-item list-group-item-action" id="list-products-list" data-toggle="list" href="#list-products" role="tab">Product page banner</a>
                          <a class="list-group-item list-group-item-action" id="list-cart-list" data-toggle="list" href="#list-cart" role="tab">Cart page banner</a>
                          <a class="list-group-item list-group-item-action" id="list-flashsale-list" data-toggle="list" href="#list-flashsale" role="tab">Flashsale page banner</a>
                        </div>
                      </div>
                      <div class="col-9">
                        <div class="tab-content" id="nav-tabContent">

                          @include('admin.advertisement.homepage-banner-one')

                          @include('admin.advertisement.homepage-banner-two')

                          @include('admin.advertisement.homepage-banner-three')

                          @include('admin.advertisement.homepage-banner-four')

                          @include('admin.advertisement.product-page-banner')

                          @include('admin.advertisement.cart-page-banner')

                          @include('admin.advertisement.flashsale-page-banner')

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

@endsection



