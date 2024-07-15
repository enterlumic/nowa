<x-app-layout>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Empresa</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item fs-15"><a href="javascript:void(0);">Empleados</a></li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row -->
    <div class="row row-sm">
        
        @php $select= 'empleados' @endphp

        @include('empresa.menu_configurar_empresa')

        <!-- Col -->
        <div class="col-lg-8 col-xl-9">
            <div class="card">
                <div class="card-body">

                    <div class="tab-pane active" id="tab-datatable" role="tabpanel">
                        <div class=" d-flex align-items-center">
                            <h5 class="mb-0 flex-grow-1"></h5>
                            <div>
                                <button id="add_new_empleados" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormIUempleados">Nuevo</button>
                                <button id="import_empleados" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalImportFormempleados">Importar</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive mb-0" data-pattern="priority-columns">
                                    <table id="get_empleados_datatable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">id</th>
                                                <th >Nombre</th>
                                                <th >Direccion</th>
                                                <th >Telefono</th>
                                                <th >Email</th>
                                                <th >Ingreso</th>
                                                <th >Puesto</th>
                                                <th >Salario</th>
                                                <th >Jornada</th>
                                                <th >Especialidades</th>
                                                <th >Certificaciones</th>
                                                <th style="width: 9%">Acción</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- row closed -->
                    <div class="div-modals">

                        {{-- Modal para Agregar o modificar un nuevo registro  --}}
                        {{-- add_empleados // en sublime F12 te lleva al .blade --}}
                        @include('modals.add_empleados')

                        {{-- Modal para descargar platilla, importar desde un excel, o pegar una lista de registro en text area  --}}
                        {{-- import_empleados // en sublime F12 te lleva al .blade --}}
                        @include('modals.import_empleados')

                    </div>
                    <!-- .div-modals -->

                </div>
            </div>
        </div>
        <!-- /Col -->
    </div>
    <!-- /row -->
</x-app-layout>

<script src="assets/js/core_js/empleados.js?{{ rand() }}"></script>
