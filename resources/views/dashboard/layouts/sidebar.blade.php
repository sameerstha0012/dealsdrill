<div class="col-md-3 side-div dash-nav-wrap">
    <button onClick="closer()" class="close-trigger"><i class="fas fa-arrow-left"></i></button>
  <ul class=" dash-nav">
    <li class="active">
      <a href="{{ url('/dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
    </li>
    <li><a href="#items-menu" data-toggle="collapse" class="collapsed"><i class="fas fa-bullhorn"></i>Ads/Items <span class="fas fa-caret-down"></span> </a>
      <ul class="sub-menu collapse" id="items-menu">
        <li><a href="{{ url('/items') }}"><i class="fas fa-circle"></i>All Items</a></li>
        <li><a href="{{ url('/items/list') }}"><i class="fas fa-circle"></i>Listed Items</a></li>
        <li><a href="{{ url('/items/sold') }}"><i class="fas fa-circle"></i>Sold Items</a></li>
      </ul>
    </li>
    <li>
      <a href="{{ url('/profile') }}"><i class="fas fa-user"></i>Profile</a>
    </li>
    <li>
      <a href="{{ url('/password-change') }}"><i class="fas fa-key"></i>Change Password</a>
    </li>
    <li>
      <a href="{{ url('logout') }}"><i class="fas fa-power-off"></i>Logout</a>
    </li>
  </ul>
</div>