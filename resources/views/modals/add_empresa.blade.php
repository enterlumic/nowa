@php
    // Esta funcion no se ocupa solo lo ocupo como atajo
    // en sublime con F12 puedes llegar a esta vista

    function add_empresa(){}
@endphp

<div class="modal fade" id="modalFormIUempresa" tabindex="-1" aria-labelledby="add_new_empresaLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-material form-action-post" action="#form_empresa" id="form_empresa" method="post">
                <div class="modal-header mb-20">
                    <h5 class="modal-title">Agregar Empresa - Información</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="smartwizardEmpresa">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#step-1">
                                <div class="num">1</div>
                                Información de la Empresa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#step-2">
                                <div class="num">2</div>
                                Ubicación
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- Paso 1: Información de la Empresa -->
                        <div id="step-1" class="tab-pane" role="tabpanel">
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                        <label for="logo" class="form-label">logo</label>
                                        <div id="fileUploaderContainer">
                                            <input type="file" name="logoUpload" class="d-none logoUpload" id="logoUpload" data-fileuploader-default="https://innostudio.de/fileuploader/images/default-avatar.png" data-fileuploader-files=''>
                                        </div>
                                    </div>
                                    <input type="hidden" id="logoEmpresa">
                                    <div class="col-sm-12 d-none tipo-ya-existe">
                                        <span class="badge bg-danger text-uppercase">Este registro ya existe</span>
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe Nombre">
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="descripcion" class="form-label">Descripción</label>
                                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Escribe Descripción">
                                    </div>
                                    <div class="col-12">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Escribe Teléfono">
                                    </div>
                                    <div class="col-12">
                                        <label for="whatsapp" class="form-label">Whatsapp</label>
                                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="Escribe Whatsapp">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Paso 2: Ubicación -->
                        <div id="step-2" class="tab-pane" role="tabpanel">
                            <div class="modal-header">
                                <h5 class="modal-title">Agregar Empresa - Ubicación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="Ubicacion" class="form-label">Ubicación</label>
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input id="target" name="target" class="form-control inputs" type="text">
                                            </div>
                                        </div>
                                        <input type="hidden" name="longitude" id="longitude">
                                        <input type="hidden" name="latitude" id="latitude">
                                        <div class="location-map" id="location-map">
                                            <div style="width: 600px; height: 400px;" id="map_canvas"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modalFormIUempresa -->

<!-- Include SmartWizard CSS -->
<link href="assets/css/smart_wizard_theme_arrows.min.css" rel="stylesheet" type="text/css" />

<style type="text/css">
            .fileuploader {
                width: 160px;
                height: 160px;
                margin: 15px;
            }    

</style>
<!-- Include SmartWizard JS -->
<script src="assets/js/core_js/jquery.smartWizard.min.js"></script>

