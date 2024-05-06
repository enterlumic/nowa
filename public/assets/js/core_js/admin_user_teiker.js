let adminUserTeiker = {

    init: function () {

        // Funciones principales
        adminUserTeiker.fn_datatable_admin_user_teiker();
        adminUserTeiker.copyToClipboard();

        // Funciones para eventos
        adminUserTeiker.fn_modalShowadminUserTeiker();
        adminUserTeiker.fn_modalHideadminUserTeiker();
        adminUserTeiker.fn_actualizarTablaadminUserTeiker();
    },

    fn_datatable_admin_user_teiker: function () {

        let table = $('#get_admin_user_teiker_datatable').DataTable({
            "stateSave": false,
            "serverSide": true,
            "destroy": true,
            "responsive": false,
            "pageLength": 10,
            "scrollCollapse": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": {
                "url": "get_admin_user_teiker_by_datatable",
                "type": "GET",
                "data": function(d) {
                    d.searchId = $('#searchId').val();
                    d.searchName = $('#searchName').val();
                    d.searchApellido = $('#searchApellido').val();
                    d.searchCorreo = $('#searchCorreo').val();
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
                { "data": "id" , class: "id-user", "orderable": false},
                { "data": "name" },
                { "data": "apellido" },
                { "data": "email" , class: "mail"},
                { "data": "email_verified_at" },
                { "data": "updated_at" },
                { "data": "password" ,visible: false},
                { "data": "pass_crypt" , visible: false},
                { "data": "referido" },
                { "data": "myrefcode" },
                { "data": "admin" },
                { "data": "telefono" },
            ],

            "columnDefs": [
                {
                    "targets": 12,
                    "render": function (data, type, row, meta) {
                        return '<div>\
                                    <ul class="list-inline mb-0 font-size-16">\
                                        <li class="list-inline-item">\
                                            <a href="#" class="text-success p-1 copy-email"  data-toggle="tooltip" title="Copiar email" data-email="' + row.email + '"><i class="bx bx-mail-send"></i></a>\
                                        </li>\
                                        <li class="list-inline-item">\
                                            <a href="#" class="text-success p-1 copy-id" data-toggle="tooltip" title="Copiar ID" data-id="' + row.id + '"><i class="bx  bx bx-walk"></i></a>\
                                        </li>\
                                    </ul>\
                                </div>';
                    },
                    "class": "text-center"
                }
            ],


        });

// get_list_maquila

       // Aplicar la búsqueda
        $("#get_admin_user_teiker_datatable thead tr:eq(1) th").each(function (i) {
            $('input', this).on('keyup change', function () {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        // Evento de clic en las filas de la tabla
        $('#get_admin_user_teiker_datatable tbody').on('click', 'tr .id-user', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            adminUserTeiker.copyToClipboard(data.id);

            LibreriaGeneral.NotyCore(titulo = ''
                , 'ID Copiado'
                , nFrom = 'top'
                , nAlign = 'center'
                , icon = 'feather icon-bell'
                , type = 'inverse'
                , animIn = 'animIn'
                , animOut = 'animOut');
        });

        // Evento de clic en las filas de la tabla
        $('#get_admin_user_teiker_datatable tbody').on('click', 'tr .mail', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            adminUserTeiker.copyToClipboard(data.email);

            LibreriaGeneral.NotyCore(titulo = ''
                , 'Mail Copiado'
                , nFrom = 'top'
                , nAlign = 'center'
                , icon = 'feather icon-bell'
                , type = 'inverse'
                , animIn = 'animIn'
                , animOut = 'animOut');
        });

       // Manejador de eventos para copiar email
        $('#get_admin_user_teiker_datatable tbody').on('click', '.copy-email', function (e) {
            e.preventDefault();
            var email = $(this).data('email');
            adminUserTeiker.copyToClipboard(email);

                LibreriaGeneral.NotyCore(titulo = ''
                    , 'Mail Copiado'
                    , nFrom = 'top'
                    , nAlign = 'center'
                    , icon = 'feather icon-bell'
                    , type = 'inverse'
                    , animIn = 'animIn'
                    , animOut = 'animOut');
        });

        // Manejador de eventos para copiar id
        $('#get_admin_user_teiker_datatable tbody').on('click', '.copy-id', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            adminUserTeiker.copyToClipboard(id);
        });

    },

    copyToClipboard: function(email) {
        // Crear un elemento temporal de input
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = email;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);

        // Actulizar la tabla de teiker.users
        $.ajax({
            url:"ActualizarUsersDate",
            data: {email: email},
            cache: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'GET'
        });
    },

    fn_modalShowadminUserTeiker: function () {
    },

    fn_modalHideadminUserTeiker: function () {
    },


    fn_actualizarTablaadminUserTeiker: function () {
        $(document).on("click", "#refresh_admin_user_teiker", function () {

            if ($("#get_admin_user_teiker_datatable").length){
                $('#get_admin_user_teiker_datatable').DataTable().ajax.reload();
            }

        });
    },

    fn_eventos_extra_admin_user_teiker: function(){
    },

};

adminUserTeiker.init();