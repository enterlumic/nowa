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
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe Nombre">
                        </div>
                        <div class="col-sm-12 d-none tipo-ya-existe">
                            <span class="badge bg-danger text-uppercase">Este registro ya existe</span>
                        </div>
                        <div class="col-sm-12">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="text" class="form-control" id="logo" name="logo" placeholder="Escribe Logo">
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