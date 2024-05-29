<x-app-layout>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Cliente Conekta</span>
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
                                <button id="refresh_cliente_conekta" class="btn btn-success">Actualizar</button>
                                <button id="add_new_cliente_conekta" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormIUclienteConekta">Nuevo</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-rep-plugin">
                                <div class="table-responsive mb-0" data-pattern="priority-columns">
                                    <table id="get_cliente_conekta_datatable" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">id</th>
                                                <th >Name</th>
                                                <th >Number</th>
                                                <th >Cvc</th>
                                                <th >Exp_Month</th>
                                                <th >Exp_Year</th>
                                                <th style="width: 9%">Acción</th>
                                            </tr>
                                        </thead>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th class="name"><input type="text" id="buscar_name" placeholder="Buscar por name"></th>
                                                <th class="number"><input type="text" id="buscar_number" placeholder="Buscar por number"></th>
                                                <th class="cvc"><input type="text" id="buscar_cvc" placeholder="Buscar por cvc"></th>
                                                <th class="exp_month"><input type="text" id="buscar_exp_month" placeholder="Buscar por exp_month"></th>
                                                <th class="exp_year"><input type="text" id="buscar_exp_year" placeholder="Buscar por exp_year"></th>
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
        {{-- add_cliente_conekta  // en sublime F12 te lleva al .blade --}}
        @include('modals.add_cliente_conekta')

    </div>
    <!-- .div-modals -->
</x-app-layout>

<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
<script src="assets/js/core_js/cliente_conekta.js?{{ rand() }}"></script>
