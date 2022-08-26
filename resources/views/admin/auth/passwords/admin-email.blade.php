<!DOCTYPE html>
<html lang="en" >
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>
            Admin Login
        </title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--begin::Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script>
          WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>
        <!--end::Web font -->
        <!--begin::Base Styles -->
        <link href="{{ asset('administrator/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('administrator/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="{{ asset('administrator/fav.png') }}" />
    </head>
    <!-- end::Head -->
    <!-- end::Body -->
    <body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login" style="background-image: url({{ asset('administrator/app/media/img//bg/bg-1.jpg') }});">
                <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
                    <div class="m-login__container">
                        <div class="m-login__logo">
                            <a href="#">
                                <img src="{{ asset('administrator/logo.png') }}">
                            </a>
                        </div>
                        <div class="m-login__forget-password animated flipInX" style="display:block;">
                            <div class="m-login__head">
                                <h3 class="m-login__title">
                                    Forgotten Password ?
                                </h3>
                                <div class="m-login__desc">
                                    Enter your email to reset your password:
                                </div>
                            </div>

                            @include('admin/layouts/error')

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form class="m-login__form m-form" action="{{ route('admin.password.email') }}" method="POST">

                            {{ csrf_field() }}

                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" value="{{ old('email') }}" autocomplete="off">
                                </div>
                                <div class="m-login__form-action">
                                    <button id="m_login_forget_password_submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                        Request
                                    </button>
                                    &nbsp;&nbsp;
                                    <a href="{{ url('admin') }}" id="m_login_forget_password_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Page -->
        <!--begin::Base Scripts -->
        <script src="{{ asset('administrator/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
        <script src="{{ asset('administrator/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
        <!--end::Base Scripts -->   
    </body>
    <!-- end::Body -->
</html>
