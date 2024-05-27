<x-app-layout>
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Check Out</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item fs-15"><a href="javascript:void(0);">Pages</a></li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->
    <!-- row -->
    <div class="row justify-content-center">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body p-0 product-checkout">
                    <ul class="nav nav-tabs tab-style-2 d-sm-flex d-block border-bottom border-block-end-dashed" id="myTab1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="shipped-tab" data-bs-toggle="tab" data-bs-target="#shipped-tab-pane" type="button" role="tab" aria-controls="shipped-tab" aria-selected="false">
                                <i class="ri-number-1 me-2 align-middle"></i>Pedido
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivery-tab-pane" type="button" role="tab" aria-controls="delivered-tab" aria-selected="false">
                                <i class="ri-number-2 me-2 align-middle"></i>Pagos
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="finished-tab" data-bs-toggle="tab" data-bs-target="#finished-tab-pane" type="button" role="tab" aria-controls="finished-tab" aria-selected="false">
                                <i class="ri-number-3 me-2 align-middle"></i>Finalizado
                            </button>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-xl-8 mx-auto">
                            <div class="tab-content border m-4" id="myTabContent">
                                <div class="tab-pane fade show active border-0 p-0" id="shipped-tab-pane" role="tabpanel" aria-labelledby="shipped-tab-pane" tabindex="0">

                                    <div class="p-4">
                                        <h5 class="text-start mb-2">Tu pedido</h5>
                                        <p class="mb-4 text-muted tx-13 ms-0 text-start">Lista de producto seleccionado</p>
                                    </div>
                                    <div id="promocion-container">

                                    </div>
                                    <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-between">
                                        <button type="button" class="btn btn-success m-1" id="continue-payment-trigger">Siguiente</button>
                                    </div>
                                </div>

                                <div class="tab-pane fade border-0 p-0" id="delivery-tab-pane" role="tabpanel" aria-labelledby="delivery-tab-pane" tabindex="0">
                                    <div class="p-4">
                                        <div class="">
                                            <h5 class="text-start mb-2">Pagos</h5>
                                            <p class="mb-4 text-muted tx-13 ms-0 text-start">Completa los detalles de tu tarjeta para finalizar tu compra de manera segura.</p>

                                            <!-- Button to trigger modal -->
                                            <button id="add_new_cliente_conekta" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormIUclienteConekta">Agregar Nueva Tarjeta</button>
                                        </div>

                                        <div class="mt-4">
                                            <h6>Tarjetas Guardadas:</h6>
                                            <div id="mainContactList">
                                                @foreach($savedCards as $card)
                                                    <div class="main-contact-item seleccionar-medio-pago" data-card-id="{{ $card->id }}">
                                                        <div class="main-img-user online"><img alt="avatar" src="../assets/images/faces/2.jpg"></div>
                                                        <div class="main-contact-body">
                                                            <h6>{{ $card->name }}</h6><span class="phone">********{{ substr($card->number, -4) }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-between">
                                        <button type="button" class="btn btn-light m-1" id="back-personal-trigger3">Anterior</button>
                                        <button type="button" class="btn btn-success m-1" id="continue-finished-tab">Continuar pago</button>
                                    </div>
                                </div>

                                <!-- Modal structure -->
                                @include('modals.add_cliente_conekta')

                                <div class="tab-pane fade border-0 p-0" id="finished-tab-pane" role="tabpanel" aria-labelledby="finished-tab-pane" tabindex="0">
                                    <div class="text-center p-4">
                                        <div class="">
                                            <h5 class="text-center mb-4">¡Tu pedido ha sido confirmado!</h5>
                                        </div>
                                        <svg class="wd-100 ht-100 mx-auto justify-content-center mb-3 text-center" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                                            <circle class="path circle" fill="none" stroke="#22c03c" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                                            <polyline class="path check" fill="none" stroke="#22c03c" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 "/>
                                        </svg>
                                        <p class="success pl-5 pr-5">Pedido realizado con éxito. Tu pedido será despachado pronto. Mientras tanto, puedes rastrear tu pedido en la sección "Mis pedidos".</p>
                                    </div>
                                    <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-between">
                                        <button type="button" class="btn btn-light m-1" id="back-personal-trigger4">Anterior</button>
                                        <button type="button" class="btn btn-secondary m-1" id="continue-payment-trigger1">Pedir de nuevo</button>
                                    </div>
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
        {{-- add_check_out // en sublime F12 te lleva al .blade --}}
        @include('modals.add_check_out')

        {{-- Modal para descargar platilla, importar desde un excel, o pegar una lista de registro en text area  --}}
        {{-- import_check_out // en sublime F12 te lleva al .blade --}}
        @include('modals.import_check_out')

    </div>
    <!-- .div-modals -->
</x-app-layout>

<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
<script src="assets/js/core_js/cliente_conekta.js?{{ rand() }}"></script>

<script src="assets/js/core_js/check_out.js?{{ rand() }}"></script>

<!-- Handle-counter js -->
<script src="assets/js/handlecounter.js"></script>

<!-- Internal Checkout JS -->
<script src="assets/js/checkout.js?{{ rand() }}"></script>

<style type="text/css">
.seleccionar-medio-pago.selected {
    border: 2px solid blue;
    background-color: #f0f8ff;
}
</style>

