@section('title')

Sell

@endsection

@extends('layouts.page')

@section('content')



<!-- sell page -->
<section class="sell-page text-center">
    <div class="sell-titles">
         <h1>SELL NOW</h1>
  <h2>Post your items in less than 30 seconds.</h2>
    </div>
 

  <form class="common-form sell-form" name="sell" method="POST" action="{{ url('sell') }}" enctype="multipart/form-data">
    @csrf
    <!-- item-information-->
    <div class="add-item-info text-left inner-group">
      <div class="container">

        @include('admin/layouts/error')

        <!-- item basic info -->
        <div class="row item-basic first-step incomplete">
          <!-- title-->
          <div class="col-md-12 form-group">
            <label>What are you Selling? *</label>
            <input type="text" name="name" placeholder="Name of item *" value="{{ old('name') }}">
            <button type="button" class="stepper1 step-btn">Continue</button>
          </div>
        </div>
        <!-- item categoty -->
        <div class="select-cat incomplete second-step not-shown animated fadeIn">
          <h3 class="mid-heading">Select Category *</h3>
          <ul>

            @foreach($category as $row)

            <li>
              <span>
                <input type="radio" id="c{{ ucwords($row->id) }}" name="category_id" value="{{ ucwords($row->id) }}" onchange="getSubcategory(<?php echo $row->id; ?>)">
                <label for="c{{ ucwords($row->id) }}" class="cat-radio">
                  <img src="{{ asset('uploads/categories/'.$row->pic) }}" alt="{{ ucwords($row->name) }}">
                  <text>{{ ucwords($row->name) }}</text>
                </label>
              </span>
            </li>

            @endforeach
            
          </ul>
        </div>
        
        <div class="subs not-shown animated fadeIn">
           <div class="row">
                <!-- item sub categoty -->
                <div class="select-cat col-md-6" id="subcategory" style="display: none;">
                  <h3 class="mid-heading" style="margin-top: 10px;margin-bottom: 10px;font-size: 14px;">Select Sub Category *</h3>
                  <select name="sub_category_id" id="reqoptions" onchange="getOthercategory(this.options[this.selectedIndex].value)">
                    <option value="no-val">Please Select</option>
                  </select>
                </div>
        
                <!-- item other categoty -->
                <div class="select-cat col-md-6 hideIt" id="othercategory" style="display: none;">
                  <h3 class="mid-heading" style="margin-top: 10px;margin-bottom: 10px;font-size: 14px;">Select Other Category *</h3>
                  <select name="other_category_id" id="reqoptionso">
                  </select>
                </div> 
            </div>
            <button type="button" class="stepper11 step-btn animated fadeIn">Continue</button> 
        </div>
    </div>
</div>

    <!-- description-->
    <div class="add-item-info text-left inner-group incomplete third-step not-shown animated fadeIn">
      <div class="container">
        <div class="form-group">
          <label>Description *</label>
          <textarea rows="10" name="features" class="tinymce" placeholder="Include the brand, model, age and any included accessories... * ">{{ old('features') }}</textarea>
           <button type="button" class="stepper2 step-btn">Continue</button>
        </div>
      </div>
    </div>
    
    
    <!-- description and price -->
    
    <div class="text-left inner-group forth-step not-shown animated fadeIn">

      <div class="container">
          <div class="row item-basic">
        <!-- price -->
        <div class="col-md-6 form-group">
          <label>Price (Only Number Values)*</label>
          <input type="text" name="price"class="price-main" placeholder="Cost of item *" value="{{ old('price') }}">
        </div>

        <div class="col-md-6 form-group">
          <label>Price Type *</label>
          <label class="radio-inline">Fixed
            <input type="radio" name="price_negotiable" value="Fixed" checked="checked">
          </label>
          <label class="radio-inline">Negotiable
            <input type="radio" name="price_negotiable" value="Negotiable">
          </label>
        </div>

        <div class="col-md-6 form-group hideIt">
          <label>Condition *</label>
          <label class="radio-inline">Brand New
            <input type="radio" name="condition" value="Brand New" checked="checked">
          </label>
          <label class="radio-inline">Like New
            <input type="radio" name="condition" value="Like New">
          </label>
          <label class="radio-inline">Used
            <input type="radio" name="condition" value="Used">
          </label>
        </div>

        <div class="col-md-6 form-group hideIt">
          <label>Used For (Time Period)</label>
          <input type="text" name="user_for" placeholder="User For" value="{{ old('user_for') }}">
        </div>

        <div class="col-md-6 form-group hideIt">
          <label>Delivery *</label>
          <label class="radio-inline">No
            <input type="radio" name="delivery" value="No" checked="checked">
          </label>
          <label class="radio-inline">Yes
            <input type="radio" name="delivery" value="Yes">
          </label>
        </div>

        <div class="col-md-6 form-group hideIt">
          <label>Delivery Area</label>
          <input type="text" name="delivery_area" placeholder="Delivery Area" value="{{ old('delivery_area') }}">
        </div>

        <div class="col-md-6 form-group">
          <label>Item Photo*</label>
          <input type="file" name="pic" accept="image/jpg, image/jpeg, image/png, image/gif, image/svg" >
           <label style="font-size:14px; margin-top:4px;">NOTE: Less Than 10MB <br>With Format jpg, jpeg, gif, png, svg </label>
        </div>

        <div class="col-md-6 form-group">
          <label>Ads Expiry Date *</label>
          <input type="text" name="expiry_date" id="datepicker" autocomplete="off" class="" placeholder="Ads Expiry Date">
        </div>

    </div>
     <button type="button" class="stepper3 step-btn">Continue</button>
