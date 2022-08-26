@section('title')

Products

@endsection

@extends('admin/layouts/app')

@section('content')

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Products
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
                        <a href="{{ url('admin/products') }}" class="m-nav__link">
                            <span class="m-nav__link-text">
                                Products   
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
                            Products
                            <small>
                                Website products.
                            </small>
                        </h3>
                    </div>
                </div>

                @can('add')
                    <div class="m-portlet__head-tools">
                        <a class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" 
                            href="{{ url('admin/product/add') }}">Add</a>
                    </div>
                @endcan
                
            </div>
            <div class="m-portlet__body">

                <div class="loader" id="tableLoader" style="display: none;">
                    <h3 class="text">
                        please wait . . <span class="m-loader m-loader--brand"></span>
                    </h3>
                </div>

                <div class="m-section">
                    <div class="m-section__content">
                        <div class="table-responsive m_datatable m-datatable m-datatable--default m-datatable--brand m-datatable--loaded">
                            <table class="table m-table m-table--head-bg-success">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <th>Featured</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                        $page = $products->currentPage()-1;
                                        $per_page = $products->perPage();
                                        $i = $page * $per_page; 
                                    @endphp

                                    @foreach($products as $row)

                                        <tr>
                                            <th scope="row"><?= ++$i; ?></th>
                                            <td class="sorting_1">{{ ucwords($row->name) }}</td>
                                            <td>
                                                <span class="m-badge m-badge--brand m-badge--wide">
                                                    {{ ucwords($row->categoryName) }}
                                                </span>
                                                >
                                                <span class="m-badge m-badge--info m-badge--wide">
                                                    {{ ucwords($row->subCategory) }}
                                                </span>
                                                @if(isset($row->otherCategory))
                                                    ><span class="m-badge m-badge--warning m-badge--wide">
                                                        {{ ucwords($row->otherCategory) }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="center">{{ $row->created_at->toFormattedDateString() }}</td>

                                            <td>
                                                <span class="m-badge m-badge--{{ ($row->status == 'sold')?'danger':'success' }} m-badge--wide">
                                                    {{ $row->status }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="m-switch m-switch--outline m-switch--icon m-switch--success">
                                                    <label>
                                                        <input type="checkbox" id="product_featured_{{ $row->id }}"
                                                            onChange="changeProductFeatured({{ $row->id }}, this.checked)" 
                                                            {{ $row->featured == 'Yes'?'checked':'' }} >
                                                        <span></span>
                                                    </label>
                                                </span>
                                            </td>

                                            <td data-field="Actions" class="m-datatable__cell">
                                                <span style="overflow: visible; width: 110px;">
                                                    <a href="{{ url('admin/product/'.$row->id.'/edit/') }}" 
                                                        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" 
                                                        title="Edit">                         
                                                        <i class="la la-edit"></i>
                                                    </a>
                                                    <a href="{{ url('admin/product/'.$row->id.'/delete/') }}" 
                                                        class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" 
                                                        title="Delete">
                                                    	<i class="la la-trash"></i>
                                                    </a>
                                                </span>
                                            </td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>

                            {{ $products->appends(['sort' => 'id'])->links() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script type="text/javascript" charset="utf-8" async defer>

        var defaultMessage = "Something Went Wrong, Try Again ! ! !";

        function changeProductFeatured(id, value){

            $this = this;

            var url = "{{ route('admin.changeProductFeatured') }}";

            $("div#tableLoader").show();

            $.ajax({

                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id, 
                    value: value
                },

            })
            .done(function(response){

                if(response.success){

                    $this.alertMessage(response.message, 'success', 'check');

                }else{

                    document.getElementById("product_featured_"+id).checked = !value;

                    $this.alertMessage(response.message, 'danger', 'ban');

                }


            })
            .fail(function(){

                document.getElementById("product_featured_"+id).checked = !value;

                $this.alertMessage(defaultMessage, 'danger', 'ban');

            });

        }



        function alertMessage(message, alert, type){

            $("div#alertMessage").html(
                "<div data-notify='container' class='alert alert-"+alert+" m-alert animated bounce'"+ 
                    "role='alert'"+ 
                    "style='display:inline-block; margin:0px auto; position:fixed;"+
                    "transition:all 0.5s ease-in-out 0s; z-index:10000; right: 30px; bottom: 60px;"+
                    "animation-iteration-count:1;'>"+
                    "<button type='button' class='close' data-dismiss='alert' aria-label='Close'"+
                        "style='position:absolute; right:10px; top:5px; z-index:100002;'"+
                        "id='closeAlertMessage'>"+
                    "</button>"+
                    "<span data-notify='message' id='message'>"+
                    "<i class='fa fa-"+type+"' aria-hidden='true'>&nbsp;</i>"+message+"</span>"+
                "</div>");

            $("div#tableLoader").hide();

            setTimeout(function(){
                $("button#closeAlertMessage").click();
            }, 5000);

        }




    
    </script>

@endsection