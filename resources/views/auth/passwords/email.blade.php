@section('title')

Forgot Password

@endsection

@extends('layouts.page')

@section('content')


  <!-- reset page-->
  <section class="reset-page pad-top pad-bot inner-page full-section">
    <style>
      .reset-title {font-size:22px; font-weight:700; color:#00B2B2;}
      .reset-wrap form {max-width:500px; margin:0 auto; margin-top:30px;}
      .reset-wrap span{display:block; color:#666; font-size:18px;}
      </style>
    <div class="container">
      <div class="reset-wrap text-center">
        <h1 class="reset-title">Please Enter Your Email.</h1>

        @include('admin/layouts/error')

        <form class="common-form" method="POST" action="{{ route('password.email') }}">
        @csrf
          <div class="form-group">
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
          </div>
          <div class="form-group">
            <button type="submit" class="form-btn">{{ __('Send Password Reset Link') }}</button>
          </div>
        </form>
        <!--<span>or</span>-->
        <!--<a class="basic-btn" style="color:#fff; margin-top:15px;">Use Phone Number</a>-->

      </div>
    </div>
  </section>

@endsection
