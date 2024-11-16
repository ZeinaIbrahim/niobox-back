<section class="latest-product-section">
    <div class="latest-product-scroll">
        @foreach ($products as $product)
            <div class="latest-product-item">
                <a href="{{route('frontend-product',[$product['id']])}}" class="latest-product-item-image" >
                    <div class="image-placeholder"></div>
                    <img src="{{ $product->image_fullpath[0] }}"  alt="{{ $product->name }}" class="latest-product-image image-load" loading="lazy">
                </a>
                <p>{{$product->name}}</p>
            </div>
        @endforeach
    </div>
</section>
