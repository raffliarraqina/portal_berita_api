@extends('frontend.parent')

@section('content')
    
<!-- ======= Single Post Content ======= -->
<div class="single-post">
    <div class="post-meta"><span class="date">{{ $news->category->name }}</span> <span class="mx-1">&bullet;</span> <span>Jul 5th '22</span></div>
    <h1 class="mb-5">{{ $news->title }}</h1>

    <figure class="my-4">
      <img src="{{ $news->image }}" alt="" class="img-fluid">
      <figcaption>{{ $news->title }}</figcaption>
    </figure>
    <p>
        {!! $news->description !!}
    </p>
  </div><!-- End Single Post Content -->

@endsection