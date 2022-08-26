@section('title')

Profile

@endsection

@extends('dashboard.layouts.app')

@section('content')

<!-- main categories -->
<section class="dash-wrapper">
  <div class="row">
    <!-- side bar -->
    @include('dashboard/layouts/sidebar')

    <!-- main contents-->
    <div class="col-md-9 dash-content-wrap">

      @include('dashboard/layouts/profilebar')

      <!-- main contents -->
      <div class="dash-content pad-top">
        <div class="dash-inner">
          <div class="custom-table col-md-6">
            <div class="custom-table-in">

              @include('admin/layouts/error')

              <form class="common-form setting-form" name="password change" method="POST" action="{{ url('password-change') }}">
                @csrf

                <div class="form-group-wrap">
                  <h4 class="table-title ">CHANGE PASSWORD
                    <span>Change your password or recover your current one.</span>
                  </h4>
                  <div class="">
                    <div class="form-group">
                      <label>New Password:</label>
                      <input type="password" name="password">
                    </div>
                    <div class="form-group">
                      <label>Confirm Password:</label>
                      <input type="password" name="password_confirmation">
                    </div>
                  </div>
                </div>
                <div class="form-group text-right">
                  <button type="submit" class="basic-btn">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
