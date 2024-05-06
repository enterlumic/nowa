let kpiTopClientes = {

    init: function () {

        // Funciones principales
        kpiTopClientes.fn_set_kpi_top_clientes();
        kpiTopClientes.fn_set_import_kpi_top_clientes();
        kpiTopClientes.fn_datatable_kpi_top_clientes(rango_fecha='');
        kpiTopClientes.fn_scroll_kpi_top_clientes();
        kpiTopClientes.fn_importar_excel_kpi_top_clientes();
        kpiTopClientes.fn_truncatekpi_top_clientes();

        // Funciones para eventos
        kpiTopClientes.fn_modalShowkpiTopClientes();
        kpiTopClientes.fn_modalHidekpiTopClientes();
        kpiTopClientes.fn_AgregarNuevokpiTopClientes();
        kpiTopClientes.fn_actualizarTablakpiTopClientes();
        kpiTopClientes.fn_CatkpiTopClientes();
        kpiTopClientes.fn_set_validar_existencia_kpi_top_clientes();

        // Funciones principales que se encuentran en controlador >> kpiTopClientesController
        // ===============================================================

        // Store procedure
        // sp_get_kpi_top_clientes
        // sp_set_kpi_top_clientes
        // sp_importar_kpi_top_clientes
        // sp_delete_kpi_top_clientes
        // sp_get_by_id_kpi_top_clientes

        // Llenar la tabla
        // get_kpi_top_clientes_by_datatable 

        // Agregar o actualizar un registro
        // set_kpi_top_clientes 

        // Importar registros
        // set_import_kpi_top_clientes

        // Truncate table útil para hacer pruebas
        // truncate_kpi_top_clientes

        // Trar una lista por si se ocupa como un catalogo util para llenar un combo
        // get_cat_kpi_top_clientes

        // Útil para validar si ya existe un registro en la bd 
        // validar_existencia_kpi_top_clientes

        // Obtener un registro por id se usa cuando se intenta actualizar un registro
        // get_kpi_top_clientes_by_id

        // Se utiliza para eliminar un registro en la tabla
        // delete_kpi_top_clientes

        // FIN Funciones principales que se encuentran en los controladores

        // ===============================================================
    },

    fn_datatable_kpi_top_clientes: function (rango_fecha) {

        let table = $('#get_kpi_top_clientes_datatable').DataTable({
            "stateSave": false,
            "serverSide": true,
            "destroy": true,
            "responsive": false,
            "pageLength": 10,
            "scrollCollapse": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": {
                "url": "get_kpi_top_clientes_by_datatable",
                "type": "GET",
                "data": function(d) {
                    d.buscar_Cliente = $('#buscar_Cliente').val();
                    d.buscar_Gerencia = $('#buscar_Gerencia').val();
                    d.buscar_Asesor = $('#buscar_Asesor').val();
                    d.buscar_Tipo = $('#buscar_Tipo').val();
                    d.buscar_ACTUAL = $('#buscar_ACTUAL').val();
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
            //         title: 'Reporte kpiTopClientes',
            //         className: 'btn header-item noti-icon btn-personalizado-xlxs',
            //         excelStyles: {
            //             template: 'blue_medium',
            //         },
            //     },
            // ],
            // "buttons": [
            //     {
            //         "extend": 'excel',
            //         "title": 'Reporte kpiTopClientes',
            //         "className": 'btn header-item noti-icon btn-personalizado-xlxs',
            //         "excelStyles": {
            //             "template": 'blue_medium',
            //         },
            //     },
            // ],

            "columns": [
                { "data": "id" , visible: false},
                { "data": "Cliente", class: "Cliente"},
                { "data": "Gerencia", class: "Gerencia" },
                { "data": "Asesor", class: "Asesor" },
                { "data": "Tipo", class: "Tipo" },
                { "data": "ACTUAL", class: "ACTUAL" },
                { "data": "PREVIOUS_MONTH" },
            ],

            "columnDefs": [
                {
                    "targets": 7,
                    "render": function (data, type, row, meta) {
                        return '<div>\
                                    <ul class="list-inline mb-0 font-size-16">\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Editar" class="text-success p-1 update-kpi_top_clientes"><i class="bx bxs-edit-alt"></i></a>\
                                        </li>\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Eliminar" class="text-danger p-1 delete-kpi_top_clientes"><i class="bx bxs-trash"></i></a>\
                                        </li>\
                                    </ul>\
                                </div>';
                    },
                    "class": "text-center"
                }
            ]
        });

        // Evento de clic en las filas de la tabla
        $('#get_kpi_top_clientes_datatable tbody').on('click', 'tr .Cliente', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            kpiTopClientes.fn_copyToClipboardkpiTopClientes(data.id);
        });

        $('#get_kpi_top_clientes_datatable tbody').on('click', 'tr .Gerencia', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            kpiTopClientes.fn_copyToClipboardkpiTopClientes(data.id);
        });

        $('#get_kpi_top_clientes_datatable tbody').on('click', 'tr .Asesor', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            kpiTopClientes.fn_copyToClipboardkpiTopClientes(data.id);
        });

        $('#get_kpi_top_clientes_datatable tbody').on('click', 'tr .Tipo', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            kpiTopClientes.fn_copyToClipboardkpiTopClientes(data.id);
        });

        $('#get_kpi_top_clientes_datatable tbody').on('click', 'tr .ACTUAL', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            kpiTopClientes.fn_copyToClipboardkpiTopClientes(data.id);
        });


        // FIN Evento de clic en las filas de la tabla


       // Aplicar la búsqueda
        $("#get_kpi_top_clientes_datatable thead tr:eq(1) th").each(function (i) {
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

        kpiTopClientes.fn_update_kpi_top_clientes();
        kpiTopClientes.fn_delete_kpi_top_clientes();
    },

    fn_scroll_kpi_top_clientes: function() {

        let AppScroll = angular.module('app-scroll-kpi_top_clientes', ['infinite-scroll']);
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

                let id_kpi_top_clientes= $("#id_kpi_top_clientes").val();
                if (id_kpi_top_clientes == 0) {
                    return;
                }

                if (this.busy) {
                    return;
                }
                this.busy = true;

                let url = "get_kpi_top_clientes_diez?id_kpi_top_clientes=" + this.after + "&callback=JSON_CALLBACK&X-CSRF-TOKEN="+$('meta[name="csrf-token"]').attr('content');
                $http.jsonp(url).success(function(data) {
                    let items = data;
                    if (Array.isArray(items)) {
                        for (let i = 0; i < items.length; i++) {
                            this.items.push(items[i]);
                        }
                        this.after = this.items[this.items.length - 1].id_kpi_top_clientes;
                        this.busy = false;
                    } else {
                        $("#id_kpi_top_clientes").val(0);
                        this.busy = false;
                    }
                }.bind(this)).error(function(data, status, headers, config) {

                });
            };
            return Reddit;
        });
    },

    fn_copyToClipboardkpiTopClientes: function(text) {
        // Crear un elemento temporal de input
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
    },

    fn_set_kpi_top_clientes: function () {
        $("#form_kpi_top_clientes").validate({
            submitHandler: function (form) {
                let get_form = document.getElementById("form_kpi_top_clientes");
                let postData = new FormData(get_form);

                let element_by_id= 'form_kpi_top_clientes';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_kpi_top_clientes",
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
                            $('#get_kpi_top_clientes_datatable').DataTable().ajax.reload();
                            document.getElementById("form_kpi_top_clientes").reset();
                            $('#modalFormIUkpiTopClientes').modal('hide');
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
              Cliente: {
                required: true
              }
            }
            , messages: {
                Cliente: {
                    minlength: "El Cliente es requerido"
                }
              }
        });
    },

    fn_set_import_kpi_top_clientes: function () {
        $("#form_import_kpi_top_clientes").validate({
            submitHandler: function (form) {
                let get_form = document.getElementById("form_import_kpi_top_clientes");
                let postData = new FormData(get_form);

                let element_by_id= 'form_import_kpi_top_clientes';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_import_kpi_top_clientes",
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
                            $('#get_kpi_top_clientes_datatable').DataTable().ajax.reload();
                            document.getElementById("form_import_kpi_top_clientes").reset();
                            $('#modalImportFormkpiTopClientes').modal('hide');
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
              Cliente: {
                required: true
              }
            }
            , messages: {
                Cliente: {
                    minlength: "Mensaje personalizado Cliente"
                }
              }
        });
    },

    fn_modalShowkpiTopClientes: function () {
        $('#modalFormIUkpiTopClientes').on('shown.bs.modal', function (e) {
            $('#Cliente', e.target).focus();
        });

        $('#modalImportFormkpiTopClientes').on('shown.bs.modal', function (e) {
            $('#vc_importar', e.target).focus();
        });
    },

    fn_modalHidekpiTopClientes: function () {

        $('#modalFormIUkpiTopClientes').on('hidden.bs.modal', function (e) {

            if ( $(".tipo-ya-existe").length ){
                $(".tipo-ya-existe").addClass("d-none");
            }

            if ( $("#vCampo1_pruebas").length ){
                $("#vCampo1_pruebas").removeClass("border-danger text-danger");
            }

            if ( $("#form_kpi_top_clientes").length ){
                $("#form_kpi_top_clientes input").removeClass("border-danger").removeClass("text-danger");
            }

            let validator = $("#form_kpi_top_clientes").validate();

            validator.resetForm();
            $("label.error").hide();
            $(".error").removeClass("error");
            
            if ($("#id").length)
            {
                $("#id").remove();
            }
            
            if ($("#form_kpi_top_clientes").length){
                document.getElementById("form_kpi_top_clientes").reset();
            }

            if ($("#form_import_kpi_top_clientes").length){
                document.getElementById("form_import_kpi_top_clientes").reset();
            }
        });
    },

    fn_AgregarNuevokpiTopClientes: function () {
        $(document).on("click", "#add_new_kpi_top_clientes", function () {
            document.getElementById("form_kpi_top_clientes").reset();            
            $("#modalFormIUkpiTopClientes .modal-title").html("Nuevo");
        });
    },

    fn_actualizarTablakpiTopClientes: function () {
        $(document).on("click", "#refresh_kpi_top_clientes", function () {

            if ($("#get_kpi_top_clientes_datatable").length){
                $('#get_kpi_top_clientes_datatable').DataTable().ajax.reload();
            }

        });
    },

    fn_truncatekpi_top_clientes: function () {
        $(document).on("click", "#truncate_kpi_top_clientes", function () {
            $.ajax({
                url:"truncate_kpi_top_clientes",
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                success: function(response)
                {
                    if ($("#get_kpi_top_clientes_datatable").length){
                        $('#get_kpi_top_clientes_datatable').DataTable().ajax.reload();
                    }
                }
            });
        });
    },

    fn_importar_excel_kpi_top_clientes: function() {

        // si no existe el elemento terminar...
        if (! $('#FormImportarkpiTopClientes').length)
            return;

        let $form = $('#FormImportarkpiTopClientes');

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
                    $.post('files/assets/js/lumic/fileuploader-2.2/examples/drag-drop-form/php/ajax_remove_file_kpi_top_clientes.php', {
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

            let element_by_id= 'FormImportarkpiTopClientes';
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

                    document.getElementById("FormImportarkpiTopClientes").reset();
                    $form.find('input[type="submit"]').removeAttr('disabled');
                    $loading.waitMe('hide');

                    $("#modalImportFormkpiTopClientes").modal("hide");
                    $('#get_kpi_top_clientes_datatable').DataTable().ajax.reload();

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

    fn_CatkpiTopClientes: function(){

        $.ajax({
            url:"get_cat_kpi_top_clientes",
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
                        // #id_cat_kpi_top_clientes' 

                        if ($("#id_cat_kpi_top_clientes").length){
                            $("#id_cat_kpi_top_clientes").append("<option value="+j['id']+"> "+j['Cliente']+" </option>");
                        }
                    });
                }

            }
        });
    },

    fn_set_validar_existencia_kpi_top_clientes: function(){

        $( "#Cliente" ).keyup(function( event ) {

            var id=0;
            // Si se esta editando return
            if ( $("#modalFormIUkpiTopClientes #id").length ){
                id= $("#modalFormIUkpiTopClientes #id").val();
            }

            let Cliente= this.value;

            if(Cliente ==""){
                $("#modalFormIUkpiTopClientes .btn-action-form").attr("disabled",false);
                $("#Cliente").removeClass("border-danger").removeClass("text-danger");
                $(".tipo-ya-existe").addClass("d-none");
                return;
            }

            $.ajax({
                url: "validar_existencia_kpi_top_clientes",
                data: { Cliente: Cliente, id: id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'GET',
                contentType: "application/json",
                success: function (response) {

                    var json = JSON.parse(response);

                    if (json['b_status']) {
                        $("#modalFormIUkpiTopClientes .btn-action-form").attr("disabled",true);
                        $("#Cliente").addClass("border-danger").addClass("text-danger");
                        $(".tipo-ya-existe").removeClass("d-none");
                    } else {
                        $("#modalFormIUkpiTopClientes .btn-action-form").attr("disabled",false);
                        $("#Cliente").removeClass("border-danger").removeClass("text-danger");
                        $(".tipo-ya-existe").addClass("d-none");
                    }
                },
            });

        });
    },

    fn_update_kpi_top_clientes: function(){

        $('#get_kpi_top_clientes_datatable tbody').on('click', '.update-kpi_top_clientes', function () {
            // Abrir modal!
            $('#modalFormIUkpiTopClientes').modal('show');

            let id = this.id;
            document.getElementById("form_kpi_top_clientes").reset();

            if ($("#id").length)
            {
                $("#id").remove();
            }

            $("#form_kpi_top_clientes").prepend('<input type="hidden" name="id" id="id" value=" '+ id +' ">');

            $("#modalFormIUkpiTopClientes .modal-title").html("Editar");

            let element_by_id= 'form_kpi_top_clientes';
            let message=  'Cargando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"get_kpi_top_clientes_by_id",
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

    fn_delete_kpi_top_clientes: function(){
        $('#get_kpi_top_clientes_datatable tbody').on('click', '.delete-kpi_top_clientes', function () {

            document.getElementById("form_kpi_top_clientes").reset();
            $("label.error").hide();
            $(".error").removeClass("error");

            let id = this.id;
            let element_by_id= 'form_kpi_top_clientes';
            let message=  'Eliminando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"delete_kpi_top_clientes",
                data: {"id": id},
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                    success: function(response)
                    {

                        $('#get_kpi_top_clientes_datatable').DataTable().ajax.reload();
                        $('#modalFormIUkpiTopClientes').modal('hide');
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
                                            url:"undo_delete_kpi_top_clientes",
                                            data: {"id" : id},
                                            cache: false,
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                            type: 'POST',
                                                success: function(response)
                                                {
                                                    n.close();
                                                    $('#get_kpi_top_clientes_datatable').DataTable().ajax.reload();

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

    fn_eventos_extra_kpi_top_clientes: function(){
    },

};

kpiTopClientes.init();