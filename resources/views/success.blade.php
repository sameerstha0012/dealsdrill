@section('title')

Sell Success

@endsection

@extends('layouts.page')

@section('content')

  <!-- success page-->
  <section class="success-page pad-top pad-bot">
    <div class="container">
      <div class="success-wrap text-center">
        <h1 class="success-msg-title">Congratulations</h1>
        <img src="{{ asset('images/smile.fw.png') }}" alt="add sccess">
        <p class="success-msg-details">You have successfully added your items for sell. Enjoy your items by selling.</p>
        <div class="img-container added-item-image">
          <img src="{{ asset('uploads/products/'.$product->pic) }}" alt="{{ ucwords($product->name) }}" class="">
        </div>
        <br>
        <a href="{{ url('sell') }}" class="basic-btn">Continue</a>
      </div>
    </div>
  </section>

@endsection