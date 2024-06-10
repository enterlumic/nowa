<x-app-layout>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Logss</span>
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
                                <button id="truncate_logss" class="btn btn-danger" onclick="logss.fn_truncatelogss()">Truncate</button>
                                <button id="refresh_logss" class="btn btn-success" onclick="logss.fn_actualizarTablalogss()">Actualizar</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive mb-0" data-pattern="priority-columns">
                                    <table id="get_logss_datatable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">id</th>
                                                <th >User_Id</th>
                                                <th >Event_Type</th>
                                                <th >Context</th>
                                                <th >Event_Data</th>
                                                <th >execution_time</th>
                                                <th >Status</th>
                                                <th >Severity</th>
                                                <th >Source</th>
                                                <th >Ip_Address</th>
                                                <th >User_Agent</th>
                                                <th style="width: 9%">Acción</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="user_id"><input type="text" id="buscar_user_id" placeholder="Buscar por user_id"></th>
                                                <th class="event_type"><input type="text" id="buscar_event_type" placeholder="Buscar por event_type"></th>
                                                <th class="context"><input type="text" id="buscar_context" placeholder="Buscar por context"></th>
                                                <th class="event_data"><input type="text" id="buscar_event_data" placeholder="Buscar por event_data"></th>
                                                <th class="execution_time"><input type="text" id="buscar_execution_time" placeholder="Buscar por execution_time"></th>
                                                <th class="status"><input type="text" id="buscar_status" placeholder="Buscar por status"></th>
                                                <th class="severity"><input type="text" id="buscar_severity" placeholder="Buscar por severity"></th>
                                                <th class="source"><input type="text" id="buscar_source" placeholder="Buscar por source"></th>
                                                <th class="ip_address"><input type="text" id="buscar_ip_address" placeholder="Buscar por ip_address"></th>
                                                <th class="user_agent"><input type="text" id="buscar_user_agent" placeholder="Buscar por user_agent"></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab-scroll" role="tabpanel">
                        <div ng-app='app-scroll-logss' ng-controller='ControllerScroll'>
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
        {{-- add_logss // en sublime F12 te lleva al .blade --}}
        @include('modals.add_logss')

        {{-- Modal para descargar platilla, importar desde un excel, o pegar una lista de registro en text area  --}}
        {{-- import_logss // en sublime F12 te lleva al .blade --}}
        @include('modals.import_logss')

    </div>
    <!-- .div-modals -->
</x-app-layout>

<script src="assets/js/core_js/logss.js?{{ rand() }}"></script>