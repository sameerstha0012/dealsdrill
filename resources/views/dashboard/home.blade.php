@section('title')

Dashboard

@endsection

@extends('dashboard.layouts.app')

@section('content')

<!-- main categories -->
<section class="dash-wrapper">
  <div class="row">
    <!-- side bar -->
    @include('dashboard/layouts/sidebar')

    <!-- main contents-->
    <div class="col-md-9 dash-content-wrap">

      @include('dashboard/layouts/profilebar')

      <!-- main contents -->
      <div class="dash-content">
          
          @include('admin/layouts/error')
          
        <div class="dash-inner">
          <div class="dash-thumbs">
            <div class="row">
              <!-- thumbs-->
              <div class="col-md-3 dash-thumb">
                <div class="dash-thumd-in">
                  <div class="dash-thumb-info">
                    <span>Total Items</span>
                    <h2>{{ $total }}</h2>
                  </div>
                  <div class="cart-icon icon-3">
                    <i class="fab fa-opencart"></i>
                  </div>
                </div>
              </div>
              <!-- thumbs-->
              <div class="col-md-3 dash-thumb">
                <div class="dash-thumd-in">
                  <div class="dash-thumb-info">
                    <span>On Sale Items</span>
                    <h2>{{ $onsale }}</h2>
                  </div>
                  <div class="cart-icon icon-2">
                    <i class="fab fa-opencart"></i>
                  </div>
                </div>
              </div>
              <!-- thumbs-->
              <div class="col-md-3 dash-thumb">
                <div class="dash-thumd-in">
                  <div class="dash-thumb-info">
                    <span>Sold Items</span>
                    <h2>{{ $sold }}</h2>
                  </div>
                  <div class="cart-icon icon-3">
                    <i class="fab fa-opencart"></i>
                  </div>
                </div>
              </div>
              <!-- thumbs-->
              <div class="col-md-3 dash-thumb">
                <div class="dash-thumd-in">
                  <div class="dash-thumb-info">
                    <span>Expired Items</span>
                    <h2>{{ $expired }}</h2>
                  </div>
                  <div class="cart-icon icon-1">
                    <i class="fab fa-opencart"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- tables -->
          <div class="tables-wrap">
            <div class="row">
              <!-- latest items -->
              <div class="custom-table col-md-6">
                <div class="custom-table-in">
                  <h4 class="table-title">Latest Items</h4>

                  <!-- rows-->
                  <div class="table-rows">

                    @foreach($latest as $row)

                    <!-- item -->
                    <div class="table-row">
                      <!-- image -->
                      <div class="img-container sm-image">
                        <img src="{{ asset('uploads/'.'products/'.$row->pic) }}" alt="{{ ucwords($row->name) }}" class="img-fitted">
                      </div>
                      <!-- des-->
                      <div class="item-col">
                        <h4><a href="{{ url('detail/'.$row->slug) }}">{{ ucwords($row->name) }}</a></h4>
                        <span><b>Category:</b>{{ ucwords($row->categoryName) }}</span>
                      </div>
                      <!-- price tag-->
                      <div class="table-badge-wrap">
                        <span class="table-badge badge-blue">Rs: {{ number_format($row->price, 2) }}</span>
                      </div>
                    </div>

                    @endforeach

                  </div>
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
