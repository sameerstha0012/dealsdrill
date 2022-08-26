@section('title')

{{ ucwords($product->name) }}

@endsection

@extends('dashboard.layouts.app')

@section('content')

<!-- main categories -->
<section class="dash-wrapper">
  <div class="row">
    <!-- side bar -->
    @include('dashboard/layouts/sidebar')

    <!-- main contents-->
    <div class="col-md-9 dash-content-wrap">

      @include('dashboard/layouts/profilebar')

      <!-- main contents -->
        <div class="dash-content pad-top">
          <div class="dash-inner">


            <!-- flash -->
            <div id="flash"></div>

            <div class="custom-table">
              <div class="custom-table-in">

                @include('admin/layouts/error')

                  <div class="form-group-wrap">
                    <h4 class="table-title">{{ ucwords($product->name) }}</h4>
                    <h4 class="table-title">{{ ucwords($product->category) }} > {{ ucwords($product->subcategory) }} @if(isset($product->othercategory)) > {{ ucwords($product->othercategory) }} @endif</h4>
                  </div>
                  <hr>
                  <div class="form-group-wrap">
                    <h4 class="table-title">Condition : {{ $product->condition }} @if($product->user_for != '') {{ $product->user_for }} @endif</h4>
                    <h4 class="table-title">Price : Rs. {{ number_format($product->price, 0) }}</h4>
                    <h4 class="table-title">Price Negotiable : {{ $product->condition }}</h4>
                  </div>
                  <hr>
                  <div class="form-group-wrap">
                    <h4 class="table-title">Delivery : {{ $product->delivery }} @if($product->delivery_area != '') {{ $product->delivery_area }} @endif</h4>
                    <h4 class="table-title">Status : <span @if($product->status=='Available') title="Mark as sold" onclick="status(<?php echo $product->id; ?>)" @endif  style="color:white;" class="table-badge badge-<?php if($product->status=='Sold') { echo "orange"; } else { echo "green"; } ?> status">{{ ($product->status) }}</span></h4>
                    <h4 class="table-title">Featured Image : <img width="100" height="80" src="{{ asset('uploads/'.'products/'.$product->pic) }}" alt="{{ ucwords($product->name) }}"></h4>
                  </div>
                  <hr>
                  <div class="form-group-wrap">
                    <h4 class="table-title ">Expiry Date : <?php $dt = Carbon::parse($product->expiry_date); ?>{{ $dt->format('jS F Y') }}
                    
                    @if($product->expiry_date < date('Y-m-d'))
                    <span style="color:white;" class="table-badge badge-red">Expired</span>
                    <span title="Renew Ads for another month" onclick="renew(<?php echo $product->id; ?>)" style="color:white;" class="table-badge badge-blue status">Renew Ads</span>
                    @endif
                    
                    </h4>
                  </div>
                  <hr>
                  <div class="form-group-wrap">
                    <h4 class="table-title">Description</h4>
                    <div class="row">
                      <div class="col-md-12">
                        <?php echo $product->features; ?>
                      </div>
                    </div>
                  </div>
                  <hr>

              </div>
            </div>
          </div>
        </div>

    </div>
  </div>
</section>

@endsection


@section('footer')

<script>
  function renew(id) {
    $.ajax({
      type:'POST',
      url:'{{ url('renew') }}',
      dataType: 'json',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data:{id: id},
      success:function(response) {
        if(response.success) {
          $("#flash").html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.success+'</div>');
        }
        
        if(response.error) {
          $("#flash").html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.error+'</div>');
        }
        location.reload();
      }
    });
  }
</script>

<script>
  function status(id) {
    $.ajax({
      type:'POST',
      url:'{{ url('update/status') }}',
      dataType: 'json',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data:{id: id},
      success:function(response) {
        if(response.success) {
          $("#flash").html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.success+'</div>');
        }
        
        if(response.error) {
          $("#flash").html('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+response.error+'</div>');
        }
        location.reload();
      }
    });
  }
</script>
@endsection