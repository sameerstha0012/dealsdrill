@section('title')

Category

@endsection

@extends('admin/layouts/app')

@section('content')

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Category
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
                        <a href="{{ url('admin/categories') }}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Category
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
                                    <?php if(isset($category)) { echo "Edit"; } else { echo "Add"; } ?> Menu
                                </h3>
                            </div>
                        </div>
                    </div>

                    <?php 
                        if(isset($category)) {
                            $action = url('/admin/category/'.$category->id.'/edit');
                        } else {
                            $action = url('/admin/category/add/');
                        } ?>

                    <!--begin::Form-->
                    <form class="m-form" action="{{ $action }}" method="post" enctype="multipart/form-data">

                        {{ csrf_field() }}

                        <div class="m-portlet__body">
                            <div class="m-form__section m-form__section--first">
                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">
                                    Name
                                    </label>
                                        <input type="text" name="name" class="form-control m-input" placeholder="Name" value="<?php if(isset($category)) { echo $category->name; } else { echo old('name'); }  ?>">
                                </div>

                                <div class="form-group m-form__group">
                                    <label>
                                    Order
                                    </label>
                                        <input type="number" name="order" class="form-control m-input" placeholder="Order" value="<?php if(isset($category)) { echo $category->order; } else { echo old('order'); }  ?>">
                                </div>

                                <div class="form-group m-form__group">
                                    <label for="pic">
                                        Pic
                                    </label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" name="pic" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label selected" for="customFile">Choose file</label>
                                    </div>

                                    @if (!empty($category->pic))
                                    <hr>
                                        <img src="{{ asset('uploads/'.'categories/'.$category->pic) }}" alt="<?php if(isset($category)) { echo $category->name; } ?>" height="100" width="100">
                                    @endif

                                </div>

                                <div class="form-group m-form__group">
                                    <label>
                                    Description
                                    </label>
                                    <textarea name="description" class="form-control tinymce" cols="50" rows="5"><?php if(isset($category)) { echo $category->description; } else {echo old('description'); } ?></textarea>
                                </div>

                                <div class="m-form__group form-group">
                                    <label for="">Status</label>
                                    <div class="m-radio-inline">
                                        <label class="m-radio">
                                            <input type="radio" name="status" value="Active" <?php echo (isset($category->status)?((isset($category->status)&&($category->status == 'Active'))?'checked="checked"':''):'checked="checked"');?>>
                                            Active
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" name="status" value="Banned" <?php echo (isset($category->status)&&($category->status == 'Banned'))?'checked="checked"':'';?>>
                                            Banned
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">SEO Keyword</label>
                                    <input type="text" name="seo_keyword" class="form-control m-input" 
                                        placeholder="Enter SEO Keyword" 
                                        value="<?= (isset($category))?$category->seo_keyword:old('seo_keyword'); ?>">
                                </div>

                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">SEO Title</label>
                                    <input type="text" name="seo_title" class="form-control m-input" 
                                        placeholder="Enter SEO Title" 
                                        value="<?= (isset($category))?$category->seo_title:old('seo_title'); ?>">
                                </div>

                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">SEO Description</label>
                                    <input type="text" name="seo_desc" class="form-control m-input" 
                                        placeholder="Enter SEO Description" 
                                        value="<?= (isset($category))?$category->seo_desc:old('seo_desc'); ?>">
                                </div>

                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                                <a href="{{ url('admin/categories') }}" class="btn btn-secondary">
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

@section('footer')
    @include('admin/layouts/tinymce')
@endsection
