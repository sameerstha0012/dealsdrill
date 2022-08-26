<!DOCTYPE html>
<html lang="en">
    <head>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-163691969-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-163691969-1');
    </script>

    <meta name="google-site-verification" content="6IA1uTzkLcgEM_1nNV2PhGnhLaHOPeKd9dbzBdk4qLg" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if(isset($seo))
        <meta name="keyword" content="{{ $seo->seo_keyword }}">
        <meta name="title" content="{{ $seo->seo_title }}">
        <meta name="descriptiom" content="{{ $seo->seo_desc }}">
    @endif
  
    @yield('header')
  
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:image" content="{{ asset('uploads/logo.png') }}"/>
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('images/fav.fw.png') }}">
    <link rel="stylesheet" 
        href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" 
        integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
        crossorigin="anonymous">
    
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.theme.default.min.css') }}" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/colorbox.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/modernizr.custom.js') }}"></script>
    <script type='text/javascript' 
        src='https://platform-api.sharethis.com/js/sharethis.js#property=5e996dd6f4621e00127d1947&product=image-share-buttons&cms=sop' 
        async='async'></script>


</head>

<body onload="">
  <header>
    <div class="container">
      <div class="row">
        <div class="col-md-7 col-4 logo right-align logo-others" style="padding-bottom:15px;" >
          <a href="{{ url('/') }}" class="logo-link">
            <img src="{{ asset('uploads/settings/'.$setting->pic) }}" alt="{{ $setting->title }}" style="max-width:80px;">
            <span style="
    position: absolute;
    font-size: 12px;
    font-weight: 600;
    color: #637483;
    bottom:-7px;
    left:15px;
    width:180px
">By Rewa Digi Commerce</span>
          </a>
          <a href="{{ url('dealsdrill/how-it-works') }}" class="new-btn desktop">How It Works <i class="fas fa-question-circle"></i></a>
             <a href="{{ url('dealsdrill/help') }}" class="new-btn desktop">Help Center <i class="fas fa-info-circle"></i></a>
              <a href="{{ url('dealsdrill/blog') }}" class="new-btn desktop">Blog <i class="fas fa-rss-square"></i></a>
        </div>
        <!-- actions-->
        <div class="col-md-5 actions text-right col-8" style="padding-left:0">
        
                    @if(!Request::is('login'))
                    @if(Auth::guard('web')->user()) 
                     <div class="dropdown account-thumb">
                          <button type="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-user"></i>My Account<span class="fas fa-caret-down"></span>
                          </button>
                          <div class="dropdown-menu ac-options">
                              <div class="ac-top">
                                  <div class="ac-img">
                                  <div class="img-container">
                                      <img src="@if(Auth::guard('web')->user()->pic != '') {{ asset('uploads/'.'users/'.Auth::guard('web')->user()->pic) }} @else {{ asset('images/icons/default.fw.png') }} @endif" alt="{{ ucwords(Auth::guard('web')->user()->name) }}" class="img-fitted">
                                      </div>
                                      </div>
                                      <h3><span>Hello!</span>
                                          <a href="{{ url('/login') }}">{{ ucwords(Auth::guard('web')->user()->name) }}</a>
                                      </h3>
                                  </div>
                                  <a href="{{ url('/logout') }}"><i class="fas fa-sign-out-alt"></i>Logout</a>
                              </div>
                            </div>
                            
                    @else
                        <a href="{{ url('/login') }}" class="simple-btn">Login</a>
                     @endif
                    
                    @endif
               
                @if(!Request::is('sell'))
                    <a href="{{ url('/sell') }}" class="simple-btn2"><i class="fas fa-camera"></i>Sell Now</a>
                @endif
            
          </div>
          
        </div>
      </div>
      
      <div class="mobile-logo-others mobile">
          <div class="container text-center">
             <a href="{{ url('dealsdrill/how-it-works') }}" class="new-btn">How It Works <i class="fas fa-question-circle"></i></a>
             <a href="{{ url('dealsdrill/help') }}" class="new-btn">Help Center <i class="fas fa-info-circle"></i></a>
             <a href="{{ url('dealsdrill/blog') }}" class="new-btn">Blog <i class="fas fa-rss-square"></i></a>
          </div>
      </div>
    </header>

    @yield('content')
    
    <footer>
      <div class="copyrights">
        <div class="container text-center">
            <a href="{{ url('dealsdrill/help') }}" class="help-lnk">Need Any Help <i class="fas fa-question-circle"></i></a>
            <br>
          <img src="{{ asset('images/rewa-digi-com.png') }}" alt="Rewa Digi Commerce Pvt Ltd." style="max-width:100px;margin-top:5px;">
          <b style="margin-top:5px;color:#637483;font-size:14px;font-weight:500;display:block;margin-bottom:2px;">This Property is owned by Rewa Digi Commerce Pvt Ltd.</b>
           <p>Copyright {{ date('Y') }}. All rights reserved.</p>
         
        </div>
      </div>
    </footer>
    <!-- owl sliders -->
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script>
   $('.owl-feat').owlCarousel({
    autoplay:true,
    autoplayTimeout:4000,
    autoplayHoverPause:false,
    loop:false,
    nav:true,
    rewind:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:2
        },
         1200:{
            items:3
        }
        
    }
});

 $('.owl-ad').owlCarousel({
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:false,
    loop:false,
    nav:true,
    rewind:true,
    animateOut: 'fadeOut',
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        },
         1200:{
            items:1
        }
        
    }
})
     </script>  
    
    
    <script>
      $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
      });
    </script>
    <!-- Only for home page and gallery page -->
    <script>
      $(document).ready(function () {
      //Examples of how to assign the Colorbox event to elements
      $(".group1").colorbox({ rel: 'group1' });
      $(".group2").colorbox({ rel: 'group2', transition: "fade", width:"95%" });
      $(".group3").colorbox({ rel: 'group3', transition: "none", width: "75%", height: "75%" });
      $(".group4").colorbox({ rel: 'group4', slideshow: true });
      $(".ajax").colorbox();
      $(".youtube").colorbox({ iframe: true, innerWidth: 640, innerHeight: 390 });
      $(".vimeo").colorbox({ iframe: true, innerWidth: 500, innerHeight: 409 });
      $(".iframe").colorbox({ iframe: true, width: "80%", height: "80%" });
      $(".inline").colorbox({ inline: true, width: "50%" });
      $(".callbacks").colorbox({
        onOpen: function () { alert('onOpen: colorbox is about to open'); },
        onLoad: function () { alert('onLoad: colorbox has started to load the targeted content'); },
        onComplete: function () { alert('onComplete: colorbox has displayed the loaded content'); },
        onCleanup: function () { alert('onCleanup: colorbox has begun the close process'); },
        onClosed: function () { alert('onClosed: colorbox has completely closed'); }
      });

      $('.non-retina').colorbox({ rel: 'group5', transition: 'none' })
      $('.retina').colorbox({ rel: 'group5', transition: 'none', retinaImage: true, retinaUrl: true });

      //Example of preserving a JavaScript event for inline calls.
      $("#click").click(function () {
        $('#click').css({ "background-color": "#f00", "color": "#fff", "cursor": "inherit" }).text("Open this window again and this message will still be here.");
        return false;
      });
    });
  </script>
  <script src="{{ asset('js/jquery.colorbox.js') }}"></script>
 <script>
     function sider (){
         $(".main-side-cat").css("left","0")
     }
      function closer (){
         $(".main-side-cat").css("left","-100%")
     }
 </script>
  <!-- <script>
    (function () {

      var dlgtrigger = document.querySelector('[data-dialog]'),
      somedialog = document.getElementById(dlgtrigger.getAttribute('data-dialog')),
      dlg = new DialogFx(somedialog);

      dlgtrigger.addEventListener('click', dlg.toggle.bind(dlg));

    })();
  </script> -->


