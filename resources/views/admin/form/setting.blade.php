@section('title')

Settings

@endsection

@extends('admin/layouts/app')

@section('content')

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Settings
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ route('admin.dashboard') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="{{ url('admin/settings') }}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Settings
                            </span>
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
                                    <?php if(isset($setting)) { echo "Edit"; } else { echo "Add"; } ?> Settings
                                </h3>
                            </div>
                        </div>
                    </div>

                    <?php 
                        if(isset($setting)) {
                            $action = url('/admin/setting/'.$setting->id.'/edit');
                        } else {
                            $action = url('/admin/setting/add/');
                        } ?>

                    <!--begin::Form-->
                    <form class="m-form" action="{{ $action }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}

                        <div class="m-portlet__body">
                            <div class="m-form__section m-form__section--first">
                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">
                                    Name:
                                    </label>
                                        <input type="text" name="title" class="form-control m-input" placeholder="Name" value="<?php if(isset($setting)) { echo $setting->title; } else { echo old('title'); }  ?>">
                                </div>
                                <div class="form-group m-form__group">
                                    <label>
                                    Email:
                                    </label>
                                        <input type="text" name="email" class="form-control m-input" placeholder="Email" value="<?php if(isset($setting)) { echo $setting->email; } else { echo old('email'); }  ?>">
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">
                                    Phone:
                                    </label>
                                        <input type="text" name="phone" class="form-control m-input" placeholder="Phone" value="<?php if(isset($setting)) { echo $setting->phone; } else { echo old('phone'); }  ?>">
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">
                                    Address:
                                    </label>
                                        <input type="text" name="address" class="form-control m-input" placeholder="Address" value="<?php if(isset($setting)) { echo $setting->address; } else { echo old('address'); }  ?>">
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="pic">
                                        Logo
                                    </label>
                                    <div></div>
                                    <div class="custom-file" style="width:40%">
                                        <input type="file" name="pic" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label selected" for="customFile">Choose file</label>
                                    </div>

                                    @if (!empty($setting->pic))
                                    <hr>
                                        <img src="{{ asset('uploads/'.'settings/'.$setting->pic) }}" alt="<?php if(isset($setting)) { echo $setting->pic; } ?>" height="100" width="100">
                                    @endif

                                </div>

                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">SEO Keyword</label>
                                    <input type="text" name="seo_keyword" class="form-control m-input" 
                                        placeholder="Enter SEO Keyword" 
                                        value="<?= (isset($setting))?$setting->seo_keyword:old('seo_keyword'); ?>">
                                </div>

                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">SEO Title</label>
                                    <input type="text" name="seo_title" class="form-control m-input" 
                                        placeholder="Enter SEO Title" 
                                        value="<?= (isset($setting))?$setting->seo_title:old('seo_title'); ?>">
                                </div>

                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">SEO Description</label>
                                    <input type="text" name="seo_desc" class="form-control m-input" 
                                        placeholder="Enter SEO Description" 
                                        value="<?= (isset($setting))?$setting->seo_desc:old('seo_desc'); ?>">
                                </div>

                            </div>
                        </div>

                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                                <a href="{{ url('admin/settings') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
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