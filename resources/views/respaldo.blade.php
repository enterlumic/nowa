<x-app-layout>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Promociones</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item fs-15"><a href="javascript:void(0);">Pages</a></li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <div class="card">


                <div class="card-header align-items-center d-flex">
                    <div class="flex-shrink-0">
                        <ul class="nav justify-content-end nav-tabs-custom rounded card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tab-datatable" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Datatable</span> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab-scroll" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Scroll</span> 
                                </a>
                            </li>
                        </ul>
                    </div>
                </div><!-- end card header -->

                <!-- Tab panes -->
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="tab-datatable" role="tabpanel">
                        <div class=" d-flex align-items-center">
                            <h5 class="mb-0 flex-grow-1"></h5>
                            <div>
                                <button id="refresh_promociones" class="btn btn-success" onclick="promociones.fn_actualizarTablapromociones()">Actualizar</button>
                                <button id="add_new_promociones" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormIUpromociones">Nuevo</button>
                                <button id="import_promociones" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalImportFormpromociones">Importar</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive mb-0" data-pattern="priority-columns">
                                    <table id="get_promociones_datatable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">id</th>
                                                <th >Target</th>
                                                <th >Titulo</th>
                                                <th >Subtitulo</th>
                                                <th >Review</th>
                                                <th >Cantidad</th>
                                                <th >Color</th>
                                                <th >Precio</th>
                                                <th >Precio_Anterior</th>
                                                <th >Imagen</th>
                                                <th style="width: 9%">Acción</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="target"><input type="text" id="buscar_target" placeholder="Buscar por target"></th>
                                                <th class="titulo"><input type="text" id="buscar_titulo" placeholder="Buscar por titulo"></th>
{{--                                                 <th class="subtitulo"><input type="text" id="buscar_subtitulo" placeholder="Buscar por subtitulo"></th>
                                                <th class="review"><input type="text" id="buscar_review" placeholder="Buscar por review"></th>
                                                <th class="cantidad"><input type="text" id="buscar_cantidad" placeholder="Buscar por cantidad"></th>
                                                <th class="color"><input type="text" id="buscar_color" placeholder="Buscar por color"></th>
 --}}                                                <th class="precio"><input type="text" id="buscar_precio" placeholder="Buscar por precio"></th>
                                                {{-- <th class="precio_anterior"><input type="text" id="buscar_precio_anterior" placeholder="Buscar por precio_anterior"></th> --}}
                                                <th class="imagen"><input type="text" id="buscar_imagen" placeholder="Buscar por imagen"></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="tab-scroll" role="tabpanel">

                        <div ng-app='app-scroll-promociones' ng-controller='ControllerScroll'>
                            <div infinite-scroll='reddit.nextPage()' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="row row-sm">
                                        <div ng-repeat='item in reddit.items' class="col-md-4 col-lg-6 col-xl-4 col-xxl-3 col-sm-6">
                                            <div class="card">
                                                <div class="card-body h-100 product-grid6">
                                                    <div class="pro-img-box product-image">
                                                        <a href="detalle?id=@{{item.id}}">
                                                            <img class="pic-1" ng-src="@{{item.imagen}}" alt="product-image">
                                                            <img class="pic-2" ng-src="@{{item.imagen}}" alt="product-image-1">
                                                        </a>
                                                        <ul class="icons list-unstyled">
                                                            <li><a href="wish-list.html" data-bs-placement="top" data-bs-toggle="tooltip" title="Add to Wishlist" class="primary-gradient me-2"><i class="fa fa-heart"></i></a></li>
                                                            <li><a href="product-cart.html" data-bs-placement="top" data-bs-toggle="tooltip" title="Add to Cart" class="secondary-gradient me-2"><i class="fa fa-shopping-cart"></i></a></li>
                                                            <li><a href="product-details.html" data-bs-placement="top" data-bs-toggle="tooltip" title="Quick View" class="info-gradient"><i class="fas fa-eye"></i></a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="text-center pt-2">
                                                        <h3 class="h6 mb-2 mt-4 fw-bold text-uppercase">@{{item.titulo}}</h3>
                                                        <span class="fs-15 ms-auto">
                                                            <i class="ion ion-md-star text-warning"></i>
                                                            <i class="ion ion-md-star text-warning"></i>
                                                            <i class="ion ion-md-star text-warning"></i>
                                                            <i class="ion ion-md-star-half text-warning"></i>
                                                            <i class="ion ion-md-star-outline text-warning"></i>
                                                        </span>
                                                        <h4 class="h5 mb-0 mt-1 text-center fw-bold fs-22">@{{item.precio}} 
                                                            <span class="text-secondary fw-normal fs-13 ms-1 prev-price text-decoration-line-through">@{{item.precio}}</span>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div ng-show='reddit.busy'>Cargando...</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    <div class="div-modals">

        {{-- Modal para Agregar o modificar un nuevo registro  --}}
        {{-- add_promociones // en sublime F12 te lleva al .blade --}}
        @include('modals.add_promociones')

        {{-- Modal para descargar platilla, importar desde un excel, o pegar una lista de registro en text area  --}}
        {{-- import_promociones // en sublime F12 te lleva al .blade --}}
        @include('modals.import_promociones')

    </div>
    <!-- .div-modals -->
</x-app-layout>

<script src="assets/js/core_js/promociones.js?{{ rand() }}"></script>