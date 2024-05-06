let pruebasXxxx = {

    init: function () {

        // Funciones principales
        pruebasXxxx.fn_set_pruebas_xxxx();
        pruebasXxxx.fn_set_import_pruebas_xxxx();
        pruebasXxxx.fn_datatable_pruebas_xxxx(rango_fecha='');
        pruebasXxxx.fn_scroll_pruebas_xxxx();
        pruebasXxxx.fn_importar_excel_pruebas_xxxx();
        pruebasXxxx.fn_truncatepruebas_xxxx();

        // Funciones para eventos
        pruebasXxxx.fn_modalShowpruebasXxxx();
        pruebasXxxx.fn_modalHidepruebasXxxx();
        pruebasXxxx.fn_AgregarNuevopruebasXxxx();
        pruebasXxxx.fn_actualizarTablapruebasXxxx();
        pruebasXxxx.fn_CatpruebasXxxx();
        pruebasXxxx.fn_set_validar_existencia_pruebas_xxxx();

        // Funciones principales que se encuentran en controlador >> pruebasXxxxController
        // ===============================================================

        // Llenar la tabla
        // get_pruebas_xxxx_by_datatable 

        // Agregar o actualizar un registro
        // set_pruebas_xxxx 

        // Importar registros
        // set_import_pruebas_xxxx

        // Truncate table útil para hacer pruebas
        // truncate_pruebas_xxxx

        // Trar una lista por si se ocupa como un catalogo util para llenar un combo
        // get_cat_pruebas_xxxx

        // Útil para validar si ya existe un registro en la bd 
        // validar_existencia_pruebas_xxxx

        // Obtener un registro por id se usa cuando se intenta actualizar un registro
        // get_pruebas_xxxx_by_id

        // Se utiliza para eliminar un registro en la tabla
        // delete_pruebas_xxxx

        // FIN Funciones principales que se encuentran en los controladores

        // ===============================================================
    },

    fn_datatable_pruebas_xxxx: function (rango_fecha) {

        let table = $('#get_pruebas_xxxx_datatable').DataTable({
            "stateSave": false,
            "serverSide": true,
            "destroy": true,
            "responsive": false,
            "pageLength": 10,
            "scrollCollapse": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": {
                "url": "get_pruebas_xxxx_by_datatable",
                "type": "GET",
                "data": function(d) {
                    d.searchvCampo1_pruebas_xxxx = $('#searchvCampo1_pruebas_xxxx').val();
                    d.searchvCampo2_pruebas_xxxx = $('#searchvCampo2_pruebas_xxxx').val();
                    d.searchvCampo3_pruebas_xxxx = $('#searchvCampo3_pruebas_xxxx').val();
                    d.searchvCampo4_pruebas_xxxx = $('#searchvCampo4_pruebas_xxxx').val();
                    d.searchvCampo5_pruebas_xxxx = $('#searchvCampo5_pruebas_xxxx').val();
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
            //         title: 'Reporte pruebasXxxx',
            //         className: 'btn header-item noti-icon btn-personalizado-xlxs',
            //         excelStyles: {
            //             template: 'blue_medium',
            //         },
            //     },
            // ],
            // "buttons": [
            //     {
            //         "extend": 'excel',
            //         "title": 'Reporte pruebasXxxx',
            //         "className": 'btn header-item noti-icon btn-personalizado-xlxs',
            //         "excelStyles": {
            //             "template": 'blue_medium',
            //         },
            //     },
            // ],

            "columns": [
                { "data": "id" , visible: false},
                { "data": "vCampo1_pruebas_xxxx", class: "vCampo1_pruebas_xxxx"},
                { "data": "vCampo2_pruebas_xxxx" },
                { "data": "vCampo3_pruebas_xxxx" },
                { "data": "vCampo4_pruebas_xxxx" },
                { "data": "vCampo5_pruebas_xxxx" },
                { "data": "vCampo6_pruebas_xxxx" },
                { "data": "vCampo7_pruebas_xxxx" },
                { "data": "vCampo8_pruebas_xxxx" },
                { "data": "vCampo9_pruebas_xxxx" },
                { "data": "vCampo10_pruebas_xxxx" },
            ],

            "columnDefs": [
                {
                    "targets": 11,
                    "render": function (data, type, row, meta) {
                        return '<div>\
                                    <ul class="list-inline mb-0 font-size-16">\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Editar" class="text-success p-1 update-pruebas_xxxx"><i class="bx bxs-edit-alt"></i></a>\
                                        </li>\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Eliminar" class="text-danger p-1 delete-pruebas_xxxx"><i class="bx bxs-trash"></i></a>\
                                        </li>\
                                    </ul>\
                                </div>';
                    },
                    "class": "text-center"
                }
            ]
        });

        // Evento de clic en las filas de la tabla
        $('#get_pruebas_xxxx_datatable tbody').on('click', 'tr .vCampo1_pruebas_xxxx', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            adminUserTeiker.fn_copyToClipboardpruebasXxxx(data.id);
        });

       // Aplicar la búsqueda
        $("#get_pruebas_xxxx_datatable thead tr:eq(1) th").each(function (i) {
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

        pruebasXxxx.fn_update_pruebas_xxxx();
        pruebasXxxx.fn_delete_pruebas_xxxx();
    },

    fn_scroll_pruebas_xxxx: function() {

        let AppScroll = angular.module('app-scroll-pruebas_xxxx', ['infinite-scroll']);
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

                let id_pruebas_xxxx= $("#id_pruebas_xxxx").val();
                if (id_pruebas_xxxx == 0) {
                    return;
                }

                if (this.busy) {
                    return;
                }
                this.busy = true;

                let url = "get_pruebas_xxxx_diez?id_pruebas_xxxx=" + this.after + "&callback=JSON_CALLBACK&X-CSRF-TOKEN="+$('meta[name="csrf-token"]').attr('content');
                $http.jsonp(url).success(function(data) {
                    let items = data;
                    if (Array.isArray(items)) {
                        for (let i = 0; i < items.length; i++) {
                            this.items.push(items[i]);
                        }
                        this.after = this.items[this.items.length - 1].id_pruebas_xxxx;
                        this.busy = false;
                    } else {
                        $("#id_pruebas_xxxx").val(0);
                        this.busy = false;
                    }
                }.bind(this)).error(function(data, status, headers, config) {

                });
            };
            return Reddit;
        });
    },

    fn_copyToClipboardpruebasXxxx: function(text) {
        // Crear un elemento temporal de input
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
    },

    fn_set_pruebas_xxxx: function () {
        $("#form_pruebas_xxxx").validate({
            submitHandler: function (form) {
                let get_form = document.getElementById("form_pruebas_xxxx");
                let postData = new FormData(get_form);

                let element_by_id= 'form_pruebas_xxxx';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_pruebas_xxxx",
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
                            $('#get_pruebas_xxxx_datatable').DataTable().ajax.reload();
                            document.getElementById("form_pruebas_xxxx").reset();
                            $('#modalFormIUpruebasXxxx').modal('hide');
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
              vCampo1_pruebas_xxxx: {
                required: true
              }
            }
            , messages: {
                vCampo1_pruebas_xxxx: {
                    minlength: "El vCampo1_pruebas_xxxx es requerido"
                }
              }
        });
    },

    fn_set_import_pruebas_xxxx: function () {
        $("#form_import_pruebas_xxxx").validate({
            submitHandler: function (form) {
                let get_form = document.getElementById("form_import_pruebas_xxxx");
                let postData = new FormData(get_form);

                let element_by_id= 'form_import_pruebas_xxxx';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_import_pruebas_xxxx",
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
                            $('#get_pruebas_xxxx_datatable').DataTable().ajax.reload();
                            document.getElementById("form_import_pruebas_xxxx").reset();
                            $('#modalImportFormpruebasXxxx').modal('hide');
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
              vCampo1_pruebas_xxxx: {
                required: true
              }
            }
            , messages: {
                vCampo1_pruebas_xxxx: {
                    minlength: "Mensaje personalizado vCampo1_pruebas_xxxx"
                }
              }
        });
    },

    fn_modalShowpruebasXxxx: function () {
        $('#modalFormIUpruebasXxxx').on('shown.bs.modal', function (e) {
            $('#vCampo1_pruebas_xxxx', e.target).focus();
        });

        $('#modalImportFormpruebasXxxx').on('shown.bs.modal', function (e) {
            $('#vc_importar', e.target).focus();
        });
    },

    fn_modalHidepruebasXxxx: function () {

        $('#modalFormIUpruebasXxxx').on('hidden.bs.modal', function (e) {

            if ( $(".tipo-ya-existe").length ){
                $(".tipo-ya-existe").addClass("d-none");
            }

            if ( $("#vCampo1_pruebas").length ){
                $("#vCampo1_pruebas").removeClass("border-danger text-danger");
            }

            if ( $("#form_pruebas_xxxx").length ){
                $("#form_pruebas_xxxx input").removeClass("border-danger").removeClass("text-danger");
            }

            let validator = $("#form_pruebas_xxxx").validate();

            validator.resetForm();
            $("label.error").hide();
            $(".error").removeClass("error");
            
            if ($("#id").length)
            {
                $("#id").remove();
            }
            
            if ($("#form_pruebas_xxxx").length){
                document.getElementById("form_pruebas_xxxx").reset();
            }

            if ($("#form_import_pruebas_xxxx").length){
                document.getElementById("form_import_pruebas_xxxx").reset();
            }
        });
    },

    fn_AgregarNuevopruebasXxxx: function () {
        $(document).on("click", "#add_new_pruebas_xxxx", function () {
            document.getElementById("form_pruebas_xxxx").reset();            
            $("#modalFormIUpruebasXxxx .modal-title").html("Nuevo");
        });
    },

    fn_actualizarTablapruebasXxxx: function () {
        $(document).on("click", "#refresh_pruebas_xxxx", function () {

            if ($("#get_pruebas_xxxx_datatable").length){
                $('#get_pruebas_xxxx_datatable').DataTable().ajax.reload();
            }

        });
    },

    fn_truncatepruebas_xxxx: function () {
        $(document).on("click", "#truncate_pruebas_xxxx", function () {
            $.ajax({
                url:"truncate_pruebas_xxxx",
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                success: function(response)
                {
                    if ($("#get_pruebas_xxxx_datatable").length){
                        $('#get_pruebas_xxxx_datatable').DataTable().ajax.reload();
                    }
                }
            });
        });
    },

    fn_importar_excel_pruebas_xxxx: function() {

        // si no existe el elemento terminar...
        if (! $('#FormImportarpruebasXxxx').length)
            return;

        let $form = $('#FormImportarpruebasXxxx');

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
                    $.post('files/assets/js/lumic/fileuploader-2.2/examples/drag-drop-form/php/ajax_remove_file_pruebas_xxxx.php', {
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

            let element_by_id= 'FormImportarpruebasXxxx';
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

                    document.getElementById("FormImportarpruebasXxxx").reset();
                    $form.find('input[type="submit"]').removeAttr('disabled');
                    $loading.waitMe('hide');

                    $("#modalImportFormpruebasXxxx").modal("hide");
                    $('#get_pruebas_xxxx_datatable').DataTable().ajax.reload();

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

    fn_CatpruebasXxxx: function(){

        $.ajax({
            url:"get_cat_pruebas_xxxx",
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
                        // #id_cat_pruebas_xxxx' 

                        if ($("#id_cat_pruebas_xxxx").length){
                            $("#id_cat_pruebas_xxxx").append("<option value="+j['id']+"> "+j['vCampo1_pruebas_xxxx']+" </option>");
                        }
                    });
                }

            }
        });
    },

    fn_set_validar_existencia_pruebas_xxxx: function(){

        $( "#vCampo1_pruebas_xxxx" ).keyup(function( event ) {

            var id=0;
            // Si se esta editando return
            if ( $("#modalFormIUpruebasXxxx #id").length ){
                id= $("#modalFormIUpruebasXxxx #id").val();
            }

            let vCampo1_pruebas_xxxx= this.value;

            if(vCampo1_pruebas_xxxx ==""){
                $("#modalFormIUpruebasXxxx .btn-action-form").attr("disabled",false);
                $("#vCampo1_pruebas_xxxx").removeClass("border-danger").removeClass("text-danger");
                $(".tipo-ya-existe").addClass("d-none");
                return;
            }

            $.ajax({
                url: "validar_existencia_pruebas_xxxx",
                data: { vCampo1_pruebas_xxxx: vCampo1_pruebas_xxxx, id: id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'GET',
                contentType: "application/json",
                success: function (response) {

                    var json = JSON.parse(response);

                    if (json['b_status']) {
                        $("#modalFormIUpruebasXxxx .btn-action-form").attr("disabled",true);
                        $("#vCampo1_pruebas_xxxx").addClass("border-danger").addClass("text-danger");
                        $(".tipo-ya-existe").removeClass("d-none");
                    } else {
                        $("#modalFormIUpruebasXxxx .btn-action-form").attr("disabled",false);
                        $("#vCampo1_pruebas_xxxx").removeClass("border-danger").removeClass("text-danger");
                        $(".tipo-ya-existe").addClass("d-none");
                    }
                },
            });

        });
    },

    fn_update_pruebas_xxxx: function(){

        $('#get_pruebas_xxxx_datatable tbody').on('click', '.update-pruebas_xxxx', function () {
            // Abrir modal!
            $('#modalFormIUpruebasXxxx').modal('show');

            let id = this.id;
            document.getElementById("form_pruebas_xxxx").reset();

            if ($("#id").length)
            {
                $("#id").remove();
            }

            $("#form_pruebas_xxxx").prepend('<input type="hidden" name="id" id="id" value=" '+ id +' ">');

            $("#modalFormIUpruebasXxxx .modal-title").html("Editar");

            let element_by_id= 'form_pruebas_xxxx';
            let message=  'Cargando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"get_pruebas_xxxx_by_id",
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

    fn_delete_pruebas_xxxx: function(){
        $('#get_pruebas_xxxx_datatable tbody').on('click', '.delete-pruebas_xxxx', function () {

            document.getElementById("form_pruebas_xxxx").reset();
            $("label.error").hide();
            $(".error").removeClass("error");

            let id = this.id;
            let element_by_id= 'form_pruebas_xxxx';
            let message=  'Eliminando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"delete_pruebas_xxxx",
                data: {"id": id},
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                    success: function(response)
                    {

                        $('#get_pruebas_xxxx_datatable').DataTable().ajax.reload();
                        $('#modalFormIUpruebasXxxx').modal('hide');
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
                                            url:"undo_delete_pruebas_xxxx",
                                            data: {"id" : id},
                                            cache: false,
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                            type: 'POST',
                                                success: function(response)
                                                {
                                                    n.close();
                                                    $('#get_pruebas_xxxx_datatable').DataTable().ajax.reload();

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

    fn_eventos_extra_pruebas_xxxx: function(){
    },

};

pruebasXxxx.init();