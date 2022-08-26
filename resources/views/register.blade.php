@section('title')

{{ ucwords($setting->title) }} : Register

@endsection

@extends('layouts.page')

@section('content')

  <!-- register page-->
  <section class="login-page inner-page">
    <div class="">
      <div class="row">
        <!-- login -infos-->
        <div class="col-md-6 login-infos register-infos">
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

        <!-- register form-->
        <div class="col-md-6 login-form-wrap outer-wrap pad-bot">
          <div class="login-form inner-wrap">
            <h1 class="mid-heading" style="max-width: 300px;">Get access to the world of buy and sales.</h1>

            @include('admin/layouts/error')
            
            <form class="common-form outer-form" name="register" method="POST" action="{{ route('register') }}">
              @csrf
              <div class="form-group">
                <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}">
              </div>
              <div class="form-group">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
              </div>
              <div class="form-group">
                <input type="text" name="phone" placeholder="Phone" value="{{ old('phone') }}">
              </div>
              <div class="form-group">
                <input type="text" name="address" placeholder="Address" value="{{ old('address') }}">
              </div>
              <div class="form-group">
                <input type="password" name="password" placeholder="Password" >
              </div>
              <div class="form-group">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" >
              </div>

              <div class="form-group">
                <button class="form-btn">Register Now</button>
                <span href="#" style="font-size: 13px;
                color: #9dacb2;
                margin-top: 8px;
                margin-left: 15px;">Clicking
                  Register, you accept our
                  <a href="{{ url('dealsdrill/terms-of-use') }}" style="color:#FF7F00; font-weight:600;">Terms of Use</a>
                </span>
              </div>
            </form>
          </div>
        </div>
  </section>

@endsection
