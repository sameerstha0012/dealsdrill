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
                    <a href="{{ url('admin/products') }}" class="m-nav__link">
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
                                <?php if(isset($advertise)) { echo "Edit"; } else { echo "Add"; } ?> Advertise
                            </h3>
                        </div>
                    </div>
                </div>

                <?php 
                    if(isset($advertise)):
                        $action = route('admin.editAdvertiseProcess', $advertise->id);
                    else:
                        $action = route('admin.addAdvertiseProcess');
                    endif; 

                    $types = array(
                        array(
                            "name" => "footer",
                        ),
                        array(
                            "name" => "m-left",
                        ),
                        array(
                            "name" => "section1",
                        ),
                        array(
                            "name" => "section2",
                        ),
                        array(
                            "name" => "section-long1",
                        ),
                        array(
                            "name" => "section-long2",
                        ),
                        array(
                            "name"  => "m-right",
                        ),
                    );
                ?>

                <!--begin::Form-->
                <form class="m-form" action="{{ $action }}" method="post" enctype="multipart/form-data">

                    {{ csrf_field() }}

                    <div class="m-portlet__body">
                        <div class="m-form__section m-form__section--first">

                            <div class="form-group m-form__group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control m-input" 
                                    placeholder="Enter Title" 
                                    value="<?= (isset($advertise))?$advertise->title:old('title'); ?>">
                                <input type="hidden" name="advertise_id" class="form-control m-input" readonly 
                                    value="<?= (isset($advertise))?$advertise->id:''; ?>">
                            </div>

                            <div class="form-group m-form__group">
                                <label>Featured Picture</label>
                                <div></div>
                                <div class="custom-file" style="width:40%">
                                    <input type="file" name="pic" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label selected" for="customFile">Choose file</label>
                                </div>

                                @if(!empty($advertise->pic))
                                <hr>
                                <img src="{{ asset('uploads/advertise/'.$advertise->pic) }}" 
                                    alt="<?= (isset($advertise))?$advertise->title:''; ?>" width="100">
                                @endif

                            </div>

                            <div class="form-group m-form__group">
                                <label>Link</label>
                                <input type="text" name="link" class="form-control m-input" 
                                    placeholder="Enter Link" 
                                    value="<?= (isset($advertise))?$advertise->link:old('link'); ?>">
                            </div>

                            <div class="form-group m-form__group">
                                <label>Type</label>
                                <select name="type" class="form-control m-input">
                                <option value="" selected>None</option>
                                @foreach($types as $row)

                                    <option <?= (isset($advertise) && $advertise->type == $row['name'])?'selected':''; ?> 
                                        value="{{ $row['name'] }}">{{ ucwords($row['name']) }}</option>

                                @endforeach

                                </select>
                            </div>

                            <div class="m-form__group form-group">
                                <label for="">Status</label>
                                <div class="m-radio-inline">
                                    <label class="m-radio">
                                        <input type="radio" name="status" value="Banned" 
                                            <?= (isset($advertise->status)?((isset($advertise->status)&&($advertise->status == 'Banned'))?'checked="checked"':''):'checked="checked"'); ?>>
                                        Banned
                                        <span></span>
                                    </label>
                                    <label class="m-radio">
                                        <input type="radio" name="status" value="Active" 
                                            <?= (isset($advertise->status)&&($advertise->status == 'Active'))?'checked="checked"':''; ?>>
                                        Active
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group m-form__group">
                                <label>Order</label>
                                <input type="number" name="order" class="form-control m-input" 
                                    placeholder="Enter Order" 
                                    value="<?php 
                                            if(isset($advertise)):
                                                echo $advertise->order;
                                            elseif(old('order')):
                                                echo old('order');
                                            else:
                                                echo 0; 
                                            endif;
                                            ?>">
                            </div>

                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            @if(isset($advertise))
                                <button type="submit" class="btn btn-primary">Update</button>
                            @else
                                <button type="submit" class="btn btn-primary">Submit</button>
                            @endif
                            <a href="{{ route('admin.advertiseList') }}" class="btn btn-secondary">Cancel</a>
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

    <script src="{{ asset('administrator/demo/default/custom/components/forms/widgets/dropzone.js') }}" 
        type="text/javascript">
    </script>

    <script src="{{ asset('administrator/demo/default/custom/components/forms/widgets/bootstrap-datepicker.js') }}" 
        type="text/javascript">
    </script>

    <script>
        var BootstrapDatepicker={init:function(){
                $("#datepicker").datepicker({
                    todayHighlight:!0,orientation:"bottom left",
                    templates:{
                        leftArrow:'<i class="la la-angle-left"></i>',
                        rightArrow:'<i class="la la-angle-right"></i>'
                    },
                    format: 'yyyy-mm-dd',
                    startDate: '<?php echo date('Y-m-d'); ?>',
                    endDate: '<?php echo date('Y-m-d', strtotime('1 months')); ?>'
                })
        }};jQuery(document).ready(function(){BootstrapDatepicker.init()});
    </script>

    <script>
        function getSubcategory(id) {
            $.ajax({
                type:'POST',
                url:'{{ url('admin/product/subcategory') }}',
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{category: id},
                success:function(response) {
                    if(response.success) {

                        $("#successreq").fadeIn(200).html(); 
                        var data = response.success;
                        if(data.length == 0) {
                            $("#reqoptions").html('<option value="0">None</option>');
                            $('#successreq').fadeOut().html();
                        }
                        
                        $("#reqoptions").html('<option value="">None</option>');

                        $.each(data, function (i) {

                            var id = data[i].id;
                            var name = data[i].name;
                            $("#reqoptions").append('<option value="'+id+'">'+name+'</option>');

                        });
                    }
                    
                    if(response.error) {
                        $("#reqoptions").html('<option value="0">None</option>');
                        $('#successreq').fadeOut().html();
                    }

                }
            });
        }

        function getOthercategory(id) {
            $.ajax({
                type:'POST',
                url:'{{ url('admin/product/othercategory') }}',
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{category: id},
                success:function(response) {
                    if(response.success) {

                        $("#successreqo").fadeIn(200).html(); 
                        var data = response.success;
                        if(data.length == 0) {
                            $("#reqoptionso").html('<option value="0">None</option>');
                            $('#successreqo').fadeOut().html();
                        }
                        
                        $.each(data, function (i) {

                            var id = data[i].id;
                            var name = data[i].name;
                            if(i===0) {
                                $("#reqoptionso").html('<option value="'+id+'">'+name+'</option>');
                            } else {
                                $("#reqoptionso").append('<option value="'+id+'">'+name+'</option>');
                            }

                        });
                    }
                    
                    if(response.error) {
                        $("#reqoptions").html('<option value="0">None</option>');
                        $('#successreq').fadeOut().html();
                    }

                }
            });
        }
    </script>

<style>
#reqoptions, #reqoptionso {
    text-transform:capitalize;
}

</style>
@endsection
