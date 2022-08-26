@section('title')

Assign Permissions

@endsection

@extends('admin/layouts/app')

@section('content')

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Assign Permissions
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
                        <a href="{{ url('admin/roles') }}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Roles
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
                                    <?php if(isset($role)) { echo "Edit"; } else { echo "Add"; } ?> Roles
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->
                    <form class="m-form" action="{{ url('admin/role/'.$role->id.'/assign') }}" method="post">

                        {{ csrf_field() }}

                        <div class="m-portlet__body">
                            <div class="m-form__section m-form__section--first col-md-5">
                                <div class="form-group m-form__group">
                                    <label for="example_input_full_name">
                                    Role:
                                    </label>
                                        <input disabled type="text" class="form-control m-input" value="{{ ucwords($role->name) }}">
                                </div>
                                <div class="form-group m-form__group">
                                    <label>
                                    Permissions:
                                    </label>
                                    <select name="permissions[]" multiple="" class="form-control m-input">
										
                                    @foreach($permissions as $permission)

                                    <option <?php if(!empty($assigned)) {
                                            foreach ($assigned as $check) {
                                                if($permission->id == $check->id) {
                                                    echo "selected";
                                                }
                                            }
                                        } ?> value="{{ $permission->name }}">{{ ucwords($permission->label) }}</option>

                                    @endforeach

									</select>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                                <a href="{{ url('admin/roles') }}" class="btn btn-secondary">
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