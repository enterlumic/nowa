var Notas = {

    init: function(){

        Notas.editor();
        Notas.eventos_clicks();
        Notas.eventos_teclado();
        Notas.datatable_Notas(stateSave= true, filtrar_nota= true, value= '');
        Notas.set_Notas();

        $('#modal_form_notas').on('shown.bs.modal', function (e) {
            $('#id_user', e.target).focus();
        });
        
        $('#modal_form_notas').on('hidden.bs.modal', function (e) {
            var validator = $( "#form_notas" ).validate();
            validator.resetForm();
            $("label.error").hide();
            $(".error").removeClass("error");           
        });

    },

    datatable_Notas: function(serverSide= true, filtrar_nota= true, value_filtrar_nota= ''){
      var table = $('#tb-datatable-notas').DataTable( 
      {
            "stateSave": false
          , "serverSide": true
          , "pageLength": 50
          , "lengthMenu": [ 10, 25, 50, 75, 100 ]
          , "ajax": {
               "url": "http://console/notas/get_notas_by_datatable"
              ,"type": "POST"
          }
          , "language": {
              "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
          }
          , "columnDefs": [
              {
                  "targets": [0],
                  "visible": true,
              },
              {
                  "targets": [1],
                  "visible": false,
              },
              {
                  "targets": [2],
                  "visible": false,
              },
              {
                  "targets": [3],
                  "visible": false,
              },
              {
                  "targets": [4],
                  "render": function(data, type, row, meta ){
                      return '<p class="text-muted">'+row[3]+'</p> \
                    <a href="#modal_form_notas" id="' + row[0] + '" data-bs-toggle="modal" class="text-success p-1 update-notas"><i class="bx bxs-edit-alt"></i></a>\
                    <a href="javascript:void(0)" id="' + row[0] + '" class="text-danger p-1 delete-notas"><i class="bx bxs-trash"></i></a>\
                              <br><br>\
                              '+row[4]+'';
                  } 
              }
          ]
      } );

      if (filtrar_nota == true){
        table.columns(3).search(1 ? '^'+ value_filtrar_nota +'$' : '', true, false).draw();
      }

      $('#tb-datatable-notas tbody').on( 'click', '.delete-notas', function () {

          document.getElementById("form_notas").reset();
          $("label.error").hide();
          $(".error").removeClass("error");

          var id_notas = this.id;

          $.post( "http://console/notas/delete_notas/",{"id_notas" : id_notas}
              , function( data )
              {
                  if (data)
                  {
                      // $('#tb-datatable-notas').DataTable().ajax.reload();
                      var n = new Noty({
                       type: "warning",
                          close: false,
                          text: "<b>Se movio a la papelera<b>" ,
                          timeout: 20e3,
                            buttons: [
                              Noty.button('Deshacer', 'btn btn-success', function () {
                                  $.post( "http://console/notas/undo_delete_notas/"+id_notas,{"id_notas" : id_notas}
                                      , function( data ){
                                        if (data)
                                        {
                                          n.close();
                                          // $('#tb-datatable-notas').DataTable().ajax.reload();
                                        }
                                        else
                                        {
                                          alert("Ocurrio un error");
                                        }
                                      }
                                  );
                              }
                              ,{id: 'id-'+id_notas, 'data-status': 'ok'}),
                                  Noty.button('Cerrar', 'btn btn-error', function () {
                                      n.close();
                                  })
                            ]
                      });
                      n.show();
                  }
                  else
                  {
                      alert("Ocurrio un error");
                  }
              }
          );

      } );

      $('#tb-datatable-notas tbody').on( 'click', '.update-notas', function () {

          var id = this.id;
          document.getElementById("form_notas").reset();
          $("#id_notas").remove();
          $("#form_notas").prepend("<input type=\"hidden\" name=\"id_notas\" id=\"id_notas\" value="+id+">");

          $(".modal-title").html("Editar Nota");

          $.post( "http://console/Notas/get_notas_by_id", {"id_notas" : id } , function( data )
          {
              try {
                  var result = JSON.stringify(result);
                  var json   = JSON.parse(data);
              } catch (e) {
                  console.log(data);
              }
              if (json["b_status"]){
                  var p= json['data'];
                  for (var key in p) 
                  {
                      if (p.hasOwnProperty(key)) 
                      {
                          if (p[key] !=="")
                          {
                              $("#"+key).addClass("fill");
                              $("#"+key).val(p[key]);

                              if("#"+key == "#vc_descripcion"){
                                $("#form_notas .Editor-editor").html(p[key]);
                              }

                              if ( $("#"+key).prop('nodeName') == "SELECT")
                              {
                                  $('#'+key+' option[value="'+p[key]+'"]').prop('selected', true);
                              }
                          }
                      }
                  }
              }
              else{
                  alert("Revisar console para mas detalle");
                  console.log(json);
              }
              $(".btn-action-form").attr("value","Actualizar");
              $(".btn-action-form").prop("disabled",false);
          }); //  Fin $.post

      } );

    },
    
    editor: function() {
        
        $('#form_notas').each(function () {
            if ($(this).data('validator'))
                $(this).data('validator').settings.ignore = ".note-editor *";
        });
        
        if ( $( "#vc_descripcion" ).length )
          $("#vc_descripcion").Editor();

        $("#agregar-nota").click(function(){
            $("#vc_nombre").val("");
            $("#vc_descripcion Editor-editor").html("");
        });

        $(document).keyup(function(e) {
            if (e.key === "Escape")
              $("#modal_form_notas").modal("hide");
        });

        $(document).on('keydown', function(e){
            if(e.ctrlKey && e.which === 83){
                e.preventDefault();
                return false;
            }
        });
    },

    set_Notas: function(){
      $("#form_notas").validate(
      {
          submitHandler:function(form)
          {
              var get_form = document.getElementById("form_notas");
              var postData = new FormData( get_form );
              var vc_descripcion = $("#form_notas .Editor-editor").html();
              postData.append("vc_descripcion", vc_descripcion);

              $.ajax({
                  url:"http://console/notas/set_notas",
                  data: postData,
                  cache: false,
                  processData: false,
                  contentType: false,
                  type: 'POST',
                  success: function(response)
                  {
                    console.log("response", response);
                    try {
                        var json   = JSON.parse(response);
                    } catch (e) {
                        alert(response);
                        return ;
                    }

                    $('#tb-datatable-notas').DataTable().ajax.reload();
                    document.getElementById("form_notas").reset();                          
                    $('#modal_form_notas .close').click();
                  }
              });
          }
      });      
    },

    eventos_clicks: function(){
        $(document).on("click", ".agregar-notas", function(){
            document.getElementById("form_notas").reset();
            $("#id_notas").remove();
            $(".modal-title").html("Agregar nueva nota");
        });      
    },

    eventos_teclado: function(){

      // $('#filtrar_nota').keyup(function () {
      //     $('#tb-datatable-notas').DataTable().destroy().clear().draw();
      //     Notas.datatable_Notas(serverSide= true, filtrar_nota= true, value= $(this).val());          
      // });

      // document.addEventListener('keydown', (event) => {
      //     const keyName = event.key;

      //     if ($(event.target).is('input')) return false;

      //     if (keyName == "" || keyName == "Alt" || keyName == "Control")
      //         return;

      //     var get_id= $("body").attr("id");

      //     // PERSINALIZADOS          

      //     if (keyName == "*"){
      //         setTimeout(function(){
      //           $('#tb-datatable-notas').DataTable().clear().destroy();
      //           Notas.datatable_Notas(serverSide= false, filtrar_nota= false, value= '');
      //           $("div.dataTables_filter input").val(""); 
      //           $("#filtrar_nota").val("");

      //           document.getElementById('filtrar_nota').focus();
      //           $('div.dataTables_filter input').blur();
      //         }, 100);
      //     }
      // });

    }

};

  $(function () {
    Notas.init();
  });
