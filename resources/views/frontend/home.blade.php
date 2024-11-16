@extends('frontend.app')

@section('title', translate('home'))

@section('content')
<section class="section-container">
    @if($bannerPrimer->count() > 0)
        @include('frontend.home.banner',['bannerPrimer'=>$bannerPrimer])
    @endif
        @include('frontend.home.category-slider',['categories'=>$categories])
    @if($latestProducts !=null)
        @include('frontend.home.latest-product',['products'=>$latestProducts['products']])
    @endif
    @if($featuredData !=null)
        @foreach ($featuredData as $featered)
            <p>{{$featered['category']->name}} </p>
            @include('frontend.home.featered-category',['products'=>$featered['products']])
        @endforeach
    @endif
</section>
@endsection

@push('script_2')
    <script src="{{ asset('public/assets/frontend/js/banner.js') }}"></script>
    <script src="{{ asset('public/assets/frontend/js/category.js') }}"></script>
@endpush

