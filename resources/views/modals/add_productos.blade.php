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
    <div class="modal-dialog modal-dialog modal-xl">
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
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">$</span>
                                                        <input type="text" class="form-control number-format" id="precio_refaccion" name="precio_refaccion" placeholder="1,000">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Precio a cobrar</label>
                                                <div class="row">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text">$</span>
                                                        <input type="text" class="form-control number-format2" id="precio" name="precio" placeholder="1,000">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">

                                                <label for="tiempo_trabajador" class="form-label">Duración Estimada (horas)</label>

                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                                    <select class="form-select" id="tiempo_trabajador" name="tiempo_trabajador">
                                                        <option selected value="">Selecciona...</option>
                                                        <option value="1 hora">1 hora</option>
                                                        <option value="2 horas">2 horas</option>
                                                        <option value="3 horas">3 horas</option>
                                                        <option value="4 horas">4 horas</option>
                                                        <option value="5 horas">5 horas</option>
                                                        <option value="6 horas">6 horas</option>
                                                        <option value="7 horas">7 horas</option>
                                                        <option value="8 horas">8 horas (1 día)</option>
                                                        <!-- Continuar añadiendo opciones hasta 16 horas -->
                                                        <option value="16 horas (2 días)">16 horas (2 días)</option>
                                                        <!-- Continuar añadiendo opciones hasta 24 horas -->
                                                        <option value="24 24 horas (3 días)">24 horas (3 días)</option>
                                                        <!-- Continuar añadiendo opciones hasta 32 horas -->
                                                        <option value="32 horas (4 días)">32 horas (4 días)</option>
                                                        <!-- Continuar añadiendo opciones hasta 40 horas -->
                                                        <option value="40 horas (5 días)">40 horas (5 días)</option>
                                                        <!-- Finalmente, agregar opción para 48 horas -->
                                                        <option value="48 horas (6 días)">48 horas (6 días)</option>
                                                    </select>
                                                </div>
                                                <span id="error-hora"></span>
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
                                    </div>
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <label class="form-label">Fotos</label>
                                            <div id="fileUploaderContainer">
                                                <input type="file" name="fotosUpload" id="fotosUpload">
                                            </div>

                                            <br/>
                                            <br/>
                                            <br/>
                                            <br/>
                                            <br/>
                                            <br/>
                                            <br/>
                                            <br/>
                                            <br/>
                                            <br/>

                                        </div>                                            
                                    </div>
                                    <div class="card-footer d-none border-top-0">

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-info btn-action-form" id="submit-set-product">Guardar</button>
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

        #tiempo_trabajador option[value="8"],
        #tiempo_trabajador option[value="16"],
        #tiempo_trabajador option[value="24"],
        #tiempo_trabajador option[value="32"],
        #tiempo_trabajador option[value="40"],
        #tiempo_trabajador option[value="48"] {
            font-weight: bold;
            color: #007bff; /* Color azul de Bootstrap para destacar */
        }        
    </style>

<script type="text/javascript">
    
    var n1 = new Cleave('#precio_refaccion', {
        numeral: true,
        numeralThousandsGroupStyle: 'lakh'
    });
    var n1 = new Cleave('#precio', {
        numeral: true,
        numeralThousandsGroupStyle: 'lakh'
    });

    // Enfocar el campo de título
    Mousetrap.bind('alt+t', function() {
        document.getElementById('titulo').focus();
        return false;
    });

    // Enfocar el campo de descripción
    Mousetrap.bind('alt+d', function() {
        document.getElementById('descripcion').focus();
        return false;
    });

    // Enfocar el campo de descripción
    Mousetrap.bind('alt+p', function() {
        document.getElementById('precio').focus();
        return false;
    });

    // Guardar el formulario con Control + s
    Mousetrap.bind('ctrl+s', function(e) {
        e.preventDefault(); // Prevenir la acción predeterminada de guardar la página
        document.getElementById('submit-set-product').click();
    });

    // Cerrar el formulario con Esc
    Mousetrap.bind('esc', function() {
        $('#modalFormIUproductos').modal('hide'); // Asumiendo que estás usando Bootstrap Modal
    });
</script>

