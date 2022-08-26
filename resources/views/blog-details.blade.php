@section('title') {{ ucwords($data['blog']->name) }} @endsection

@extends('layouts.page')
    
@section('header')
    <meta name="title"       content="{{ $data['blog']->seo_title }}">
    <meta name="keyword"     content="{{ $data['blog']->seo_keywords }}">
    <meta name="description" content="{{ $data['blog']->seo_description }}">

    <meta property="og:url"         content="{{ $data['social']['url'] }}" />
    <meta property="og:type"        content="website" />
    <meta property="og:title"       content="{{ $data['social']['title'] }}" />
    <meta property="og:description" content="{{ $data['social']['description'] }}" />
    <meta property="og:image"       content="{{ $data['social']['image'] }}" />

    <meta name="twitter:title" content="{{ $data['social']['title'] }}" >
    <meta name="twitter:description" content="{{ $data['social']['description'] }}" >
    <meta name="twitter:image" content="{{ $data['social']['image'] }}" >
    <meta name="twitter:card" content="summary_large_image">
@endsection

@section('content')
<h1 style="display:none">$data['blog']->name }}</h1>
     <section class="pad-top pad-bot inner-page" style="background-color:#f3f3f5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 blog-wrap">
                    <div class="blog-all blog-single">
                       <h2>{{ $data['blog']->name }}</h2> 
                       <span  class="blog-date">{{ date('j M, Y', strtotime($data['blog']->created_at)) }}</span>
                       <div class="img-container">
                            <img src="{{ asset('uploads/blog/'.$data['blog']->pics) }}" alt="{{ $data['blog']->name }}">
                       </div>
                       
                        <div class="sharethis-inline-share-buttons share-div" 
                            data-url="{{ $data['social']['url'] }}" 
                            data-title="{{ $data['social']['title'] }}" 
                            data-image="{{ $data['social']['image'] }}" >
                        </div>
                         <p><?php echo $data['blog']->description; ?></p>
                    </div>
                </div>
                <!-- side bar -->
                <div class="col-lg-4 related-sidebar">
                    <h3 class="sidebar-blog-title">Similar Posts</h3>
                    <div class="related-blogs">
                         @foreach($data['other-blogs'] as $blog)
                            <div class="sm-post">
                                <div class="img-container">
                                    <img src="{{ asset('uploads/blog/'.$blog->pics) }}" alt="{{ $blog->name }}" class="img-fitted">
                                </div>
                                <div class="sm-overview">
                                   <h3>
                                      <a href="{{ route('site.blogDetails', $blog->permalink) }}" title="{{ $blog->name }}" >
                                       {{ $blog->name }}
                                      </a>
                                    </h3>
                                   <span>{{ date('j M, Y', strtotime($blog->created_at)) }}</span>
                                </div>
                            </div>
                          @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
   

   
   

@endsection
