@php
    use Illuminate\Support\Str;
@endphp

@foreach ($promociones as $promocion)
    <div class="col-md-4 col-lg-6 col-xl-4 col-xxl-3 col-sm-6 mb-4">
        <div class="card ">
            <div class="card-body h-100 product-grid6">
                <div class="pro-img-box product-image">
                    <a href="product-details.html">
                        <img class="pic-1" src="{{ asset('uploads/promociones/' . $promocion->foto) }}" alt="{{ $promocion->titulo }}">
                        <img class="pic-2" src="{{ asset('uploads/promociones/' . $promocion->foto) }}" alt="{{ $promocion->titulo }}">
                    </a>
                    <ul class="icons list-unstyled">
                        <li><a href="wish-list.html" class="primary-gradient me-2" data-bs-placement="top" data-bs-toggle="tooltip" title="Add to Wishlist"><i class="fa fa-heart"></i></a></li>
                        <li><a href="product-cart.html" class="secondary-gradient me-2" data-bs-placement="top" data-bs-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                        <li><a href="product-details.html" class="info-gradient" data-bs-placement="top" data-bs-toggle="tooltip" title="Quick View"><i class="fas fa-eye"></i></a></li>
                    </ul>
                </div>
                <div class="text-center pt-2">
                    <h3 class="h6 mb-2 mt-4 text-uppercase">{{ Str::limit($promocion->titulo, 70) }}</h3>
                    <h4 class="h5 mb-0 mt-1 text-center fw-bold fs-22">${{ $promocion->precio }} <span class="text-secondary fw-normal fs-13 ms-1 prev-price text-decoration-line-through">${{ $promocion->precio_anterior }}</span></h4>
                </div>
            </div>
        </div>
    </div>
@endforeach
