@php
    // Esta funcion no se ocupa solo lo ocupo como atajo
    // en sublime con F12 puedes llegar a esta vista

    function add_sandbox_types(){}
@endphp

<div class="modal fade" id="modalFormIUsandboxTypes" tabindex="-1" aria-labelledby="add_new_sandbox_typesLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-material form-action-post" action="#form_sandbox_types" id="form_sandbox_types" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_sandbox_typesLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Escribe Name">
                        </div>
                        <div class="col-sm-12 d-none tipo-ya-existe">
                            <span class="badge bg-danger text-uppercase">Este registro ya existe</span>
                        </div>
                        <div class="col-sm-12">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Escribe Description">
                        </div>
                        <div class="col-sm-12">
                            <label for="is_sandbox" class="form-label">Is_Sandbox</label>
                            <input type="text" class="form-control" id="is_sandbox" name="is_sandbox" placeholder="Escribe Is_Sandbox">
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
<!-- /.modalFormIUsandboxTypes -->