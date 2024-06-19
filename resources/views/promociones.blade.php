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
                <!-- Tab panes -->
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="tab-datatable" role="tabpanel">
                        <div class=" d-flex align-items-center">
                            <h5 class="mb-0 flex-grow-1"></h5>
                            <div>
                                <button id="refresh_promociones" class="btn btn-info" onclick="promociones.fn_actualizarTablapromociones()">Actualizar</button>
                                <button id="add_new_promociones" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormIUpromociones">Nuevo</button>
                                <button id="import_promociones" class="btn btn-secondary d-none" data-bs-toggle="modal" data-bs-target="#modalImportFormpromociones">Importar</button>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="table-rep-plugin">
                                <div class="product-details table-responsive text-nowrap" data-pattern="priority-columns">
                                    <table id="get_promociones_datatable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">id</th>
                                                <th >Titulo</th>
                                                <th >Descripcion</th>
                                                <th >Precio</th>
                                                <th >Marca</th>
                                                <th >Review</th>
                                                <th >Cantidad</th>
                                                <th >Color</th>
                                                <th >Precio_Anterior</th>
                                                <th >Target</th>
                                                <th style="width: 9%">Acción</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
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
        @include('modals.add_python')

        {{-- Modal para descargar platilla, importar desde un excel, o pegar una lista de registro en text area  --}}
        {{-- import_promociones // en sublime F12 te lleva al .blade --}}
        @include('modals.import_promociones')
    </div>
    <!-- .div-modals -->
</x-app-layout>

<script src="assets/js/core_js/promociones.js?{{ rand() }}"></script>
