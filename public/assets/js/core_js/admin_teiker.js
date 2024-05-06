let adminTeiker = {

    init: function () {

        // Funciones principales
        adminTeiker.fn_set_adminteiker();
        adminTeiker.fn_set_import_adminteiker();
        adminTeiker.fn_datatable_adminteiker(rango_fecha='');
        adminTeiker.fn_scroll_adminteiker();
        adminTeiker.fn_importar_excel_adminteiker();
        adminTeiker.fn_truncateadminteiker();

        // Funciones para eventos
        adminTeiker.fn_modalShowadminTeiker();
        adminTeiker.fn_modalHideadminTeiker();
        adminTeiker.fn_AgregarNuevoadminTeiker();
        adminTeiker.fn_actualizarTablaadminTeiker();
        adminTeiker.fn_CatadminTeiker();
        adminTeiker.fn_set_validar_existencia_adminteiker();
    },

    fn_datatable_adminteiker: function (rango_fecha) {

        let table = $('#get_adminteiker_datatable').DataTable({
            "stateSave": false,
            "serverSide": true,
            "destroy": true,
            "responsive": false,
            "pageLength": 10,
            "scrollCollapse": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": {
                "url": "get_adminteiker_by_datatable",
                "type": "GET",
                "data": {
                    "rango_fecha": rango_fecha
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
            //         title: 'Reporte adminTeiker',
            //         className: 'btn header-item noti-icon btn-personalizado-xlxs',
            //         excelStyles: {
            //             template: 'blue_medium',
            //         },
            //     },
            // ],
            // "buttons": [
            //     {
            //         "extend": 'excel',
            //         "title": 'Reporte adminTeiker',
            //         "className": 'btn header-item noti-icon btn-personalizado-xlxs',
            //         "excelStyles": {
            //             "template": 'blue_medium',
            //         },
            //     },
            // ],

            "columns": [
                { "data": "id" },
                { "data": "vCampo1_adminteiker" },
                { "data": "vCampo2_adminteiker" },
                { "data": "vCampo3_adminteiker" },
                { "data": "vCampo4_adminteiker" },
                { "data": "vCampo5_adminteiker" },
                { "data": "vCampo6_adminteiker" },
                { "data": "vCampo7_adminteiker" },
                { "data": "vCampo8_adminteiker" },
                { "data": "vCampo9_adminteiker" },
                { "data": "vCampo10_adminteiker" },
            ],

            "columnDefs": [
                {
                    "targets": 11,
                    "render": function (data, type, row, meta) {
                        return '<div>\
                                    <ul class="list-inline mb-0 font-size-16">\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Editar" class="text-success p-1 update-adminteiker"><i class="bx bxs-edit-alt"></i></a>\
                                        </li>\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Eliminar" class="text-danger p-1 delete-adminteiker"><i class="bx bxs-trash"></i></a>\
                                        </li>\
                                    </ul>\
                                </div>';
                    },
                    "class": "text-center"
                }
            ]
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

        adminTeiker.fn_update_adminteiker();
        adminTeiker.fn_delete_adminteiker();
    },

    fn_scroll_adminteiker: function() {

        let AppScroll = angular.module('app-scroll-adminteiker', ['infinite-scroll']);
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

                let id_adminteiker= $("#id_adminteiker").val();
                if (id_adminteiker == 0) {
                    return;
                }

                if (this.busy) {
                    return;
                }
                this.busy = true;

                let url = "get_adminteiker_diez?id_adminteiker=" + this.after + "&callback=JSON_CALLBACK&X-CSRF-TOKEN="+$('meta[name="csrf-token"]').attr('content');
                $http.jsonp(url).success(function(data) {
                    let items = data;
                    if (Array.isArray(items)) {
                        for (let i = 0; i < items.length; i++) {
                            this.items.push(items[i]);
                        }
                        this.after = this.items[this.items.length - 1].id_adminteiker;
                        this.busy = false;
                    } else {
                        $("#id_adminteiker").val(0);
                        this.busy = false;
                    }
                }.bind(this)).error(function(data, status, headers, config) {

                });
            };
            return Reddit;
        });

    },

    fn_set_adminteiker: function () {
        $("#form_adminteiker").validate({
            submitHandler: function (form) {
                let get_form = document.getElementById("form_adminteiker");
                let postData = new FormData(get_form);

                let element_by_id= 'form_adminteiker';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_adminteiker",
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
                            $('#get_adminteiker_datatable').DataTable().ajax.reload();
                            document.getElementById("form_adminteiker").reset();
                            $('#modalFormIUadminTeiker').modal('hide');
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
              vCampo1_adminteiker: {
                required: true
              }
            }
            , messages: {
                vCampo1_adminteiker: {
                    minlength: "El vCampo1_adminteiker es requerido"
                }
              }
        });
    },

    fn_set_import_adminteiker: function () {
        $("#form_import_adminteiker").validate({
            submitHandler: function (form) {
                let get_form = document.getElementById("form_import_adminteiker");
                let postData = new FormData(get_form);

                let element_by_id= 'form_import_adminteiker';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_import_adminteiker",
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
                            $('#get_adminteiker_datatable').DataTable().ajax.reload();
                            document.getElementById("form_import_adminteiker").reset();
                            $('#modalImportFormadminTeiker').modal('hide');
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
              vCampo1_adminteiker: {
                required: true
              }
            }
            , messages: {
                vCampo1_adminteiker: {
                    minlength: "Mensaje personalizado vCampo1_adminteiker"
                }
              }
        });
    },

    fn_modalShowadminTeiker: function () {
        $('#modalFormIUadminTeiker').on('shown.bs.modal', function (e) {
            $('#vCampo1_adminteiker', e.target).focus();
        });

        $('#modalImportFormadminTeiker').on('shown.bs.modal', function (e) {
            $('#vc_importar', e.target).focus();
        });
    },

    fn_modalHideadminTeiker: function () {

        $('#modalFormIUadminTeiker').on('hidden.bs.modal', function (e) {

            if ( $(".tipo-ya-existe").length ){
                $(".tipo-ya-existe").addClass("d-none");
            }

            if ( $("#vCampo1_pruebas").length ){
                $("#vCampo1_pruebas").removeClass("border-danger text-danger");
            }

            if ( $("#form_adminteiker").length ){
                $("#form_adminteiker input").removeClass("border-danger").removeClass("text-danger");
            }

            let validator = $("#form_adminteiker").validate();

            validator.resetForm();
            $("label.error").hide();
            $(".error").removeClass("error");
            
            if ($("#id").length)
            {
                $("#id").remove();
            }
            
            if ($("#form_adminteiker").length){
                document.getElementById("form_adminteiker").reset();
            }

            if ($("#form_import_adminteiker").length){
                document.getElementById("form_import_adminteiker").reset();
            }
        });

    },

    fn_AgregarNuevoadminTeiker: function () {
        $(document).on("click", "#add_new_adminteiker", function () {
            document.getElementById("form_adminteiker").reset();            
            $("#modalFormIUadminTeiker .modal-title").html("Nuevo");
        });
    },

    fn_actualizarTablaadminTeiker: function () {
        $(document).on("click", "#refresh_adminteiker", function () {

            if ($("#get_adminteiker_datatable").length){
                $('#get_adminteiker_datatable').DataTable().ajax.reload();
            }

        });
    },

    fn_truncateadminteiker: function () {
        $(document).on("click", "#truncate_adminteiker", function () {
            $.ajax({
                url:"truncate_adminteiker",
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                success: function(response)
                {
                    if ($("#get_adminteiker_datatable").length){
                        $('#get_adminteiker_datatable').DataTable().ajax.reload();
                    }
                }
            });
        });
    },

    fn_importar_excel_adminteiker: function() {

        // si no existe el elemento terminar...
        if (! $('#FormImportaradminTeiker').length)
            return;

        let $form = $('#FormImportaradminTeiker');

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
                    $.post('files/assets/js/lumic/fileuploader-2.2/examples/drag-drop-form/php/ajax_remove_file_adminteiker.php', {
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

            let element_by_id= 'FormImportaradminTeiker';
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

                    document.getElementById("FormImportaradminTeiker").reset();
                    $form.find('input[type="submit"]').removeAttr('disabled');
                    $loading.waitMe('hide');

                    $("#modalImportFormadminTeiker").modal("hide");
                    $('#get_adminteiker_datatable').DataTable().ajax.reload();

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

    fn_CatadminTeiker: function(){

        $.ajax({
            url:"get_cat_adminteiker",
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
                        // #id_cat_adminteiker' 

                        if ($("#id_cat_adminteiker").length){
                            $("#id_cat_adminteiker").append("<option value="+j['id']+"> "+j['vCampo1_adminteiker']+" </option>");
                        }
                    });
                }

            }
        });

    },

    fn_set_validar_existencia_adminteiker: function(){

        $( "#vCampo1_adminteiker" ).keyup(function( event ) {

            var id=0;
            // Si se esta editando return
            if ( $("#modalFormIUadminTeiker #id").length ){
                id= $("#modalFormIUadminTeiker #id").val();
            }

            let vCampo1_adminteiker= this.value;

            if(vCampo1_adminteiker ==""){
                $("#modalFormIUadminTeiker .btn-action-form").attr("disabled",false);
                $("#vCampo1_adminteiker").removeClass("border-danger").removeClass("text-danger");
                $(".tipo-ya-existe").addClass("d-none");
                return;
            }

            $.ajax({
                url: "validar_existencia_adminteiker",
                data: { vCampo1_adminteiker: vCampo1_adminteiker, id: id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'GET',
                contentType: "application/json",
                success: function (response) {

                    var json = JSON.parse(response);

                    if (json['b_status']) {
                        $("#modalFormIUadminTeiker .btn-action-form").attr("disabled",true);
                        $("#vCampo1_adminteiker").addClass("border-danger").addClass("text-danger");
                        $(".tipo-ya-existe").removeClass("d-none");
                    } else {
                        $("#modalFormIUadminTeiker .btn-action-form").attr("disabled",false);
                        $("#vCampo1_adminteiker").removeClass("border-danger").removeClass("text-danger");
                        $(".tipo-ya-existe").addClass("d-none");
                    }
                },
            });

        });
    },

    fn_update_adminteiker: function(){

        $('#get_adminteiker_datatable tbody').on('click', '.update-adminteiker', function () {
            // Abrir modal!
            $('#modalFormIUadminTeiker').modal('show');

            let id = this.id;
            document.getElementById("form_adminteiker").reset();

            if ($("#id").length)
            {
                $("#id").remove();
            }

            $("#form_adminteiker").prepend('<input type="hidden" name="id" id="id" value=" '+ id +' ">');

            $("#modalFormIUadminTeiker .modal-title").html("Editar");

            let element_by_id= 'form_adminteiker';
            let message=  'Cargando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"get_adminteiker_by_id",
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

    fn_delete_adminteiker: function(){
        $('#get_adminteiker_datatable tbody').on('click', '.delete-adminteiker', function () {

            document.getElementById("form_adminteiker").reset();
            $("label.error").hide();
            $(".error").removeClass("error");

            let id = this.id;
            let element_by_id= 'form_adminteiker';
            let message=  'Eliminando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"delete_adminteiker",
                data: {"id": id},
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                    success: function(response)
                    {

                        $('#get_adminteiker_datatable').DataTable().ajax.reload();
                        $('#modalFormIUadminTeiker').modal('hide');
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
                                            url:"undo_delete_adminteiker",
                                            data: {"id" : id},
                                            cache: false,
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                            type: 'POST',
                                                success: function(response)
                                                {
                                                    n.close();
                                                    $('#get_adminteiker_datatable').DataTable().ajax.reload();

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

    fn_eventos_extra_adminteiker: function(){
    },

};

adminTeiker.init();