<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <link href="{{ asset('administrator/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('administrator/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="{{ asset('images/fav.fw.png') }}" />

    @yield('header')

</head>
<body  class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <header id="m_header" class="m-grid__item    m-header "  m-minimize-offset="200" m-minimize-mobile-offset="200" >
            <div class="m-container m-container--fluid m-container--full-height">
                <div class="m-stack m-stack--ver m-stack--desktop">
                    <div class="m-stack__item m-brand  m-brand--skin-dark ">
                        <div class="m-stack m-stack--ver m-stack--general">
                            <div class="m-stack__item m-stack__item--middle m-brand__logo">
                                <a href="{{ route('admin.dashboard') }}" class="m-brand__logo-wrapper">
                                    Admin Panel
                                </a>
                            </div>
                            <div class="m-stack__item m-stack__item--middle m-brand__tools">
                                <a href="javascript:;" id="m_aside_left_minimize_toggle" 
                                    class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block">
                                    <span></span>
                                </a>
                                <a href="javascript:;" id="m_aside_left_offcanvas_toggle" 
                                    class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                    <span></span>
                                </a>
                                <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" 
                                    class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                    <i class="flaticon-more"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                        <button class="m-aside-header-menu-mobile-close m-aside-header-menu-mobile-close--skin-dark" 
                            id="m_aside_header_menu_mobile_close_btn">
                            <i class="la la-close"></i>
                        </button>
                        <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                            <div class="m-stack__item m-topbar__nav-wrapper">
                                <ul class="m-topbar__nav m-nav m-nav--inline">
                                    <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img 
                                        m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 
                                        m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1">
                                        <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                                            <span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
                                            <span class="m-nav__link-icon">
                                                <i class="flaticon-music-2"></i>
                                            </span>
                                        </a>
                                        <div class="m-dropdown__wrapper">
                                            <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__header m--align-center" 
                                                    style="background: url({{ asset('administrator/app/media/img/misc/notification_bg.jpg') }}); background-size: cover;">
                                                    <span class="m-dropdown__header-title">1 New</span>
                                                    <span class="m-dropdown__header-subtitle">Notifications</span>
                                                </div>
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
                                                                <div class="m-scrollable" data-scrollable="true" data-max-height="250" data-mobile-max-height="200">
                                                                    <div class="m-list-timeline m-list-timeline--skin-light">
                                                                        <div class="m-list-timeline__items">
                                                                            <div class="m-list-timeline__item">
                                                                                <span class="m-list-timeline__badge -m-list-timeline__badge--state-success"></span>
                                                                                    <span class="m-list-timeline__text">
                                                                                </span>
                                                                            </div>
                                                                            <style>
                                                                                .m-list-timeline__text a{
                                                                                    text-decoration: none;
                                                                                    color: #575962!important;
                                                                                }
                                                                            </style>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img 
                                        m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill 
                                        m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                                        <a href="#" class="m-nav__link m-dropdown__toggle">
                                            <span class="m-topbar__userpic">
                                                <img src="{{ asset('uploads/admins/'.Auth::guard('admin')->user()->pic) }}" 
                                                    class="m--img-rounded m--marginless m--img-centered" alt=""/>
                                            </span>
                                            <span class="m-topbar__username m--hide">
                                                {{ ucwords(Auth::guard('admin')->user()->name) }}
                                            </span>
                                        </a>
                                        <div class="m-dropdown__wrapper">
                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__header m--align-center" 
                                                    style="background: url({{ asset('administrator/app/media/img/misc/user_profile_bg.jpg') }}); background-size: cover;">
                                                    <div class="m-card-user m-card-user--skin-dark">
                                                        <div class="m-card-user__pic">
                                                            <img src="{{ asset('uploads/'.'admins/'.Auth::guard('admin')->user()->pic) }}" 
                                                                class="m--img-rounded m--marginless" alt=""/>
                                                        </div>
                                                        <div class="m-card-user__details">
                                                            <span class="m-card-user__name m--font-weight-500">
                                                                {{ ucwords(Auth::guard('admin')->user()->name) }}
                                                            </span>
                                                            <a href="" class="m-card-user__email m--font-weight-300 m-link">
                                                                {{ ucwords(Auth::guard('admin')->user()->email) }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav m-nav--skin-light">
                                                            <li class="m-nav__section m--hide">
                                                                <span class="m-nav__section-text">Section</span>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="{{ url('admin/profile') }}" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                                    <span class="m-nav__link-title">
                                                                        <span class="m-nav__link-wrap">
                                                                            <span class="m-nav__link-text">My Profile</span>
                                                                            <span class="m-nav__link-badge">
                                                                                <span class="m-badge m-badge--success">2</span>
                                                                            </span>
                                                                        </span>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__separator m-nav__separator--fit"></li>
                                                            <li class="m-nav__item">
                                                                <a href="{{ url('admin/logout') }}" 
                                                                    class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                                                    Logout</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

            @include('admin/layouts/sidebar')
            
            <div class="m-grid__item m-grid__item--fluid m-wrapper">
                <div id="app">
                    <flash message=""></flash>
                    @yield('content')
                </div>
            </div>
        </div>
        <footer class="m-grid__item m-footer ">
            <div class="m-container m-container--fluid m-container--full-height m-page__container">
                <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
                    <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
                        <span class="m-footer__copyright">
                            {{ date('Y') }} &copy; Rewa Soft Pvt. Ltd
                            <a href="http://rewasoft.com.np/" class="m-link">
                                Rewa Soft Pvt. Ltd
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </footer>
      </div>
      <div id="m_scroll_top" class="m-scroll-top">
        <i class="la la-arrow-up"></i>
    </div>
    
    <div id="alertMessage"></div>
    <style>
        .loader {
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.5);
            text-align: center;
            z-index: 999999;
        }
    
        .loader h3 {
            font-size: 15px;
            font-weight: 400;
            padding: 10px;
            margin-bottom: 0;
            margin-top:13%;
            width: 180px;
            height: 40px;
            background-position: center;
            background: white;
            box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);
            color:#575962;
            display: inline-block;
        }
    
        .m-loader {
            width: 50px;
            display: inline-block;
        }
    
        .m-loader:before {
            margin-top: -13px;
            border-top-width: 3px;
            border-right-width: 3px;
        }
    </style>
    
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('administrator/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('administrator/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
    
    @yield('footer')
    
</body>
</html>