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
    <div id="product-container"></div>

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
    .ui-pdp-description__content{
        font-size: 17px;
        font-weight:400;
        word-wrap: break-word;
    }

</style>
<script src="assets/js/core_js/detalle.js?{{ rand() }}"></script>