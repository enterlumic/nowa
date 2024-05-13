<div class="modal fade" id="modalFormIUmarcas" tabindex="-1" aria-labelledby="add_new_marcasLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-material form-action-post" action="#form_marcas" id="form_marcas" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_marcasLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="Nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="Nombre" name="Nombre" placeholder="Escribe Nombre">
                        </div>
                        <div class="col-sm-12 d-none tipo-ya-existe">
                            <span class="badge bg-danger text-uppercase">Este registro ya existe</span>
                        </div>
                        <div class="col-sm-12">
                            <label for="Logo" class="form-label">Logo</label>
                            <input type="text" class="form-control" id="Logo" name="Logo" placeholder="Escribe Logo">
                        </div>
                        <div class="col-sm-12">
                            <label for="vCampo3_marcas" class="form-label">vTema3_marcas</label>
                            <input type="text" class="form-control" id="vCampo3_marcas" name="vCampo3_marcas" placeholder="Escribe vTema3_marcas">
                        </div>
                        <div class="col-12">
                            <label for="vCampo4_marcas" class="form-label">vTema4_marcas</label>
                            <input type="text" class="form-control" id="vCampo4_marcas" name="vCampo4_marcas" placeholder="Escribe vTema4_marcas">
                        </div>
                        <div class="col-12">
                            <label for="vCampo4_marcas" class="form-label">vTema5_marcas</label>
                            <input type="text" class="form-control" id="vCampo5_marcas" name="vCampo5_marcas" placeholder="Escribe vTema5_marcas">
                        </div>
                        <div class="col-12">
                            <label for="vCampo6_marcas" class="form-label">vTema6_marcas</label>
                            <input type="text" class="form-control" id="vCampo6_marcas" name="vCampo6_marcas" placeholder="Escribe vTema6_marcas">
                        </div>
                        <div class="col-12">
                            <label for="vCampo7_marcas" class="form-label">vTema7_marcas</label>
                            <input type="text" class="form-control" id="vCampo7_marcas" name="vCampo7_marcas" placeholder="Escribe vTema7_marcas">
                        </div>
                        <div class="col-md-4">
                            <label for="vCampo8_marcas" class="form-label">vTema8_marcas</label>
                            <select class="form-select" id="vCampo8_marcas" name="vCampo8_marcas">
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="vCampo9_marcas" class="form-label">vTema9_marcas</label>
                            <input type="text" class="form-control" id="vCampo9_marcas" name="vCampo9_marcas" placeholder="Escribe vCampo9_marcas">
                        </div>
                        <div class="col-md-3">
                            <label for="vCampo10_marcas" class="form-label">vTema10_marcas</label>
                            <input type="text" class="form-control" id="vCampo10_marcas" name="vCampo10_marcas" placeholder="Escribe vCampo10_marcas">
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
<!-- /.modalFormIUmarcas -->