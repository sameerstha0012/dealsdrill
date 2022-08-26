@section('title')

Dashboard

@endsection

@extends('admin/layouts/app')

@section('content')

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">
                    Dashboard
                </h3>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="row">

            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                Welcome, {{ ucwords(Auth::guard('admin')->user()->name) }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body" style="padding:0">

                        <div class="row">
                        
                            <div class="col-xl-4">
                                <!--begin:: Widgets/Blog-->
                                <div class="m-portlet m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force">

                                    <div class="m-portlet__body">
                                        <div class="m-widget27 m-portlet-fit--sides">
                                            <div class="m-widget27__pic">
                                                <img src="{{ asset('administrator/app/media/img//bg/bg-4.jpg') }}" alt="">
                                                <h3 class="m-widget27__title m--font-light">
                                                    <span>
                                                        <span>
                                                            Total
                                                        </span>
                                                        {{ number_format($total, 0) }}
                                                    </span>
                                                </h3>
                                                <div class="m-widget27__btn">
                                                    <a href="{{ url('admin/products') }}">
                                                        <button type="button" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--bolder">
                                                            View Products
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end:: Widgets/Blog-->
                            </div>

                            <div class="col-xl-4">
                                <!--begin:: Widgets/Blog-->
                                <div class="m-portlet m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force">

                                    <div class="m-portlet__body">
                                        <div class="m-widget27 m-portlet-fit--sides">
                                            <div class="m-widget27__pic">
                                                <img src="{{ asset('administrator/app/media/img//bg/bg-5.jpg') }}" alt="">
                                                <h3 class="m-widget27__title m--font-light">
                                                    <span>
                                                        <span>
                                                            Available
                                                        </span>
                                                        {{ number_format($available, 0) }}
                                                    </span>
                                                </h3>
                                                <div class="m-widget27__btn">
                                                    <a href="{{ url('admin/products') }}">
                                                        <button type="button" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--bolder">
                                                            View Products
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end:: Widgets/Blog-->
                            </div>

                            <div class="col-xl-4">
                                <!--begin:: Widgets/Blog-->
                                <div class="m-portlet m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force">

                                    <div class="m-portlet__body">
                                        <div class="m-widget27 m-portlet-fit--sides">
                                            <div class="m-widget27__pic">
                                                <img src="{{ asset('administrator/app/media/img//bg/bg-6.jpg') }}" alt="">
                                                <h3 class="m-widget27__title m--font-light">
                                                    <span>
                                                        <span>
                                                            Users
                                                        </span>
                                                        {{ number_format($users, 0) }}
                                                    </span>
                                                </h3>
                                                <div class="m-widget27__btn">
                                                    <a href="{{ url('admin/users') }}">
                                                        <button type="button" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--bolder">
                                                            View Customers
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end:: Widgets/Blog-->
                            </div>
                        </div>

                    </div>
                </div>
                <!--end::Portlet-->
            </div>

        </div>
    </div>

@endsection


@section('footer')
@endsection