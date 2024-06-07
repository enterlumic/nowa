
let clienteConekta = {

    init: function () {

        // Funciones principales
        clienteConekta.fn_conekta_key();
        clienteConekta.fn_set_cliente_conekta();
        clienteConekta.fn_datatable_cliente_conekta(rango_fecha='');

        // Funciones para eventos
        clienteConekta.fn_modalShowclienteConekta();
        clienteConekta.fn_modalHideclienteConekta();
        clienteConekta.fn_AgregarNuevoclienteConekta();
        clienteConekta.fn_actualizarTablaclienteConekta();
    },

    fn_set_cliente_conekta: function () {

        $("#form_cliente_conekta").validate({
            submitHandler: function (form) {
                let get_form = document.getElementById("form_cliente_conekta");
                let element_by_id = 'form_cliente_conekta';
                let message = 'Cargando...';
                let $loading = LibreriaGeneral.f_cargando(element_by_id, message);

                // Inicia la generación del token de Conekta
                Conekta.Token.create(get_form, clienteConekta.conektaSuccessResponseHandler, clienteConekta.conektaErrorResponseHandler);

                return false; // Previene el envío automático del formulario
            },
            rules: {
                name: {
                    required: true
                }
            },
            messages: {
                  name: {
                      minlength: "El nombre es requerido"
                  }
            }
        });
    },

    conektaSuccessResponseHandler: function (token) {
        let get_form = document.getElementById("form_cliente_conekta");

        // Añadir el token al formulario
        $(get_form).append($('<input type="hidden" name="token_id" />').val(token.id));

        // Ahora enviar el formulario al backend
        let postData = new FormData(get_form);
        let element_by_id = 'form_cliente_conekta';
        let message = 'Cargando...';
        let $loading = LibreriaGeneral.f_cargando(element_by_id, message);

        $.ajax({
            url: "createCustomer",
            data: postData,
            cache: false,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function (response) {

                $loading.waitMe('hide');
                let json = '';
                try {
                    json = JSON.parse(response);
                } catch (e) {
                    alert(response);
                    return;
                }

                if (json["b_status"]) {

                    // Si no existe se esta agregando desde el checkout
                    if (!$('#get_cliente_conekta_datatable').length){
                        checkOut.fn_customerConnekta();
                        $('#modalFormIUclienteConekta').modal('hide');
                        return ;
                    }

                    // Solo aplica cuando se registra desde conekta
                    $('#get_cliente_conekta_datatable').DataTable().ajax.reload();
                    document.getElementById("form_cliente_conekta").reset();
                    $('#modalFormIUclienteConekta').modal('hide');
                } else {
                    alert(json);
                }

            },
            error: function (response) {
                $('#get_cliente_conekta_datatable').DataTable().ajax.reload();
                $loading.waitMe('hide');
            }
        });
    },

    conektaErrorResponseHandler: function (response) {
        let get_form = document.getElementById("form_cliente_conekta");
        $(get_form).find(".card-errors").text(response.message_to_purchaser);
        $(get_form).find("button").prop("disabled", false);
        let element_by_id = 'form_cliente_conekta';
        let $loading = LibreriaGeneral.f_cargando(element_by_id, 'Cargando...');
        $loading.waitMe('hide');
    },
    fn_datatable_cliente_conekta: function (rango_fecha) {

        // let columna = 
        let table = $('#get_cliente_conekta_datatable').DataTable({
            "stateSave": false,
            "serverSide": true,
            "destroy": true,
            "responsive": false,
            "pageLength": 10,
            "scrollCollapse": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": {
                "url": "get_cliente_conekta_datatable",
                "type": "GET",
                "data": function(d) {
                    d.buscar_name = $('#buscar_name').val();
                    d.buscar_number = $('#buscar_number').val();
                    d.buscar_cvc = $('#buscar_cvc').val();
                    d.buscar_exp_month = $('#buscar_exp_month').val();
                    d.buscar_exp_year = $('#buscar_exp_year').val();
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

            "order": [[0, "desc"]],

            "columns": [
                { "data": "id" , visible: true},
                { "data": "name", class: "name"},
                { "data": "number", class: "number" },
                { "data": "cvc", class: "cvc" },
                { "data": "exp_month", class: "exp_month" },
                { "data": "exp_year", class: "exp_year" },
            ],

            "columnDefs": [
                {
                    "targets": 5,
                    "render": function (data, type, row, meta) {
                        return '<div>\
                                    <ul class="list-inline mb-0 font-size-16">\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Editar" class="text-success p-1 update-cliente_conekta"><i class="bx bxs-edit-alt"></i></a>\
                                        </li>\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Eliminar" class="text-danger p-1 delete-cliente_conekta"><i class="bx bxs-trash"></i></a>\
                                        </li>\
                                    </ul>\
                                </div>';
                    },
                    "class": "text-center"
                }
            ]
        });

        // Evento de clic en las filas de la tabla
        $('#get_cliente_conekta_datatable tbody').on('click', 'tr .name', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            clienteConekta.fn_copyToClipboardclienteConekta(data.name);
        });

        $('#get_cliente_conekta_datatable tbody').on('click', 'tr .number', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            clienteConekta.fn_copyToClipboardclienteConekta(data.number);
        });

        $('#get_cliente_conekta_datatable tbody').on('click', 'tr .cvc', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            clienteConekta.fn_copyToClipboardclienteConekta(data.cvc);
        });

        $('#get_cliente_conekta_datatable tbody').on('click', 'tr .exp_month', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            clienteConekta.fn_copyToClipboardclienteConekta(data.exp_month);
        });

        $('#get_cliente_conekta_datatable tbody').on('click', 'tr .exp_year', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            clienteConekta.fn_copyToClipboardclienteConekta(data.exp_year);
        });

        // FIN Evento de clic en las filas de la tabla
        //////////////////////////////////////////////////////////////////////

       // Aplicar la búsqueda
        $("#get_cliente_conekta_datatable thead tr:eq(1) th").each(function (i) {
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

        clienteConekta.fn_update_cliente_conekta();
        clienteConekta.fn_delete_cliente_conekta();
    },

    fn_copyToClipboardclienteConekta: function(text) {
        // Crear un elemento temporal de input
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
    },

    fn_conekta_key: function() {

        $.ajax({
            url: '/conekta-key',
            method: 'GET',
            success: function(response) {
                Conekta.setPublicKey(response.key);
            },
            error: function() {
                console.error('Error al obtener la llave de Conekta');
            }
        });

        var conektaSuccessResponseHandler = function(token) {
            var $form = $("#form_cliente_conekta");
            $form.append($('<input type="text" name="conektaTokenId" />').val(token.id));
            $form.get(0).submit();
        };

        var conektaErrorResponseHandler = function(response) {
            var $form = $("#form_cliente_conekta");
            $form.find(".card-errors").text(response.message_to_purchaser);
            $form.find("button").prop("disabled", false);
        };
    },

    fn_modalShowclienteConekta: function () {
        $('#modalFormIUclienteConekta').on('shown.bs.modal', function (e) {
            $('#name', e.target).focus();
        });

        $('#modalImportFormclienteConekta').on('shown.bs.modal', function (e) {
            $('#vc_importar', e.target).focus();
        });
    },

    fn_modalHideclienteConekta: function () {

        $('#modalFormIUclienteConekta').on('hidden.bs.modal', function (e) {

            if ( $(".tipo-ya-existe").length ){
                $(".tipo-ya-existe").addClass("d-none");
            }

            if ( $("#vCampo1_pruebas").length ){
                $("#vCampo1_pruebas").removeClass("border-danger text-danger");
            }

            if ( $("#form_cliente_conekta").length ){
                $("#form_cliente_conekta input").removeClass("border-danger").removeClass("text-danger");
            }

            let validator = $("#form_cliente_conekta").validate();

            validator.resetForm();
            $("label.error").hide();
            $(".error").removeClass("error");
            
            if ($("#id").length)
            {
                $("#id").remove();
            }
            
            if ($("#form_cliente_conekta").length){
                document.getElementById("form_cliente_conekta").reset();
            }

        });
    },

    fn_AgregarNuevoclienteConekta: function () {
        $(document).on("click", "#add_new_cliente_conekta", function () {
            document.getElementById("form_cliente_conekta").reset();
            $("#modalFormIUclienteConekta .modal-title").html("Agregar nueva tarjeta");
        });
    },

    fn_actualizarTablaclienteConekta: function () {
        $(document).on("click", "#refresh_cliente_conekta", function () {

            if ($("#get_cliente_conekta_datatable").length){
                $('#get_cliente_conekta_datatable').DataTable().ajax.reload();
            }

        });
    },

    fn_update_cliente_conekta: function(){

        $('#get_cliente_conekta_datatable tbody').on('click', '.update-cliente_conekta', function () {
            // Abrir modal!
            $('#modalFormIUclienteConekta').modal('show');

            let id = this.id;
            document.getElementById("form_cliente_conekta").reset();

            if ($("#id").length)
            {
                $("#id").remove();
            }

            $("#form_cliente_conekta").prepend('<input type="hidden" name="id" id="id" value=" '+ id +' ">');

            $("#modalFormIUclienteConekta .modal-title").html("Editar tarjeta");

            let element_by_id= 'form_cliente_conekta';
            let message=  'Cargando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"get_cliente_conekta_by_id",
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

    fn_delete_cliente_conekta: function(){
        $('#get_cliente_conekta_datatable tbody').on('click', '.delete-cliente_conekta', function () {

            let id = this.id;
            let element_by_id= 'get_cliente_conekta_datatable';
            let message=  'Eliminando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"delete_cliente_conekta",
                data: {"id": id},
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                    success: function(response)
                    {

                        $('#get_cliente_conekta_datatable').DataTable().ajax.reload();
                        $('#modalFormIUclienteConekta').modal('hide');
                        $loading.waitMe('hide');

                    },
                    error: function(response)
                    {
                        $loading.waitMe('hide');
                    }
            });
        });  
    },

    _fnAddPaymentSource: function (customerId, token) {
        let get_form = document.getElementById("form_cliente_conekta");

        // Añadir el token al formulario
        $(get_form).append($('<input type="hidden" name="conektaTokenId" />').val(token.id));

        // Ahora enviar el formulario al backend
        let postData = new FormData(get_form);
        let element_by_id = 'form_cliente_conekta';
        let message = 'Cargando...';
        let $loading = LibreriaGeneral.f_cargando(element_by_id, message);

        $.ajax({
            url: "/addPaymentSource",
            data: postData,
            cache: false,
            processData: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function (response) {
                $loading.waitMe('hide');
                let json = '';
                try {
                    json = JSON.parse(response);
                } catch (e) {
                    alert(response);
                    return;
                }

                if (json["b_status"]) {
                    if (!$('#get_cliente_conekta_datatable').length) {
                        checkOut.fn_customerConnekta();
                        $('#modalFormIUclienteConekta').modal('hide');
                        return;
                    }
                    $('#get_cliente_conekta_datatable').DataTable().ajax.reload();
                    document.getElementById("form_cliente_conekta").reset();
                    $('#modalFormIUclienteConekta').modal('hide');
                } else {
                    alert(json);
                }
            },
            error: function (response) {
                $('#get_cliente_conekta_datatable').DataTable().ajax.reload();
                $loading.waitMe('hide');
            }
        });
    },

    fn_eventos_extra_cliente_conekta: function(){
    },

};

clienteConekta.init();