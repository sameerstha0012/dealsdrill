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
        <h1 class="reset-title">{{ __('Reset Password') }}</h1>

        @include('admin/layouts/error')


        <form class="common-form" method="POST" action="{{ route('password.request') }}">
        @csrf

            <input type="hidden" name="token" value="{{ $token }}">

          <div class="form-group">
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
          </div>
          <div class="form-group">
            <input type="password" name="password" placeholder="Password" required>
          </div>
          <div class="form-group">
            <input type="password" name="password_confirmation" placeholder="Password Confirmation">
          </div>
          <div class="form-group">
            <button type="submit" class="form-btn">{{ __('Reset Password') }}</button>
          </div>
        </form>

      </div>
    </div>
  </section>

@endsection
