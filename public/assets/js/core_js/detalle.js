let detalle = {

    init: function () {

        // Funciones principales
        detalle.fn_set_detalle();
        detalle.fn_get_by_id();
        detalle.fn_datatable_detalle(rango_fecha='');
        detalle.fn_scroll_detalle();
        detalle.fn_importar_excel_detalle();

        // Funciones para eventos
        detalle.fn_modalHidedetalle();
        detalle.fn_AgregarNuevodetalle();
        detalle.fn_actualizarTabladetalle();
        detalle.fn_Catdetalle();
        detalle.fn_set_validar_existencia_detalle();

        // Funciones principales que se encuentran en controlador >> detalleController
        // ===============================================================

        // Store procedure
        // sp_get_detalle
        // sp_set_detalle
        // sp_get_by_id_detalle

        // Llenar la tabla
        // get_detalle_datatable 

        // Agregar o actualizar un registro
        // set_detalle 

        // Importar registros
        // set_import_detalle

        // Truncate table útil para hacer pruebas
        // truncate_detalle
        // truncate_sps_detalle

        // Trar una lista por si se ocupa como un catalogo util para llenar un combo
        // get_cat_detalle

        // Útil para validar si ya existe un registro en la bd 
        // validar_existencia_detalle

        // Obtener un registro por id se usa cuando se intenta actualizar un registro
        // get_detalle_by_id

        // Se utiliza para eliminar un registro en la tabla
        // delete_detalle

        // FIN Funciones principales que se encuentran en los controladores

        // ===============================================================
    },

    fn_datatable_detalle: function (rango_fecha) {

        // let columna = 
        let table = $('#get_detalle_datatable').DataTable({
            "stateSave": false,
            "serverSide": true,
            "destroy": true,
            "responsive": false,
            "pageLength": 10,
            "scrollCollapse": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": {
                "url": "get_detalle_datatable",
                "type": "GET",
                "data": function(d) {
                    d.buscar_vCampo1_detalle = $('#buscar_vCampo1_detalle').val();
                    d.buscar_vCampo2_detalle = $('#buscar_vCampo2_detalle').val();
                    d.buscar_vCampo3_detalle = $('#buscar_vCampo3_detalle').val();
                    d.buscar_vCampo4_detalle = $('#buscar_vCampo4_detalle').val();
                    d.buscar_vCampo5_detalle = $('#buscar_vCampo5_detalle').val();
                    d.buscar_vCampo6_detalle = $('#buscar_vCampo6_detalle').val();
                    d.buscar_vCampo7_detalle = $('#buscar_vCampo7_detalle').val();
                    d.buscar_vCampo8_detalle = $('#buscar_vCampo8_detalle').val();
                    d.buscar_vCampo9_detalle = $('#buscar_vCampo9_detalle').val();
                    d.buscar_vCampo10_detalle = $('#buscar_vCampo10_detalle').val();
                    // Añade aquí más datos de búsqueda si es necesario
                },
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            "processing": true,
            "language": {
                "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Cargando...</span>',
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": '<div class="text-center">\
                                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#25a0e2,secondary:#00bd9d" style="width:75px;height:75px">\
                                                    </lord-icon>\
                                                    <h5 class="mt-2">Sin resultados</h5>\
                                                    <p class="text-muted mb-0">Hemos buscado en más de 50 Registros No encontramos ningún registro para su búsqueda.</p>\
                                                </div>',
                "sEmptyTable": "Ningún registro disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": '<div class="spinner-border text-primary avatar-sm" role="status">\
                                        <span class="visually-hidden">Loading...</span>\
                                    </div>',
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
            // guarda el estado de la tabla (paginación, filtrado, etc.)
            ,
            stateSaveCallback: function (settings, data) {
                localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify(data))
            },
            stateLoadCallback: function (settings) {
                return JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance))
            },
            fnDrawCallback: function( oSettings ) {
                $('[data-toggle="tooltip"]').tooltip();
            },
            // "dom": 'Brtip',
            // buttons: [
            //     {
            //         extend: 'excel',
            //         title: 'Reporte detalle',
            //         className: 'btn header-item noti-icon btn-personalizado-xlxs',
            //         excelStyles: {
            //             template: 'blue_medium',
            //         },
            //     },
            // ],
            // "buttons": [
            //     {
            //         "extend": 'excel',
            //         "title": 'Reporte detalle',
            //         "className": 'btn header-item noti-icon btn-personalizado-xlxs',
            //         "excelStyles": {
            //             "template": 'blue_medium',
            //         },
            //     },
            // ],

            // "order": [[0, "asc"]],

            "columns": [
                { "data": "id", visible: true},
                { "data": "vCampo1_detalle", class: "vCampo1_detalle", visible: true },
                { "data": "vCampo2_detalle", class: "vCampo2_detalle", visible: true },
                { "data": "vCampo3_detalle", class: "vCampo3_detalle", visible: true },
                { "data": "vCampo4_detalle", class: "vCampo4_detalle", visible: true },
                { "data": "vCampo5_detalle", class: "vCampo5_detalle", visible: true },
                { "data": "vCampo6_detalle", class: "vCampo6_detalle", visible: true },
                { "data": "vCampo7_detalle", class: "vCampo7_detalle", visible: true },
                { "data": "vCampo8_detalle", class: "vCampo8_detalle", visible: true },
                { "data": "vCampo9_detalle", class: "vCampo9_detalle", visible: true },
                { "data": "vCampo10_detalle", class: "vCampo10_detalle", visible: true },
            ],

            "columnDefs": [
                {
                    "targets": 11,
                    "render": function (data, type, row, meta) {
                        return '<div>\
                                    <ul class="list-inline mb-0 font-size-16">\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Editar" class="text-success p-1 update-detalle"><i class="bx bxs-edit-alt"></i></a>\
                                        </li>\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Eliminar" class="text-danger p-1 delete-detalle"><i class="bx bxs-trash"></i></a>\
                                        </li>\
                                    </ul>\
                                </div>';
                    },
                    "class": "text-center"
                }
            ]
        });

        // Evento de clic en las filas de la tabla
        $('#get_detalle_datatable tbody').on('click', 'tr .vCampo1_detalle', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            detalle.fn_copyToClipboarddetalle(data.vCampo1_detalle);
        });

        $('#get_detalle_datatable tbody').on('click', 'tr .vCampo2_detalle', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            detalle.fn_copyToClipboarddetalle(data.vCampo2_detalle);
        });

        $('#get_detalle_datatable tbody').on('click', 'tr .vCampo3_detalle', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            detalle.fn_copyToClipboarddetalle(data.vCampo3_detalle);
        });

        $('#get_detalle_datatable tbody').on('click', 'tr .vCampo4_detalle', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            detalle.fn_copyToClipboarddetalle(data.vCampo4_detalle);
        });

        $('#get_detalle_datatable tbody').on('click', 'tr .vCampo5_detalle', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            detalle.fn_copyToClipboarddetalle(data.vCampo5_detalle);
        });

        $('#get_detalle_datatable tbody').on('click', 'tr .vCampo6_detalle', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            detalle.fn_copyToClipboarddetalle(data.vCampo6_detalle);
        });

        $('#get_detalle_datatable tbody').on('click', 'tr .vCampo7_detalle', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            detalle.fn_copyToClipboarddetalle(data.vCampo7_detalle);
        });

        $('#get_detalle_datatable tbody').on('click', 'tr .vCampo8_detalle', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            detalle.fn_copyToClipboarddetalle(data.vCampo8_detalle);
        });

        $('#get_detalle_datatable tbody').on('click', 'tr .vCampo9_detalle', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            detalle.fn_copyToClipboarddetalle(data.vCampo9_detalle);
        });

        $('#get_detalle_datatable tbody').on('click', 'tr .vCampo10_detalle', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            detalle.fn_copyToClipboarddetalle(data.vCampo10_detalle);
        });
        // FIN Evento de clic en las filas de la tabla
        //////////////////////////////////////////////////////////////////////

       // Aplicar la búsqueda
        $("#get_detalle_datatable thead tr:eq(1) th").each(function (i) {
            $('input', this).on('keyup change', function () {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        if ( $("#btn-personalizados").length && $(".btn-personalizado-xlxs").length ){
            $('#btn-personalizados').html('');
            table.buttons().container().appendTo( '#btn-personalizados' );
            $('.btn-personalizado-xlxs').html('<i class="mdi mdi-microsoft-excel text-success"></i>');
            $('.btn-personalizado-xlxs').removeClass('btn-secondary header-item');
            $('.btn-personalizado-xlxs').addClass('header-item noti-icon');
        }

        if ( $('#vc-buscador').length ){
            $('#vc-buscador').keyup(function(){
                table.search($(this).val()).draw() ;
            });
        }

        // setInterval( function () {
        //     table.ajax.reload( null, false );
        // }, 5000 );

        detalle.fn_update_detalle();
        detalle.fn_delete_detalle();
    },

    fn_scroll_detalle: function() {

        let AppScroll = angular.module('app-scroll-detalle', ['infinite-scroll']);
        AppScroll.controller('ControllerScroll', function($scope, Reddit) {
            $scope.reddit = new Reddit();
        });

        AppScroll.factory('Reddit', function($http) {
            let Reddit = function() {
                this.items = [];
                this.busy = false;
                this.after = '';
            };

            Reddit.prototype.nextPage = function() {

                let id_detalle= $("#id_detalle").val();
                if (id_detalle == 0) {
                    return;
                }

                if (this.busy) {
                    return;
                }
                this.busy = true;

                let url = "get_detalle_diez?id_detalle=" + this.after + "&callback=JSON_CALLBACK&X-CSRF-TOKEN="+$('meta[name="csrf-token"]').attr('content');
                $http.jsonp(url).success(function(data) {
                    let items = data;
                    if (Array.isArray(items)) {
                        for (let i = 0; i < items.length; i++) {
                            this.items.push(items[i]);
                        }
                        this.after = this.items[this.items.length - 1].id_detalle;
                        this.busy = false;
                    } else {
                        $("#id_detalle").val(0);
                        this.busy = false;
                    }
                }.bind(this)).error(function(data, status, headers, config) {

                });
            };
            return Reddit;
        });
    },

    fn_copyToClipboarddetalle: function(text) {
        // Crear un elemento temporal de input
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
    },

    fn_set_detalle: function () {
        $("#form_detalle").validate({
            submitHandler: function (form) {
                let get_form = document.getElementById("form_detalle");
                let postData = new FormData(get_form);

                let element_by_id= 'form_detalle';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_detalle",
                    data: postData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    success: function (response) {

                        $loading.waitMe('hide');

                        let json ='';
                        try {
                            json = JSON.parse(response);
                        } catch (e) {
                            alert(response);
                            return;
                        }

                        if (json["b_status"]) {
                            $('#get_detalle_datatable').DataTable().ajax.reload();
                            document.getElementById("form_detalle").reset();
                            $('#modalFormIUdetalle').modal('hide');
                        } else {
                            alert(json);
                        }
                    },
                    error: function (response) {
                        $loading.waitMe('hide');
                    }
                });
            }
            , rules: {
              vCampo1_detalle: {
                required: true
              }
            }
            , messages: {
                vCampo1_detalle: {
                    minlength: "El vCampo1_detalle es requerido"
                }
              }
        });
    },

    fn_get_by_id: function () {

        var productId = detalle.fn_get_id(); // Cambia esto por el ID del producto que quieres cargar
        $.ajax({
            url: '/producto/' + productId,
            method: 'GET',
            success: function(data) {
                if (Array.isArray(data.fotos_array) && data.fotos_array.length > 0) {
                    var thumbHtml = data.fotos_array.map((foto, index) => `
                        <li data-bs-target="#Slider" data-bs-slide-to="${index}" class="thumb ${index === 0 ? 'active' : ''} my-sm-2 m-2 mx-sm-0">
                            <img src="${foto.trim()}" alt="img">
                        </li>
                    `).join('');

                    var sliderHtml = data.fotos_array.map((foto, index) => `
                        <div class="carousel-item ${index === 0 ? 'active' : ''}">
                            <img src="${foto.trim()}" alt="img" class="img-fluid mx-auto d-block">
                            <div class="text-center mt-5 mb-5 btn-list">
                                <!-- Aquí puedes añadir botones u otros elementos -->
                            </div>
                        </div>
                    `).join('');

                    var productHtml = `
                        <div class="row row-sm">
                            <div class="col-xxl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row row-sm">
                                            <div class="col-xxl-6 col-lg-12 col-md-12">
                                                <div class="row">
                                                    <div class="col-xxl-2 col-xl-2 col-md-2 col-sm-3">
                                                        <div class="clearfix carousel-slider">
                                                            <div id="thumbcarousel" class="carousel slide" data-bs-interval="t">
                                                                <div class="carousel-inner">
                                                                    <ul class="carousel-item active">
                                                                        ${thumbHtml}
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xxl-10 col-xl-10 col-md-10 col-sm-9">
                                                        <div class="product-carousel border br-5">
                                                            <div id="Slider" class="carousel slide" data-bs-ride="false">
                                                                <div class="carousel-inner">
                                                                    ${sliderHtml}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="details col-xxl-6 col-lg-12 col-md-12 mt-4">
                                                <h4 class="product-title mb-1">${data.titulo}</h4>
                                                <h6 class="price">Precio: <span class="h3 ms-2">${data.precio}</span></h6>
                                                <h5>Descripción</h5>
                                                <pre class="styled-pre">${data.descripcion.trim()}</pre>
                                                <div class="mt-4 btn-list">
                                                    <a href="javascript:void(0);" class="btn ripple btn-primary me-2"><i class="fe fe-shopping-cart"></i> Agregar al carrito</a>
                                                    <a href="check_out?id=${data.id}" class="btn ripple btn-secondary"><i class="fe fe-credit-card"></i> Comprar ahora</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    $('#product-container').html(productHtml);

                    // Adding event listeners for thumbs after the HTML is updated
                    var thumbs = document.querySelectorAll('.thumb');
                    thumbs.forEach(function (thumb) {
                        thumb.addEventListener('click', function () {
                            // Check if the clicked element does not have the 'active' class
                            if (!this.classList.contains('active')) {
                                // Remove the 'active' class from all elements with the class 'thumb'
                                thumbs.forEach(function (el) {
                                    el.classList.remove('active');
                                });
                                // Add the 'active' class to the clicked element
                                this.classList.add('active');
                            }
                        });
                    });
                } else {
                    $('#product-container').html('<p>No hay fotos disponibles para este producto.</p>');
                }
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });

    },

    fn_get_id: function () {
        // Get the URL
        const url = new URL(window.location.href);

        // Get the value of the 'id' parameter
        const id = url.searchParams.get('id');

        return id;
    },

    fn_modalHidedetalle: function () {

        $('#modalFormIUdetalle').on('hidden.bs.modal', function (e) {

            if ( $(".tipo-ya-existe").length ){
                $(".tipo-ya-existe").addClass("d-none");
            }

            if ( $("#vCampo1_pruebas").length ){
                $("#vCampo1_pruebas").removeClass("border-danger text-danger");
            }

            if ( $("#form_detalle").length ){
                $("#form_detalle input").removeClass("border-danger").removeClass("text-danger");
            }

            let validator = $("#form_detalle").validate();

            validator.resetForm();
            $("label.error").hide();
            $(".error").removeClass("error");
            
            if ($("#id").length)
            {
                $("#id").remove();
            }
            
            if ($("#form_detalle").length){
                document.getElementById("form_detalle").reset();
            }

            if ($("#form_import_detalle").length){
                document.getElementById("form_import_detalle").reset();
            }
        });
    },

    fn_AgregarNuevodetalle: function () {
        $(document).on("click", "#add_new_detalle", function () {
            document.getElementById("form_detalle").reset();            
            $("#modalFormIUdetalle .modal-title").html("Nuevo");
        });
    },

    fn_actualizarTabladetalle: function () {
        $(document).on("click", "#refresh_detalle", function () {

            if ($("#get_detalle_datatable").length){
                $('#get_detalle_datatable').DataTable().ajax.reload();
            }

        });
    },

    fn_truncateSPSdetalle: function () {
        $.ajax({
            url:"truncate_sps_detalle",
            cache: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function(response)
            {
                if ($("#get_detalle_datatable").length){
                    $('#get_detalle_datatable').DataTable().ajax.reload();
                }
            }
        });
    },

    fn_truncatedetalle: function () {
        $.ajax({
            url:"truncate_detalle",
            cache: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function(response)
            {
                if ($("#get_detalle_datatable").length){
                    $('#get_detalle_datatable').DataTable().ajax.reload();
                }
            }
        });
    },

    fn_importar_excel_detalle: function() {

        // si no existe el elemento terminar...
        if (! $('#FormImportardetalle').length)
            return;

        let $form = $('#FormImportardetalle');

        $form.find('input:file').fileuploader({
            addMore: true,
            changeInput: '<div class="fileuploader-input">' +
                '<div class="fileuploader-input-inner">' +
                '<div>${captions.feedback} ${captions.or} <span>${captions.button}</span></div>' +
                '</div>' +
                '</div>',
            theme: 'dropin',
            upload: true,
            enableApi: true,
            onSelect: function(item) {
                item.upload = null;
                $(".btn-importar").removeClass('btn-disabled disabled');
                $(".btn-importar").removeAttr('disabled');            
            },
            onRemove: function(item) {
                if (item.data.uploaded)
                    $.post('files/assets/js/lumic/fileuploader-2.2/examples/drag-drop-form/php/ajax_remove_file_detalle.php', {
                        file: item.name
                    }, function(data) {
                        // if (data)
                            // $(".text-success").html("");
                    });
            },
            captions: $.extend(true, {}, $.fn.fileuploader.languages['en'], {
                feedback: 'Arrastra y suelta aquí',
                or: 'ó <br>',
                button: 'Buscar archivo'
            })
          });

        // form submit
        $form.on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(),
                _fileuploaderFields = [];

            // append inputs to FormData
            $.each($form.serializeArray(), function(key, field) {
                formData.append(field.name, field.value);
            });
            // append file inputs to FormData
            $.each($form.find("input:file"), function(index, input) {
                let $input = $(input),
                    name = $input.attr('name'),
                    files = $input.prop('files'),
                    api = $.fileuploader.getInstance($input);

                // add fileuploader files to the formdata
                if (api) {
                    if ($.inArray(name, _fileuploaderFields) > -1)
                        return;
                    files = api.getChoosedFiles();
                    _fileuploaderFields.push($input);
                }

                for (let i = 0; i < files.length; i++) {
                    formData.append(name, (files[i].file ? files[i].file : files[i]), (files[i].name ? files[i].name : false));
                }
            });

            let element_by_id= 'FormImportardetalle';
            let message=  'Importando archivo...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url: $form.attr('action') || '#',
                data: formData,
                type: $form.attr('method') || 'POST',
                enctype: $form.attr('enctype') || 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                beforeSend: function() {
                    $form.find('.form-status').html('<div class="progressbar-holder"><div class="progressbar"></div></div>');
                    $form.find('input[type="submit"]').attr('disabled', 'disabled');
                },
                xhr: function() {
                    let xhr = $.ajaxSettings.xhr();

                    if (xhr.upload) {
                        xhr.upload.addEventListener("progress", this.progress, false);
                    }

                    return xhr;
                },
                success: function(result, textStatus, jqXHR) {
                    // update input values
                    try {
                        let data = JSON.parse(result);

                        for (let key in data) {
                            let field = data[key],
                                api;

                            // if fileuploader input
                            if (field.files) {
                                let input = _fileuploaderFields.filter(function(element) {
                                        return key == element.attr('name').replace('[]', '');
                                    }).shift(),
                                    api = input ? $.fileuploader.getInstance(input) : null;

                                if (field.hasWarnings) {
                                    for (let warning in field.warnings) {
                                        alert(field.warnings[warning]);
                                    }

                                    return this.error ? this.error(jqXHR, textStatus, field.warnings) : null;
                                }

                                if (api) {
                                    // update the fileuploader's file names
                                    for (let i = 0; i < field.files.length; i++) {
                                        $.each(api.getChoosedFiles(), function(index, item) {
                                            if (field.files[i].old_name == item.name) {
                                                item.name = field.files[i].name;
                                                item.html.find('.column-title > div:first-child').text(field.files[i].name).attr('title', field.files[0].name);
                                            }
                                            item.data.uploaded = true;
                                        });
                                    }

                                    api.updateFileList();
                                }
                            } else {
                                $form.find('[name="' + key + '"]:input').val(field);
                            }
                        }
                    } catch (e) {}

                    document.getElementById("FormImportardetalle").reset();
                    $form.find('input[type="submit"]').removeAttr('disabled');
                    $loading.waitMe('hide');

                    $("#modalImportFormdetalle").modal("hide");
                    $('#get_detalle_datatable').DataTable().ajax.reload();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $form.find('.form-status').html('<p class="text-error">Error!</p>');
                    $form.find('input[type="submit"]').removeAttr('disabled');
                    $(".btn-importar").removeClass('btn-disabled disabled');
                    $(".btn-importar").removeAttr('disabled');                     

                    $loading.waitMe('hide');
                },
                progress: function(e) {
                    if (e.lengthComputable) {
                        let t = Math.round(e.loaded * 100 / e.total).toString();

                        $form.find('.form-status .progressbar').css('width', t + '%');
                    }
                }
            });
        });
    },

    fn_Catdetalle: function(){

        $.ajax({
            url:"get_cat_detalle",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function(response)
            {
                let json= '';
                try {
                    json= JSON.parse(response);
                } catch (e) {
                    console.log(response);
                }
                
                if (json["b_status"])
                {
                    $(json['data']).each(function(i, j){
                        // Agregar este id en el select by id y luego borrar este comentario 
                        // #id_cat_detalle' 

                        if ($("#id_cat_detalle").length){
                            $("#id_cat_detalle").append("<option value="+j['id']+"> "+j['vCampo1_detalle']+" </option>");
                        }
                    });
                }

            }
        });
    },

    fn_set_validar_existencia_detalle: function(){

        $( "#vCampo1_detalle" ).keyup(function( event ) {

            var id=0;
            // Si se esta editando return
            if ( $("#modalFormIUdetalle #id").length ){
                id= $("#modalFormIUdetalle #id").val();
            }

            let vCampo1_detalle= this.value;

            if(vCampo1_detalle ==""){
                $("#modalFormIUdetalle .btn-action-form").attr("disabled",false);
                $("#vCampo1_detalle").removeClass("border-danger").removeClass("text-danger");
                $(".tipo-ya-existe").addClass("d-none");
                return;
            }

            $.ajax({
                url: "validar_existencia_detalle",
                data: { vCampo1_detalle: vCampo1_detalle, id: id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'GET',
                contentType: "application/json",
                success: function (response) {

                    var json = JSON.parse(response);

                    if (json['b_status']) {
                        $("#modalFormIUdetalle .btn-action-form").attr("disabled",true);
                        $("#vCampo1_detalle").addClass("border-danger").addClass("text-danger");
                        $(".tipo-ya-existe").removeClass("d-none");
                    } else {
                        $("#modalFormIUdetalle .btn-action-form").attr("disabled",false);
                        $("#vCampo1_detalle").removeClass("border-danger").removeClass("text-danger");
                        $(".tipo-ya-existe").addClass("d-none");
                    }
                },
            });

        });
    },

    fn_update_detalle: function(){

        $('#get_detalle_datatable tbody').on('click', '.update-detalle', function () {
            // Abrir modal!
            $('#modalFormIUdetalle').modal('show');

            let id = this.id;
            document.getElementById("form_detalle").reset();

            if ($("#id").length)
            {
                $("#id").remove();
            }

            $("#form_detalle").prepend('<input type="hidden" name="id" id="id" value=" '+ id +' ">');

            $("#modalFormIUdetalle .modal-title").html("Editar");

            let element_by_id= 'form_detalle';
            let message=  'Cargando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"get_detalle_by_id",
                data: {id: id},
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                    success: function(response)
                    {
                        $loading.waitMe('hide');

                        let json='';
                        try {
                            json = JSON.parse(response);
                        } catch (e) {
                            console.log(response);
                        }

                        if (json["b_status"]) {
                            let p = json['data'];
                            for (let keyIni in p) {
                                for (let key in p[0]) {
                                    if (p[0].hasOwnProperty(key)) {
                                        if (p[0][key] !== "") {
                                            $("#" + key).addClass("fill");

                                            if ($("#" + key).prop('type') == "text" ||
                                                $("#" + key).prop('type') == "textarea" ||
                                                $("#" + key).prop('type') == "email" ||
                                                $("#" + key).prop('type') == "number" ||
                                                $("#" + key).prop('type') == "url" ||
                                                $("#" + key).prop('type') == "tel"
                                            ) {
                                                $("#" + key).val(p[0][key]);
                                            }

                                            if ($("#" + key).prop('type') == "file") {
                                                if (p[0][key] !== "") {
                                                    $("#" + key).attr("required", false);
                                                }

                                                if (p[0][key] !== null) {
                                                    let filename = p[0][key].replace(/^.*[\\\/]/, '')
                                                        $("#" + key).after("<a href=\"" + p[0][key] + "\" target=\"_blank\" class=\"external_link  abrir-" + key + " \"> " + filename.substr(0, 15) + " </a>");
                                                }
                                            }

                                            if ($("#" + key).prop('nodeName') == "SELECT") {
                                                $('#' + key + ' option[value="' + p[0][key] + '"]').prop('selected', true);
                                            }
                                        }
                                    }
                                }
                            }

                        } 
                        else 
                        {
                            alert("Revisar console para mas detalle");
                            console.log(json);
                        }
                    },
                    error: function(response)
                    {
                        $loading.waitMe('hide');
                    }
            });
        });
    },

    fn_delete_detalle: function(){
        $('#get_detalle_datatable tbody').on('click', '.delete-detalle', function () {

            document.getElementById("form_detalle").reset();
            $("label.error").hide();
            $(".error").removeClass("error");

            let id = this.id;
            let element_by_id= 'form_detalle';
            let message=  'Eliminando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"delete_detalle",
                data: {"id": id},
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                    success: function(response)
                    {

                        $('#get_detalle_datatable').DataTable().ajax.reload();
                        $('#modalFormIUdetalle').modal('hide');
                        $loading.waitMe('hide');

                        let n = new Noty({
                            type: "warning",
                            close: false,
                            text: "<b>Se movio a la papelera<b>" ,
                            layout: 'topCenter',
                            timeout: 20e3,
                                buttons: [
                                  Noty.button('Deshacer', 'btn btn-success btn-sm', function () {
                                        $.ajax({
                                            url:"undo_delete_detalle",
                                            data: {"id" : id},
                                            cache: false,
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                            type: 'POST',
                                                success: function(response)
                                                {
                                                    n.close();
                                                    $('#get_detalle_datatable').DataTable().ajax.reload();

                                                    new Noty({
                                                        text: 'Se ha deshecho la acción.',
                                                        type: "warning",
                                                        layout: 'topCenter',
                                                        timeout: 1e3,
                                                    }).show();


                                                },
                                                error: function(response)
                                                {
                                                    alert("Ocurrio un error");
                                                }
                                        });
                                  }
                                  ,{
                                      'id'         : 'id-'+id
                                    , 'data-status': 'ok'
                                  }
                                  )
                                  , Noty.button('Cerrar', 'btn btn-error', function () {
                                        n.close();
                                    })
                                ]
                        });
                        n.show();
                    },
                    error: function(response)
                    {
                        $loading.waitMe('hide');
                    }
            });
        });  
    },

    fn_eventos_extra_detalle: function(){
    },

};

detalle.init();