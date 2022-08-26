@section('title')

{{ ucwords($setting->title) }}

@endsection

@extends('layouts.page')

@section('content')
<!--
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#0082BF">
            <h4 class="modal-title" style="font-weight:700;color:#fff">This Property is on Sale.</h4>
      </div>
      <div class="modal-body">
        <h3 style="font-size:24px; font-weight:600"><span style="color:#0082BF">Thank You!</span> For Visiting this site.</h3>
         <p style="font-size:15px;line-height:20px;margin-top:15px;">Believe it or not, this property is on sale. Well, everything needs an expertise to be successful, and our expertise lies in Designing and Developing Awesome Web Applications and Ecommerce sites rather operating them.</p> 
         <p style="font-size:15px;line-height:20px;margin-top:15px;">So, if you think you have an expertise to operate an Ecommerce Marketplace, we have an amazing offer for you. If you purchase this property (Blend of Ecommerce Marketplace and Classified site), you will have the instant access to the following:
          </p>
          <ul style="list-style:none; margin-top:15px; font-weight:600; font-size:15px;">
              <li><i class="fas fa-check-circle" style="color:#0082BF;margin-right:8px;"></i>Wireframes of the Single Page Application for Deals Drill</li>
              <li><i class="fas fa-check-circle" style="color:#0082BF;margin-right:8px;"></i>Detailed Business Plan with Execution Strategy</li>
              <li><i class="fas fa-check-circle" style="color:#0082BF;margin-right:8px;"></i>Business Consultation (If Required)</li>
              <li><i class="fas fa-check-circle" style="color:#0082BF;margin-right:8px;"></i>Existing User base</li>
          </ul>
          
          <div style="border:2px dashed #ddd; padding:20px; margin-top:20px;" class="text-center">
               <p style="font-size:16px;font-weight:600">Please call us @ <a href="tel:9843493682/ 9851243682/ 014440615" style="color:#0082BF">9843493682/ 9851243682/ 014440615</a></p>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="font-size:14px;font-weight:500;background-color:#ff5c26; color:#fff; padding:10px 30px;">Close</button>
      </div>
    </div>

  </div>
</div>-->
<section class="search-banner">
  <div class="container">
    <div class="search-wrap">
      <h1>Simple, Sell & Buy</h1>
      <p>Welcome to <b>DealsDrill.com</b>, we are a <b>FREE</b> online classified site where <b>YOU</b> as an individual or company can post your items (services or products) to <b>SELL</b>. <b>DealsDrill.com</b> is where buyers meet the best sellers. Go! <b>Drill</b> your <b>Deal</b>.</p>
      <form class="search-form" name="search" method="POST" action="{{ url('/search') }}">
      @csrf
        <input type="search" name="keyword" placeholder="Find what you’re looking for..." required value="{{ session('search') }}">
        <button type="submit">
          <i class="fas fa-search"></i>
        </button>
      </form>
    </div>
  </div>
</section>

<!-- main categories -->
<section class="main-cats-wrap">
    <div class="container">
        
        <!-- desktop -->
        <div class="main-cats desktop">
            <ul>
                <?php $z=0; ?>
                @foreach($category as $row)
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
                <li class="cat-toggle">
                    <a href="#">
                        <img src="{{ asset('images/opt.fw.png') }}" alt="icon">
                        <text>View More</text>
                    </a>
                </li>
            </ul>
            <ul class="hidden-cat">
                <?php $z=0; ?>
                @foreach($category as $row)
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
            @foreach($category as $row)
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

<!-- starting selling
<section class="start-wrap pad-top pad-bot">
    <div class="container">
        <div class="start-sell text-center">
            <h3>Wanna <span>Sell</span> Anything?</h3>
            <p>We are a local classifieds site. At Deals Drill, you can sell anything from mobiles, cars and furnitures to property, accessories and many more. Create an account in a few easy steps and post your ads for free. Looking to buy something? In here, you will find the best deals for you.</p>
            <a href="#">Start Selling</a>
        </div>
    </div>
</section> -->

<!-- Featured Items -->
<section class="feat-wrap pad-top">
  <div class="container">
    <h3 class="main-heading text-center">Featured Items</h3>
    <div class="feat-items">
      <div class="owl-carousel owl-theme owl-feat">
        
      @foreach($featured as $row)
        <div class="item">
          <div class="feat-item">
            <div class="feat-item-in">
              <div class="img-container">
                <a href="{{ url('/item/'.$row->slug) }}" style="display: inline">
                  <img src="{{ asset('uploads/'.'products/'.$row->pic) }}" 
                    alt="{{ ucwords($row->name) }}" class="img-fitted hvr-grow">
                </a>
                <a href="{{ url('seller/'.$row->sellerslug) }}" class="seller-info img-container" 
                    data-toggle="tooltip" title="Seller: {{ ucwords($row->seller) }}" data-placement="right">
                  <img src="@if($row->profile != '') {{ asset('uploads/'.'users/'.$row->profile) }} @else {{ asset('images/icons/default.fw.png') }} @endif" alt="{{ ucwords($row->seller) }}" alt="{{ ucwords($row->seller) }}"> 
                </a>
              </div>
              <div class="feat-overview">
                <a href="{{ url('/item/'.$row->slug) }}" title="{{ ucwords($row->name) }}">
                  <h4>{{ ucwords($row->name) }}</h4>
                </a>
                @if($row->category_id != 17)
                    <div class="feat-con">
                      <b>{{ $row->condition }}</b>
                    </div>
                @endif
                <div class="feat-price-con">
                  <div class="feat-price">
                    <span>Rs</span>
                    <strong>{{ number_format($row->price, 0) }}</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach

      </div>
    </div>
  </div>   
