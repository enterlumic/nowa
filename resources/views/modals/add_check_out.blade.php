@php
    // Esta funcion no se ocupa solo lo ocupo como atajo
    // en sublime con F12 puedes llegar a esta vista

    function add_check_out(){}
@endphp

<div class="modal fade" id="modalFormIUcheckOut" tabindex="-1" aria-labelledby="add_new_check_outLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-material form-action-post" action="#form_check_out" id="form_check_out" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_check_outLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="vCampo1_check_out" class="form-label">vTema1_check_out</label>
                            <input type="text" class="form-control" id="vCampo1_check_out" name="vCampo1_check_out" placeholder="Escribe vTema1_check_out">
                        </div>
                        <div class="col-sm-12 d-none tipo-ya-existe">
                            <span class="badge bg-danger text-uppercase">Este registro ya existe</span>
                        </div>
                        <div class="col-sm-12">
                            <label for="vCampo2_check_out" class="form-label">vTema2_check_out</label>
                            <input type="text" class="form-control" id="vCampo2_check_out" name="vCampo2_check_out" placeholder="Escribe vTema2_check_out">
                        </div>
                        <div class="col-sm-12">
                            <label for="vCampo3_check_out" class="form-label">vTema3_check_out</label>
                            <input type="text" class="form-control" id="vCampo3_check_out" name="vCampo3_check_out" placeholder="Escribe vTema3_check_out">
                        </div>
                        <div class="col-12">
                            <label for="vCampo4_check_out" class="form-label">vTema4_check_out</label>
                            <input type="text" class="form-control" id="vCampo4_check_out" name="vCampo4_check_out" placeholder="Escribe vTema4_check_out">
                        </div>
                        <div class="col-12">
                            <label for="vCampo4_check_out" class="form-label">vTema5_check_out</label>
                            <input type="text" class="form-control" id="vCampo5_check_out" name="vCampo5_check_out" placeholder="Escribe vTema5_check_out">
                        </div>
                        <div class="col-12">
                            <label for="vCampo6_check_out" class="form-label">vTema6_check_out</label>
                            <input type="text" class="form-control" id="vCampo6_check_out" name="vCampo6_check_out" placeholder="Escribe vTema6_check_out">
                        </div>
                        <div class="col-12">
                            <label for="vCampo7_check_out" class="form-label">vTema7_check_out</label>
                            <input type="text" class="form-control" id="vCampo7_check_out" name="vCampo7_check_out" placeholder="Escribe vTema7_check_out">
                        </div>
                        <div class="col-md-4">
                            <label for="vCampo8_check_out" class="form-label">vTema8_check_out</label>
                            <select class="form-select" id="vCampo8_check_out" name="vCampo8_check_out">
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="vCampo9_check_out" class="form-label">vTema9_check_out</label>
                            <input type="text" class="form-control" id="vCampo9_check_out" name="vCampo9_check_out" placeholder="Escribe vCampo9_check_out">
                        </div>
                        <div class="col-md-3">
                            <label for="vCampo10_check_out" class="form-label">vTema10_check_out</label>
                            <input type="text" class="form-control" id="vCampo10_check_out" name="vCampo10_check_out" placeholder="Escribe vCampo10_check_out">
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
<!-- /.modalFormIUcheckOut -->