<script>
let firstVal = $(".first-step input").val();

// first step
$(".stepper1").click(function() {
    
if(firstVal === ""){
    $(".first-step input").addClass("not-valid");
}
else{
     $(".first-step").removeClass("incomplete");
     $(".first-step").addClass("complete");
     
    $(".second-step").removeClass("not-shown");
     $(this).css("display","none");
   
}
})

$(".first-step input").change(
   function(){
       firstVal = $(".first-step input").val()
         $(".first-step input").removeClass("not-valid");
         
   })
   
// second-step
let subValue = $("#reqoptions").val();
let otherCatCheck =  $('#othercategory').hasClass("sub-shown");
let otherSub = $("#reqoptionso").val();

   $(".second-step input[type=radio]").change(
   function(){
         $(".subs").removeClass("not-shown");
   })

// second sub step
$("#reqoptions").change(function(){
     subValue = $(this).val();
     $("#subcategory select").removeClass("not-valid") ; 
     otherCatCheck =  $('#othercategory').hasClass("sub-shown");
   
});

$("#reqoptionso").change(function(){
  otherSub = $(this).val();
  $(this).removeClass("not-valid")
});

$(".stepper11").click(function(){
    subValue = $("#reqoptions").val();
    otherSub = $("#reqoptionso").val();
    otherCatCheck =  $('#othercategory').hasClass("sub-shown");
   // conditions
    if(subValue === "no-val" || subValue === ""){
     $("#subcategory select").addClass("not-valid") ;  
    }
    else{
        if (otherCatCheck === true){
            if(otherSub === "no-sub" || otherSub === ""){
                $("#reqoptionso").addClass("not-valid") 
            }
            else{
                 $(".third-step").removeClass("not-shown");
                 $(this).css("display","none");
            }
        }
        
         else{
                 $(".third-step").removeClass("not-shown");
                 $(this).css("display","none");
            }
        
    }
});

// third step
$(".stepper2").click(function() {
    $(".forth-step").removeClass("not-shown");
      $(this).css("display","none");
})

$(".third-step textarea").change(
   function(){
       desVal =   $(".third-step textarea").val()
         $(".third-step textarea").removeClass("not-valid");
   })
   
// fourth step
let val1 =  $(".price-main").val();
let val2 =  $(".forth-step input[name*='pic']").val();
let val3 =  $("#datepicker").val();

$(".stepper3").click(function() {
    
if(val1 === ""){
$(".price-main").addClass("not-valid");
} 
if(val2 === "") {
   $(".forth-step input[name*='pic']").addClass("not-valid");
    
}
if(val3 === "") {
   $("#datepicker").addClass("not-valid");
    
}

if(val1 !== "" && val2 !== "" && val3 !== "" ){
     
    $(".fifth-step").removeClass("not-shown");
     $(this).css("display","none");
   
}
})

$(".forth-step input").change(
    function(){
val1 =  $(".price-main").val();
val2 =  $(".forth-step input[name*='pic']").val();
val3 =  $("#datepicker").val();

$(this).removeClass("not-valid");

    });

$(".fifth-step input").change(
    function(){
 $(".last-step").removeClass("not-shown");
    });


</script>



  @yield('footer')

</body>

</html>