</section>
<style>
    .owl-dots, .owl-nav {display:none;}
</style>
<section class="middle-ad pad-top">
<div class="container">
    <div class="row">
       
            <div class="col-md-6 mid-ad">
                <div class="img-container">
                     @if(isset($data['m-left']->pic))
                    <a href="{{ $data['m-left']->link }}" title="" target="_blank">
                        <img src="{{ asset('uploads/advertise/'.$data['m-left']->pic) }}">
                    </a>
                         @else
                         <img src="{{ asset('uploads/advertise/half-ad.fw.png')}}">
                  @endif
                </div>
            </div>
       
        
      
            <div class="col-md-6 mid-ad mid-ad-bot">
               <div class="img-container">
                     @if(isset($data['m-right']->pic))
                    <a href="{{ $data['m-right']->link }}" title="" target="_blank">
                        <img src="{{ asset('uploads/advertise/'.$data['m-right']->pic) }}">
                    </a>
                         @else
                         <img src="{{ asset('uploads/advertise/half-ad.fw.png')}}">
                  @endif
                </div>
            </div>
      
    </div>
</div>    
</section>

<!-- items-->
<section class="home-items pad-top pad-bot">
  <div class="container">
    <h3 class="main-heading text-center">Latest Items</h3>

    <div class="row" id="appendProduct">

    @foreach($products as $row)
    
        <!-- item -->
        <div class="col-md-4 col-sm-6 col-lg-3 item-column-wrap">
            <div class="item-column">
                <div class="img-container">
                    <a href="{{ url('/item/'.$row->slug) }}" style="display: inline">
                        <img src="{{ asset('uploads/'.'products/'.$row->pic) }}" alt="{{ ucwords($row->name) }}" class="img-fitted hvr-grow">
                    </a>
                    <a href="{{ url('seller/'.$row->sellerslug) }}" class="seller-info img-container" 
                        data-toggle="tooltip" title="Seller: {{ ucwords($row->seller) }}" data-placement="right">
                        <img src="@if($row->profile != '') {{ asset('uploads/'.'users/'.$row->profile) }} @else {{ asset('images/icons/default.fw.png') }} @endif" alt="{{ ucwords($row->seller) }}" class="img-fitted">
                    </a>
                    <div class="item-thumbs">
                        <h3 class="item-price">Rs. {{ number_format($row->price, 0) }}</h3>
                    </div>
                </div>
                <div class="column-info">
                    <a href="{{ url('/item/'.$row->slug) }}" title="{{ ucwords($row->name) }}">
                        <h4 class="item-title">{{ ucwords($row->name) }}</h4>
                    </a>
                    @if($row->category_id != 17)
                        <span class="item-location">
                            <b>Condition:</b>{{ $row->condition }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    
    @endforeach
    
        <!-- ad -->
        <div class="col-sm-6 col-md-4 col-lg-3 item-column-wrap column-ad">
            <div class="wanna-sell">
                <h4>Wanna see your items here?</h4>
                <p>Get the best deals on Deals Drill.</p>
               <a href="{{ url('/sell') }}">START SELLING</a>
            </div>
        </div>
 
    @foreach($products1 as $row)
    
        <!-- item -->
        <div class="col-md-4 col-sm-6 col-lg-3 item-column-wrap">
            <div class="item-column">
                <div class="img-container">
                    <a href="{{ url('/item/'.$row->slug) }}" style="display: inline">
                        <img src="{{ asset('uploads/'.'products/'.$row->pic) }}" alt="{{ ucwords($row->name) }}" class="img-fitted hvr-grow">
                    </a>
                    <a href="{{ url('seller/'.$row->sellerslug) }}" class="seller-info img-container" 
                        data-toggle="tooltip" title="Seller: {{ ucwords($row->seller) }}" data-placement="right">
                        <img src="@if($row->profile != '') {{ asset('uploads/'.'users/'.$row->profile) }} @else {{ asset('images/icons/default.fw.png') }} @endif" alt="{{ ucwords($row->seller) }}" class="img-fitted">
                    </a>
                    <div class="item-thumbs">
                        <h3 class="item-price">Rs. {{ number_format($row->price, 0) }}</h3>
                    </div>
                </div>
                <div class="column-info">
                    <a href="{{ url('/item/'.$row->slug) }}" title="{{ ucwords($row->name) }}">
                        <h4 class="item-title">{{ ucwords($row->name) }}</h4>
                    </a>
                    @if($row->category_id != 17)
                        <span class="item-location">
                            <b>Condition:</b>{{ $row->condition }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    
    @endforeach
    <!-- ad -->
    <div class="col-sm-6 col-lg-3 col-md-4 item-column-wrap column-ad">
        <div class="wanna-sell">
            <h4>Wanna see your items here?</h4>
            <p>Get the best deals on Deals Drill.</p>
           <a href="{{ url('/sell') }}">START SELLING</a>
        </div>
    </div>
    
        @foreach($products2 as $key => $row)
            
            @if($key > 6)
                @break
            @endif
            
            <!-- item -->
            <div class="col-md-4 col-sm-6 col-lg-3 item-column-wrap">
                <div class="item-column">
                    <div class="img-container">
                        <a href="{{ url('/item/'.$row->slug) }}" style="display: inline">
                            <img src="{{ asset('uploads/'.'products/'.$row->pic) }}" alt="{{ ucwords($row->name) }}" class="img-fitted hvr-grow">
                        </a>
                        <a href="{{ url('seller/'.$row->sellerslug) }}" class="seller-info img-container" 
                            data-toggle="tooltip" title="Seller: {{ ucwords($row->seller) }}" data-placement="right">
                            <img src="@if($row->profile != '') {{ asset('uploads/'.'users/'.$row->profile) }} @else {{ asset('images/icons/default.fw.png') }} @endif" alt="{{ ucwords($row->seller) }}" class="img-fitted">
                        </a>
                        <div class="item-thumbs">
                            <h3 class="item-price">Rs. {{ number_format($row->price, 0) }}</h3>
                        </div>
                    </div>
                    <div class="column-info">
                        <a href="{{ url('/item/'.$row->slug) }}" title="{{ ucwords($row->name) }}">
                            <h4 class="item-title">{{ ucwords($row->name) }}</h4>
                        </a>
                        @if($row->category_id != 17)
                            <span class="item-location">
                                <b>Condition:</b>{{ $row->condition }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        
        @endforeach
        
    </div>
    
    @if(count($products2) > 7 )
        <!-- load more -->
        <div class="load-sec text-center" id="hideIt">
            <button type="button" class="load-btn" id="loadMoreProduct">Load More</button>
        </div>
    @endif()
    
  </div>
</section>

<section class="middle-ad pad-bot">
    <div class="container" style="padding:0 30px;">
        <div class="row">
            <div class="col-md-12 long-ad">
                <div class="feat-items">
      <div class="owl-carousel owl-theme owl-ad">
        <div class="item">
         <div class="img-container">
             <a href="http://nexsuseducation.com.np/" target="_blank" title="Nexsus Educational Consultancy">
                 <img src="{{ url('uploads/advertise/nexus.jpg') }}" alt="Nexus Education" >
             </a>
         </div>
        </div>
         <div class="item">
         <div class="img-container">
             <a href="http://navadurgapartyvenue.com/" target="_blank" title="Nava Durga Party Venue">
                 <img src="{{ url('uploads/advertise/navadurga.jpg') }}" alt="Nava Durga Party Venue" >
             </a>
         </div>
        </div>
         <div class="item">
         <div class="img-container">
             <a href="http://laxmee.com.np" target="_blank" title="Laxmee Hair Studio">
                 <img src="{{ url('uploads/advertise/laxmee.jpg') }}" alt="Laxmee Hair Studio">
             </a>
         </div>
        </div>
      </div>
    </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" charset="utf-8" async defer>

$(document).ready(function(){

    // After Click Event In Load More Button
    var start = 22;
    var take = 0;
    $('button#loadMoreProduct').click(function(event){
      event.preventDefault();
      
      var url = "{{ route('site.loadMoreProduct') }}";
    
      $("button#loadMoreProduct").html("Loading . . . <i class='fa fa-spinner fa-spin'>");
      $("button#loadMoreProduct").attr('disabled', true);
      
      $.ajax({
    
        headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        url: url,
        type: 'POST',
        dataType: 'json',
        data: {
            start: start
        }
    
      })
      .done(function(response){
          
        start += 8;
        take ++;
        $("button#loadMoreProduct").html("Load More");
        $("button#loadMoreProduct").attr('disabled', false);
    
        if(response.success){
            
            if(response.hide === true){
                $("div#hideIt").remove();
            }
          
          $("div#appendProduct").append(response.data);
    
        }else{
    
          $('button[type=submit]').attr('disabled', false);
    
        }
        
        if(take == 2){
            $("div#hideIt").remove();
        }
    
      })
      .fail(function(){
    
        $("button#loadMoreProduct").html("Load More");
        $("button#loadMoreProduct").attr('disabled', false);
    
      });
    
    });
});

</script>  


@endsection