</div>
</div>



 <div class="sell-add-photos incomplete fifth-step not-shown animated fadeIn">
      <div class="text-center container">
        <!-- upload div -->
        <div class="upload-div ">
          <h3>Add More Photos</h3>
          <span>Maximum 5 Files.</span>
          <label style="font-size:14px; margin-top:4px;">NOTE: Each File Not More Than 10MB <br>With Format jpg, jpeg, gif, png, svg </label>
          <!-- add div-->
          <div class="drap-div-wrap">
            <!-- add div-->
            <div class="box">
              <div class="drag-div box__input">
                <input class="box__file" type="file" name="gallery[]" id="file1" 
                    multiple style="display: none" accept="image/jpg, image/jpeg, image/png, image/gif, image/svg" />
                <i class="fas fa-plus"></i>
                <label for="file1" class="">
                  <span class="box__dragndrop">Drag a file</span>
                  <b>or</b>
                  <strong class="alternate-btn">Click Here</strong>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

 <!-- personal inforn=mations-->
    <div class="add-item-info text-left inner-group last-step not-shown animated fadeIn">
      <div class="container">
        <h3 class="mid-heading">Personal Information</h3>
        <!-- personal info info -->
        <div class="row personal-basic">
          <!-- name-->
          <div class="col-md-6 form-group">
            <label>
              Name:
            </label>
            <input type="text" value="{{ ucwords(Auth::guard('web')->user()->name) }}" readonly>
          </div>
          <!-- phone -->
          <div class="col-md-6 form-group">
            <label>
              Phone:
            </label>
            <input type="text" value="{{ Auth::guard('web')->user()->phone }}" readonly>
          </div>
          <!-- name-->
          <div class="col-md-6 form-group">
            <label>
              Email:
            </label>
            <input type="email" value="{{ Auth::guard('web')->user()->email }}" readonly>
          </div>
          <!-- phone -->
          <div class="col-md-6 form-group">
            <label>
              City:
            </label>
            <input type="text" value="{{ ucwords(Auth::guard('web')->user()->address) }}" readonly>
          </div>
        </div>
        <!-- submit-->
        <div class="submit-wrap">
          <h5>By clicking ‘Submit’ you agree to our
            <a href="{{ url('dealsdrill/terms-of-use') }}">Terms of Use</a> &
            <a href="{{ url('dealsdrill/posting-rule') }}">Posting Rules</a>
          </h5>
          <button type="submit" class="form-btn">Submit</button>
        </div>
      </div>
    </div>
    
    
   

   
  </form>
</section>

@endsection

@section('footer')

<style>
  .radio-inline {
    position: relative;
    display: inline-block!important;
    padding-left: 20px;
    margin-bottom: 0;
    vertical-align: middle;
    cursor: pointer;
  }

  .radio-inline input[type=radio] {
    position: absolute;
    margin-top: 4px\9;
    margin-left: -20px;
  }

  #reqoptions, #reqoptionso {
    text-transform : capitalize;
  }
</style>

