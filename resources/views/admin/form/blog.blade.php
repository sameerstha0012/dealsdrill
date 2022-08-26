@section('title') Blog @endsection

@extends('admin/layouts/app')

@section('content')

    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Blog
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
                        <a href="{{ route('admin.blogList') }}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Blog
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="m-content">
        @include('admin/layouts/error')
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon m--hide">
                                    <i class="la la-gear"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    <?php if(isset($page)){ echo "Edit"; }else{ echo "Add"; } ?> Blog
                                </h3>
                            </div>
                        </div>
                    </div>

                    <?php 
                        if(isset($data['blog'])):
                            $action = route('admin.editBlogProcess', $data['blog']->id);
                        else:
                            $action = route('admin.addBlog');
                        endif; 
                    ?>

                    <!--begin::Form-->
                    <form class="m-form" action="{{ $action }}" method="post" 
                        enctype="multipart/form-data">

                        @csrf

                        <div class="m-portlet__body">
                            <div class="m-form__section m-form__section--first">

                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">Name*</label>
                                    <input type="text" name="name" class="form-control m-input" 
                                        placeholder="Name" value="{{ isset($data['blog'])?$data['blog']->name:old('name') }}" >
                                </div>

                                <div class="form-group m-form__group">
                                    <label for="pic">Pics*</label>
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" name="pics" class="custom-file-input" id="customFile">
                                        <label class="custom-file-label selected" for="customFile">Choose file</label>
                                    </div>

                                    @if(isset($data['blog']) && !empty($data['blog']->pics))
                                    <hr>
                                        <img src="{{ asset('uploads/blog/'.$data['blog']->pics) }}" 
                                            alt="{{ $data['blog']->name }}" height="120" width="155">
                                    @endif

                                </div>

                                <div class="form-group m-form__group">
                                    <label>Description*</label>
                                    <textarea name="desc" class="form-control tinymce" cols="50" 
                                        rows="15">{{ isset($data['blog']->description)?$data['blog']->description:old('desc') }}</textarea>
                                </div>

                                <div class="m-form__group form-group">
                                    <label for="">Status*</label>
                                    <div class="m-radio-inline">
                                        <label class="m-radio">
                                            <input type="radio" name="status" value="Active" checked >
                                            Active
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" name="status" value="Banned" 
                                                {{ (isset($data['blog']) && $data['blog']->status == 'Banned')?'checked':'' }} >
                                            Banned
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">SEO Title</label>
                                    <input type="text" name="seo_title" class="form-control m-input" 
                                        placeholder="SEO Title" 
                                        value="{{ (isset($data['blog']->seo_title))?$data['blog']->seo_title:old('seo_title') }}" >
                                </div>

                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">SEO Keyword</label>
                                    <textarea name="seo_keywords" class="form-control" cols="50" placeholder="SEO Keywords"
                                        rows="5">{{ (isset($data['blog']->seo_keywords))?$data['blog']->seo_keywords:old('seo_keywords') }} </textarea>
                                </div>

                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">SEO Description</label>
                                    <textarea name="seo_desc" class="form-control" cols="50" placeholder="SEO Description" 
                                        rows="5">{{ (isset($data['blog']->seo_description))?$data['blog']->seo_description:old('seo_desc') }}</textarea>
                                </div>

                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                                <a href="{{ route('admin.blogList') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
    @include('admin/layouts/tinymce')
@endsection
