@section('title')

Advertise

@endsection

@extends('admin/layouts/app')

@section('content')

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Advertise
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
                                Advertise   
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
                            Advertise
                            <small>
                                Product categories.
                            </small>
                        </h3>
                    </div>
                </div>

                @can('add')
                    <div class="m-portlet__head-tools">
                        <a class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" 
                            href="{{ route('admin.addAdvertise') }}">Add
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
                                        <th>Title</th>
                                        <th>pics</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $page     = $advertise->currentPage()-1;
                                        $per_page = $advertise->perPage();
                                        $i        = $page * $per_page; 
                                    @endphp 

                                    @foreach ($advertise as $row)

                                    <tr>
                                        <th scope="row">{{ ++$i }}</th>

                                        <td class="sorting_1">{{ ucwords($row->title) }}</td>

                                        <th>
                                            @if(isset($row->pic) && $row->pic != '')
                                                <img src="{{ asset('uploads/advertise/'.$row->pic) }}" 
                                                        alt="{{ $row->title }}" width="120" height="90">
                                            @else
                                                {{ "Image Not Uploaded ! ! !" }}
                                            @endif
                                        </th>           

                                        <td class="center">{{ $row->created_at->toFormattedDateString() }}</td>

                                        <td>
                                            <span class="m-badge m-badge--<?= ($row->status == 'Banned')?'danger':'success'; ?> m-badge--wide">
                                                {{ $row->status }}
                                            </span>
                                        </td>

                                        <td data-field="Actions" class="m-datatable__cell">
                                            <span style="overflow: visible; width: 110px;">

                                                <a href="{{ route('admin.editAdvertise',$row->id) }}" 
                                                    class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit">                         
                                                    <i class="la la-edit"></i>
                                                </a>

                                                <a href="{{ route('admin.deleteAdvertise',$row->id) }}" 
                                                    class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                                	<i class="la la-trash"></i>
                                                </a>

                                            </span>
                                        </td>
                                        
                                    </tr>

                                    @endforeach

                                </tbody>
                            </table>

                            {{ $advertise->appends(['sort' => 'id'])->links() }}

                        </div>
                    </div>
                </div>
                <!--end::Section-->
            </div>
        </div>
    </div>

@endsection