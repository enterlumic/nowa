let empleados = {

    init: function () {

        // Funciones principales
        empleados.fn_set_empleados();
        empleados.fn_set_import_empleados();
        empleados.fn_datatable_empleados(rango_fecha='');
        empleados.fn_scroll_empleados();
        empleados.fn_importar_excel_empleados();

        // Funciones para eventos
        empleados.fn_modalShowempleados();
        empleados.fn_modalHideempleados();
        empleados.fn_AgregarNuevoempleados();
        empleados.fn_actualizarTablaempleados();
        empleados.fn_Catempleados();
        empleados.fn_set_validar_existencia_empleados();


        var n1 = new Cleave('#salario', {
            numeral: true,
            numeralThousandsGroupStyle: 'lakh'
        });


        var pn = new Cleave('.phone-number', {
            blocks: [2, 4, 4],
        });

    },

    fn_datatable_empleados: function (rango_fecha) {

        // let columna = 
        let table = $('#get_empleados_datatable').DataTable({
            "stateSave": false,
            "serverSide": true,
            "destroy": true,
            "responsive": false,
            "pageLength": 10,
            "scrollCollapse": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": {
                "url": "get_empleados_datatable",
                "type": "GET",
                "data": function(d) {
                    d.buscar_nombre = $('#buscar_nombre').val();
                    d.buscar_direccion = $('#buscar_direccion').val();
                    d.buscar_telefono = $('#buscar_telefono').val();
                    d.buscar_email = $('#buscar_email').val();
                    d.buscar_fecha_ingreso = $('#buscar_fecha_ingreso').val();
                    d.buscar_puesto = $('#buscar_puesto').val();
                    d.buscar_salario = $('#buscar_salario').val();
                    d.buscar_jornada = $('#buscar_jornada').val();
                    d.buscar_especialidades = $('#buscar_especialidades').val();
                    d.buscar_certificaciones = $('#buscar_certificaciones').val();
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
            "columns": [
                { "data": "id", visible: true},
                { "data": "nombre", class: "nombre", visible: true },
                { "data": "direccion", class: "direccion", visible: true },
                { "data": "telefono", class: "telefono", visible: true },
                { "data": "email", class: "email", visible: true },
                { "data": "fecha_ingreso", class: "fecha_ingreso", visible: true },
                { "data": "puesto", class: "puesto", visible: false },
                { "data": "salario", class: "salario", visible: false },
                { "data": "jornada", class: "jornada", visible: false },
                { "data": "especialidades", class: "especialidades", visible: false },
                { "data": "certificaciones", class: "certificaciones", visible: false },
            ],

            "columnDefs": [
                {
                    "targets": 11,
                    "render": function (data, type, row, meta) {
                        return '<div>\
                                    <ul class="list-inline mb-0 font-size-16">\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Editar" class="text-success p-1 update-empleados"><i class="bx bxs-edit-alt"></i></a>\
                                        </li>\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Eliminar" class="text-danger p-1 delete-empleados"><i class="bx bxs-trash"></i></a>\
                                        </li>\
                                    </ul>\
                                </div>';
                    },
                    "class": "text-center"
                }
            ]
        });

        // Evento de clic en las filas de la tabla
        $('#get_empleados_datatable tbody').on('click', 'tr .nombre', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empleados.fn_copyToClipboardempleados(data.nombre);
        });

        $('#get_empleados_datatable tbody').on('click', 'tr .direccion', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empleados.fn_copyToClipboardempleados(data.direccion);
        });

        $('#get_empleados_datatable tbody').on('click', 'tr .telefono', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empleados.fn_copyToClipboardempleados(data.telefono);
        });

        $('#get_empleados_datatable tbody').on('click', 'tr .email', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empleados.fn_copyToClipboardempleados(data.email);
        });

        $('#get_empleados_datatable tbody').on('click', 'tr .fecha_ingreso', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empleados.fn_copyToClipboardempleados(data.fecha_ingreso);
        });

        $('#get_empleados_datatable tbody').on('click', 'tr .puesto', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empleados.fn_copyToClipboardempleados(data.puesto);
        });

        $('#get_empleados_datatable tbody').on('click', 'tr .salario', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empleados.fn_copyToClipboardempleados(data.salario);
        });

        $('#get_empleados_datatable tbody').on('click', 'tr .jornada', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empleados.fn_copyToClipboardempleados(data.jornada);
        });

        $('#get_empleados_datatable tbody').on('click', 'tr .especialidades', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empleados.fn_copyToClipboardempleados(data.especialidades);
        });

        $('#get_empleados_datatable tbody').on('click', 'tr .certificaciones', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empleados.fn_copyToClipboardempleados(data.certificaciones);
        });
        // FIN Evento de clic en las filas de la tabla
        //////////////////////////////////////////////////////////////////////

       // Aplicar la búsqueda
        $("#get_empleados_datatable thead tr:eq(1) th").each(function (i) {
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

        empleados.fn_update_empleados();
        empleados.fn_delete_empleados();
    },

    fn_scroll_empleados: function() {

        let AppScroll = angular.module('app-scroll-empleados', ['infinite-scroll']);
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

                let id_empleados= $("#id_empleados").val();
                if (id_empleados == 0) {
                    return;
                }

                if (this.busy) {
                    return;
                }
                this.busy = true;

                let url = "get_empleados_diez?id_empleados=" + this.after + "&callback=JSON_CALLBACK&X-CSRF-TOKEN="+$('meta[name="csrf-token"]').attr('content');
                $http.jsonp(url).success(function(data) {
                    let items = data;
                    if (Array.isArray(items)) {
                        for (let i = 0; i < items.length; i++) {
                            this.items.push(items[i]);
                        }
                        this.after = this.items[this.items.length - 1].id_empleados;
                        this.busy = false;
                    } else {
                        $("#id_empleados").val(0);
                        this.busy = false;
                    }
                }.bind(this)).error(function(data, status, headers, config) {

                });
            };
            return Reddit;
        });
    },

    fn_copyToClipboardempleados: function(text) {
        // Crear un elemento temporal de input
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
    },

    fn_set_empleados: function () {

        $.validator.addMethod("digitsAndSpaces", function(value, element) {
            return this.optional(element) || /^[0-9 ]+$/.test(value);
        }, "Por favor, introduce solo números y espacios");

        $.validator.addMethod("validSalario", function(value, element) {
            return this.optional(element) || /^[0-9.,]+$/.test(value);
        }, "Por favor, introduce solo números, puntos y comas");

        $('#salario').on('input', function() {
            // Reemplazar cualquier caracter que no sea un dígito, punto o coma con una cadena vacía
            this.value = this.value.replace(/[^0-9.,]/g, '');
        });
        $("#form_empleados").validate({
            submitHandler: function (form) {
                let get_form = document.getElementById("form_empleados");
                let postData = new FormData(get_form);

                let element_by_id= 'form_empleados';
                let message= 'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_empleados",
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
                            $('#get_empleados_datatable').DataTable().ajax.reload();
                            document.getElementById("form_empleados").reset();
                            $('#modalFormIUempleados').modal('hide');
                        } else {
                            alert(json);
                        }
                    },
                    error: function (response) {
                        $loading.waitMe('hide');
                    }
                });
            },
            rules: {
                nombre: {
                    required: true
                },
                direccion: {
                    required: true
                },
                telefono: {
                    required: true,
                    digitsAndSpaces: true,
                    minlength: 12,
                    maxlength: 12
                },
                email: {
                    required: true,
                    email: true
                },
                fecha_ingreso: {
                    required: true,
                },
                puesto: {
                    required: true
                },
                salario: {
                    required: true,
                    validSalario: true
                },
                jornada: {
                    required: true
                }
            },
            messages: {
                nombre: {
                    required: "El nombre es requerido"
                },
                direccion: {
                    required: "La dirección es requerida"
                },
                telefono: {
                    required: "El teléfono es requerido",
                    digitsAndSpaces: "Por favor, introduce solo números y espacios",
                    minlength: "El teléfono debe tener al menos 10 dígitos",
                    maxlength: "El teléfono debe tener máximo 10 dígitos"
                },
                email: {
                    required: "El correo electrónico es requerido",
                    email: "Por favor, introduce un correo electrónico válido"
                },
                fecha_ingreso: {
                    required: "La fecha de ingreso es requerida",
                    date: "Por favor, introduce una fecha válida"
                },
                puesto: {
                    required: "El puesto es requerido"
                },
                salario: {
                    required: "El salario es requerido",
                    number: "Por favor, introduce un número válido",
                    min: "El salario debe ser un número positivo"
                },
                jornada: {
                    required: "La jornada es requerida"
                }
            }
        });

    },

    fn_set_import_empleados: function () {
        $("#form_import_empleados").validate({
            submitHandler: function (form) {
                let get_form = document.getElementById("form_import_empleados");
                let postData = new FormData(get_form);

                let element_by_id= 'form_import_empleados';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_import_empleados",
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
                            $('#get_empleados_datatable').DataTable().ajax.reload();
                            document.getElementById("form_import_empleados").reset();
                            $('#modalImportFormempleados').modal('hide');
                        } else {
                            alert(json);
                        }
                    },
                    error: function (response) {
                        $loading.waitMe('hide');
                        alert(response);
                    }
                });
            }
            , rules: {
              nombre: {
                required: true
              }
            }
            , messages: {
                nombre: {
                    minlength: "Mensaje personalizado nombre"
                }
              }
        });
    },

    fn_modalShowempleados: function () {
        $('#modalFormIUempleados').on('shown.bs.modal', function (e) {
            $('#nombre', e.target).focus();

            flatpickr("#fecha_ingreso", {
                dateFormat: "Y-m-d",
                time_24hr: true,
                closeOnSelect: true,  // Cierra el calendario automáticamente después de seleccionar una fecha
                onChange: function(selectedDates, dateStr, instance) {
                    instance.close();  // Cierra el calendario después de seleccionar una fecha
                },
                static: true,  // Hace que el calendario sea siempre visible y no se cierre con scroll o clic fuera
                appendTo: document.body // Asegura que el calendario es parte del body y no está confinado dentro del modal
            });

        });

        $('#modalImportFormempleados').on('shown.bs.modal', function (e) {
            $('#vc_importar', e.target).focus();
        });
    },

    fn_modalHideempleados: function () {

        $('#modalFormIUempleados').on('hidden.bs.modal', function (e) {

            if ( $(".tipo-ya-existe").length ){
                $(".tipo-ya-existe").addClass("d-none");
            }

            if ( $("#vCampo1_pruebas").length ){
                $("#vCampo1_pruebas").removeClass("border-danger text-danger");
            }

            if ( $("#form_empleados").length ){
                $("#form_empleados input").removeClass("border-danger").removeClass("text-danger");
            }

            let validator = $("#form_empleados").validate();

            validator.resetForm();
            $("label.error").hide();
            $(".error").removeClass("error");
            
            if ($("#id").length)
            {
                $("#id").remove();
            }
            
            if ($("#form_empleados").length){
                document.getElementById("form_empleados").reset();
            }

            if ($("#form_import_empleados").length){
                document.getElementById("form_import_empleados").reset();
            }
        });
    },

    fn_AgregarNuevoempleados: function () {
        $(document).on("click", "#add_new_empleados", function () {
            document.getElementById("form_empleados").reset();            
            $("#modalFormIUempleados .modal-title").html("Agregar Nuevo Empleado");
        });
    },

    fn_actualizarTablaempleados: function () {
        $(document).on("click", "#refresh_empleados", function () {

            if ($("#get_empleados_datatable").length){
                $('#get_empleados_datatable').DataTable().ajax.reload();
            }

        });
    },

    fn_truncateSPSempleados: function () {
        $.ajax({
            url:"truncate_sps_empleados",
            cache: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function(response)
            {
                if ($("#get_empleados_datatable").length){
                    $('#get_empleados_datatable').DataTable().ajax.reload();
                }
            }
        });
    },

    fn_truncateempleados: function () {
        $.ajax({
            url:"truncate_empleados",
            cache: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function(response)
            {
                if ($("#get_empleados_datatable").length){
                    $('#get_empleados_datatable').DataTable().ajax.reload();
                }
            }
        });
    },

    fn_importar_excel_empleados: function() {

        // si no existe el elemento terminar...
        if (! $('#FormImportarempleados').length)
            return;

        let $form = $('#FormImportarempleados');

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
                    $.post('files/assets/js/lumic/fileuploader-2.2/examples/drag-drop-form/php/ajax_remove_file_empleados.php', {
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

            let element_by_id= 'FormImportarempleados';
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

                    document.getElementById("FormImportarempleados").reset();
                    $form.find('input[type="submit"]').removeAttr('disabled');
                    $loading.waitMe('hide');

                    $("#modalImportFormempleados").modal("hide");
                    $('#get_empleados_datatable').DataTable().ajax.reload();

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

    fn_Catempleados: function(){

        $.ajax({
            url:"get_cat_empleados",
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
                        // #id_cat_empleados' 

                        if ($("#id_cat_empleados").length){
                            $("#id_cat_empleados").append("<option value="+j['id']+"> "+j['nombre']+" </option>");
                        }
                    });
                }

            }
        });
    },

    fn_set_validar_existencia_empleados: function(){

        $( "#nombre" ).keyup(function( event ) {

            var id=0;
            // Si se esta editando return
            if ( $("#modalFormIUempleados #id").length ){
                id= $("#modalFormIUempleados #id").val();
            }

            let nombre= this.value;

            if(nombre ==""){
                $("#modalFormIUempleados .btn-action-form").attr("disabled",false);
                $("#nombre").removeClass("border-danger").removeClass("text-danger");
                $(".tipo-ya-existe").addClass("d-none");
                return;
            }

            $.ajax({
                url: "validar_existencia_empleados",
                data: { nombre: nombre, id: id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'GET',
                contentType: "application/json",
                success: function (response) {

                    var json = JSON.parse(response);

                    if (json['b_status']) {
                        $("#modalFormIUempleados .btn-action-form").attr("disabled",true);
                        $("#nombre").addClass("border-danger").addClass("text-danger");
                        $(".tipo-ya-existe").removeClass("d-none");
                    } else {
                        $("#modalFormIUempleados .btn-action-form").attr("disabled",false);
                        $("#nombre").removeClass("border-danger").removeClass("text-danger");
                        $(".tipo-ya-existe").addClass("d-none");
                    }
                },
            });

        });
    },

    fn_update_empleados: function(){

        $('#get_empleados_datatable tbody').on('click', '.update-empleados', function () {
            // Abrir modal!
            $('#modalFormIUempleados').modal('show');

            let id = this.id;
            document.getElementById("form_empleados").reset();

            if ($("#id").length)
            {
                $("#id").remove();
            }

            $("#form_empleados").prepend('<input type="hidden" name="id" id="id" value=" '+ id +' ">');

            $("#modalFormIUempleados .modal-title").html("Editar Empleado");

            let element_by_id= 'form_empleados';
            let message=  'Cargando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"get_empleados_by_id",
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

    fn_delete_empleados: function(){
        $('#get_empleados_datatable tbody').on('click', '.delete-empleados', function () {

            document.getElementById("form_empleados").reset();
            $("label.error").hide();
            $(".error").removeClass("error");

            let id = this.id;
            let element_by_id= 'form_empleados';
            let message=  'Eliminando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"delete_empleados",
                data: {"id": id},
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                    success: function(response)
                    {

                        $('#get_empleados_datatable').DataTable().ajax.reload();
                        $('#modalFormIUempleados').modal('hide');
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
                                            url:"undo_delete_empleados",
                                            data: {"id" : id},
                                            cache: false,
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                            type: 'POST',
                                                success: function(response)
                                                {
                                                    n.close();
                                                    $('#get_empleados_datatable').DataTable().ajax.reload();

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

    fn_eventos_extra_empleados: function(){
    },

};

empleados.init();