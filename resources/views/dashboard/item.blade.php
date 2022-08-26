@section('title')

{{ ucwords($title) }}

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
      <div class="dash-content">
        <div class="dash-inner">
          <!-- items-->
          <div class="tables-wrap">
            <div class="">
              <h3 class="dash-title text-center color-red">{{ ucwords($title) }}</h3>

              <!-- flash -->
              <div id="flash"></div>

              <!-- latest items -->
              <div class="custom-table">
                <div class="custom-table-in">
                  <h4 class="table-title ">Your Items</h4>

                  <!-- rows-->
                  <div class="table-rows">

                    @foreach($products as $row)

                    <!-- item -->
                    <div class="table-row">
                      <!-- image -->
                      <div class="img-container sm-image">
                        <img src="{{ asset('uploads/'.'products/'.$row->pic) }}" alt="{{ ucwords($row->name) }}" class="img-fitted">
                      </div>
                      <!-- des-->
                      <div class="item-col">
                        <h4><a href="{{ url('detail/'.$row->slug) }}">{{ ucwords($row->name) }}</a></h4>
                        <span><b>Category:</b>{{ ucwords($row->categoryName) }} > {{ ucwords($row->subcategoryName) }} @if(isset($row->otherCategory))
                                            > {{ ucwords($row->otherCategory) }} @endif

                        @if($row->status == 'Available')

                          @if($row->expiry_date < date('Y-m-d'))

                          <span style="color:white;" class="table-badge badge-red">Expired</span>

                          @else

                            <span><b>Expires On:</b><?php $dt = Carbon::parse($row->expiry_date); ?>{{ $dt->format('jS F Y') }}</span>

                          @endif

                        @endif

                        <span @if($row->status=='Available') title="Mark as sold" onclick="status(<?php echo $row->id; ?>)" @endif style="color:white;" class="table-badge badge-<?php if($row->status=='Sold') { echo "orange"; } else { echo "green"; } ?> status">{{ ($row->status) }}</span>

                      </div>
                      <!-- price tag-->
                      <div class="table-badge-wrap">
                        <span class="table-badge badge-<?php if($row->status == 'Sold') { echo "orange"; } else { echo "blue"; } ?>">Rs: {{ number_format($row->price, 2) }}</span>
                      </div>
                    </div>

                    @endforeach

                    {{ $products->links() }}
                    
                    @if(count($products) == 0)
                        <span class="badge badge-warning">No product found.</span>
                    @endif
            
                  </div>
                </div>
              </div>
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