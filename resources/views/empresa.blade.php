<x-app-layout>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Empresa</span>
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
                                <button id="truncate_sps_empresa" class="btn btn-danger" onclick="empresa.fn_truncateSPSempresa()">Truncate SPS</button>
                                <button id="truncate_empresa" class="btn btn-danger" onclick="empresa.fn_truncateempresa()">Truncate</button>
                                <button id="refresh_empresa" class="btn btn-success" onclick="empresa.fn_actualizarTablaempresa()">Actualizar</button>
                                <button id="add_new_empresa" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormIUempresa">Nuevo</button>
                                <button id="import_empresa" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalImportFormempresa">Importar</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive mb-0" data-pattern="priority-columns">
                                    <table id="get_empresa_datatable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">id</th>
                                                <th >Nombre</th>
                                                <th >Descripcion</th>
                                                <th >Telefono</th>
                                                <th >Whatsapp</th>
                                                <th >Ubicacion</th>
                                                <th style="width: 9%">Acción</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="nombre"><input type="text" id="buscar_nombre" placeholder="Buscar por nombre"></th>
                                                <th class="descripcion"><input type="text" id="buscar_descripcion" placeholder="Buscar por descripcion"></th>
                                                <th class="telefono"><input type="text" id="buscar_telefono" placeholder="Buscar por telefono"></th>
                                                <th class="whatsapp"><input type="text" id="buscar_whatsapp" placeholder="Buscar por whatsapp"></th>
                                                <th class="ubicacion"><input type="text" id="buscar_ubicacion" placeholder="Buscar por ubicacion"></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab-scroll" role="tabpanel">
                        <div ng-app='app-scroll-empresa' ng-controller='ControllerScroll'>
                            <div infinite-scroll='reddit.nextPage()' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
                                <div class="row">
                                    <ul class="list-group">
                                        <div ng-repeat='item in reddit.items' class="col-xl-3 col-md-3 col-sm-3 col-xs-3">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                @{{item.nombre }} <span class="badge bg-success">@{{item.id}}</span>
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
        {{-- add_empresa // en sublime F12 te lleva al .blade --}}
        @include('modals.add_empresa')

        {{-- Modal para descargar platilla, importar desde un excel, o pegar una lista de registro en text area  --}}
        {{-- import_empresa // en sublime F12 te lleva al .blade --}}
        @include('modals.import_empresa')

    </div>
    <!-- .div-modals -->
</x-app-layout>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBQ-mOlzL2_V-Esh-ssOr-mtqvviYCSWQ&libraries=places"></script>
{{-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdSvVepDl30nFw15uaj_BaWQeDOR5Hfj8&libraries=places"></script> --}}
<script src="assets/js/core_js/empresa.js?{{ rand() }}"></script>