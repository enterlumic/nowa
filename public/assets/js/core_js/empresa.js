let empresa = {

    init: function () {

        // Funciones principales
        empresa.fn_set_empresa();
        empresa.fn_datatable_empresa(rango_fecha='');
        empresa.fn_scroll_empresa();
        empresa.fn_importar_excel_empresa();

        // Funciones para eventos
        empresa.fn_modalShowempresa();
        empresa.fn_modalHideempresa();
        empresa.fn_AgregarNuevoempresa();
        empresa.fn_actualizarTablaempresa();
        empresa.fn_Catempresa();
        empresa.fn_set_validar_existencia_empresa();

        // Funciones principales que se encuentran en controlador >> empresaController
        // ===============================================================

        // Store procedure
        // sp_get_empresa
        // sp_set_empresa
        // sp_get_by_id_empresa

        // Llenar la tabla
        // get_empresa_datatable 

        // Agregar o actualizar un registro
        // set_empresa 

        // Importar registros
        // set_import_empresa

        // Truncate table útil para hacer pruebas
        // truncate_empresa
        // truncate_sps_empresa

        // Trar una lista por si se ocupa como un catalogo util para llenar un combo
        // get_cat_empresa

        // Útil para validar si ya existe un registro en la bd 
        // validar_existencia_empresa

        // Obtener un registro por id se usa cuando se intenta actualizar un registro
        // get_empresa_by_id

        // Se utiliza para eliminar un registro en la tabla
        // delete_empresa

        // FIN Funciones principales que se encuentran en los controladores

        // ===============================================================
    },

    fn_datatable_empresa: function (rango_fecha) {

        // let columna = 
        let table = $('#get_empresa_datatable').DataTable({
            "stateSave": false,
            "serverSide": true,
            "destroy": true,
            "responsive": false,
            "pageLength": 10,
            "scrollCollapse": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": {
                "url": "get_empresa_datatable",
                "type": "GET",
                "data": function(d) {
                    d.buscar_logo = $('#buscar_logo').val();
                    d.buscar_nombre = $('#buscar_nombre').val();
                    d.buscar_descripcion = $('#buscar_descripcion').val();
                    d.buscar_telefono = $('#buscar_telefono').val();
                    d.buscar_whatsapp = $('#buscar_whatsapp').val();
                    d.buscar_ubicacion = $('#buscar_ubicacion').val();
                    d.buscar_longitud = $('#buscar_longitud').val();
                    d.buscar_latitud = $('#buscar_latitud').val();
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
            //         title: 'Reporte empresa',
            //         className: 'btn header-item noti-icon btn-personalizado-xlxs',
            //         excelStyles: {
            //             template: 'blue_medium',
            //         },
            //     },
            // ],
            // "buttons": [
            //     {
            //         "extend": 'excel',
            //         "title": 'Reporte empresa',
            //         "className": 'btn header-item noti-icon btn-personalizado-xlxs',
            //         "excelStyles": {
            //             "template": 'blue_medium',
            //         },
            //     },
            // ],

            // "order": [[0, "asc"]],

            "columns": [
                { "data": "id", visible: true},
                { "data": "logo", class: "logo", visible: true },
                { "data": "nombre", class: "nombre", visible: true },
                { "data": "descripcion", class: "descripcion", visible: true },
                { "data": "telefono", class: "telefono", visible: false },
                { "data": "whatsapp", class: "whatsapp", visible: false },
                { "data": "ubicacion", class: "ubicacion", visible: false },
                { "data": "longitud", class: "longitud", visible: false },
                { "data": "latitud", class: "latitud", visible: false },
            ],

            "columnDefs": [
                {
                    "targets": 9,
                    "render": function (data, type, row, meta) {
                        return '<div>\
                                    <ul class="list-inline mb-0 font-size-16">\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Editar" class="text-success p-1 update-empresa"><i class="bx bxs-edit-alt"></i></a>\
                                        </li>\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Eliminar" class="text-danger p-1 delete-empresa"><i class="bx bxs-trash"></i></a>\
                                        </li>\
                                    </ul>\
                                </div>';
                    },
                    "class": "text-center"
                }
            ]
        });

        // Evento de clic en las filas de la tabla
        $('#get_empresa_datatable tbody').on('click', 'tr .logo', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empresa.fn_copyToClipboardempresa(data.logo);
        });

        $('#get_empresa_datatable tbody').on('click', 'tr .nombre', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empresa.fn_copyToClipboardempresa(data.nombre);
        });

        $('#get_empresa_datatable tbody').on('click', 'tr .descripcion', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empresa.fn_copyToClipboardempresa(data.descripcion);
        });

        $('#get_empresa_datatable tbody').on('click', 'tr .telefono', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empresa.fn_copyToClipboardempresa(data.telefono);
        });

        $('#get_empresa_datatable tbody').on('click', 'tr .whatsapp', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empresa.fn_copyToClipboardempresa(data.whatsapp);
        });

        $('#get_empresa_datatable tbody').on('click', 'tr .ubicacion', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empresa.fn_copyToClipboardempresa(data.ubicacion);
        });

        $('#get_empresa_datatable tbody').on('click', 'tr .longitud', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empresa.fn_copyToClipboardempresa(data.longitud);
        });

        $('#get_empresa_datatable tbody').on('click', 'tr .latitud', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            empresa.fn_copyToClipboardempresa(data.latitud);
        });

        // FIN Evento de clic en las filas de la tabla
        //////////////////////////////////////////////////////////////////////

       // Aplicar la búsqueda
        $("#get_empresa_datatable thead tr:eq(1) th").each(function (i) {
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

        empresa.fn_update_empresa();
        empresa.fn_delete_empresa();
    },

    fn_scroll_empresa: function() {

        let AppScroll = angular.module('app-scroll-empresa', ['infinite-scroll']);
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

                let id_empresa= $("#id_empresa").val();
                if (id_empresa == 0) {
                    return;
                }

                if (this.busy) {
                    return;
                }
                this.busy = true;

                let url = "get_empresa_diez?id_empresa=" + this.after + "&callback=JSON_CALLBACK&X-CSRF-TOKEN="+$('meta[name="csrf-token"]').attr('content');
                $http.jsonp(url).success(function(data) {
                    let items = data;
                    if (Array.isArray(items)) {
                        for (let i = 0; i < items.length; i++) {
                            this.items.push(items[i]);
                        }
                        this.after = this.items[this.items.length - 1].id_empresa;
                        this.busy = false;
                    } else {
                        $("#id_empresa").val(0);
                        this.busy = false;
                    }
                }.bind(this)).error(function(data, status, headers, config) {

                });
            };
            return Reddit;
        });
    },

    fn_copyToClipboardempresa: function(text) {
        // Crear un elemento temporal de input
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
    },

    fn_set_empresa: function () {

            $('#smartwizardEmpresa').smartWizard({
                selected: 0,
                theme: 'dots',
                justified: true,
                toolbar: {
                    showNextButton: true,
                    showPreviousButton: true,
                    position: 'bottom',
                    extraHtml: `<button type="submit" class="btn btn-success sw-btn d-none" id="comprar-checkout">Guardar</button>`
                },
                lang: {
                    next: 'Siguiente',
                    previous: 'Atrás'
                },
                keyboard: {
                    keyNavigation: false, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
                    keyLeft: [37], // Left key code
                    keyRight: [39] // Right key code
                }
            });

            $("#form_empresa").validate({
                submitHandler: function (form) {
                    let get_form = document.getElementById("form_empresa");
                    let postData = new FormData(get_form);

                    let element_by_id= 'form_empresa';
                    let message=  'Cargando...' ;
                    let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                    $.ajax({
                        url: "set_empresa",
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
                                $('#get_empresa_datatable').DataTable().ajax.reload();
                                document.getElementById("form_empresa").reset();
                                $('#modalFormIUempresa').modal('hide');
                            } else {
                                alert(json);
                            }
                        
                        },
                        error: function (response) {
                            console.log("response", response);
                            $loading.waitMe('hide');
                        }
                    });

                },
                rules: {
                    nombre: {
                        required: true
                    },
                    descripcion: {
                        required: true
                    }
                },
                messages: {
                    nombre: {
                        required: "Por favor ingrese el nombre de la empresa"
                    },
                    descripcion: {
                        required: "Por favor ingrese la descripción de la empresa"
                    }
                },
                ignore: "", // Esta línea asegura que los campos ocultos también se validen
                errorPlacement: function(error, element) {
                    // Personaliza dónde y cómo se colocan los mensajes de error
                    error.insertAfter(element);
                }
            });

            // Set event to validate before moving to the next step
            $("#smartwizardEmpresa").on("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {

                if (stepDirection === 1 && $("#form_empresa").valid()) {
                    $(".sw-toolbar-elm .sw-btn-next").addClass('d-none');
                    $(".sw-toolbar-elm #comprar-checkout").removeClass('d-none');
                    return $("#form_empresa").valid();
                } else {
                    return $("#form_empresa").valid();
                }

                return true;
            });

            // Handle navigation button clicks
            $('.nexttab').on('click', function() {
                $('#smartwizardEmpresa').smartWizard("next");
            });

            $('.previestab').on('click', function() {
                $('#smartwizardEmpresa').smartWizard("prev");
            });
    },

    fn_modalShowempresa: function () {
        $('#modalFormIUempresa').on('shown.bs.modal', function (e) {
            $('#logo', e.target).focus();

            var logoUploadInput = document.getElementById('logoUpload');
            var urlFoto= $('#logoEmpresa').val();
            logoUploadInput.setAttribute('data-fileuploader-default', urlFoto);

            // empresa.googleMaps();
            // $("#location-map").css("width", "100%");
            // $("#map_canvas").css("width", "100%");


            if (!$('#form_empresa #id').length) {
                empresa.initializeFileUploader('');
            } else {
                empresa.fnShowbyIDPromocion();
            }


        });

        $('#modalImportFormempresa').on('shown.bs.modal', function (e) {
            $('#vc_importar', e.target).focus();
        });
    },

    fn_modalHideempresa: function () {

        $('#modalFormIUempresa').on('hidden.bs.modal', function (e) {

            $('#smartwizardEmpresa').smartWizard("reset");

            if ( $(".tipo-ya-existe").length ){
                $(".tipo-ya-existe").addClass("d-none");
            }

            if ( $("#vCampo1_pruebas").length ){
                $("#vCampo1_pruebas").removeClass("border-danger text-danger");
            }

            if ( $("#form_empresa").length ){
                $("#form_empresa input").removeClass("border-danger").removeClass("text-danger");
            }

            let validator = $("#form_empresa").validate();

            validator.resetForm();
            $("label.error").hide();
            $(".error").removeClass("error");
            
            if ($("#id").length)
            {
                $("#id").remove();
            }
            
            if ($("#form_empresa").length){
                document.getElementById("form_empresa").reset();
            }

            if ($("#form_import_empresa").length){
                document.getElementById("form_import_empresa").reset();
            }
        });
    },

    fn_AgregarNuevoempresa: function () {
        $(document).on("click", "#add_new_empresa", function () {
            document.getElementById("form_empresa").reset();            
            $("#modalFormIUempresa .modal-title").html("Nuevo");
        });
    },

    fn_actualizarTablaempresa: function () {
        $(document).on("click", "#refresh_empresa", function () {

            if ($("#get_empresa_datatable").length){
                $('#get_empresa_datatable').DataTable().ajax.reload();
            }

        });
    },

    fn_truncateSPSempresa: function () {
        $.ajax({
            url:"truncate_sps_empresa",
            cache: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function(response)
            {
                if ($("#get_empresa_datatable").length){
                    $('#get_empresa_datatable').DataTable().ajax.reload();
                }
            }
        });
    },

    fn_truncateempresa: function () {
        $.ajax({
            url:"truncate_empresa",
            cache: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function(response)
            {
                if ($("#get_empresa_datatable").length){
                    $('#get_empresa_datatable').DataTable().ajax.reload();
                }
            }
        });
    },

    fn_importar_excel_empresa: function() {

        // si no existe el elemento terminar...
        if (! $('#FormImportarempresa').length)
            return;

        let $form = $('#FormImportarempresa');

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
                    $.post('files/assets/js/lumic/fileuploader-2.2/examples/drag-drop-form/php/ajax_remove_file_empresa.php', {
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

            let element_by_id= 'FormImportarempresa';
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

                    document.getElementById("FormImportarempresa").reset();
                    $form.find('input[type="submit"]').removeAttr('disabled');
                    $loading.waitMe('hide');

                    $("#modalImportFormempresa").modal("hide");
                    $('#get_empresa_datatable').DataTable().ajax.reload();

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

    fn_Catempresa: function(){

        $.ajax({
            url:"get_cat_empresa",
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
                        // #id_cat_empresa' 

                        if ($("#id_cat_empresa").length){
                            $("#id_cat_empresa").append("<option value="+j['id']+"> "+j['logo']+" </option>");
                        }
                    });
                }

            }
        });
    },

    fn_set_validar_existencia_empresa: function(){

        $( "#logo" ).keyup(function( event ) {

            var id=0;
            // Si se esta editando return
            if ( $("#modalFormIUempresa #id").length ){
                id= $("#modalFormIUempresa #id").val();
            }

            let logo= this.value;

            if(logo ==""){
                $("#modalFormIUempresa .btn-action-form").attr("disabled",false);
                $("#logo").removeClass("border-danger").removeClass("text-danger");
                $(".tipo-ya-existe").addClass("d-none");
                return;
            }

            $.ajax({
                url: "validar_existencia_empresa",
                data: { logo: logo, id: id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'GET',
                contentType: "application/json",
                success: function (response) {

                    var json = JSON.parse(response);

                    if (json['b_status']) {
                        $("#modalFormIUempresa .btn-action-form").attr("disabled",true);
                        $("#logo").addClass("border-danger").addClass("text-danger");
                        $(".tipo-ya-existe").removeClass("d-none");
                    } else {
                        $("#modalFormIUempresa .btn-action-form").attr("disabled",false);
                        $("#logo").removeClass("border-danger").removeClass("text-danger");
                        $(".tipo-ya-existe").addClass("d-none");
                    }
                },
            });

        });
    },

    fn_update_empresa: function(){

        $('#get_empresa_datatable tbody').on('click', '.update-empresa', function () {
            // Abrir modal!
            $('#modalFormIUempresa').modal('show');

            let id = this.id;
            document.getElementById("form_empresa").reset();

            if ($("#id").length)
            {
                $("#id").remove();
            }

            $("#form_empresa").prepend('<input type="hidden" name="id" id="id" value=" '+ id +' ">');

            $("#modalFormIUempresa .modal-title").html("Editar");

            let element_by_id= 'form_empresa';
            let message=  'Cargando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"get_empresa_by_id",
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

                                            if (key == "logo_url") {
                                                $('#logoEmpresa').val('');
                                                $('#logoEmpresa').val(p[0][key]);
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

    fn_delete_empresa: function(){
        $('#get_empresa_datatable tbody').on('click', '.delete-empresa', function () {

            document.getElementById("form_empresa").reset();
            $("label.error").hide();
            $(".error").removeClass("error");

            let id = this.id;
            let element_by_id= 'form_empresa';
            let message=  'Eliminando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"delete_empresa",
                data: {"id": id},
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                    success: function(response)
                    {

                        $('#get_empresa_datatable').DataTable().ajax.reload();
                        $('#modalFormIUempresa').modal('hide');
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
                                            url:"undo_delete_empresa",
                                            data: {"id" : id},
                                            cache: false,
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                            type: 'POST',
                                                success: function(response)
                                                {
                                                    n.close();
                                                    $('#get_empresa_datatable').DataTable().ajax.reload();

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

    googleMaps: function()
    {
        setTimeout(function() {
            var input = document.getElementById('target');
            var searchBox = new google.maps.places.SearchBox(input);
            var markers = [];

            let v_verificar_lat = $("#latitude").val();
            let v_lat = $("#latitude").val();
            let v_lng = $("#longitude").val();

            v_lat = v_lat === '' ? 25.68 : parseFloat(v_lat);
            v_lng = v_lng === '' ? -100.33 : parseFloat(v_lng);

            if ($("#form_empresa").length) {
                const map = new google.maps.Map(document.getElementById("map_canvas"), {
                    zoom: 15,
                    center: { lat: v_lat, lng: v_lng },
                });

                var marker = new google.maps.Marker({
                    map,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    position: { lat: v_lat, lng: v_lng },
                });

                // Actualiza latitud y longitud después de cargar el mapa
                $("#latitude").val(v_lat.toFixed(6));
                $("#longitude").val(v_lng.toFixed(6));

                marker.addListener("dragend", function(evt) {
                    $("#latitude").val(evt.latLng.lat().toFixed(6));
                    $("#longitude").val(evt.latLng.lng().toFixed(6));
                    console.log("X ", evt.latLng.lat().toFixed(6));
                });

                google.maps.event.addListener(searchBox, 'places_changed', function() {
                    var places = searchBox.getPlaces();

                    for (var i = 0, marker; marker = markers[i]; i++) {
                        marker.setMap(null);
                    }

                    markers = [];
                    var bounds = new google.maps.LatLngBounds();
                    for (var i = 0, place; place = places[i]; i++) {
                        var image = {
                            url: place.icon,
                            size: new google.maps.Size(71, 71),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(25, 25)
                        };

                        var marker = new google.maps.Marker({
                            map,
                            draggable: true,
                            animation: google.maps.Animation.DROP,
                            position: place.geometry.location
                        });

                        marker.addListener("dragend", function(evt) {
                            $("#latitude").val(evt.latLng.lat().toFixed(6));
                            $("#longitude").val(evt.latLng.lng().toFixed(6));
                        });

                        markers.push(marker);

                        bounds.extend(place.geometry.location);
                    }
                    map.fitBounds(bounds);

                    let v_lo = bounds.getCenter().lng();
                    let v_la = bounds.getCenter().lat();

                    $("#latitude").val(v_la.toFixed(6));
                    $("#longitude").val(v_lo.toFixed(6));
                });
            }

            if (v_verificar_lat !== '') {
                const map = new google.maps.Map(document.getElementById("map_canvas"), {
                    zoom: 15,
                    center: { lat: v_lat, lng: v_lng },
                });

                var marker = new google.maps.Marker({
                    map,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    position: { lat: v_lat, lng: v_lng },
                });

                // Actualiza latitud y longitud después de cargar el mapa
                $("#latitude").val(v_lat.toFixed(6));
                $("#longitude").val(v_lng.toFixed(6));

                marker.addListener("dragend", function(evt) {
                    $("#latitude").val(evt.latLng.lat().toFixed(6));
                    $("#longitude").val(evt.latLng.lng().toFixed(6));
                });

                google.maps.event.addListener(searchBox, 'places_changed', function() {
                    var places = searchBox.getPlaces();

                    for (var i = 0, marker; marker = markers[i]; i++) {
                        marker.setMap(null);
                    }

                    markers = [];
                    var bounds = new google.maps.LatLngBounds();
                    for (var i = 0, place; place = places[i]; i++) {
                        var image = {
                            url: place.icon,
                            size: new google.maps.Size(71, 71),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(25, 25)
                        };

                        var marker = new google.maps.Marker({
                            map,
                            draggable: true,
                            animation: google.maps.Animation.DROP,
                            position: place.geometry.location
                        });

                        marker.addListener("dragend", function(evt) {
                            $("#latitude").val(evt.latLng.lat().toFixed(6));
                            $("#longitude").val(evt.latLng.lng().toFixed(6));
                        });

                        markers.push(marker);

                        bounds.extend(place.geometry.location);
                    }
                    map.fitBounds(bounds);

                    let v_lo = bounds.getCenter().lng();
                    let v_la = bounds.getCenter().lat();

                    $("#latitude").val(v_la.toFixed(6));
                    $("#longitude").val(v_lo.toFixed(6));
                });
            }
        }, 1000);
    },

    initializeFileUploader: function(preloadedFiles) {

        // enable fileupload plugin
        $('input[name="logoUpload"]').fileuploader({
            limit: 2,
            extensions: ['image/*'],
            fileMaxSize: 10,
            changeInput: ' ',
            theme: 'avatar',
            addMore: true,
            enableApi: true,
            thumbnails: {
                box: '<div class="fileuploader-wrapper">' +
                        '<div class="fileuploader-items"></div>' +
                        '<div class="fileuploader-droparea" data-action="fileuploader-input"><i class="fileuploader-icon-main"></i></div>' +
                       '</div>' +
                        '<div class="fileuploader-menu">' +
                            '<button type="button" class="fileuploader-menu-open"><i class="fileuploader-icon-menu"></i></button>' +
                            '<ul>' +
                                '<li><a data-action="fileuploader-input"><i class="fileuploader-icon-upload"></i> ${captions.upload}</a></li>' +
                                '<li><a data-action="fileuploader-edit"><i class="fileuploader-icon-edit"></i> ${captions.edit}</a></li>' +
                                '<li><a data-action="fileuploader-remove"><i class="fileuploader-icon-trash"></i> ${captions.remove}</a></li>' +
                            '</ul>' +
                        '</div>',
                item: '<div class="fileuploader-item">' +
                          '${image}' +
                          '<span class="fileuploader-action-popup" data-action="fileuploader-edit"></span>' +
                          '<div class="progressbar3" style="display: none"></div>' +
                        '</div>',
                item2: null,
                itemPrepend: true,
                startImageRenderer: true,
                canvasImage: false,
                _selectors: {
                    list: '.fileuploader-items'
                },
                popup: {
                    arrows: false,
                    onShow: function(item) {
                        item.popup.html.addClass('is-for-avatar');
                        item.popup.html.on('click', '[data-action="remove"]', function(e) {
                            item.popup.close();
                            item.remove();
                        }).on('click', '[data-action="cancel"]', function(e) {
                            item.popup.close();
                        }).on('click', '[data-action="save"]', function(e) {
                            if (item.editor && !item.isSaving) {
                                item.isSaving = true;
                                item.editor.save();
                            }
                            if (item.popup.close)
                                item.popup.close();
                        });
                    },
                    onHide: function(item) {
                        if (!item.isSaving && !item.uploaded && !item.appended) {
                            item.popup.close = null;
                            item.remove();
                        }
                    }   
                },
                onItemShow: function(item) {
                    if (item.choosed)
                        item.html.addClass('is-image-waiting');
                },
                onImageLoaded: function(item, listEl, parentEl, newInputEl, inputEl) {
                    if (item.choosed && !item.isSaving) {
                        if (item.reader.node && item.reader.width >= 256 && item.reader.height >= 256) {
                            item.image.hide();
                            item.popup.open();
                            item.editor.cropper();
                        } else {
                            item.remove();
                            alert('The image is too small!');
                        }
                    } else if (item.data.isDefault)
                        item.html.addClass('is-default');
                    else if (item.image.hasClass('fileuploader-no-thumbnail'))
                        item.html.hide();
                },
                onItemRemove: function(html) {
                    html.fadeOut(250, function() {
                        html.remove();
                    });
                }
            },
            dragDrop: {
                container: '.fileuploader-wrapper'
            },
            editor: {
                maxWidth: 512,
                maxHeight: 512,
                quality: 90,
                cropper: {
                    showGrid: false,
                    ratio: '1:1',
                    minWidth: 256,
                    minHeight: 256,
                },
                onSave: function(base64, item, listEl, parentEl, newInputEl, inputEl) {
                    var api = $.fileuploader.getInstance(inputEl);
                    
                    if (!base64)
                        return;

                    // blob
                    item.editor._blob = api.assets.dataURItoBlob(base64, item.type);
                    
                    if (item.upload) {
                        if (api.getFiles().length == 2 && (api.getFiles()[0].data.isDefault || api.getFiles()[0].upload))
                            api.getFiles()[0].remove();
                        parentEl.find('.fileuploader-menu ul a').show();
                        
                        if (item.upload.send)
                            return item.upload.send();
                        if (item.upload.resend)
                            return item.upload.resend();
                    } else if (item.appended) {
                        var form = new FormData();
                        
                        // hide current thumbnail (this is only animation)
                        item.image.addClass('fileuploader-loading').html('');
                        item.html.find('.fileuploader-action-popup').hide();
                        parentEl.find('[data-action="fileuploader-edit"]').hide();
                        
                        // send ajax
                        form.append(inputEl.attr('name'), item.editor._blob);
                        form.append('fileuploader', true);
                        form.append('name', item.name);
                        form.append('editing', true);
                        $.ajax({
                            url: api.getOptions().upload.url,
                            data: form,
                            type: 'POST',
                            processData: false,
                            contentType: false
                        }).always(function() {
                            delete item.isSaving;
                            item.reader.read(function() {
                                item.html.find('.fileuploader-action-popup').show();
                                parentEl.find('[data-action="fileuploader-edit"]').show();
                                item.popup.html = item.popup.node = item.popup.editor = item.editor.crop = item.editor.rotation = item.popup.zoomer = null;
                                item.renderThumbnail();
                            }, null, true);
                        });
                    }
                }
            },
            upload: {
                url: 'ajax_upload_file',
                data: null, // should be null
                type: 'POST',
                enctype: 'multipart/form-data',
                start: false,
                beforeSend: function(item, listEl, parentEl, newInputEl, inputEl) {
                    item.upload.formData = new FormData();

                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    item.upload.formData.append('_token', csrfToken);

                    if (item.editor && item.editor._blob) {
                        item.upload.data.fileuploader = 1;
                        item.upload.data.name = item.name;
                        item.upload.data.editing = item.uploaded;

                        item.upload.formData.append(inputEl.attr('name'), item.editor._blob, item.name);
                    }

                    item.image.hide();
                    item.html.removeClass('upload-complete');
                    parentEl.find('[data-action="fileuploader-edit"]').hide();
                    this.onProgress({percentage: 0}, item);
                },
                onSuccess: function(result, item, listEl, parentEl, newInputEl, inputEl) {

                    var api = $.fileuploader.getInstance(inputEl),
                        $progressBar = item.html.find('.progressbar3'),
                        data = {};
                    
                    if (result && result.files)
                        data = result;
                    else
                        data.hasWarnings = true;
                    
                    if (api.getFiles().length > 1)
                        api.getFiles()[0].remove();
                    
                    // if success
                    if (data.isSuccess && data.files[0]) {
                        item.name = data.files[0].name;
                    }
                    
                    // if warnings
                    if (data.hasWarnings) {
                        for (var warning in data.warnings) {
                            alert(data.warnings[warning]);
                        }
                        
                        item.html.removeClass('upload-successful').addClass('upload-failed');
                        return this.onError ? this.onError(item) : null;
                    }
                    
                    delete item.isSaving;
                    item.html.addClass('upload-complete').removeClass('is-image-waiting');
                    $progressBar.find('span').html('<i class="fileuploader-icon-success"></i>');
                    parentEl.find('[data-action="fileuploader-edit"]').show();
                    setTimeout(function() {
                        $progressBar.fadeOut(450);
                    }, 1250);
                    item.image.fadeIn(250);
                },
                onError: function(item, listEl, parentEl, newInputEl, inputEl) {
                    var $progressBar = item.html.find('.progressbar3');
                    
                    item.html.addClass('upload-complete');
                    if (item.upload.status != 'cancelled')
                        $progressBar.find('span').attr('data-action', 'fileuploader-retry').html('<i class="fileuploader-icon-retry"></i>');
                },
                onProgress: function(data, item) {
                    var $progressBar = item.html.find('.progressbar3');
                    
                    if (data.percentage == 0)
                        $progressBar.addClass('is-reset').fadeIn(250).html('');
                    else if (data.percentage >= 99)
                        data.percentage = 100;
                    else
                        $progressBar.removeClass('is-reset');
                    if (!$progressBar.children().length)
                        $progressBar.html('<span></span><svg><circle class="progress-dash"></circle><circle class="progress-circle"></circle></svg>');
                    
                    var $span = $progressBar.find('span'),
                        $svg = $progressBar.find('svg'),
                        $bar = $svg.find('.progress-circle'),
                        hh = Math.max(60, item.html.height() / 2),
                        radius = Math.round(hh / 2.28),
                        circumference = radius * 2 * Math.PI,
                        offset = circumference - data.percentage / 100 * circumference;
                    
                    $svg.find('circle').attr({
                        r: radius,
                        cx: hh,
                        cy: hh
                    });
                    $bar.css({
                        strokeDasharray: circumference + ' ' + circumference,
                        strokeDashoffset: offset
                    });
                    
                    $span.html(data.percentage + '%');
                },
                onComplete: null,
            },
            afterRender: function(listEl, parentEl, newInputEl, inputEl) {
                var api = $.fileuploader.getInstance(inputEl);
                
                // remove multiple attribute
                inputEl.removeAttr('multiple');
                
                // set drop container
                api.getOptions().dragDrop.container = parentEl.find('.fileuploader-wrapper');
                
                // disabled input
                if (api.isDisabled()) {
                    parentEl.find('.fileuploader-menu').remove();
                }
                
                // [data-action]
                parentEl.on('click', '[data-action]', function() {
                    var $this = $(this),
                        action = $this.attr('data-action'),
                        item = api.getFiles().length ? api.getFiles()[api.getFiles().length-1] : null;
                    
                    switch (action) {
                        case 'fileuploader-input':
                            api.open();
                            break;
                        case 'fileuploader-edit':
                            if (item && item.popup) {
                                if (!$this.is('.fileuploader-action-popup'))
                                    item.popup.open();
                                item.editor.cropper();
                            }
                            break;
                        case 'fileuploader-retry':
                            if (item && item.upload.retry)
                                item.upload.retry();
                            break;
                        case 'fileuploader-remove':
                            if (item)
                                item.remove();
                            break;
                    }
                });
                
                // menu
                $('body').on('click', function(e) {
                    var $target = $(e.target),
                        $parent = $target.closest('.fileuploader');

                    $('.fileuploader-menu').removeClass('is-shown');
                    if ($target.is('.fileuploader-menu-open') || $target.closest('.fileuploader-menu-open').length)
                        $parent.find('.fileuploader-menu').addClass('is-shown');
                });
            },
            onEmpty: function(listEl, parentEl, newInputEl, inputEl) {
                var api = $.fileuploader.getInstance(inputEl),
                    defaultAvatar = inputEl.attr('data-fileuploader-default');
                
                if (defaultAvatar && !listEl.find('> .is-default').length)
                    api.append({name: '', type: 'image/png', size: 0, file: defaultAvatar, data: {isDefault: true, popup: false, listProps: {is_default: true}}});
                
                parentEl.find('.fileuploader-menu ul a').hide().filter('[data-action="fileuploader-input"]').show();
            },
            onRemove: function(item) {
                if (item.name && (item.appended || item.uploaded))
                    $.post('ajax_remove_file', {
                        file: item.name,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    });
            },
            captions: $.extend(true, {}, $.fn.fileuploader.languages['en'], {
                edit: 'Edit',
                upload: 'Upload',
                remove: 'Remove',
                errors: {
                    filesLimit: 'Only 1 file is allowed to be uploaded.',
                }
            })
        });


    },

    fnShowbyIDPromocion: function(){
        let element_by_id= 'form_empresa';
        let message=  'Cargando...' ;
        let $loading= LibreriaGeneral.f_cargando(element_by_id, message);
        let id= 0;

        if ( $('#form_empresa #id').length ){
            id= $('#form_empresa #id').val();
        }

        $.ajax({
            url:"get_empresa_by_id",
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
                    let preloadedFiles = json['preloadedFiles'];

                    // Inicializar de nuevo el fileuploader con archivos pre-cargados
                    empresa.initializeFileUploader(preloadedFiles);

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
                                        $("#" + key).prop('type') == "tel") {
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
                } else {
                    alert("Revisar console para mas detalle");
                    console.log(json);
                }
            },
            error: function(response)
            {
                $loading.waitMe('hide');
            }
        });
    },

    fn_eventos_extra_empresa: function(){
    },



};

empresa.init();