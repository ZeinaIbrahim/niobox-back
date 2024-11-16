<section class="banner-section">
    <div class="slider-container">
        <div class="slider" id="slider">
            @foreach ($bannerPrimer as $banner)
                <div class="slider-item" >
                    <div class="image-placeholder"></div>
                    <img src="{{ $banner->image_fullpath }}" alt="{{ $banner->title }}" class="image_banner image-load" loading="lazy">
                </div>
            @endforeach
        </div>
        <div class="controls">
            <button class="arrow" id="prev">
                &#10094;
            </button>
            <button class="arrow" id="next">
                &#10095;
            </button>
        </div>
    </div>
</section>
