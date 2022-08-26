@section('title')

{{ ucwords($product->name) }}

@endsection

@extends('layouts.page')

@section('content')

@include('layouts/search')

  <!-- page nav -->
  <section class="page-nav">
    <div class="container">
      <ul>
        <li>
          <a href="{{ url('/') }}">Home</a>
          <i class="fas fa-angle-double-right"></i>
        </li>
        <li>
          <a href="{{ url($category->slug) }}">{{ ucwords($category->name) }}</a>
          <i class="fas fa-angle-double-right"></i>
        </li>
        <li>
          <a href="{{ url($category->slug.'/'.$subcategory->slug) }}">{{ ucwords($subcategory->name) }}</a>
          <i class="fas fa-angle-double-right"></i>
        </li>
        
        @if(isset($othercategory))
        <li>
          <a href="{{ url($category->slug.'/'.$subcategory->slug.'/'.$othercategory->slug) }}">{{ ucwords($othercategory->name) }}</a>
          <i class="fas fa-angle-double-right"></i>
        </li>
        @endif
        
        <li>
          <a href="{{ url(
         'item/'.$product->slug) }}">{{ ucwords($product->name) }}</a>
          <i class="fas fa-angle-double-right"></i>
        </li>
      </ul>
    </div>
  </section>

  <!-- item details-->
  <section class="item-details-wrap pad-top pad-bot">
    <div class="container">
      <div class="row">
        <div class="col-md-8 item-details">
          <div class="item-details-in">
            <h1 class="item-title">{{ ucwords($product->name) }}</h1>
            <span class="price-tag">
                <i class="fas fa-circle"></i>Rs: {{ number_format($product->price, 0) }}
            </span>
            <span class="item-location">
              <i class="fas fa-map-marker-alt"></i>{{ ucwords($product->address) }}
            </span>
          </div>

          <!-- umage-gallery-->
          <div class="image-gallery">
            <div class="row">

            <?php $z=0; ?>
            @foreach($gallery as $row)
              @if($z < 1)

              <!-- large-image-->
              <div class="col-md-6 image-wrap">
                <div class="large-image img-container">
                  <a href="{{ asset('uploads/gallery/'.$row->pic) }}" class="cboxElement group2">
                    <img src="{{ asset('uploads/gallery/'.$row->pic) }}" alt="{{ $product->name }}" class="img-fitted">
                  </a>
                </div>
              </div>

              @endif
            <?php $z++; ?>
            @endforeach

              <?php $z=0; ?>
              @foreach($gallery as $row)
                @if($z > 0 && $z < 2)

              <!-- long-image-->
              <div class="col-md-3 col-sm-6 image-wrap">
                <div class="long-image img-container">
                  <a href="{{ asset('uploads/gallery/'.$row->pic) }}" class="cboxElement group2">
                    <img src="{{ asset('uploads/gallery/'.$row->pic) }}" alt="{{ $product->name }}" class="img-fitted">
                  </a>
                </div>
              </div>

                @endif
              <?php $z++; ?>
              @endforeach

              <!-- small images -->
              <div class="col-md-3 col-sm-6 small-images image-wrap">

              <?php $z=0; ?>
              @foreach($gallery as $row)
                @if($z > 1)

                <!-- small image -->
                <div class="image-wrap-in">
                  <div class="small-image img-container">
                    <a href="{{ asset('uploads/gallery/'.$row->pic) }}" class="cboxElement group2">
                      <img src="{{ asset('uploads/gallery/'.$row->pic) }}" alt="{{ $product->name }}" class="img-fitted">
                    </a>
                  </div>
                </div>

                @endif
              <?php $z++; ?>
              @endforeach

              </div>
            </div>
          </div>

            <!-- item description-->
            <div class="item-des">
                @if($product->category_id == 16 || $product->category_id == 17)
                @else
                <div class="delivery-des">
                    <span class="item-location">Delivery : {{ ucwords($product->delivery) }}</span>
                    @if($product->delivery == 'Yes')
                        <span class="item-location">
                            <i class="fas fa-map-marker-alt"></i> {{ ucwords($product->delivery_area) }}
                        </span>
                    @endif 
                </div>
                @endif
            <?php echo $product->features; ?>
          </div>
          
          <!-- comments-->
          <div class="buyer-speak pad-top pad-bot" style="clear:both">
            <div class="comments-wrap">
              <h3 class="inner-heading">Buyer's Speak</h3>
              <span class="heading-line"></span>
              <div class="img-container" style="margin-top:40px;">
                <div class="fb-comments" data-href="{{ url($category->slug.'/'.$subcategory->slug.'/'.$product->slug) }}" data-numposts="5"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- side bar-->
        <div class="col-md-4 seller-side">
          <div class="seller-side-info">
            <div class="side-info-in">
              <!-- image -->
              <div class="seller-sm-image">
                <div class="img-container round-img">
                  <img src="@if($seller->pic != '') {{ asset('uploads/'.'users/'.$seller->pic) }} @else {{ asset('images/icons/default.fw.png') }} @endif" class="img-fitted" alt="{{ ucwords($seller->name) }}">
                </div>
              </div>

              <!-- seller details -->
              <div class="seller-info-main text-center">
                <h4>{{ ucwords($seller->name) }}</h4>
                <div class="item-actions">
                  <a href="{{ url('seller/'.$seller->slug) }}">
                    <i class="fas fa-plus"></i> More Items</a>
                 <a href="#" class="high-btn call-toggle">
                    <i class="fas fa-phone"></i> Call Now</a>
                    <div id="seller-phone"><a href="tel:{{ $seller->phone }}">{{ $seller->phone }}</a></div>
                    
                  <a href="#" class="mail-toggle">
                    <i class="fas fa-envelope"></i> Email Seller</a>
                     <div id="seller-mail"><a href="mailto:{{ $seller->email }}">{{ $seller->email }}</a></div>
                </div>
            </div>

           <script>
                $(".call-toggle").click(function(e){
                    e.preventDefault();
                    $("#seller-phone").slideToggle(200);
                });
                 $(".mail-toggle").click(function(e){
                      e.preventDefault();
                    $("#seller-mail").slideToggle(200);
                })
            </script>
          </div>
          
            <!-- member info-->
            <h4 class="member-date text-center">
              <span>Member Since:</span>{{ $seller->created_at->toFormattedDateString() }}</h4>
        </div>
      </div>
    </div>
  </section>

  @if(count($similar_products) > 0)

  <!-- Similar items-->
  <section class="inner-items pad-top pad-bot">
    <div class="container">
      <h3 class="inner-heading">Similar Items</h3>
      <span class="heading-line"></span>
      <div class="items-wrap">
        <div class="row">

        @foreach($similar_products as $row)

          <!-- item -->
          <div class="col-md-4 col-lg-3 item-column-wrap">
            <div class="item-column">
              <div class="img-container">
                <a href="{{ url('/item/'.$row->slug) }}" style="display: inline">
                  <img src="{{ asset('uploads/'.'products/'.$row->pic) }}" alt="{{ ucwords($row->name) }}" class="img-fitted hvr-grow">
                </a>
                <a href="{{ url('seller/'.$row->sellerslug) }}" class="seller-info img-container" data-toggle="tooltip" title="Seller: {{ ucwords($row->seller) }}"
                  data-placement="right">
                  <img src="@if($row->profile != '') {{ asset('uploads/users/'.$row->profile) }} @else {{ asset('images/icons/default.fw.png') }} @endif" alt="{{ ucwords($row->seller) }}" class="img-fitted">
                </a>
                <div class="item-thumbs">
                  <h3 class="item-price">Rs. {{ number_format($row->price, 0) }}</h3>
                </div>
              </div>
              <div class="column-info">
                <h4 class="item-title">{{ ucwords($row->name) }}</h4>
                <span class="item-location">
                  <i class="fas fa-map-marker-alt"></i> {{ ucwords($row->address) }}</span>
              </div>
            </div>
          </div>

        @endforeach
        
        </div>
      </div>
    </div>
  </section>

  @endif

@endsection

@section('footer')
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.1';
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
@endsection