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
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Escribe Nombre">
                        </div>
                        <div class="col-sm-12 d-none tipo-ya-existe">
                            <span class="badge bg-danger text-uppercase">Este registro ya existe</span>
                        </div>
                        <div class="col-sm-12">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Escribe Descripcion">
                        </div>
                        <div class="col-sm-12">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Escribe Telefono">
                        </div>
                        <div class="col-12">
                            <label for="whatsapp" class="form-label">Whatsapp</label>
                            <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="Escribe Whatsapp">
                        </div>
                        <div class="col-12">
                            <label for="whatsapp" class="form-label">Ubicacion</label>
                            
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input id="target" name="target" class="form-control inputs" type="text" >
                                </div>
                            </div>

                            <input type="text" name="longitude" id="longitude">
                            <input type="text" name="latitude" id="latitude">
                            <div class="location-map" id="location-map">
                                <div style="width: 600px; height: 400px;" id="map_canvas"></div>
                            </div>
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