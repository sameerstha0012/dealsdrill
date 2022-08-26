@section('title')

Profile | Americar Shuttle

@endsection

@extends('admin/layouts/app')

@section('content')

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Profile
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">

        @include('admin/layouts/error')

        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide">
                                    <i class="la la-gear"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    Profile
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <form class="m-form" action="{{ url('admin/profile') }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}

                        <div class="m-portlet__body">
                            <div class="m-form__section m-form__section--first">
                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">
                                    Name:
                                    </label>
                                        <input type="text" name="name" class="form-control m-input" placeholder="Name" value="{{ Auth::guard('admin')->user()->name }}">
                                </div>
                                <div class="form-group m-form__group">
                                    <label>
                                    Email:
                                    </label>
                                        <input type="text" name="email" class="form-control m-input" placeholder="Email" value="{{ Auth::guard('admin')->user()->email }}">
                                </div>
                                <div class="form-group m-form__group">
                                    <label>
                                    Password:
                                    </label>
                                        <input type="password" name="password" class="form-control m-input" placeholder="Password">
                                </div>
                                <div class="form-group m-form__group">
                                    <label>
                                    Password Confirmation:
                                    </label>
                                        <input type="password" name="password_confirmation" class="form-control m-input" placeholder="Password Confirmation">
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="pic">
                                        Profile Picture
                                    </label>
                                    <div></div>
                                    <div class="custom-file" style="width:40%">
                                        <input type="file" name="pic" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label selected" for="customFile">Choose file</label>
                                    </div>

                                    @if (!empty(Auth::guard('admin')->user()->email))
                                    <hr>
                                        <img src="{{ asset('uploads/'.'admins/'.Auth::guard('admin')->user()->pic) }}" alt="{{ Auth::guard('admin')->user()->name }}" height="100" width="100">
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->

            </div>

        </div>

    </div>

@endsection