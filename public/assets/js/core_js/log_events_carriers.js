let logEventsCarriers = {

    init: function () {
        // logEventsCarriersController
        // sp_get_log_events_carriers
        // log_events_carriersjs

        // Funciones principales
        logEventsCarriers.fn_datatable_log_events_carriers(rango_fecha='');
        logEventsCarriers.fn_truncatelog_events_carriers();

    },

    fn_datatable_log_events_carriers: function (rango_fecha) {

        let table = $('#get_log_events_carriers_datatable').DataTable({
            "stateSave": true,
            "serverSide": true,
            "destroy": true,
            "responsive": false,
            "pageLength": 10,
            "scrollCollapse": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "ajax": {
                "url": "get_log_events_carriers_by_datatable",
                "type": "GET",
                "data": function(d) {
                    d.buscar_id_cliente = $('#buscar_id_cliente').val();
                    d.buscar_carrier = $('#buscar_carrier').val();
                    d.buscar_evento = $('#buscar_evento').val();
                    d.buscar_descripcion = $('#buscar_descripcion').val();
                    d.buscar_creado = $('#buscar_creado').val();
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
                                                    <p class="text-muted mb-0">Hemos buscado en más de 50 Registros No encontramos ningún registro para su búsqueda.\
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
            },

            "columns": [
                { "data": "id" , visible: true},
                { "data": "id_cliente", class: "id_cliente"},
                { "data": "carrier" },
                { "data": "evento" },
                { "data": "descripcion" },
                { "data": "creado" },
            ],

            "columnDefs": [
                {
                    "targets": 6,
                    "render": function (data, type, row, meta) {
                        return '<div>\
                                    <ul class="list-inline mb-0 font-size-16">\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Editar" class="text-success p-1 update-log_events_carriers"><i class="bx bxs-edit-alt"></i></a>\
                                        </li>\
                                        <li class="list-inline-item">\
                                            <a href="javascript: void(0);" id="' + row.id + '" data-toggle="tooltip" title="Eliminar" class="text-danger p-1 delete-log_events_carriers"><i class="bx bxs-trash"></i></a>\
                                        </li>\
                                    </ul>\
                                </div>';
                    },
                    "class": "text-center"
                }
            ]
        });

        // Evento de clic en las filas de la tabla
        $('#get_log_events_carriers_datatable tbody').on('click', 'tr .id_cliente', function () {
            // Obtener los datos de la fila en la que se hizo clic
            let data = table.row(this).data();

            // Copiar el valor del email al portapapeles
            logEventsCarriers.fn_copyToClipboardlogEventsCarriers(data.id);
        });

       // Aplicar la búsqueda
        $("#get_log_events_carriers_datatable thead tr:eq(1) th").each(function (i) {
            $('input', this).on('keyup change', function () {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });
    },

    fn_copyToClipboardlogEventsCarriers: function(text) {
        // Crear un elemento temporal de input
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
    },

    fn_truncatelog_events_carriers: function () {
        $(document).on("click", "#refresh_log_events_carriers", function () {
            if ($("#get_log_events_carriers_datatable").length){
                $('#get_log_events_carriers_datatable').DataTable().ajax.reload();
            }
        });

        $(document).on("click", "#truncate_log_events_carriers", function () {
            $.ajax({
                url:"truncate_log_events_carriers",
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                success: function(response)
                {
                    if ($("#get_log_events_carriers_datatable").length){
                        $('#get_log_events_carriers_datatable').DataTable().ajax.reload();
                    }
                }
            });
        });
    },

    fn_eventos_extra_log_events_carriers: function(){
    },

};

logEventsCarriers.init();