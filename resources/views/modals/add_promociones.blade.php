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
                            <label for="fotos" class="form-label">Fotos</label>
                            <input type="text" class="form-control" id="fotos" name="fotos" placeholder="Escribe Fotos">
                        </div>
                        <div class="col-sm-12 d-none tipo-ya-existe">
                            <span class="badge bg-danger text-uppercase">Este registro ya existe</span>
                        </div>
                        <div class="col-sm-12">
                            <label for="titulo" class="form-label">Titulo</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Escribe Titulo">
                        </div>
                        <div class="col-sm-12">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Escribe Descripcion">
                        </div>
                        <div class="col-12">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="text" class="form-control" id="precio" name="precio" placeholder="Escribe Precio">
                        </div>
                        <div class="col-12">
                            <label for="precio" class="form-label">Marca</label>
                            <input type="text" class="form-control" id="marca" name="marca" placeholder="Escribe Marca">
                        </div>
                        <div class="col-12">
                            <label for="review" class="form-label">Review</label>
                            <input type="text" class="form-control" id="review" name="review" placeholder="Escribe Review">
                        </div>
                        <div class="col-12">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Escribe Cantidad">
                        </div>
                        <div class="col-md-4">
                            <label for="color" class="form-label">Color</label>
                            <select class="form-select" id="color" name="color">
                                <option value="">Seleccione...</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="precio_anterior" class="form-label">Precio_Anterior</label>
                            <input type="text" class="form-control" id="precio_anterior" name="precio_anterior" placeholder="Escribe precio_anterior">
                        </div>
                        <div class="col-md-3">
                            <label for="target" class="form-label">Target</label>
                            <input type="text" class="form-control" id="target" name="target" placeholder="Escribe target">
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