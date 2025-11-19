<div class="col-6 col-xxl-3 col-lg-4 col-md-6 col-sm-6">
    <div class="product-cart-wrap mb-30">
        <div class="product-img-action-wrap">
            <div class="product-img product-img-zoom">
                <a href="shop-product-right.html">
                    @foreach($product->images as $key => $image)
                    <img class="{{  $key == 0 ? 'default-img' : 'hover-img' }}" src="{{ asset($image->path) }}" alt="" />
                    @endforeach
                    {{-- <img class="hover-img" src="assets/imgs/shop/product-1-2.jpg" alt="" /> --}}
                </a>
            </div>
            <div class="product-action-1">
                <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i
                        class="fi-rs-heart"></i></a>
                <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i
                        class="fi-rs-eye"></i></a>
            </div>
            <div class="product-badges product-badges-position product-badges-mrg">
                @if ($product->is_hot == 1)
                    <span class="hot">Hot</span>
                @endif
                @if ($product->is_new == 1)
                    <span class="hot ms-1">New</span>
                @endif
            </div>
        </div>
        <div class="product-content-wrap">
            {{-- <div class="product-category">
                <a href="shop-grid-right.html">{{ $product->category->name }}</a>
            </div> --}}
            <h2><a href="shop-product-right.html">{{ $product->name }}</a></h2>
            <div class="product-rate-cover">
                <div class="product-rate d-inline-block">
                    <div class="product-rating" style="width: 90%"></div>
                </div>
                <span class="font-small ml-5 text-muted"> (4.0)</span>
            </div>
            <div>
                <span class="font-small text-muted">By <a href="vendor-details-1.html">{{ $product->store->name }}</a></span>
            </div>
            <div class="product-card-bottom">
                <div class="product-price">
                    @php
                        $price = $product->getEffectivePriceAndStock();
                    @endphp

                    @if ($price['in_stock'])

                        @if ($price['old_price'] > 0)
                            <span>${{ $price['price'] }}</span>
                            <span class="old-price">${{ $price['old_price'] }}</span>
                        @else
                            <span>${{ $price['price'] }}</span>
                        @endif
                    @else
                        <span class="text-danger">Out of stock</span>
                    @endif
                </div>
                <div class="add-cart">
                    <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end product card-->
