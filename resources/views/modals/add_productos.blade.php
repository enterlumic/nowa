@php
    // Esta función no se ocupa solo lo uso como atajo
    // en sublime con F12 puedes llegar a esta vista
    function add_productos(){}
@endphp
<link rel="stylesheet" href="assets/libs/quill/quill.snow.css">
<link rel="stylesheet" href="assets/libs/quill/quill.bubble.css">

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalFormIUproductos" tabindex="-1"
    aria-labelledby="exampleModalScrollable" data-bs-keyboard="false"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl modal-dialog-scrollable...">
        <div class="modal-content">
            <form class="form-material form-action-post" action="#form_productos" id="form_productos" method="post">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel1">Modal title
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                    <div class="modal-body">


                        <div class="row">
                            <div class="col-xxl-6">
                                <div class="card custom-card">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">
                                            Datos del producto
                                        </div>
                                        <div class="prism-toggle">
                                            <button class="btn btn-sm btn-primary-light">Show Code<i class="ri-code-line ms-2 d-inline-block align-middle"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="titulo" class="form-label">Título</label>
                                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Escribe el título">                                                
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="descripcion" class="form-label">Descripción</label>
                                                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Escribe la descripción" rows="5" cols="50"></textarea>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Precio de Refacción</label>
                                                <div class="row">
                                                    <div class="col-xl-12 mb-3">
                                                        <input type="text" class="form-control" id="precio_anterior" name="precio_anterior" placeholder="Precio de las refacciones">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="row">
                                                    <div class="col-xl-12 mb-3">
                                                        <label class="form-label">Precio Mano de Obra</label>
                                                        <input type="text" class="form-control" id="precio" name="precio" placeholder="Precio a cobrar?">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="titulo" class="form-label">Tiempo necesario para terminar el trabajo</label>
                                                <input type="text" class="form-control" id="tiempo_trabajador" name="tiempo_trabajador" placeholder="Escribe el tiempo estimado">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-6">
                                <div class="card custom-card">
                                    <div class="card-header justify-content-between">
                                        <div class="card-title">
                                            Multimedia
                                        </div>
                                        <div class="prism-toggle">
                                            <button class="btn btn-sm btn-primary-light">Show Code<i class="ri-code-line ms-2 d-inline-block align-middle"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <label class="form-label">Fotos</label>
                                            <textarea class="form-control d-none" id="fotos" name="fotos" placeholder="Escribe cada URL de foto en una nueva línea"></textarea>
                                            <div id="fileUploaderContainer">
                                                <input type="file" name="fotosUpload" id="fotosUpload">
                                            </div>
                                        </div>                                            
                                    </div>
                                    <div class="card-footer d-none border-top-0">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-action-form">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.modalFormIUproductos -->


    <style>
        .modal-body {
            display: flex;
            flex-wrap: wrap;
        }
        .modal-body .form-group {
            flex: 1 1 100%; /* Hace que cada form-group ocupe todo el ancho del contenedor */
        }
        .modal-body .form-group.half-width {
            flex: 1 1 48%; /* Hace que cada form-group ocupe la mitad del ancho del contenedor */
            margin-right: 4%;
        }
        .modal-body .form-group.half-width:last-child {
            margin-right: 0;
        }
        #descripcion {
            height: 100px; /* Ajusta la altura según tus necesidades */
        }
        .image-thumbnail {
            margin-right: 10px;
            margin-bottom: 10px;
        }
    </style>
