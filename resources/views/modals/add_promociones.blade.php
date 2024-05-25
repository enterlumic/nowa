@php
    // Esta funcion no se ocupa solo lo ocupo como atajo
    // en sublime con F12 puedes llegar a esta vista

    function add_promociones(){}
@endphp

<div class="modal fade" id="modalFormIUpromociones" tabindex="-1" aria-labelledby="add_new_promocionesLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-material form-action-post" action="#form_promociones" id="form_promociones" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_promocionesLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="vCampo1_promociones" class="form-label">vTema1_promociones</label>
                            <input type="text" class="form-control" id="vCampo1_promociones" name="vCampo1_promociones" placeholder="Escribe vTema1_promociones">
                        </div>
                        <div class="col-sm-12 d-none tipo-ya-existe">
                            <span class="badge bg-danger text-uppercase">Este registro ya existe</span>
                        </div>
                        <div class="col-sm-12">
                            <label for="vCampo2_promociones" class="form-label">vTema2_promociones</label>
                            <input type="text" class="form-control" id="vCampo2_promociones" name="vCampo2_promociones" placeholder="Escribe vTema2_promociones">
                        </div>
                        <div class="col-sm-12">
                            <label for="vCampo3_promociones" class="form-label">vTema3_promociones</label>
                            <input type="text" class="form-control" id="vCampo3_promociones" name="vCampo3_promociones" placeholder="Escribe vTema3_promociones">
                        </div>
                        <div class="col-12">
                            <label for="vCampo4_promociones" class="form-label">vTema4_promociones</label>
                            <input type="text" class="form-control" id="vCampo4_promociones" name="vCampo4_promociones" placeholder="Escribe vTema4_promociones">
                        </div>
                        <div class="col-12">
                            <label for="vCampo4_promociones" class="form-label">vTema5_promociones</label>
                            <input type="text" class="form-control" id="vCampo5_promociones" name="vCampo5_promociones" placeholder="Escribe vTema5_promociones">
                        </div>
                        <div class="col-12">
                            <label for="vCampo6_promociones" class="form-label">vTema6_promociones</label>
                            <input type="text" class="form-control" id="vCampo6_promociones" name="vCampo6_promociones" placeholder="Escribe vTema6_promociones">
                        </div>
                        <div class="col-12">
                            <label for="vCampo7_promociones" class="form-label">vTema7_promociones</label>
                            <input type="text" class="form-control" id="vCampo7_promociones" name="vCampo7_promociones" placeholder="Escribe vTema7_promociones">
                        </div>
                        <div class="col-md-4">
                            <label for="vCampo8_promociones" class="form-label">vTema8_promociones</label>
                            <select class="form-select" id="vCampo8_promociones" name="vCampo8_promociones">
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="vCampo9_promociones" class="form-label">vTema9_promociones</label>
                            <input type="text" class="form-control" id="vCampo9_promociones" name="vCampo9_promociones" placeholder="Escribe vCampo9_promociones">
                        </div>
                        <div class="col-md-3">
                            <label for="vCampo10_promociones" class="form-label">vTema10_promociones</label>
                            <input type="text" class="form-control" id="vCampo10_promociones" name="vCampo10_promociones" placeholder="Escribe vCampo10_promociones">
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
<!-- /.modalFormIUpromociones -->