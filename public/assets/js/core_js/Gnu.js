var Gnu = {

    init: function(){
        let url= LibreriaGeneral.url();
        Gnu.get_perfil();
        Gnu.cerrar_session();
        Gnu.buscador(url);
        Gnu.exportar_excel();
    },

    close: function(){
        var objWindow = window.open(location.href, "_self");
        objWindow.close();
    },

    buscador: function(url){

        $(document).on('shown.bs.modal', function (e) {
            $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
        });

        $("#exportar-xlxs").attr("data-reporte-type", url).attr("Descargar");
        $("#envio-cron").attr("data-reporte-type", url).attr("Programar envio");

        if (url == 'desepenio'){
            Gnu.habilitarBotonExportarExcelYCalendario();
        }

        Gnu.Calendario(url);
    },

    get_perfil: function(){
        $.ajax({
            url:"get_perfil_usuario_by_id",
            cache: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'GET',
            success: function(response)
            {
                try {
                    var result = JSON.stringify(result);
                    var json = JSON.parse(response);
                } catch (e) {
                    console.log(response);
                }

                if (json["b_status"]) {                    
                    var p = json['data'];

                    if ($('.rounded-circle').length){
                        $('.rounded-circle').attr('src', p[0]['photo']);
                    }
                } 
                else 
                {
                    // console.log(json);
                }
            },
            error: function(response)
            {
            }
        });
    },

    exportar_excel: function(){
        $(document).on("click", "#exportar-xlxs", function(){

            let TipoReporte = this.getAttribute("data-reporte-type");
            let vc_parametro_busqueda= $("#buscar_reporte").val();

            $(".s-exportando").removeClass("d-none");
            $("#exportar-xlxs").attr("disabled", true);

        });
    },


    f_eliminar_archivo_ya_exportado: function(nombre_archivo){

        $.ajax({
            url:"eliminar_archivo_ya_exportado",
            data: {nombre_archivo: nombre_archivo},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'POST',
            success: function(response)
            {
                console.log("success", response);
            },
            error: function(response)
            {
                console.log("error", response);
            }
        });
    },

    cerrar_session: function(){
        $(document).on("click" , "#Logout", function(){
            $.ajax({
                url:"logout",
                cache: false,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'POST',
                success: function(response)
                {
                    window.location.href = "login";
                },
                error: function(response)
                {
                    console.log(0);
                }
            });
        });
    },

    html_dashboard: function(json){
        $(json['data']['DestinosMasUsados']).each(function(k, v) {
            let htmlDirecciones = '<div class="row align-items-center g-2">\
                              <div class="col-auto">\
                                  <div class="p-2">\
                                      <h6 class="mb-0">' + v['Direccion'] + '</h6>\
                                  </div>\
                              </div>\
                              <div class="col">\
                                  <div class="p-2">\
                                      <div class="progress animated-progress progress-sm">\
                                          <div class="progress-bar bg-primary" role="progressbar" style="width: ' + v['CuentaDireccion'] +
                '%" aria-valuenow="' + v['CuentaDireccion'] + '" aria-valuemin="0" aria-valuemax="100"></div>\
                                      </div>\
                                  </div>\
                              </div>\
                              <div class="col-auto">\
                                  <div class="p-2">\
                                      <h6 class="mb-0 text-muted">' + v['CuentaDireccion'] + '</h6>\
                                  </div>\
                              </div>\
                          </div>'
            $("#destinos-mas-usados").append(htmlDirecciones);
        });

        $(json['data']['PaqueteriaEnvio']).each(function(k, v) {
            let htmlDirecciones = '<div class="row align-items-center g-2">\
                              <div class="col-auto">\
                                  <div class="p-2">\
                                      <h6 class="mb-0">' + v['label'] + '</h6>\
                                  </div>\
                              </div>\
                              <div class="col">\
                                  <div class="p-2">\
                                      <div class="progress animated-progress progress-sm">\
                                          <div class="progress-bar bg-primary" role="progressbar" style="width: ' + v['CuentaEnvio'] +
                '%" aria-valuenow="' + v['CuentaEnvio'] + '" aria-valuemin="0" aria-valuemax="100"></div>\
                                      </div>\
                                  </div>\
                              </div>\
                              <div class="col-auto">\
                                  <div class="p-2">\
                                      <h6 class="mb-0 text-muted">' + v['CuentaEnvio'] + '</h6>\
                                  </div>\
                              </div>\
                          </div>'
            $("#servicios-mas-usados").append(htmlDirecciones);
        });


        let PesoPromedio= isNaN(json['data']['PesoPromedio']) ? 0 : json['data']['PesoPromedio'];
        let CostoPromedio= isNaN(json['data']['CostoPromedio']) ? 0 : json['data']['CostoPromedio'];
        let Guias= isNaN(json['data']['Guias']) ? 0 : json['data']['Guias'];

        $('#i_total_guia').html(Guias);
        $('#i_costo_promedio').html((Math.round(CostoPromedio * 100) / 100).toFixed());
        $('#i_peso_promedio').html((Math.round( PesoPromedio* 100) / 100).toFixed());        
    },

    formatDate: function(date){

        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join('-');
    },

    habilitarBotonExportarExcelYCalendario: function(){
        $('#exportar-xlxs').removeClass('d-none');
        $('#tooltip-container').removeClass('d-none');
        $("#buscar_reporte").val(LibreriaGeneral.FechaActual());
    },

    Calendario: function(url){

        let restar_dia = -1;

        if (url == 'cortes_por_hora'){
            let restar_dia = 0;
        }

        flatpickr("#rango_fecha", {
            onChange: function(selectedDates, dateStr, instance) {

                if ( dateStr.indexOf("a") >= 0 || selectedDates.length == 2 ){
                    $("#buscar_reporte").val(dateStr);

                    if ( $(".fecha-dicamico").length ){
                        $(".fecha-dicamico").html(dateStr);
                    }

                    if (url == 'desepenio'){
                        Desepenio.datatable_Desepenio(dateStr);
                    }
                }
            },
            "mode": 'range',
            weekNumbers: true,
            "locale": "es",
            "maxDate": new Date().fp_incr(restar_dia),
            onDayCreate: function (dObj, dStr, fp, dayElem) {
                        if (dayElem.dateObj.getDay() === 0 ) {
                            dayElem.className += " flatpickr-disabled nextMonthDayflatpickr-disabled";
                        }
            },
        });
    }
};

Gnu.init();


