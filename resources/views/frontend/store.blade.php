@extends('frontend.app')

@section('title', translate('store'))

@section('content')
<section id="section-container-store">

    <div id="filter">
        <div id="toggle-filter">toggle</div>
        <div id="category-filter">
            <label>{{ translate('Categories') }}</label>
            <select id="category_id">
                <option value="">{{ translate('All Categories') }}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{$category_id == $category->id ? 'selected' : ''}}>{{ $category->name }}</option>
                    @foreach ($category['sub_categories'] as $sub_category)
                        <option value="{{ $sub_category->id }}" data-parent-id="{{ $category->id }}" {{$sub_category_id == $sub_category->id ? 'selected' : ''}}>
                            ---- {{ $sub_category->name }}
                        </option>
                    @endforeach
                @endforeach
            </select>
        </div>
        <div id="price-filter">
            <label>{{ translate('Price Range') }}</label>
            <input type="number" id="min_price" placeholder="{{ translate('Min Price') }}" value="{{ $min_price }}">
            <input type="number" id="max_price" placeholder="{{ translate('Max Price') }}" value="{{ $max_price }}">
        </div>
        <div id="sort-filter">
            <label>{{ translate('Sort By') }}</label>
            <select id="order">
                <option value="1">{{ translate('Newest') }}</option>
                <option value="2">{{ translate('Oldest') }}</option>
                <option value="3">{{ translate('Price High to Low') }}</option>
                <option value="4">{{ translate('Price Low to High') }}</option>
                <option value="5">{{ translate('Discount High to Low') }}</option>
                <option value="6">{{ translate('Discount Low to High') }}</option>
            </select>
        </div>
        <div id="search-filter">
            <label>{{ translate('Search') }}</label>
            <input type="text" id="search" placeholder="{{ translate('Search by name') }}">
        </div>
        <button id="apply-filters">{{ translate('Apply Filters') }}</button>
    </div>
    <div id="product-filtered"></div>
</section>
@endsection

@push('script_2')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const categorySelect = document.getElementById("category_id");
        const minPriceInput = document.getElementById("min_price");
        const maxPriceInput = document.getElementById("max_price");
        const orderSelect = document.getElementById("order");
        const searchInput = document.getElementById("search");
        const applyFiltersButton = document.getElementById("apply-filters");
        const productFiltered = document.getElementById("product-filtered");
        const filterUrl = '{{ route('frontend-filter') }}';

        // Fetch products function
        function fetchProducts() {
            const category_id = categorySelect.value;
            const min_price = minPriceInput.value;
            const max_price = maxPriceInput.value;
            const order = orderSelect.value;
            const search = searchInput.value;

            fetch(`${filterUrl}?category_id=${category_id}&min_price=${min_price}&max_price=${max_price}&order=${order}&search=${search}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        productFiltered.innerHTML = "<p>" + data.message + "</p>";
                    } else {
                        let productsHTML = "";

                        data.data.forEach(product => {
                            let productImage = product.image_fullpath.length > 0 ? product.image_fullpath[0] : 'default_image_path';
                            let productUrl = '{{ route('frontend-product', ':id') }}'.replace(':id', product.id);

                            productsHTML += `
                                <div class="latest-product-item">
                                    <a href="${productUrl}" class="latest-product-item-image">
                                        <div class="image-placeholder"></div>
                                        <img src="${productImage}" alt="${product.name}" class="latest-product-image image-load-after" loading="lazy">
                                    </a>
                                    <p>${product.name}</p>
                                </div>
                            `;
                        });
                        productFiltered.innerHTML = productsHTML;
                        const images = document.querySelectorAll('.image-load-after');
                        images.forEach(img => {
                            img.addEventListener('load', () => {
                                img.classList.add('loaded');
                                const placeholder = img.previousElementSibling;
                                if (placeholder && placeholder.classList.contains('image-placeholder')) {
                                    placeholder.style.display = 'none';
                                }
                            });
                            if (img.complete) {
                                img.classList.add('loaded');
                                const placeholder = img.previousElementSibling;
                                if (placeholder && placeholder.classList.contains('image-placeholder')) {
                                    placeholder.style.display = 'none';
                                }
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error("Error fetching products:", error);
                    productFiltered.innerHTML = "<p>{{ translate('An error occurred while fetching products.') }}</p>";
                });
        }

        // Initial fetch
        fetchProducts();

        // Fetch products on filter change
        applyFiltersButton.addEventListener("click", fetchProducts);
    });
</script>
@endpush