<script>
  function getSubcategory(id){
    
    if(id == 16 || id == 17 || id == 20){
        $("div.hideIt").hide();
    }else{
        $("div.hideIt").show();
    }
      
    $.ajax({
      type:'POST',
      url:'{{ url('get/subcategory') }}',
      dataType: 'json',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data:{category: id},
      success:function(response) {
        if(response.success) {

          var data = response.success;
          if(data.length == 0) {
            $("#reqoptions").html('');
            $('#subcategory').fadeOut().html();
          } else {
            $("#subcategory").fadeIn().html();
          }


          $("#reqoptions").html('');
          $("#reqoptions").html('<option value="">None</option>');
          
          $.each(data, function (i) {

            var id = data[i].id;
            var name = data[i].name;
            $("#reqoptions").append('<option value="'+id+'">'+name+'</option>');

          });
        }
        
        if(response.error) {
          $("#reqoptions").html('');
          $('#successreq').fadeOut().html();
        }

      }
    });
  }

  function getOthercategory(id) {
    $.ajax({
      type:'POST',
      url:'{{ url('get/othercategory') }}',
      dataType: 'json',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data:{category: id},
      success:function(response) {
        if(response.success) {

          var data = response.success;
          if(data.length == 0) {
            $("#reqoptionso").html('');
            $('#othercategory').fadeOut().html();
            var hasClass =  $('#othercategory').hasClass("sub-shown");
            if(hasClass === true) {
                 $('#othercategory').removeClass("sub-shown");
            }
          } else {
            $("#othercategory").fadeIn().html();
             $('#othercategory').addClass("sub-shown");
          }

          $("#reqoptionso").html('');
          $("#reqoptionso").html('<option value="no-sub">None</option>');

          $.each(data, function (i) {

            var id = data[i].id;
            var name = data[i].name;
            $("#reqoptionso").append('<option value="'+id+'">'+name+'</option>');

          });
        }
        
        if(response.error) {
          $("#reqoptionso").html('');
          $("#reqoptionso").html('<option value="">None</option>');
          $('#successreq').fadeOut().html();
        }

      }
    });
  }

</script>

<!-- box 1 -->
<script>

  'use strict';

  (function (document, window, index) {
  // feature detection for drag&drop upload
  var isAdvancedUpload = function () {
    var div = document.createElement('div');
    return (('draggable' in div) || ('ondragstart' in div && 'ondrop' in div)) && 'FormData' in window && 'FileReader' in window;
  }();
  // applying the effect for every form
  var forms = document.querySelectorAll('.box');
  Array.prototype.forEach.call(forms, function (form) {
    var input = form.querySelector('input[type="file"]'),
    label = form.querySelector('label'),
    errorMsg = form.querySelector('.box__error span'),
    restart = form.querySelectorAll('.box__restart'),
    droppedFiles = false,
    showFiles = function (files) {
        // label.textContent = files.length > 1 ? (input.getAttribute('data-multiple-caption') || '').replace('{count}', files.length) : files[0].name;
        label.textContent = files.length+" files selected";
      },
      triggerFormSubmit = function () {
        var event = document.createEvent('HTMLEvents');
        event.initEvent('submit', true, false);
        form.dispatchEvent(event);
      };
    // automatically submit the form on file select
    input.addEventListener('change', function (e) {
      showFiles(e.target.files);
    });
    // drag&drop files if the feature is available
    if (isAdvancedUpload) {
      form.classList.add('has-advanced-upload'); // letting the CSS part to know drag&drop is supported by the browser

      ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach(function (event) {
        form.addEventListener(event, function (e) {
          // preventing the unwanted behaviours
          e.preventDefault();
          e.stopPropagation();
        });
      });
      ['dragover', 'dragenter'].forEach(function (event) {
        form.addEventListener(event, function () {
          form.classList.add('is-dragover');
        });
      });
      ['dragleave', 'dragend', 'drop'].forEach(function (event) {
        form.addEventListener(event, function () {
          form.classList.remove('is-dragover');
        });
      });
      form.addEventListener('drop', function (e) {
        droppedFiles = e.dataTransfer.files; // the files that were dropped
        showFiles(droppedFiles);

      });
    }
    // restart the form if has a state of error/success
    Array.prototype.forEach.call(restart, function (entry) {
      entry.addEventListener('click', function (e) {
        e.preventDefault();
        form.classList.remove('is-error', 'is-success');
        input.click();
      });
    });
    // Firefox focus bug fix for file input
    input.addEventListener('focus', function () { input.classList.add('has-focus'); });
    input.addEventListener('blur', function () { input.classList.remove('has-focus'); });
  });
}(document, window, 0));
</script>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script src="{{ asset('/vendor/laravel-filemanager/js/lfm.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/vendor/laravel-filemanager/css/cropper.min.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/laravel-filemanager/css/lfm.css') }}">

<script>
  var editor_config = {
    path_absolute : "{{ URL::to('/') }}/admin/",
    selector: "textarea.tinymce",
    plugins: [
    "code table"
    ],
    menubar: "format table tools",
  };

  tinymce.init(editor_config);
</script>


<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

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
@endsection