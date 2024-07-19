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
                                        <h5 class="mb-1">Seleccione una fecha disponible</h5>
                                    </div>
                                    <div class="mt-4">
                                        <div class="row gy-3">
                                            <div id="agendar_cita_automotriz"></div>
                                            <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> <br /> 
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

    <!-- OffCanvas para Detalles del Evento -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEvento" aria-labelledby="offcanvasEventoLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasEventoLabel">Seleccione un horario disponible</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p id="eventDetails">Estos son los horarios disponibles...</p>

            <form id="agendarCitaForm">
                <div class="mb-3">
                    <label for="hora" class="form-label">Hora</label>
                    <div class="list-group" id="hora-list">
                        <label class="list-group-item">
                            <input class="form-check-input me-1" type="radio" name="hora" value="08:00" required> 08:00 AM - 10:00 AM
                        </label>
                        <label class="list-group-item bg-danger text-white">
                            <input class="form-check-input me-1" type="radio" name="hora" value="10:00" disabled> 10:00 AM - 12:00 PM (Ocupado)
                        </label>
                        <label class="list-group-item">
                            <input class="form-check-input me-1" type="radio" name="hora" value="12:00" required> 12:00 PM - 02:00 PM
                        </label>
                        <label class="list-group-item">
                            <input class="form-check-input me-1" type="radio" name="hora" value="14:00" required> 02:00 PM - 04:00 PM
                        </label>
                        <label class="list-group-item bg-danger text-white">
                            <input class="form-check-input me-1" type="radio" name="hora" value="16:00" disabled> 04:00 PM - 06:00 PM (Ocupado)
                        </label>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" id="submitCitaForm" data-bs-dismiss="offcanvas" aria-label="Close">Seleccionar Hora</button>
            </form>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmationModalLabel">Confirmación</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- El mensaje se actualizará dinámicamente -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
          </div>
        </div>
      </div>
    </div>


</x-app-layout>

<!-- Full Calendar CSS -->
<link rel="stylesheet" href="../assets/libs/fullcalendar/main.min.css">

<!-- Moment JS -->
<script src="assets/libs/moment/moment.js"></script>

<!-- Fullcalendar JS -->
<script src="assets/libs/fullcalendar/main.min.js"></script>

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

<style type="text/css">
    .fc {
        font-size: 12px; /* Reducir el tamaño de la fuente */
    }

    .fc-toolbar-title {
        font-size: 16px; /* Reducir el tamaño de la fuente del título */
    }

    .fc-daygrid-day-number {
        padding: 0.2em; /* Reducir el relleno de los números de los días */
    }

    .fc-daygrid-event {
        margin: 1px; /* Reducir el margen de los eventos */
    }
        
    .fc-event.Lleno {
        background-color: red !important;
        color: white !important;
        border-color: red !important;
        opacity: 0.7;
    }

</style>
