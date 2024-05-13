<x-app-layout>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Marcas</span>
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
                <!-- Tab panes -->
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="tab-datatable" role="tabpanel">
                        <div class=" d-flex align-items-center">
                            <h5 class="mb-0 flex-grow-1"></h5>
                            <div>
                                <button id="truncate_sps_marcas" class="btn btn-danger">Truncate SPS</button>
                                <button id="truncate_marcas" class="btn btn-danger">Truncate</button>
                                <button id="refresh_marcas" class="btn btn-success">Actualizar</button>
                                <button id="add_new_marcas" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormIUmarcas">Nuevo</button>
                                <!-- <button id="add_new_marcas" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFormIUmarcas" data-backdrop="static" data-keyboard="false">Nuevo</button> -->
                                <button id="import_marcas" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalImportFormmarcas">Importar</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive mb-0" data-pattern="priority-columns">
                                    <table id="get_marcas_datatable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">id</th>
                                                <th >Nombre</th>
                                                <th >Logo</th>
                                                <th style="width: 9%">Acción</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="Nombre"><input type="text" id="buscar_Nombre" placeholder="Buscar por Nombre"></th>
                                                <th class="Logo"><input type="text" id="buscar_Logo" placeholder="Buscar por Logo"></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="tab-scroll" role="tabpanel">
                        <div ng-app='app-scroll-marcas' ng-controller='ControllerScroll'>
                            <div infinite-scroll='reddit.nextPage()' infinite-scroll-disabled='reddit.busy' infinite-scroll-distance='1'>
                                <div class="row">
                                    <ul class="list-group">
                                        <div ng-repeat='item in reddit.items' class="col-xl-3 col-md-3 col-sm-3 col-xs-3">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                @{{item.Nombre }} <span class="badge bg-success">@{{item.id_marcas}}</span>
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
        @include('modals.add_marcas')

        {{-- Modal para descargar platilla, importar desde un excel, o pegar una lista de registro en text area  --}}
        @include('modals.import_marcas')

    </div>
    <!-- .div-modals -->
</x-app-layout>

<script src="assets/js/core_js/marcas.js?{{ rand() }}"></script>