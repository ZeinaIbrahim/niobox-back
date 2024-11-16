@extends('frontend.app')

@section('title', translate('product'))


@section('content')
<section class="section-container">
    {{-- @if($relatedProducts->count() > 0) --}}
    @foreach($product->image_fullpath as $image)
        <img src="{{ $image }}"  alt="{{ $product->name }}" class="latest-product-image" loading="lazy">
    @endforeach
    <p>{{$product->name}}</p>
    <p>{{$product->price}}</p>
    <p>{{$product->discount}}</p>

    @include('frontend.home.latest-product',['products'=>$relatedProducts])
    {{-- @endif --}}
</section>
@endsection
