@section('title')

{{ ucwords($seller->name) }}

@endsection

@extends('layouts.page')

@section('content')

<!-- page nav -->
<section class="page-nav">
    <div class="container">
      <ul>
        <li>
          <a href="{{ url('/') }}">Home</a>
          <i class="fas fa-angle-double-right"></i>
        </li>
        <li>
          <a href="{{ url('seller/'.$seller->slug) }}">{{ ucwords($seller->name) }}</a>
          <i class="fas fa-angle-double-right"></i>
        </li>
      </ul>
    </div>
</section>

<!-- item details-->
<section class="seller-page pad-top pad-bot">
  <div class="container">
    <div class="row">
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
                  <a href="#" class="high-btn call-toggle">
                    <i class="fas fa-phone"></i> Call Now</a>
                    <div id="seller-phone"><a href="tel:{{ $seller->phone }}">{{ $seller->phone }}</a></div>
                    
                  <a href="#" class="mail-toggle">
                    <i class="fas fa-envelope"></i> Email Seller</a>
                     <div id="seller-mail"><a href="mailto:{{ $seller->email }}">{{ $seller->email }}</a></div>
                </div>
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
            <!-- member info-->
            <h4 class="member-date text-center">
              <span>Member Since:</span>{{ $seller->created_at->toFormattedDateString() }}</h4>
          </div>
      </div>
      <!-- Items -->
      <div class="items-wrap col-md-8 inner-items">
          <div class="row">

            @foreach($products as $row)

                <!-- item -->
                <div class="col-md-6 col-lg-4 item-column-wrap">
                <div class="item-column">
                    <div class="img-container">
                    <a href="{{ url('item/'.$row->slug) }}" style="display: inline">
                        <img src="{{ asset('uploads/'.'products/'.$row->pic) }}" alt="{{ ucwords($row->name) }}" class="img-fitted hvr-grow">
                    </a>
                    <div class="item-thumbs">
                        <h3 class="item-price">Rs. {{ number_format($row->price, 0) }}</h3>
                    </div>
                    </div>
                    <div class="column-info">
                        <a href="{{ url('item/'.$row->slug) }}">
                            <h4 class="item-title">{{ ucwords($row->name) }}</h4>
                        </a>
                    <span class="item-location">
                        <b>Condtiton:</b>{{ $row->condition }}</span>
                        
                    </div>
                </div>
                </div>

            @endforeach

          </div>
      </div>
    </div>
  </div>
</section>

@endsection