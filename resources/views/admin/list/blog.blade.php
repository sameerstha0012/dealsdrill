@section('title') Blogs @endsection

@extends('admin/layouts/app')

@section('content')

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Blogs
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
    <!-- END: Subheader -->
    <div class="m-content">

        @include('admin/layouts/error')

        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Blog
                            <small>
                                Website Blogs.
                            </small>
                        </h3>
                    </div>
                </div>

                @can('add')
                <div class="m-portlet__head-tools">
                    <a class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" 
                        href="{{ route('admin.addBlog') }}">Add
                    </a>
                </div>
                @endcan
                
            </div>
            <div class="m-portlet__body">
                <!--begin::Section-->
                <div class="m-section">
                    <div class="m-section__content">
                        <div class="table-responsive m_datatable m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                            <table class="table m-table m-table--head-bg-success">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>pics</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @php 
                                    $page = $data['blogs']->currentPage()-1;
                                    $per_page = $data['blogs']->perPage();
                                    $i = $page * $per_page; 
                                @endphp

                                @foreach($data['blogs'] as $index => $blog)
                                    <tr>
                                        <th scope="row">{{ ++$i }}</th>
                                        <td class="sorting_1">{{ ucwords($blog->name) }}</td>
                                        <td>
                                            <img src="{{ asset('uploads/blog/'.$blog->pics) }}" 
                                                alt="{{ $blog->name }}" width="155" height="90" >
                                        </td>
                                        <td><span class="m-badge m-badge--{{ ($blog->status == "Active")?'success':'danger' }} 
                                            m-badge--wide"><?php echo $blog->status; ?></span>
                                        </td>
                                        <td class="center">{{ $blog->created_at->toFormattedDateString() }}</td>
                                        <td data-field="Actions" class="m-datatable__cell">
                                            <span style="overflow: visible; width: 110px;">                                     
                                                <a href="{{ route('admin.editBlog', $blog->id) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">                         
                                                    <i class="la la-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.deleteBlog', $blog->id) }}" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                                	<i class="la la-trash"></i>
                                                </a>
                                            </span>
                                        </td>
                                    </tr>

                                    @endforeach

                                </tbody>
                            </table>

                            {{ $data['blogs']->links() }}

                        </div>
                    </div>
                </div>
                <!--end::Section-->
            </div>
        </div>
    </div>

@endsection