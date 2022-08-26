<div class="dash-top">
    
@if (!Auth::guard('web')->user()->verified)
  	<div class="alert alert-danger alert-dismissible">
    	<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
        <p><strong><i class="fa fa-ban" aria-hidden="true"></i> Please verify your email to continue.</strong></p>
</div>
@endif

  <div class="dash-inner">
    <div class="lg-round img-container">
      <img src="@if(Auth::guard('web')->user()->pic != '') {{ asset('uploads/users/'.Auth::guard('web')->user()->pic) }} @else {{ asset('images/icons/default.fw.png') }}" alt="{{ ucwords(Auth::guard('web')->user()->name) }} @endif" class="img-fitted">
    </div>
    
     <div class="top-info-in top-info-mob">
          <h3>{{ ucwords(Auth::guard('web')->user()->name) }}</h3>
          <h5><span>Member Since:</span>{{ Auth::guard('web')->user()->created_at->toFormattedDateString() }}</h5>
        </div>
    
    <!-- top details and actions -->
    <div class="top-actions-wrap">
      <div class="top-info">
        <div class="top-info-in top-info-tab">
          <h3>{{ ucwords(Auth::guard('web')->user()->name) }}</h3>
          <h5><span>Member Since:</span>{{ Auth::guard('web')->user()->created_at->toFormattedDateString() }}</h5>
        </div>
        <div class="top-actions">
          <a href="{{ url('profile') }}" class="basic-btn basic-btn2"><i class="fas fa-edit"></i>Edit Profile</a>
          <a href="{{ url('sell') }}" class="basic-btn"><i class="fas fa-camera"></i>Sell Now</a>
        </div>
      </div>
      <!-- other-infos-->
      <div class="other-infos">
        <div class="other-info-in">
          <h5>Phone:</h5>
          <span>{{ Auth::guard('web')->user()->phone }}</span>
        </div>
        <div class="other-info-in">
          <h5>Email:</h5>
          <span>{{ Auth::guard('web')->user()->email }}</span>
        </div>
        <div class="other-info-in">
          <h5>Location:</h5>
          <span>{{ ucwords(Auth::guard('web')->user()->address) }}</span>
        </div>
      </div>
    </div>
  </div>
</div>