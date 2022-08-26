@section('title')

{{ ucwords($page->name) }}

@endsection

@extends('layouts.page')

@section('content')

  <!-- page-->
  <section class="common-page pad-top pad-bot inner-page full-section" style="background:#f3f3f5">
    <div class="container">
      <div class="common-internal-wrap">
        <h1 class="main-title text-center">{{ ucwords($page->name) }}</h1>
        <!-- page contents -->
        <div class="common-layout">
          
          <?php echo $page->description; ?>

        </div>
      </div>
    </div>
  </section>

@endsection
