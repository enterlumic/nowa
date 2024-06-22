let empresa = {

    init: function () {

        // Funciones principales
        empresa.fn_set_empresa();
        empresa.fn_set_import_empresa();
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
                { "data": "telefono", class: "telefono", visible: true },
                { "data": "whatsapp", class: "whatsapp", visible: true },
                { "data": "ubicacion", class: "ubicacion", visible: true },
                { "data": "longitud", class: "longitud", visible: true },
                { "data": "latitud", class: "latitud", visible: true },
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
                        $loading.waitMe('hide');
                    }
                });
            }
            , rules: {
              logo: {
                required: true
              }
            }
            , messages: {
                logo: {
                    minlength: "El logo es requerido"
                }
              }
        });
    },

    fn_set_import_empresa: function () {
        $("#form_import_empresa").validate({
            submitHandler: function (form) {
                let get_form = document.getElementById("form_import_empresa");
                let postData = new FormData(get_form);

                let element_by_id= 'form_import_empresa';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_import_empresa",
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
                            document.getElementById("form_import_empresa").reset();
                            $('#modalImportFormempresa').modal('hide');
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
              logo: {
                required: true
              }
            }
            , messages: {
                logo: {
                    minlength: "Mensaje personalizado logo"
                }
              }
        });
    },

    fn_modalShowempresa: function () {
        $('#modalFormIUempresa').on('shown.bs.modal', function (e) {
            $('#logo', e.target).focus();

            var button = $(event.relatedTarget);
            empresa.googleMaps();
            $("#location-map").css("width", "100%");
            $("#map_canvas").css("width", "100%");


        });

        $('#modalImportFormempresa').on('shown.bs.modal', function (e) {
            $('#vc_importar', e.target).focus();
        });
    },

    fn_modalHideempresa: function () {

        $('#modalFormIUempresa').on('hidden.bs.modal', function (e) {

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

    fn_eventos_extra_empresa: function(){
    },



};

empresa.init();