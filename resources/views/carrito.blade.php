<x-app-layout>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Carrito</span>
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
                                <button id="truncate_sps_carrito" class="btn btn-danger" onclick="carrito.fn_truncateSPScarrito()">Truncate SPS</button>
                                <button id="truncate_carrito" class="btn btn-danger" onclick="carrito.fn_truncatecarrito()">Truncate</button>
                                <button id="refresh_carrito" class="btn btn-success" onclick="carrito.fn_actualizarTablacarrito()">Actualizar</button>
                                <button id="add_new_carrito" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormIUcarrito">Nuevo</button>
                                <button id="import_carrito" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalImportFormcarrito">Importar</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive mb-0" data-pattern="priority-columns">
                                    <table id="get_carrito_datatable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">id</th>
                                                <th >User_Id</th>
                                                <th >Producto_Id</th>
                                                <th >Cantidad</th>
                                                <th >Agregado_En</th>
                                                <th >Estado</th>
                                                <th style="width: 9%">Acción</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="user_id"><input type="text" id="buscar_user_id" placeholder="Buscar por user_id"></th>
                                                <th class="producto_id"><input type="text" id="buscar_producto_id" placeholder="Buscar por producto_id"></th>
                                                <th class="cantidad"><input type="text" id="buscar_cantidad" placeholder="Buscar por cantidad"></th>
                                                <th class="agregado_en"><input type="text" id="buscar_agregado_en" placeholder="Buscar por agregado_en"></th>
                                                <th class="estado"><input type="text" id="buscar_estado" placeholder="Buscar por estado"></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab-scroll" role="tabpanel">
                        <div ng-app='app-scroll-carrito' ng-controller='ControllerScroll'>
                            <div infinite-scroll='reddit.nextPage()' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
                                <div class="row">
                                    <ul class="list-group">
                                        <div ng-repeat='item in reddit.items' class="col-xl-3 col-md-3 col-sm-3 col-xs-3">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                @{{item.user_id }} <span class="badge bg-success">@{{item.id}}</span>
                                            </li>
                                        </div>
                                    </ul>
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
        {{-- add_carrito // en sublime F12 te lleva al .blade --}}
        @include('modals.add_carrito')

        {{-- Modal para descargar platilla, importar desde un excel, o pegar una lista de registro en text area  --}}
        {{-- import_carrito // en sublime F12 te lleva al .blade --}}
        @include('modals.import_carrito')

    </div>
    <!-- .div-modals -->
</x-app-layout>

<script src="assets/js/core_js/carrito.js?{{ rand() }}"></script>