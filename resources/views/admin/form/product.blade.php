@section('title')

Product

@endsection

@extends('admin/layouts/app')

@section('content')

<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                Product
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
                            Product
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
                                <?php if(isset($product)) { echo "Edit"; } else { echo "Add"; } ?> Product
                            </h3>
                        </div>
                    </div>
                </div>

                <?php 
                    if(isset($product)) {
                        $action = url('/admin/product/'.$product->id.'/edit');
                    } else {
                        $action = url('/admin/product/add/');
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
                                    <input type="text" name="name" class="form-control m-input" placeholder="Name" value="<?php if(isset($product)) { echo $product->name; } else { echo old('name'); }  ?>">
                            </div>

                            <div class="form-group m-form__group">
                                <label>Posted By (Seller)</label>
                                <select name="user_id" class="form-control m-input">
                                <option value="">None</option>
                                @foreach($sellers as $row)

                                    <option <?php if(isset($product) && $product->user_id == $row->id) {
                                                    echo "selected";
                                        } ?> value="{{ $row->id }}">{{ ucwords($row->name) }}</option>

                                @endforeach

                                </select>
                            </div>

                            <div class="form-group m-form__group">
                                <label>Category</label>
                                <select name="category_id" class="form-control m-input" onchange="getSubcategory(this.options[this.selectedIndex].value)">
                                <option value="">None</option>
                                @foreach($categories as $row)

                                    <option <?php if(isset($product) && $product->category_id == $row->id) {
                                                    echo "selected";
                                        } ?> value="{{ $row->id }}">{{ ucwords($row->name) }}</option>

                                @endforeach

                                </select>
                            </div>

                            <div class="form-group m-form__group" id="successreq" <?php if(isset($product->sub_category_id) && $product->sub_category_id > 0) { echo ""; } else { echo "style='display: none;'"; } ?>>
                                <label>Sub Category</label>
                                <select name="sub_category_id" class="form-control m-input" id="reqoptions" onchange="getOthercategory(this.options[this.selectedIndex].value)">
                                <option value="">None</option>
                                @if(isset($product))
                                    @foreach($subcategory as $row)

                                        <option <?php if(isset($product->sub_category_id) && $row->id == $product->sub_category_id) { echo "selected"; } ?> value="{{ $row->id }}">{{ ucwords($row->name) }}</option>

                                    @endforeach
                                @endif;

                                </select>
                            </div>
                            
                            <div class="form-group m-form__group hideIt" id="successreqo" 
                                style="<?= (isset($product->category_id) && ($product->category_id == '16' || $product->category_id == '17' || $product->category_id == '20'))?'display:none':''; ?>"
                                <?php if(isset($product->other_category_id) && $product->other_category_id > 0) { echo ""; } else { echo "style='display: none;'"; } ?>>
                                <label>Other Category</label>
                                <select name="other_category_id" class="form-control m-input" id="reqoptionso">
                                <option value="0">None</option>
                                @if(isset($product))
                                    @foreach($othercategory as $row)

                                        <option <?php if(isset($product->other_category_id) && $row->id == $product->other_category_id) { echo "selected"; } ?> value="{{ $row->id }}">{{ ucwords($row->name) }}</option>

                                    @endforeach
                                @endif;

                                </select>
                            </div>

                            <div class="form-group m-form__group hideIt" 
                                style="<?= (isset($product->category_id) && ($product->category_id == '16' || $product->category_id == '17' || $product->category_id == '20'))?'display:none':''; ?>">
                                <label for="example_input_full_name">Price</label>
                                    <input type="text" name="price" class="form-control m-input" placeholder="Price" value="<?php if(isset($product)) { echo $product->price; } else { echo old('price'); }  ?>">
                            </div>

                            <div class="m-form__group form-group hideIt" style="<?= (isset($product->category_id) && $product->category_id == '17')?'display:none':''; ?>">
                                <label for="">Price Negotiable</label>
                                <div class="m-radio-inline">
                                    <label class="m-radio">
                                        <input type="radio" name="price_negotiable" value="Fixed" <?php echo (isset($product->price_negotiable)?((isset($product->price_negotiable)&&($product->price_negotiable == 'Fixed'))?'checked="checked"':''):'checked="checked"');?>>
                                        Fixed
                                        <span></span>
                                    </label>
                                    <label class="m-radio">
                                        <input type="radio" name="price_negotiable" value="Negotiable" <?php echo (isset($product->price_negotiable)&&($product->price_negotiable == 'Negotiable'))?'checked="checked"':'';?>>
                                        Negotiable
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="m-form__group form-group hideIt" 
                                style="<?= (isset($product->category_id) && ($product->category_id == '16' || $product->category_id == '17' || $product->category_id == '20'))?'display:none':''; ?>">
                                <label>Condition</label>
                                <div class="m-radio-inline">
                                    <label class="m-radio">
                                        <input type="radio" name="condition" value="Brand New" <?php echo (isset($product->condition)?((isset($product->condition)&&($product->condition == 'Brand New'))?'checked="checked"':''):'checked="checked"');?>>
                                        Brand New
                                        <span></span>
                                    </label>
                                    <label class="m-radio">
                                        <input type="radio" name="condition" value="Like New" <?php echo (isset($product->condition)&&($product->condition == 'Like New'))?'checked="checked"':'';?>>
                                        Like New
                                        <span></span>
                                    </label>
                                    <label class="m-radio">
                                        <input type="radio" name="condition" value="Used" <?php echo (isset($product->condition)&&($product->condition == 'Used'))?'checked="checked"':'';?>>
                                        Used
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group m-form__group hideIt" 
                                style="<?= (isset($product->category_id) && ($product->category_id == '16' || $product->category_id == '17' || $product->category_id == '20'))?'display:none':''; ?>">
                                <label for="example_input_full_name">User For</label>
                                    <input type="text" name="user_for" class="form-control m-input" placeholder="User For" value="<?php if(isset($product)) { echo $product->user_for; } else { echo old('user_for'); }  ?>">
                            </div>

                            <div class="m-form__group form-group hideIt" style="<?= (isset($product->category_id) && $product->category_id == '17')?'display:none':''; ?>">
                                <label for="">Delivery</label>
                                <div class="m-radio-inline">
                                    <label class="m-radio">
                                        <input type="radio" name="delivery" value="No" <?php echo (isset($product->delivery)?((isset($product->delivery)&&($product->delivery == 'No'))?'checked="checked"':''):'checked="checked"');?>>
                                        No
                                        <span></span>
                                    </label>
                                    <label class="m-radio">
                                        <input type="radio" name="delivery" value="Yes" <?php echo (isset($product->delivery)&&($product->delivery == 'Yes'))?'checked="checked"':'';?>>
                                        Yes
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group m-form__group hideIt" 
                                style="<?= (isset($product->category_id) && ($product->category_id == '16' || $product->category_id == '17' || $product->category_id == '20'))?'display:none':''; ?>">
                                <label for="example_input_full_name">Delivery Area</label>
                                <input type="text" name="delivery_area" class="form-control m-input" 
                                    placeholder="Delivery Area" 
                                    value="<?php if(isset($product)){echo $product->delivery_area;}else{echo old('delivery_area'); }  ?>">
                            </div>

                            <div class="form-group m-form__group">
                                <label>Features</label>
                                <textarea name="features" class="form-control tinymce" cols="50" rows="5">
                                    <?php if(isset($product)) { echo $product->features; } else {echo old('features'); } ?>
                                </textarea>
                            </div>

                            <div class="m-form__group form-group">
                                <label>Status</label>
                                <div class="m-radio-inline">
                                    <label class="m-radio">
                                        <input type="radio" name="status" value="Available" <?php echo (isset($product->status)?((isset($product->status)&&($product->status == 'Available'))?'checked="checked"':''):'checked="checked"');?>>
                                        Available
                                        <span></span>
                                    </label>
                                    <label class="m-radio">
                                        <input type="radio" name="status" value="Sold" <?php echo (isset($product->status)&&($product->status == 'Sold'))?'checked="checked"':'';?>>
                                        Sold
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="m-form__group form-group">
                                <label>Featured</label>
                                <div class="m-radio-inline">
                                    <label class="m-radio">
                                        <input type="radio" name="featured" value="Yes" <?php echo (isset($product->featured)?((isset($product->featured)&&($product->featured == 'Yes'))?'checked="checked"':''):'checked="checked"');?>>
                                        Yes
                                        <span></span>
                                    </label>
                                    <label class="m-radio">
                                        <input type="radio" name="featured" value="No" <?php echo (isset($product->featured)&&($product->featured == 'No'))?'checked="checked"':'';?>>
                                        No
                                        <span></span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group m-form__group">
                                <label for="pic">Featured Picture</label>
                                <div></div>
                                <div class="custom-file" style="width:40%">
                                    <input type="file" name="pic" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label selected" for="customFile">Choose file</label>
                                </div>

                                @if(!empty($product->pic))
                                <hr>
                                    <img src="{{ asset('uploads/'.'products/'.$product->pic) }}" alt="<?php if(isset($product)) { echo $product->name; } ?>" height="100" width="100">
                                @endif

                            </div>

                            <div class="form-group m-form__group" style="width:40%">
                                <label for="example_input_full_name">Expiry Date</label>
                                <input type="text" name="expiry_date" id="datepicker" readonly class="form-control m-input" placeholder="Expiry Date" value="<?php if(isset($product)) { echo $product->expiry_date; } else { echo old('expiry_date'); }  ?>">
                            </div>

                            <div class="form-group m-form__group">
                                <label for="example_input_full_name">SEO Keyword</label>
                                <input type="text" name="seo_keyword" class="form-control m-input" 
                                    placeholder="Enter SEO Keyword" 
                                    value="<?= (isset($product))?$product->seo_keyword:old('seo_keyword'); ?>">
                            </div>

                            <div class="form-group m-form__group" >
                                <label for="example_input_full_name">SEO Title</label>
                                <input type="text" name="seo_title" class="form-control m-input" 
                                    placeholder="Enter SEO Title" 
                                    value="<?= (isset($product))?$product->seo_title:old('seo_title'); ?>">
                            </div>

                            <div class="form-group m-form__group">
                                <label for="example_input_full_name">SEO Description</label>
                                <input type="text" name="seo_desc" class="form-control m-input" 
                                    placeholder="Enter SEO Description" 
                                    value="<?= (isset($product))?$product->seo_desc:old('seo_desc'); ?>">
                            </div>

							<div class="form-group m-form__group row">
								<label class="col-form-label col-lg-3 col-sm-12">Gallery</label>
								<div class="col-lg-4 col-md-9 col-sm-12">
									<div class="m-dropzone dropzone m-dropzone--primary" action="{{ url('admin/product/1/gallery') }}" id="m-dropzone-two">
										<div class="m-dropzone__msg dz-message needsclick">
											<h3 class="m-dropzone__msg-title">
												Drop files here or click to upload.
											</h3>
											<span class="m-dropzone__msg-desc">
												Upload up to 10 files
											</span>
										</div>
									</div>
								</div>
							</div>

                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                            <a href="{{ url('admin/products') }}" class="btn btn-secondary">
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
        function getSubcategory(id){
            
            if(id == 16 || id == 17 || id == 20){
                $("div.hideIt").hide();
            }else{
                $("div.hideIt").show();
            }
                
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
