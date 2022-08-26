@section('title')

{{ ucwords($page->name) }}

@endsection

@extends('layouts.page')

@section('content')

  <!-- help page-->
  <section class="reset-page pad-top pad-bot inner-page full-section" style="background:#f3f3f5">
    <style>
      .help-title {
        font-size: 22px;
        font-weight: 700;
        color: #00B2B2;
      }

      .collaspe-list,
      .small-list {
        list-style: none
      }

      .collaspe-list>li {
        padding-top: 15px;
      }

      .helps-collaspe {
        max-width: 600px;
        background: #fff;
        padding: 15px 20px;
        margin: 0 auto;
        margin-top: 20px;
        padding-bottom: 30px;
      }

      .collaspe-list>li>a {
        display: flex;
        color: #5f717e;
        font-weight: 600;
        font-size: 15px;
        border: 1px solid #ddd;
        padding: 15px;
      }

      .helps-collaspe li a i {
        font-size: 18px;
        margin-right: 10px;
        padding-top: 2px;
      }

      .helps-collaspe li a span {
        margin-left: auto;
        font-size: 18px;
        padding-top: 4px;
        transform: rotate(180deg) !important;
      }

      .helps-collaspe .collapsed span {
        transform: rotate(0deg) !important;
      }

      .small-list {
        padding-left: 20px;
        padding-top: 10px;
        padding-bottom: 10px;
      }

      .small-list li a {
        font-size: 13px;
        color: #7c92a2;
        font-weight: 500;
      }

      .small-list li a i {
        font-size: 12px;
        margin-right: 8px;
      }

      .small-list li a:hover {
        color: #00a3d9
      }
    </style>
    <div class="container">
      <div class="helps-wrap text-center">
        <h1 class="help-title">Need Any Help?</h1>
        <!-- helps tabs-->
        <div class="helps-collaspe text-left">
          <ul class="collaspe-list">
            <!-- about-->
            <li>
              <a href="#about-tab" data-toggle="collapse" class="collapsed"><i class="fas fa-info-circle"></i>About
                Deals Drill<span class="fas fa-angle-down"></span></a>
              <div id="about-tab" class="collapse">
                <ul class="small-list">
                  <li><a href="{{ url('dealsdrill/about-us') }}"><i class="fas fa-angle-double-right"></i>What is Deals Drills?</a></li>
                </ul>
              </div>
            </li>

            <!-- post ad -->
            <li>
              <a href="#post-tab" data-toggle="collapse" class="collapsed"><i class="fas fa-tags"></i>Post an
                Ad<span class="fas fa-angle-down"></span></a>
              <div id="post-tab" class="collapse">
                <ul class="small-list">
                  <li><a href="{{ url('dealsdrill/how-to-post') }}"><i class="fas fa-angle-double-right"></i>How to Post?</a></li>
                  <li><a href="{{ url('dealsdrill/what-to-post') }}"><i class="fas fa-angle-double-right"></i>What to Post?</a></li>
                </ul>
              </div>
            </li>
            <!-- manage ads -->
            <li>
              <a href="#manage-tab" data-toggle="collapse" class="collapsed"><i class="fas fa-edit"></i>Manage
                Ads<span class="fas fa-angle-down"></span></a>
              <div id="manage-tab" class="collapse">
                <ul class="small-list">
                  <li><a href="{{ url('dealsdrill/renew-ads') }}"><i class="fas fa-angle-double-right"></i>Renew Ads</a></li>
                  <li><a href="{{ url('dealsdrill/mark-ads') }}"><i class="fas fa-angle-double-right"></i>Mark Ads</a></li>
                </ul>
              </div>
            </li>

            <!-- Accoint -->
            <li>
              <a href="#account-tab" data-toggle="collapse" class="collapsed"><i class="fas fa-user"></i>My Account<span
                  class="fas fa-angle-down"></span></a>
              <div id="account-tab" class="collapse">
                <ul class="small-list">
                  <li><a href="{{ url('dealsdrill/login') }}"><i class="fas fa-angle-double-right"></i>Login</a></li>
                  <li><a href="{{ url('dealsdrill/register') }}"><i class="fas fa-angle-double-right"></i>Register Account</a></li>
                </ul>
              </div>
            </li>
            <!-- Site policies -->
            <li>
              <a href="#policy-tab" data-toggle="collapse" class="collapsed"><i class="fas fa-flag"></i>Site Policies<span
                  class="fas fa-angle-down"></span></a>
              <div id="policy-tab" class="collapse">
                <ul class="small-list">
                  <li><a href="{{ url('dealsdrill/terms-of-use') }}"><i class="fas fa-angle-double-right"></i>Terms of Use</a></li>
                  <li><a href="{{ url('dealsdrill/posting-rules') }}"><i class="fas fa-angle-double-right"></i>Posting Rules</a></li>
                </ul>
              </div>
            </li>

          </ul>
        </div>

      </div>
    </div>
  </section>
@endsection
