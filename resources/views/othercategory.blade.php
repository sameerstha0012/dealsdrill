@section('title')

{{ ucwords($othercategory->name) }}

@endsection

@extends('layouts.page')

@section('content')

@include('layouts/search')

<!-- page nav -->
<section class="inner-nav" style="padding:0">
    <div class="container">
        <div class="main-cats desktop">
            <ul>
               
                <?php $z=0; ?>
                @foreach($categories as $row)
                @if($z < 6)

                <li>
                  <a href="{{ url('/'.$row->slug) }}">
                    <img src="{{ asset('uploads/categories/'.$row->pic) }}" alt="{{ ucwords($row->name) }}">
                    <text>{{ ucwords($row->name) }}</text>
                  </a>
                </li>

                @endif
                <?php $z++; ?>
                @endforeach
                
                <li class="cat-toggle inner-toggle"><a href="#">
                    <img src="{{ asset('images/opt.fw.png') }}" alt="icon">
                    <text>View More</text></a>
                </li>
            </ul>
     
            <ul class="hidden-cat">
    
            <?php $z=0; ?>
            @foreach($categories as $row)
            @if($z > 5)
    
            <li>
              <a href="{{ url('/'.$row->slug) }}">
                <img src="{{ asset('uploads/categories/'.$row->pic) }}" alt="{{ ucwords($row->name) }}">
                <text>{{ ucwords($row->name) }}</text>
              </a>
            </li>
            
            @endif
            <?php $z++; ?>
            @endforeach
    
          </ul>
        </div>

        <script>
         $(".hidden-cat").hide();
           $(".cat-toggle").click(function(e){
               e.preventDefault();
               var state =  $(".hidden-cat").hasClass("shown");
                if(state === false){
                    $(".hidden-cat").addClass("shown");
                     $(".cat-toggle text").text("View Less");
                     $(".hidden-cat").slideDown();
                }
                else{
                    $(".hidden-cat").removeClass("shown");
                     $(".hidden-cat").slideUp();
                     $(".cat-toggle text").text("View More")
                }
           })
        </script>
        
        <!-- mobile -->
        <div class="main-cats mobile">
          <button data-toggle="collapse" data-target="#mob-cat" class="collapsed">All Categories<i class="fas fa-caret-down"></i></button>      
          <div id="mob-cat" class="collapse">
            <ul>
    
                @foreach($categories as $row)

                <li>
                  <a href="{{ url('/'.$row->slug) }}">
                    <img src="{{ asset('uploads/categories/'.$row->pic) }}" alt="{{ ucwords($row->name) }}">
                    <text>{{ ucwords($row->name) }}</text>
                  </a>
                </li>

                @endforeach

            </ul>
          </div>
        </div>
    </div>
</section>

  <!-- item details-->
  <section class="cat-page pad-top pad-bot">
    <div class="container">
      <div class="row" style="position:relative">
        <!-- side bar-->
        <div class="col-md-3 side-cat main-side-cat">
             <div class="mobile text-right"> <button class="close-btn" onClick="closer()"><i class="far fa-times-circle"></i></button></div>
          <!-- filters -->
          <div class="filters" style="margin-top:0">
            <h4 class="sidebar-title">Ad Filters</h4>
            <div class="filters-wrap">
              <form class="filter-form" id="filterForm" name="filter" method="POST" action="{{ url('/filter') }}">
              @csrf

                <input type="hidden" name="url" value="{{ $category->slug.'/'.$subcategory->slug.'/'.$othercategory->slug }}">

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
                        <div class="start-price">
                             <input type="number" name="start" id="fstart" placeholder="From" value="{{ session('start') }}">
                        </div>
                     
                      
                      <span><i class="fas fa-exchange-alt"></i></span>
                      <div>
                          <input type="number" name="end" id="fend" placeholder="To" value="{{ session('end') }}"> 
                      </div>
                     
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
              <h2 class="cat-title">{{ ucwords($othercategory->name) }} <button class="mobile" onClick="sider()"><i class="fas fa-bars"></i></button></h2>
            </div>

            <div class="sorts">
              <form name="filter" method="POST" action="{{ url('/filter') }}">
              @csrf

                <input type="hidden" name="url" value="{{ $category->slug.'/'.$subcategory->slug }}">

                <label>SORT BY:</label>
                <select name="sort" onchange="this.form.submit()">
                  <option value="">Default (Date)</option>
                  <option <?php if(Session::has("sort")) { if(session('order') == 'DESC') { echo 'selected'; } } ?> value="price-desc">Price: High-Low </option>
                  <option <?php if(Session::has("sort")) { if(session('order') == 'ASC') { echo 'selected'; } } ?> value="price-asc">Price: Low-High </option>
                </select>
              </form>
            </div>
            <!-- views-->
            <div class="views" style="display:none">
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
                <span class="badge badge-warning">No product found.</span>
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