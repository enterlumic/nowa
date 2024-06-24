<x-app-layout>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body checkout-tab">
                    <form action="#form_check_out" id="form_check_out" method="post">
                        <div id="smartwizardCheckOut">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-1">
                                        <div class="num">1</div>
                                        Agendar cita
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-2">
                                        <span class="num">2</span>
                                        Información del taller
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#step-3">
                                        <span class="num">3</span>
                                        Método de pago
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                
                                {{-- ========================== --}}
                                {{-- Inicio paso 1 Agendar cita --}}
                                <div id="step-1" class="tab-pane" role="tabpanel">
                                    <div>
                                        <h5 class="mb-1">Agendar cita</h5>
                                    </div>
                                    <div class="mt-4">
                                        <div class="row gy-3">
                                            <div class="col-md-6">
                                                <label for="appointmentDateTime" class="form-label">Seleccione una fecha</label>
                                                <div id="errorSeleccionarFecha"></div>
                                                <input type="date" id="appointmentDateTime" class="form-control d-none" name="appointmentDateTime" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="appointmentTimeGroup" class="form-label">Seleccione una hora</label>
                                                <div id="errorSeleccionarHorario"></div>
                                                <div id="appointmentTimeGroup" class="horarios">
                                                    <ul class="badge-type-selection__list">
                                                        <li class="badge-type-selection__list-item ui-list__item">
                                                            <div>
                                                                <label tabindex="0" class="ui-radio__label">
                                                                    <div class="ui-radio-element">
                                                                        <input type="radio" name="horario_dispobible[]" value="09-10" class="ui-radio__input d-none">
                                                                        <div class="ui-radio__background">
                                                                            <div class="ui-radio__outer-circle"></div>
                                                                            <div class="ui-radio__inner-circle"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ui-radio__text">
                                                                        <div class="badge-type__metadata">
                                                                            <span class="badge-type-selection__list-title"> 09:00 - 10:00 AM </span>
                                                                            <p class="badge-type-selection__list-text">
                                                                                <span>Lunes</span>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li class="badge-type-selection__list-item ui-list__item">
                                                            <div>
                                                                <label tabindex="0" class="ui-radio__label">
                                                                    <div class="ui-radio-element">
                                                                        <input type="radio" name="horario_dispobible[]" value="10-11" class="ui-radio__input d-none">
                                                                        <div class="ui-radio__background">
                                                                            <div class="ui-radio__outer-circle"></div>
                                                                            <div class="ui-radio__inner-circle"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="ui-radio__text">
                                                                        <div class="badge-type__metadata">
                                                                            <span class="badge-type-selection__list-title"> 10:00 - 11:00 AM </span>
                                                                            <p class="badge-type-selection__list-text">
                                                                                <span>Lunes</span>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-2" class="tab-pane" role="tabpanel">
                                    <div>
                                        <h5 class="mb-1">Informacion del taller</h5>
                                        <p class="text-muted mb-4">Te mostramos la dirección del taller</p>
                                    </div>
                                    <div class="mt-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="flex-grow-1">
                                                <h5 class="fs-14 mb-0">Dirección Guardada</h5>
                                            </div>
                                        </div>
                                        <div class="row gy-3">
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-check card-radio">
                                                    <input id="shippingAddress01" name="shippingAddress" type="radio" class="form-check-input" checked>
                                                    <label class="form-check-label" for="shippingAddress01">
                                                        <span class="mb-4 fw-semibold d-block text-muted text-uppercase">Dirección de Rac Automotriz</span>
                                                        <span class="fs-14 mb-2 d-block">Isaac Garza 2018</span>
                                                        <span class="text-muted fw-normal text-wrap mb-1 d-block">Obrera, 64010 Monterrey, N.L.</span>
                                                        <span class="text-muted fw-normal d-block">Tel. 81 8342 3649</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-3" class="tab-pane" role="tabpanel">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-grow-1">
                                            <h5>¿Como quires pagar?</h5>
                                        </div>
                                    </div>
                                    <div class="collapse show" id="paymentmethodCollapse">
                                        <div class="card p-4 border shadow-none mb-0 mt-4">
                                            <ul class="badge-type-selection__list">
                                                
                                                <div id="DivCustomerConekta"></div>

                                                <li class="add-card-new ui-list__item modal-effect" id="add_new_cliente_conekta" data-bs-effect="effect-slide-in-bottom" data-bs-toggle="modal" data-bs-target="#modalFormIUclienteConekta">
                                                    <div>
                                                        <label tabindex="0" class="ui-radio__label">
                                                            <div class="ui-radio__text">
                                                                <span class="ui-badge ui-badge--small">
                                                                    <img src="https://via.placeholder.com/30" alt="Nueva Tarjeta" width="30">
                                                                </span>
                                                                <div class="badge-type__metadata">
                                                                    <span class="badge-type-selection__list-title">
                                                                        Nueva Tarjeta
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
                                                <div id="errorSeleccionarMetodoPago"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="customer_id" id="customer_id">
                        <input type="hidden" name="card_id" id="card_id">
                        <input type="hidden" name="id_producto" id="id_producto">
                    </form>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        {{-- Agremos el detalle del producto que se selecciono --}}
        @include('extras.detalleProducto')
    </div>

    @include('modals.add_cliente_conekta')

</x-app-layout>

<!-- Include SmartWizard CSS -->
<link href="assets/css/smart_wizard_theme_arrows.min.css" rel="stylesheet" type="text/css" />

<!-- Include SmartWizard JS -->
<script src="assets/js/core_js/jquery.smartWizard.min.js"></script>

<!-- Handle-counter js -->
<script src="assets/js/handlecounter.js"></script>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="assets/css/checkout.css" rel="stylesheet" >

<link href="assets/css/smart_wizard.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/smart_wizard_theme_dots.min.css" rel="stylesheet" type="text/css" />


<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Flatpickr Locale ES -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<!-- Include Conekta -->
<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
<script src="assets/js/core_js/check_out.js?{{ rand() }}"></script>
<script src="assets/js/core_js/cliente_conekta.js?{{ rand() }}"></script>

@php
    function getCardLogoUrl($brand) {
        $logos = [
            'visa' => 'https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg',
            'mastercard' => 'https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg',
            'american express' => 'https://upload.wikimedia.org/wikipedia/commons/3/30/American_Express_logo.svg'
            // Agrega más marcas si es necesario
        ];

        return $logos[strtolower($brand)] ?? 'https://via.placeholder.com/30';
    }
@endphp
