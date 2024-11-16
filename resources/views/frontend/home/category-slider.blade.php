<section class="category-section">
    <div class="category-scroll">
        @foreach ($categories as $category)
            <a href="{{route('frontend-store',['category_id'=>$category['id']])}}" class="category-item" data-category-id="{{$category->id}}">
                <div class="image-placeholder"></div>
                <img src="{{ $category->image_fullpath }}"  alt="{{ $category->name }}" class="category-item-image image-load" loading="lazy">
            </a>
        @endforeach
    </div>
</section>
