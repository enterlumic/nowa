@php
    // Esta funcion no se ocupa solo lo ocupo como atajo
    // en sublime con F12 puedes llegar a esta vista

    function import_detalle(){}
@endphp

<div id="modalImportFormdetalle" class="modal fade" tabindex="-1" aria-labelledby="modalImportFormdetalleLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImportFormdetalleLabel">Cargar datos</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab-importar-excel" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Cargar archivo de Excel</span> 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-copiar-pegar" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Copiar y pegar</span> 
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content p-3">
                    <div class="tab-pane active" id="tab-importar-excel" role="tabpanel">
                        <div class="live-preview row">
                           <a href="descargar_plantilla_detalle" class="btn btn-soft-success">
                                <i class="typcn typcn-download"></i> 
                                Descargar plantilla
                            </a>
                        </div>
                        <form action="form_importar_detalle" id="FormImportardetalle" name="FormImportardetalle" >
                            <input type="file" accept=".xlsx, .ods" name="files" data-fileuploader-limit="1" data-fileuploader-extensions="xlsx, ods">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary btn-action-form">Importar</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab-copiar-pegar" role="tabpanel">
                        <form action="#form_import_detalle" id="form_import_detalle" method="post" class="form-material form-action-post justify-content-center" >
                            <div class="modal-body">
                                <textarea class="form-control" id="vc_importar" name="vc_importar" rows="10" placeholder="Registro por cada salto de linea"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light close" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary btn-action-form">Importar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modalImportFormdetalle -->