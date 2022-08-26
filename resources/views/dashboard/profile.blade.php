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
            <div class="custom-table">
              <div class="custom-table-in">

                @include('admin/layouts/error')

                <form class="common-form setting-form" name="profile" method="POST" action="{{ url('profile') }}" enctype="multipart/form-data">
                  @csrf

                  <div class="form-group-wrap">
                    <h4 class="table-title ">Account</h4>
                    <div class="row">
                      <div class="col-md-6">
                        <label>Name:</label>
                        <input type="text" name="name" value="{{ Auth::guard('web')->user()->name }}">
                      </div>
                      <div class="col-md-6">
                        <label>Email:</label>
                        <input type="email" name="email" value="{{ Auth::guard('web')->user()->email }}">
                      </div>
                    </div>
                  </div>
                  <div class="form-group-wrap">
                    <h4 class="table-title ">Details</h4>
                    <div class="row">
                      <div class="col-md-6">
                        <label>Phone:</label>
                        <input type="text" name="phone" value="{{ Auth::guard('web')->user()->phone }}">
                      </div>
                      <div class="col-md-6">
                        <label>Address:</label>
                        <input type="text" name="address" value="{{ Auth::guard('web')->user()->address }}">
                      </div>
                    </div>
                  </div>

                  <div class="form-group-wrap">
                    <h4 class="table-title ">Profile Picture</h4>
                    <div class="row">
                      <div class="col-md-6">
                        <label>Profile:</label>
                        <input type="file" name="pic">
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
