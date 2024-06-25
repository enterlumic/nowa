@php
    // Esta funcion no se ocupa solo lo ocupo como atajo
    // en sublime con F12 puedes llegar a esta vista

    function add_empresa(){}
@endphp

<div class="modal fade" id="modalFormIUempresa" tabindex="-1" aria-labelledby="add_new_empresaLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-material form-action-post" action="#form_empresa" id="form_empresa" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_empresaLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="text" class="form-control" id="logo" name="logo" placeholder="Escribe Logo">
                        </div>
                        <div class="col-sm-12 d-none tipo-ya-existe">
                            <span class="badge bg-danger text-uppercase">Este registro ya existe</span>
                        </div>
                        <div class="col-sm-12">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe Nombre">
                        </div>
                        <div class="col-sm-12">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Escribe Descripcion">
                        </div>
                        <div class="col-12">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Escribe Telefono">
                        </div>
                        <div class="col-12">
                            <label for="telefono" class="form-label">Whatsapp</label>
                            <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="Escribe Whatsapp">
                        </div>
                        <div class="col-12">
                            <label for="ubicacion" class="form-label">Ubicacion</label>
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Escribe Ubicacion">
                        </div>
                        <div class="col-12">
                            <label for="longitud" class="form-label">Longitud</label>
                            <input type="text" class="form-control" id="longitud" name="longitud" placeholder="Escribe Longitud">
                        </div>
                        <div class="col-md-4">
                            <label for="latitud" class="form-label">Latitud</label>
                            <select class="form-select" id="latitud" name="latitud">
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="vCampo9_empresa" class="form-label">vTema9_empresa</label>
                            <input type="text" class="form-control" id="vCampo9_empresa" name="vCampo9_empresa" placeholder="Escribe vCampo9_empresa">
                        </div>
                        <div class="col-md-3">
                            <label for="vCampo10_empresa" class="form-label">vTema10_empresa</label>
                            <input type="text" class="form-control" id="vCampo10_empresa" name="vCampo10_empresa" placeholder="Escribe vCampo10_empresa">
                        </div>
                    </div>
                </div>
                <div class="modal-footer m-t-10">
                    <div class="col-lg-12">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary btn-action-form">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modalFormIUempresa -->