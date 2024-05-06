var Skynet = {

    init: function () {

        // Funciones principales
        Skynet.set_Skynet();
        Skynet.set_import_Skynet();
        Skynet.datatable_Skynet();
        Skynet.truncateSkynet();

        // Funciones para eventos
        Skynet.modalShow();
        Skynet.modalHide();
        Skynet.AgregarNuevo();
        Skynet.actualizarTabla();
    },

    datatable_Skynet: function () {
        var table = $('#tb-datatable-skynet').DataTable({
            "stateSave": true,
            "order": [[0, 'desc']],
            "responsive": false,
            "serverSide": false,
            "pageLength": 50,
            "scrollCollapse": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": {
                "url": "get_skynet_by_datatable",
                "type": "GET",
                "data": {
                    "extra": 1
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
                "sLoadingRecords": "Cargando...",
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

            },
            "columnDefs": [{
                    "targets": 0,
                    "class": "text-center",
                    "visible": true,
                },
                {
                    "targets": 1,
                    "visible": false,
                },
                {
                    "targets": 2,
                    "visible": false,
                },
                {
                    "targets": 3,
                    "visible": false,
                },
                {
                    "targets": 4,
                    "render": function (data, type, row, meta) {
                        return  '<span class="badge badge-soft-primary"> '+row[2]+' </span>' + "<br>" + row[4];
                    },
                },
                {
                    "targets": 5,
                    "visible": false,
                    "render": function (data, type, row, meta) {
                        return '<div>\
                                <a href="javascript:void(0);" id="' + row[0] + '" class="fs-15 update-skynet"><i class="ri-edit-2-line"></i></a>\
                                <a href="javascript:void(0);" id="' + row[0] + '" class="link-success fs-15 delete-skynet" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Delete">\
                                    <i class="ri-delete-bin-line"></i>\
                                </a>\
                            </div>';
                    },
                    "class": "text-center"
                }
            ]
        });

        $('#tb-datatable-skynet tbody').on('click', '.delete-skynet', function () {

            document.getElementById("form_skynet").reset();
            $("label.error").hide();
            $(".error").removeClass("error");

            var id = this.id;

            let element_by_id= 'form_skynet';
            let message=  'Eliminando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"delete_skynet",
                data: {"id": id},
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                    success: function(response)
                    {
                        console.log("response", response);

                        $('#tb-datatable-skynet').DataTable().ajax.reload();
                        $('#modalFormIUSkynet').modal('hide');
                        $loading.waitMe('hide');

                        var n = new Noty({
                            type: "warning",
                            close: false,
                            text: "<b>Se movio a la papelera<b>" ,
                            layout: 'topCenter',
                            timeout: 20e3,
                                buttons: [
                                  Noty.button('Deshacer', 'btn btn-success btn-sm', function () {
                                        $.ajax({
                                            url:"undo_delete_skynet",
                                            data: {"id" : id},
                                            cache: false,
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                            type: 'POST',
                                                success: function(response)
                                                {
                                                    n.close();
                                                    $('#tb-datatable-skynet').DataTable().ajax.reload();

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

        $('#tb-datatable-skynet tbody').on('click', '.update-skynet', function () {
            // Abrir modal!
            $('#modalFormIUSkynet').modal('show');

            var id = this.id;
            document.getElementById("form_skynet").reset();

            if ($("#id").length)
            {
                $("#id").remove();
            }

            $("#form_skynet").prepend('<input type="hidden" name="id" id="id" value=" '+ id +' ">');

            $("#modalFormIUSkynet .modal-title").html("Editar skynet");

            let element_by_id= 'form_skynet';
            let message=  'Cargando...' ;
            let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

            $.ajax({
                url:"get_skynet_by_id",
                data: {id: id},
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                    success: function(response)
                    {
                        $loading.waitMe('hide');

                        try {
                            var result = JSON.stringify(result);
                            var json = JSON.parse(response);
                        } catch (e) {
                            console.log(response);
                        }

                        if (json["b_status"]) {
                            var p = json['data'];
                            for (var keyIni in p) {
                                for (var key in p[0]) {
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
                                                    var filename = p[0][key].replace(/^.*[\\\/]/, '')
                                                    $("#" + key).after("<a href=\"" + p[0][key] + "\" target=\"_blank\" class=\"external_link  abrir-" + key + " \"> " + filename.substr(0, 15) + " </a>");
                                                }
                                            }

                                            if ($("#" + key).prop('nodeName') == "SELECT") {
                                                console.log("key", key);
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

        $('#tb-datatable-skynet tbody').on( 'click', 'tr', function () {
            let html= table.row( this ).data()[2] + "\n" +table.row( this ).data()[4];

            html= html.replace('<pre>', '');
            html= html.replace('</pre>', '');

            var dummy = $('<textarea id="comodin">').val(html).appendTo('body').select();
            var v= document.execCommand('copy');
            $("#comodin").remove();

        } );

        // setInterval( function () {
        //     table.ajax.reload( null, false );
        //     console.log("actualizando tbl", true);
        // }, 5000 );

    },

    set_Skynet: function () {
        $("#form_skynet").validate({
            submitHandler: function (form) {
                var get_form = document.getElementById("form_skynet");
                var postData = new FormData(get_form);

                let element_by_id= 'form_skynet';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_skynet",
                    data: postData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    success: function (response) {
                        
                        console.log("response", response);

                        $loading.waitMe('hide');

                        try {
                            var json = JSON.parse(response);
                        } catch (e) {
                            alert(response);
                            return;
                        }

                        if (json["b_status"]) {
                            $('#tb-datatable-skynet').DataTable().ajax.reload();
                            document.getElementById("form_skynet").reset();
                            $('#modalFormIUSkynet').modal('hide');
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
              id_user_o_id_cliente: {
                required: true
              }
            }
            , messages: {
                id_user_o_id_cliente: {
                    minlength: "Mensaje personalizado id_user_o_id_cliente"
                }
              }
        });
    },

    set_import_Skynet: function () {
        $("#form_import_skynet").validate({
            submitHandler: function (form) {
                var get_form = document.getElementById("form_import_skynet");
                var postData = new FormData(get_form);

                let element_by_id= 'form_import_skynet';
                let message=  'Cargando...' ;
                let $loading= LibreriaGeneral.f_cargando(element_by_id, message);

                $.ajax({
                    url: "set_import_skynet",
                    data: postData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    success: function (response) {
                        
                        console.log("response", response);

                        $loading.waitMe('hide');

                        try {
                            var json = JSON.parse(response);
                        } catch (e) {
                            alert(response);
                            return;
                        }

                        if (json["b_status"]) {
                            $('#tb-datatable-skynet').DataTable().ajax.reload();
                            document.getElementById("form_import_skynet").reset();
                            $('#modalImportFormSkynet').modal('hide');
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
              id_user_o_id_cliente: {
                required: true
              }
            }
            , messages: {
                id_user_o_id_cliente: {
                    minlength: "Mensaje personalizado id_user_o_id_cliente"
                }
              }
        });
    },

    modalShow: function () {
        $('#modalFormIUSkynet').on('shown.bs.modal', function (e) {
            $('#id_user_o_id_cliente', e.target).focus();
        });

        $('#modalImportFormSkynet').on('shown.bs.modal', function (e) {
            $('#vc_importar', e.target).focus();
        });
    },

    modalHide: function () {
        $('#modalFormIUSkynet').on('hidden.bs.modal', function (e) {
            var validator = $("#form_skynet").validate();
            validator.resetForm();
            $("label.error").hide();
            $(".error").removeClass("error");
            
            if ($("#id").length)
            {
                $("#id").remove();
            }
            document.getElementById("form_skynet").reset();
            document.getElementById("form_import_skynet").reset();
        });
    },

    AgregarNuevo: function () {
        $(document).on("click", "#add_new_skynet", function () {
            document.getElementById("form_skynet").reset();            
            $("#modalFormIUSkynet .modal-title").html("Nuevo Skynet");
        });
    },

    actualizarTabla: function () {
        $(document).on("click", "#refresh_Skynet", function () {
            $('#tb-datatable-skynet').DataTable().ajax.reload();
            setTimeout(() => { }, 1000);
        });
    },

    truncateSkynet: function () {
        $(document).on("click", "#truncate_Skynet", function () {
            $.ajax({
                url:"truncate_Skynet",
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                    success: function(response)
                    {
                        $('#tb-datatable-skynet').DataTable().ajax.reload();
                    },
                    error: function(response)
                    {

                    }
            });
        });
    }

};

Skynet.init();