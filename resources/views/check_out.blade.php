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
                                        </div>

                                        <div class="mt-4">
                                            <h6>Tarjetas Guardadas:</h6>
                                            <div class="form-group">
                                                <div class="custom-control custom-radio mb-3">
                                                    <input type="radio" id="saved-card-1" name="saved-card" class="custom-control-input">
                                                    <label class="custom-control-label" for="saved-card-1">XXXX - XXXX - XXXX - 7646</label>
                                                </div>
                                                <div class="custom-control custom-radio mb-3">
                                                    <input type="radio" id="saved-card-2" name="saved-card" class="custom-control-input">
                                                    <label class="custom-control-label" for="saved-card-2">XXXX - XXXX - XXXX - 9556</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-pay">
                                            <ul class="tabs-menu nav">
                                                <li class=""><a href="#tab20" class="active" data-bs-toggle="tab"><i class="fa fa-credit-card"></i> Agregar nueva tarjeta de crédito</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane border-0 active show" id="tab20">
                                                    <div class="form-group">
                                                        <label class="form-label" for="cardholder-name">Nombre del titular de la tarjeta</label>
                                                        <input type="text" class="form-control" id="cardholder-name" placeholder="Nombre">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label" for="card-number">Número de tarjeta</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="card-number" placeholder="Número de tarjeta" aria-label="Número de tarjeta" aria-describedby="button-addon2">
                                                            <button class="btn btn-primary" type="button" id="button-addon22">
                                                                <i class="fab fa-cc-visa"></i> &nbsp;
                                                                <i class="fab fa-cc-amex"></i> &nbsp;
                                                                <i class="fab fa-cc-mastercard"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <div class="form-group">
                                                                <label class="form-label" for="expiration-date">Fecha de expiración</label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" id="expiration-date" placeholder="MM/AA">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label class="form-label" for="cvv">CVV <i class="fa fa-question-circle"></i></label>
                                                                <input type="number" class="form-control" id="cvv" required="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-between">
                                        <button type="button" class="btn btn-light m-1" id="back-personal-trigger3">Anterior</button>
                                        <button type="button" class="btn btn-success m-1" id="continue-finished-tab">Siguiente</button>
                                    </div>
                                </div>                                <div class="tab-pane fade border-0 p-0" id="finished-tab-pane" role="tabpanel" aria-labelledby="finished-tab-pane" tabindex="0">
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

<script src="assets/js/core_js/check_out.js?{{ rand() }}"></script>

<!-- Handle-counter js -->
<script src="assets/js/handlecounter.js"></script>

<!-- Internal Checkout JS -->
<script src="assets/js/checkout.js"></script>
