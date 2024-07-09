@php
    // Esta función no se ocupa solo lo uso como atajo
    // en sublime con F12 puedes llegar a esta vista
    function add_productos(){}
@endphp
<link rel="stylesheet" href="assets/libs/quill/quill.snow.css">
<link rel="stylesheet" href="assets/libs/quill/quill.bubble.css">

<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalFormIUproductos" tabindex="-1" aria-labelledby="add_new_productosLabel">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <form class="form-material form-action-post" action="#form_productos" id="form_productos" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_productosLabel">Agregar Nueva Promoción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Escribe el título">
                        </div>
                        <div class="col-sm-12">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Escribe la descripción"></textarea>
{{--                             <div id="editor">
                                <h4><b class="ql-size-large">Quill Snow</b> is a free, open source <a href="https://github.com/quilljs/quill/" target="_blank">Quill Editor</a> built for the modern web. With its <a href="https://quilljs.com/docs/modules/" target="_blank">modular architecture</a> and expressive API, it is completely customizable to fit any need.</h4>
                                <p><br></p>
                                <ol>
                                    <li class="ql-size-normal">Write text select and edit with multiple options.</li>
                                    <li class="">This is quill snow editor.</li>
                                    <li class="">Easy to customize and flexible.</li>
                                </ol>
                                <p><br></p>
                                <h4>Quill officially supports a standard toolbar theme <a href="https://github.com/quilljs/quill/" target="_blank">"Snow"</a> and a floating tooltip theme <a href="https://github.com/quilljs/quill/" target="_blank">"Bubble"</a></h4>
                            </div>  --}}                           
                        </div>
                        <div class="col-sm-12 d-none tipo-ya-existe">
                            <span class="badge bg-danger text-uppercase">Este registro ya existe</span>
                        </div>
                        <div class="col-md-4">
                            <label for="precio_anterior" class="form-label">Precio Refacción</label>
                            <input type="text" class="form-control" id="precio_anterior" name="precio_anterior" placeholder="Precio de las refacciones">
                        </div>
                        <div class="col-4">
                            <label for="precio" class="form-label">Precio Mano de Obra</label>
                            <input type="text" class="form-control" id="precio" name="precio" placeholder="Precio a cobrar?">
                        </div>
                        <div class="col-4">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Escribe la cantidad">
                        </div>
                        <div class="col-6">
                            <label for="marca" class="form-label">Marca</label>
                            <input type="text" class="form-control" id="marca" name="marca" placeholder="Escribe la marca">
                        </div>
                        <div class="col-6">
                            <label for="tiempo_trabajador" class="form-label">Tiempo necesario para terminar el trabajo</label>
                            <input type="text" class="form-control" id="tiempo_trabajador" name="tiempo_trabajador" placeholder="Escribe el tiempo estimado">
                        </div>
                        <div class="col-sm-12">
                            <label for="fotos" class="form-label">Fotos</label>
                            <textarea class="form-control d-none" id="fotos" name="fotos" placeholder="Escribe cada URL de foto en una nueva línea"></textarea>
                            <div id="fileUploaderContainer">
                                <input type="file" name="fotosUpload" id="fotosUpload">
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
<!-- /.modalFormIUproductos -->
