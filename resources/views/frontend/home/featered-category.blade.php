<section class="featered-category-section">
    <div class="featered-category-scroll">
        @foreach ($products as $product)
            <div class="featered-category-item">
                <a href="{{route('frontend-product',[$product['id']])}}" class="featered-category-item-image" >
                    <div class="image-placeholder"></div>
                    <img src="{{ $product->image_fullpath[0] }}"  alt="{{ $product->name }}" class="featered-category-image image-load" loading="lazy">
                </a>
                <p>{{$product->name}}</p>
            </div>
        @endforeach
    </div>
</section>
