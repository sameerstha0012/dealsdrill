@section('title')

{{ ucwords($setting->title) }} : Login

@endsection

@extends('layouts.page')

@section('content')

  <!-- login page-->
  <section class="login-page inner-page">
    <div class="">
      <div class="row">
        <!-- login -infos-->
        <div class="col-md-6 login-infos">
          <div class="login-infos-list">
            <!-- info -->
            <div class="login-info">
                <div>
                     <span>
                1
              </span>
                </div>
             
              <!-- title-->
              <h4>Browse deals on tons of great items nearby.</h4>
            </div>
            <!-- info -->
            <div class="login-info">
                <div>
                    <span>
                2
              </span> 
                </div>
             
              <!-- title-->
              <h4>Sell something of your own.</h4>
            </div>
            <!-- info -->
            <div class="login-info">
                <div>
                    <span>
                3
              </span> 
                </div>
             
              <!-- title-->
              <h4>Instantly message seller.</h4>
            </div>
          </div>
        </div>

        <!-- login form-->
        <div class="col-md-6 login-form-wrap outer-wrap pad-bot">
            <div class="row">
          <div class="login-form inner-wrap col-md-7">
            <h1 class="mid-heading" style="max-width: 300px;">See what’s on sale around you.</h1>

            @include('admin/layouts/error')

            <form class="common-form outer-form" name="login" method="POST" action="{{ route('login') }}">
            @csrf
              <div class="form-group">
                <input type="text" placeholder="Email" name="email" value="{{ old('email') }}" >
              </div>
              <div class="form-group">
                <input type="password" placeholder="Password" name="password">
              </div>
              <div class="form-group">
                <button class="form-btn">Login</button>
                <a href="{{ route('password.request') }}" style="font-size: 13px;
                color: #9dacb2;
                margin-top: 8px;
                margin-left: 15px;">Forgot
                  Password?</a>
              </div>
            </form>

           
          </div>
          <!-- sign up -->
           <!-- sign up links -->
            <div class="signup-links text-center col-md-5">
                <div class="signup-links-in">
                    <span>or</span>
              <h4>Join Us Today.</h4>
              <a href="{{ route('register') }}" class="form-btn2">Signup</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
