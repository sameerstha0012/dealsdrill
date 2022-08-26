<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <link rel="icon" href="{{ asset('images/logo.fw.png') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
  crossorigin="anonymous">
  <!-- Bootstrap Core CSS -->
  <link href="{{ asset('seller/css/animate.css') }}" rel="stylesheet">
  <link href="{{ asset('seller/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('seller/css/colorbox.css') }}">
  <link rel="stylesheet" href="{{ asset('seller/css/hover-min.css') }}">
  <link rel="stylesheet" href="{{ asset('seller/css/dialog.css') }}">
  <link rel="stylesheet" href="{{ asset('seller/css/dialog-wilma.css') }}">
  <link href="{{ asset('seller/css/main.css') }}" rel="stylesheet">
  <script src="{{ asset('seller/js/jquery3.3.1.min.js') }}"></script>
  <script src="{{ asset('seller/js/popper.min.js') }}"></script>
  <script src="{{ asset('seller/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('seller/js/modernizr.custom.js') }}"></script>

   @yield('header')

</head>

<body>
  <header>
    <div class="">
      <div class="row">
        <div class="col-md-3 logo side-div">
          <a href="{{ url('/') }}">
            <img src="{{ asset('uploads/settings/'.$setting->pic) }}" alt="{{ $setting->title }}" style="max-width:120px;">
          </a>
        </div>

        <!-- actions-->
        <div class="col-md-9 header-main-wrap">
          <div class="header-main dash-inner">
            <div class="sm-round img-container">
              <img src="@if(Auth::guard('web')->user()->pic != '') {{ asset('uploads/users/'.Auth::guard('web')->user()->pic) }} @else {{ asset('images/icons/default.fw.png') }}" alt="{{ ucwords(Auth::guard('web')->user()->name) }} @endif" alt="{{ ucwords(Auth::guard('web')->user()->name) }}" class="img-fitted">
            </div>
            <h5>Hello, {{ ucwords(Auth::guard('web')->user()->name) }}</h5>
            <button class="menu-trigger" onClick="sider()"><i class="fas fa-bars"></i></button>
          </div>


        </div>
      </div>
    </div>
  </header>

  @yield('content')

  <!-- footer-->
  <footer>
    <div class="copyrights">
      <div class="container text-center">
        <p>Copyright {{ date('Y') }}. All rights reserved.</p>
      </div>
    </div>
  </footer>
  <!-- owl sliders -->
  <script src="{{ asset('seller/js/owl.carousel.js') }}"></script>
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
      $(".group2").colorbox({ rel: 'group2', transition: "fade" });
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
  <script src="{{ asset('seller/js/jquery.colorbox.js') }}"></script>
  <script src="{{ asset('seller/js/plugins.min.js') }}"></script>
  <script src="{{ asset('seller/js/classie.js') }}"></script>
  <script src="{{ asset('seller/js/dialogFx.js') }}"></script>
  <script>
    (function () {

      // var dlgtrigger = document.querySelector('[data-dialog]'),
      // somedialog = document.getElementById(dlgtrigger.getAttribute('data-dialog')),
      // dlg = new DialogFx(somedialog);

      // dlgtrigger.addEventListener('click', dlg.toggle.bind(dlg));

    })();
  </script>
 <script>
     function sider (){
         $(".dash-nav-wrap").css("left","0")
     }
      function closer (){
         $(".dash-nav-wrap ").css("left","-300px")
     }
 </script>
  @yield('footer')
  
</body>

</html>