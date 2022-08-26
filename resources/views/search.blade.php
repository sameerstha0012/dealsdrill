@section('title')

Search

@endsection

@extends('layouts.page')

@section('content')

@include('layouts/search')

  <!-- item details-->
  <section class="cat-page pad-top pad-bot">
    <div class="container">
      <div class="row " style="position:relative">
        <!-- side bar-->
        <div class="col-md-3 side-cat main-side-cat">
             <div class="mobile text-right"> <button class="close-btn" onClick="closer()"><i class="far fa-times-circle"></i></button></div>
          <!-- filters -->
          <div class="filters" style="margin-top:0">
            <h4 class="sidebar-title">Ad Filters</h4>
            <div class="filters-wrap">
              <form class="filter-form" id="filterForm" name="filter" method="POST" action="{{ url('/search') }}">
              @csrf

                <input type="hidden" name="url" value="search">

                <!-- basic filters-->
                <div class="basic-filters">
                  <!-- location-->
                  <div class="form-group">
                    <label>Location:</label>
                    <input type="text" id="flocation" name="location" placeholder="Location" value="{{ session('location') }}">
                  </div>
                  <!-- condition -->
                  <div class="form-group">
                    <label>Condition:</label>
                    <select name="condition" id="fcondition">
                      <option value="">All</option>
                      <option <?php if(Session::has("condition")) { if(session('condition') == 'Brand New') { echo 'selected'; } } ?> value="Brand New">Brand New</option>
                      <option <?php if(Session::has("condition")) { if(session('condition') == 'Like New') { echo 'selected'; } } ?> value="Like New">Like New</option>
                      <option <?php if(Session::has("condition")) { if(session('condition') == 'Used') { echo 'selected'; } } ?> value="Used">Used</option>
                    </select>
                  </div>
                  <!-- price -->
                  <div class="form-group">
                    <label>Price:</label>
                    <div class="price-filter">
                      <input type="number" name="start" id="fstart" placeholder="From" value="{{ session('start') }}">
                      <span><i class="fas fa-exchange-alt"></i></span>
                      <input type="number" name="end" id="fend" placeholder="To" value="{{ session('end') }}">
                    </div>
                  </div>
                </div>
                <!-- submit filters-->
                <div class="submit-filters text-right">
                  <button type="submit" class="filter-btn"><i class="fas fa-check-circle"></i>Apply</button>
                 
                  <button type="button" id="clearfilter" class="filter-btn"><i class="fas fa-times-circle"></i>Clear</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- Items -->
        <div class="items-wrap col-md-9 inner-items cat-items items-list-view">

          <div class="section-header">
            <div class="cat-title-wrap">
              <h2 class="cat-title">{{ session('keyword') }} <button class="mobile" onClick="sider()"><i class="fas fa-bars"></i></button></h2>
            </div>

            <div class="sorts">
              <form name="filter" method="POST" action="{{ url('/search') }}">
              @csrf

                <input type="hidden" name="url" value="search">

                <label>SORT BY:</label>
                <select name="sort" onchange="this.form.submit()">
                  <option value="">Default (Date)</option>
                  <option <?php if(Session::has("sort")) { if(session('order') == 'DESC') { echo 'selected'; } } ?> value="price-desc">Price: High-Low </option>
                  <option <?php if(Session::has("sort")) { if(session('order') == 'ASC') { echo 'selected'; } } ?> value="price-asc">Price: Low-High </option>
                </select>
              </form>
            </div>
            <!-- views-->
            <div class="views">
              <a href="#" title="Grid View"><i class="fas fa-th-large"></i></a>
              <a href="#" title="List View" class="active-view"><i class="fas fa-th-list"></i></a>
            </div>
          </div>

          <div class="">

            @foreach($products as $row)

            <!-- item -->
            <div class="item-column-list">
              <div class="row">
                <!-- image-->
                <div class="col-md-4 list-image">
                  <div class="img-container">
                    <img src="{{ asset('uploads/'.'products/'.$row->pic) }}" alt="{{ ucwords($row->name) }}" class="img-fitted">
                  </div>
                </div>
                <!-- details-->
                <div class="col-md-6">
                  <div class="list-view-details">
                    <h2 class="item-title">{{ ucwords($row->name) }}</h2>
                    <div class="small-details">
                      <span><i class="far fa-calendar-alt"></i>{{ $row->created_at->toFormattedDateString() }}</span>
                      <span><b>Condition:</b>{{ $row->condition }}</span>
                    </div>
                    <span class="col-location-info"><i class="fas fa-map-marker-alt"></i>{{ ucwords($row->address) }}</span>
                    <p class="column-details">{{ substr(strip_tags($row->features), 0, 100) }} ...</p>
                    <a href="{{ url('/item/'.$row->slug) }}" class="link-btn">Details <i class="fas fa-angle-double-right"></i></a>
                  </div>
                </div>
                <!-- seller prices-->
                <div class="col-md-2 list-prices">
                  <div class="seller-price text-center">
                    <div class="seller-thumb img-container">
                      <a href="{{ url('seller/'.$row->sellerslug) }}">
                        <img src="@if($row->profile != '') {{ asset('uploads/users/'.$row->profile) }} @else {{ asset('images/icons/default.fw.png') }} @endif" alt="{{ ucwords($row->seller) }}" class="img-fitted">
                      </a>
                    </div>
                    <h5>{{ ucwords($row->seller) }}</h5>
                    <span> Rs: </span>
                    <h3 class="big-price">{{ number_format($row->price, 0) }}</h3>
                  </div>
                </div>
              </div>
            </div>

            @endforeach

            {{ $products->links() }}
            
            @if(count($products) == 0)
                <span class="badge badge-warning">No product found that matches the keyword. Please try a different one.</span>
            @endif

          </div>
        </div>

      </div>
    </div>
  </section>

@endsection


@section('footer')

    <script>
        $(document).ready(function(){
            $("#clearfilter").click(function(){
                $('#flocation').val('');
                $('#fcondition').val('');
                $('#fstart').val('');
                $('#fend').val('');
                $('form#filterForm').submit();
            });
        });
    </script>
  
@endsection