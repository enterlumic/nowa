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
                <div class="card-body ">
                    <div class="row row-sm ">
                        <div class=" col-xxl-6 col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-xxl-2 col-xl-2 col-md-2 col-sm-3">
                                    <div class="clearfix carousel-slider">
                                        <div id="thumbcarousel" class="carousel slide" data-bs-interval="t">
                                            <div class="carousel-inner">
                                                @foreach($fotos as $ini=>  $producto)
                                                    <ul class="carousel-item {{ $ini == 0 ? 'active' : '' }}">
                                                        @foreach($producto->fotos_array as $index => $foto)
                                                            <li data-bs-target="#Slider" data-bs-slide-to="{{ $index }}" class="thumb {{ $index == 0 ? 'active' : '' }} my-sm-2 m-2 mx-sm-0">
                                                                <img src="{{ trim($foto) }}" alt="img">
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-10 col-xl-10 col-md-10 col-sm-9">
                                    <div class="product-carousel border br-5">
                                        <div id="Slider" class="carousel slide" data-bs-ride="false">
                                            <div class="carousel-inner">
                                                @foreach($fotos as $producto)
                                                    @foreach($producto->fotos_array as $index => $foto)
                                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                            <img src="{{ trim($foto) }}" alt="img" class="img-fluid mx-auto d-block">
                                                            <div class="text-center mt-5 mb-5 btn-list">
                                                                <!-- Aquí puedes añadir botones u otros elementos -->
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="details col-xxl-6 col-lg-12 col-md-12 mt-4">
                            <h4 class="product-title mb-1">{{ $fotos[0]['titulo'] }}</h4>
                            <h6 class="price">Precio: <span class="h3 ms-2">{{$fotos[0]['precio']}}</span></h6>

                            <h5>Descripción</h5>
                            {{$fotos[0]['descripcion']}} 

                            <div class="mt-4 btn-list">
                                <a href="javascript:void(0);" class="btn ripple btn-primary me-2"><i class="fe fe-shopping-cart"> </i>Agregar al carrito</a>
                                <a href="javascript:void(0);" class="btn ripple btn-secondary"><i class="fe fe-credit-card"> </i>Comprar ahora</a>
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

<script src="assets/js/core_js/detalle.js?{{ rand() }}"></script>