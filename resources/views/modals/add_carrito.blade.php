@php
    // Esta funcion no se ocupa solo lo ocupo como atajo
    // en sublime con F12 puedes llegar a esta vista

    function add_carrito(){}
@endphp

<div class="modal fade" id="modalFormIUcarrito" tabindex="-1" aria-labelledby="add_new_carritoLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-material form-action-post" action="#form_carrito" id="form_carrito" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_carritoLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="user_id" class="form-label">User_Id</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" placeholder="Escribe User_Id">
                        </div>
                        <div class="col-sm-12 d-none tipo-ya-existe">
                            <span class="badge bg-danger text-uppercase">Este registro ya existe</span>
                        </div>
                        <div class="col-sm-12">
                            <label for="producto_id" class="form-label">Producto_Id</label>
                            <input type="text" class="form-control" id="producto_id" name="producto_id" placeholder="Escribe Producto_Id">
                        </div>
                        <div class="col-sm-12">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Escribe Cantidad">
                        </div>
                        <div class="col-12">
                            <label for="agregado_en" class="form-label">Agregado_En</label>
                            <input type="text" class="form-control" id="agregado_en" name="agregado_en" placeholder="Escribe Agregado_En">
                        </div>
                        <div class="col-12">
                            <label for="agregado_en" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="estado" name="estado" placeholder="Escribe Estado">
                        </div>
                        <div class="col-12">
                            <label for="vCampo6_carrito" class="form-label">vTema6_carrito</label>
                            <input type="text" class="form-control" id="vCampo6_carrito" name="vCampo6_carrito" placeholder="Escribe vTema6_carrito">
                        </div>
                        <div class="col-12">
                            <label for="vCampo7_carrito" class="form-label">vTema7_carrito</label>
                            <input type="text" class="form-control" id="vCampo7_carrito" name="vCampo7_carrito" placeholder="Escribe vTema7_carrito">
                        </div>
                        <div class="col-md-4">
                            <label for="vCampo8_carrito" class="form-label">vTema8_carrito</label>
                            <select class="form-select" id="vCampo8_carrito" name="vCampo8_carrito">
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="vCampo9_carrito" class="form-label">vTema9_carrito</label>
                            <input type="text" class="form-control" id="vCampo9_carrito" name="vCampo9_carrito" placeholder="Escribe vCampo9_carrito">
                        </div>
                        <div class="col-md-3">
                            <label for="vCampo10_carrito" class="form-label">vTema10_carrito</label>
                            <input type="text" class="form-control" id="vCampo10_carrito" name="vCampo10_carrito" placeholder="Escribe vCampo10_carrito">
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
<!-- /.modalFormIUcarrito -->