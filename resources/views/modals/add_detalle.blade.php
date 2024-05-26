@php
    // Esta funcion no se ocupa solo lo ocupo como atajo
    // en sublime con F12 puedes llegar a esta vista

    function add_detalle(){}
@endphp

<div class="modal fade" id="modalFormIUdetalle" tabindex="-1" aria-labelledby="add_new_detalleLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-material form-action-post" action="#form_detalle" id="form_detalle" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_detalleLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="vCampo1_detalle" class="form-label">vTema1_detalle</label>
                            <input type="text" class="form-control" id="vCampo1_detalle" name="vCampo1_detalle" placeholder="Escribe vTema1_detalle">
                        </div>
                        <div class="col-sm-12 d-none tipo-ya-existe">
                            <span class="badge bg-danger text-uppercase">Este registro ya existe</span>
                        </div>
                        <div class="col-sm-12">
                            <label for="vCampo2_detalle" class="form-label">vTema2_detalle</label>
                            <input type="text" class="form-control" id="vCampo2_detalle" name="vCampo2_detalle" placeholder="Escribe vTema2_detalle">
                        </div>
                        <div class="col-sm-12">
                            <label for="vCampo3_detalle" class="form-label">vTema3_detalle</label>
                            <input type="text" class="form-control" id="vCampo3_detalle" name="vCampo3_detalle" placeholder="Escribe vTema3_detalle">
                        </div>
                        <div class="col-12">
                            <label for="vCampo4_detalle" class="form-label">vTema4_detalle</label>
                            <input type="text" class="form-control" id="vCampo4_detalle" name="vCampo4_detalle" placeholder="Escribe vTema4_detalle">
                        </div>
                        <div class="col-12">
                            <label for="vCampo4_detalle" class="form-label">vTema5_detalle</label>
                            <input type="text" class="form-control" id="vCampo5_detalle" name="vCampo5_detalle" placeholder="Escribe vTema5_detalle">
                        </div>
                        <div class="col-12">
                            <label for="vCampo6_detalle" class="form-label">vTema6_detalle</label>
                            <input type="text" class="form-control" id="vCampo6_detalle" name="vCampo6_detalle" placeholder="Escribe vTema6_detalle">
                        </div>
                        <div class="col-12">
                            <label for="vCampo7_detalle" class="form-label">vTema7_detalle</label>
                            <input type="text" class="form-control" id="vCampo7_detalle" name="vCampo7_detalle" placeholder="Escribe vTema7_detalle">
                        </div>
                        <div class="col-md-4">
                            <label for="vCampo8_detalle" class="form-label">vTema8_detalle</label>
                            <select class="form-select" id="vCampo8_detalle" name="vCampo8_detalle">
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="vCampo9_detalle" class="form-label">vTema9_detalle</label>
                            <input type="text" class="form-control" id="vCampo9_detalle" name="vCampo9_detalle" placeholder="Escribe vCampo9_detalle">
                        </div>
                        <div class="col-md-3">
                            <label for="vCampo10_detalle" class="form-label">vTema10_detalle</label>
                            <input type="text" class="form-control" id="vCampo10_detalle" name="vCampo10_detalle" placeholder="Escribe vCampo10_detalle">
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
<!-- /.modalFormIUdetalle -->