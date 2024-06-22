<x-app-layout>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Detalle</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item fs-15"><a href="javascript:void(0);">Pages</a></li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row -->
    <div class="row row-sm">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row row-sm">
                        <div class="col-xxl-6 col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-xxl-2 col-xl-2 col-md-2 col-sm-3">
                                    <div class="clearfix carousel-slider">
                                        <div id="thumbcarousel" class="carousel slide" data-bs-interval="false">
                                            <div class="carousel-inner">
                                                @php
                                                    $thumbIndex = 0;
                                                @endphp
                                                <ul class="carousel-item active">
                                                    @foreach ($fotos as $foto)
                                                        @if ($foto->size == 'small')
                                                            <li data-bs-target="#Slider" data-bs-slide-to="{{ $thumbIndex }}" class="thumb {{ $thumbIndex == 0 ? 'active' : '' }} my-sm-2 m-2 mx-sm-0">
                                                                <img src="{{ asset('uploads/promociones/'.$foto->foto_url) }}" alt="img" class="img-thumbnail">
                                                            </li>
                                                            @php
                                                                $thumbIndex++;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-10 col-xl-10 col-md-10 col-sm-9">
                                    <div class="product-carousel border br-5">
                                        <div id="Slider" class="carousel slide" data-bs-ride="false">
                                            <div class="carousel-inner">
                                                @php
                                                    $slideIndex = 0;
                                                @endphp
                                                @foreach ($fotos as $foto)
                                                    @if ($foto->size == 'original')
                                                        <div class="carousel-item {{ $slideIndex == 0 ? 'active' : '' }}">
                                                            <img src="{{ asset('uploads/promociones/'.$foto->foto_url) }}" alt="img" class="img-fluid mx-auto d-block img-custom-size">
                                                            <div class="text-center mt-5 mb-5 btn-list">
                                                            </div>
                                                        </div>
                                                        @php
                                                            $slideIndex++;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-4 btn-list">
                                        <a href="product-cart.html" class="btn ripple btn-primary me-2"><i class="fe fe-shopping-cart"> </i> Add to cart</a>
                                        <a href="check-out.html" class="btn ripple btn-secondary"><i class="fe fe-credit-card"> </i> Buy Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="details col-xxl-6 col-lg-12 col-md-12 mt-4">
                            <h4 class="product-title mb-1">Jyothi Fashion Women's Fit & Flare Knee Length Western Frock</h4>
                            <p class="text-muted fs-13 mb-1">women red & Grey Checked Casual frock</p>
                            <div class="rating mb-1">
                                <div class="stars">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star text-muted"></span>
                                    <span class="fa fa-star text-muted"></span>
                                </div>
                                <span class="review-no">41 reviews</span>
                            </div>
                            <h6 class="price">current price: <span class="h3 ms-2">$253</span></h6>
                            <p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong></p>
                            <div class="mb-3">
                                <div class="">
                                    <p class="font-weight-normal"><span class="h4">Hurry Up!</span> Sold: <span class="text-primary h5">110/150</span> products in stock.<p>
                                </div>
                                <div class="progress ht-10 mt-0">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 60%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="ps-4 pe-4 pb-2 pt-4">
                    <h5 class="mb-4">Escribir Reseña</h5>
                    <div class="mb-1">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div class="mb-3 fw-semibold">Tu Nombre</div>
                                <input class="form-control" placeholder="Tu Nombre" type="text">
                            </div>
                            <div class="form-group col-md-6">
                                <div class="mb-3 fw-semibold">Dirección de Correo Electrónico</div>
                                <input class="form-control" placeholder="Dirección de Correo Electrónico" type="text">
                            </div>
                        </div>
                    </div>
                    <span class="star-rating">
                        <a href="javascript:void(0);"><i class="icofont-ui-rating icofont-2x"></i></a>
                        <a href="javascript:void(0);"><i class="icofont-ui-rating icofont-2x"></i></a>
                        <a href="javascript:void(0);"><i class="icofont-ui-rating icofont-2x"></i></a>
                        <a href="javascript:void(0);"><i class="icofont-ui-rating icofont-2x"></i></a>
                        <a href="javascript:void(0);"><i class="icofont-ui-rating icofont-2x"></i></a>
                    </span>
                    <form>
                        <div class="form-group">
                            <div class="mb-3 fw-semibold">Tu Comentario</div>
                            <textarea class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary mt-3 mb-0" type="button">Publicar tu reseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- row closed -->
    <div class="div-modals">

        {{-- Modal para Agregar o modificar un nuevo registro  --}}
        {{-- add_detalle // en sublime F12 te lleva al .blade --}}
        @include('modals.add_detalle')

        {{-- Modal para descargar platilla, importar desde un excel, o pegar una lista de registro en text area  --}}
        {{-- import_detalle // en sublime F12 te lleva al .blade --}}
        @include('modals.import_detalle')

    </div>
    <!-- .div-modals -->
</x-app-layout>

<style type="text/css">
    .ui-pdp-description__content {
        font-size: 17px;
        font-weight: 400;
        word-wrap: break-word;
    }
    .img-custom-size {
        max-width: 45%;
        height: auto;
        object-fit: cover; /* Ajusta la imagen para cubrir el contenedor manteniendo la proporción */
    }
</style>
<script src="assets/js/core_js/detalle.js?{{ rand() }}"></script>
