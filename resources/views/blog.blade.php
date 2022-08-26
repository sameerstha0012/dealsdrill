@section('title') {{ ucwords($page->name) }} @endsection

@extends('layouts.page')

@section('content')
<h1 style="display:none">Buy and sell blogs</h1>
   <section class="inner-page pad-top pad-bot" style="background-color:#f3f3f5">
       <div class="container">
           <div class="blog-all">
              @foreach($blogs as $blog)
                <div class="blog-wrap">
                      <h2>
                         <a href="{{ route('site.blogDetails', $blog->permalink) }}" title="{{ $blog->name }}" >
                           {{ $blog->name }}
                         </a>
                      </h2>
                    <span class="blog-date"><i class="far fa-calendar-alt"></i>{{ date('j M, Y', strtotime($blog->created_at)) }}</span>
                    <div class="img-container">
                        <a href="{{ route('site.blogDetails', $blog->permalink) }}" title="{{ $blog->name }}" >
                          <img src="{{ asset('uploads/blog/'.$blog->pics) }}" alt="{{ $blog->name }}" alt="{{ $blog->name }}" >
                        </a>
                    </div>
                    
                    <p><?php echo mb_substr(strip_tags($blog->description), 0, 200, 'utf-8').' ...'; ?>
                        <a href="{{ route('site.blogDetails', $blog->permalink) }}" title="{{ $blog->name }}" class="blog-link">Read More<i class="fas fa-angle-double-right"></i></a>
                    </p>
                    
                </div>
               @endforeach
           </div>
       </div>
   </section>

    

@endsection
