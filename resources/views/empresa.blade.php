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

                <!-- Tab panes -->
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="tab-datatable" role="tabpanel">
                        <div class=" d-flex align-items-center">
                            <h5 class="mb-0 flex-grow-1"></h5>
                            <div>
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
                                                <th >Logo</th>
                                                <th >Nombre</th>
                                                <th >Descripcion</th>
                                                <th >Telefono</th>
                                                <th >Whatsapp</th>
                                                <th >Ubicacion</th>
                                                <th >Longitud</th>
                                                <th >Latitud</th>
                                                <th style="width: 9%">Acción</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="logo"><input type="text" id="buscar_logo" placeholder="Buscar por logo"></th>
                                                <th class="nombre"><input type="text" id="buscar_nombre" placeholder="Buscar por nombre"></th>
                                                <th class="descripcion"><input type="text" id="buscar_descripcion" placeholder="Buscar por descripcion"></th>
                                                <th class="telefono"><input type="text" id="buscar_telefono" placeholder="Buscar por telefono"></th>
                                                <th class="whatsapp"><input type="text" id="buscar_whatsapp" placeholder="Buscar por whatsapp"></th>
                                                <th class="ubicacion"><input type="text" id="buscar_ubicacion" placeholder="Buscar por ubicacion"></th>
                                                <th class="longitud"><input type="text" id="buscar_longitud" placeholder="Buscar por longitud"></th>
                                                <th class="latitud"><input type="text" id="buscar_latitud" placeholder="Buscar por latitud"></th>
                                                <th></th>
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
        {{-- add_empresa // en sublime F12 te lleva al .blade --}}
        @include('modals.add_empresa')

    </div>
    <!-- .div-modals -->
</x-app-layout>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBdSvVepDl30nFw15uaj_BaWQeDOR5Hfj8&libraries=places"></script>
<script src="assets/js/core_js/empresa.js?{{ rand() }}"></script>