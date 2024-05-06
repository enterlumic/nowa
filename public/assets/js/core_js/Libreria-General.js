var LibreriaGeneral = {

    init: function(){
        LibreriaGeneral.JQueryValidate();
        LibreriaGeneral.Preview();
        LibreriaGeneral.agent();
        LibreriaGeneral.f_mask();
        LibreriaGeneral.version_php();
    },

    JQueryValidate: function(){
        
        $.validator.addMethod("custom-rfc-moral", function (value, element) 
        {
            $(element).attr('minlength', '13');
            $(element).attr('maxlength', '13');

            if (value !== '') {
                var patt = new RegExp("^[A-Z,Ã‘,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]?[A-Z,0-9]?[0-9,A-Z]?$", "i");
                return patt.test(value);
            } else {
                return false;
            }
        }
        , "Ingrese un RFC válido");

        // Validación Dirección URL
        $.validator.addMethod("url", function (value, element) 
        {
            if (value !== '') {
                var url=/^(?:([A-Za-z]+):)?(\/{0,3})([0-9.\-A-Za-z]+)(?::(\d+))?(?:\/([^?#]*))?(?:\?([^#]*))?(?:#(.*))?$/;
                var patt = new RegExp( url, "i");
                return patt.test(value);
            } 
            else {
                return false;
            }
        }
        , "Se requiere una URL valido");

        $.validator.addMethod("password1", function (value, element) 
        {
            if (value !== '') {
                var password=/(?=(.*[0-9]))(?=.*[\!@#$%^&*()\\[\]{}\-_+=|:;"'<>,./?])(?=.*[a-z])(?=(.*[A-Z]))(?=(.*)).{8,}/;
                var patt = new RegExp( password, "i");
                return patt.test(value);
            } 
            else {
                return false;
            }
        }
        , "Debe tener una letra minúscula, una letra mayúscula, un número, un carácter especial y mínimo 8 dígitos.");

        $.validator.addMethod("validarUsuario", function (value, element) 
        {
            if (value !== '') {
                var user= /^[a-z0-9_-]{3,16}$/;
                var patt = new RegExp( user, "i");
                return patt.test(value);
            } 
            else {
                return false;
            }
        }
        , "se require letras minúsculas, números, guion bajo y guion medio");

        $.validator.addMethod("custom-email", function(value, element) {
            return this.optional(element) 
            || /^([\da-z_\.-]+)\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/.test(value) 
            || /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/.test(value);
        }, "Ingrese un correo válido.", "i");

        function validateURL(value){
            var expression = /(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g;

            var regex = new RegExp(expression, "i");
            return value.match(regex);
        }

        $.validator.addMethod("custom-url", function(value, element) {
            return this.optional(element) || validateURL(value);
        }, "URL no es valida");

        $.validator.addMethod("custom-cuentaBancaria", function(value, element) {
            if (value !== '') {
                var patt = new RegExp("^[0-9]{10}$");
                return patt.test(value);
            } else {
                return false;
            }
        }, function(s, element) {
            return $("#" + element.id).val() !== "" ? "Ingrese un número de Cuenta válido" : "Campo obligatorio.";
        });
        
        $.validator.addMethod("custom-ClabeInterbancaria", function(value, element) {
            if (value !== '') {
                var patt = new RegExp("^[0-9]{18}$");
                return patt.test(value);
            } else {
                return false;
            }
        }, function(s, element) {
            return $("#" + element.id).val() !== "" ? "Ingrese un número de CLABE válido" : "Campo obligatorio.";
        });

        $.validator.addMethod("custom-cp", function (value, element) {
            if (value !== '') {
            var patt = new RegExp("^[0-9]{5}$");    
                $("#verifica_cp").attr("disabled", patt.test(value) == true ? false : true );
                return patt.test(value);
            } else {
                return false;
            }
            }, function(s,element){
                return $("#"+element.id).val() !== "" ? "Ingrese un Código Postal válido" : "Campo obligatorio.";
        });

        $.validator.addMethod("custom-curp", function (value, element) {
            if (value !== '') {
                var patt = new RegExp("^[A-Z][A,E,I,O,U,X][A-Z]{2}[0-9]{2}[0-1][0-9][0-3][0-9][M,H][A-Z]{2}[B,C,D,F,G,H,J,K,L,M,N,Ñ,P,Q,R,S,T,V,W,X,Y,Z]{3}[0-9,A-Z][0-9]$");
                return patt.test(value.toUpperCase());
            } else {
                return false;
            }
        }, function(s,element){
            return $("#"+element.id).val() !== "" ? "Ingrese una CURP válida" : "";
        });

        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param);
        }, 'File size must be less than {0}');

        // add the rule here
        $.validator.addMethod("id_perfil", function(value, element, arg){
        return arg !== value;
        }, "Value must not equal arg.");

        ///End
    },

    Preview: function(){

        $(document).on("change", "input[type=file]", function () {

            var id_filter = this.id;
            class_container = "P_" + $(this).parent().attr("id");
            $("." + class_container).remove();

            var input_uploader_ref = this;
            var array_file_preview = valida_longitud_file_preview(this);

            if (array_file_preview.length > 0) 
            {
                array_file_preview.forEach(function (item_file, index) {
                    asigna_evento_preview(
                        input_uploader_ref,
                        item_file,
                        index,
                        array_file_preview.length,
                        id_filter
                    );
                });
            }

        });

        function asigna_evento_preview(me, array_file, index, len_array, id_filter) 
        {
            // var id_after_upload = "";
            // var id_href = "";
            // var class_style = "";

            // var label_vista_previa = "Vista Previa";

            // var tag_salto = "";
            // if (len_array > 1) {
            //     label_vista_previa = label_vista_previa + " " + (index + 1);
            // }
            // if (len_array >= 1 && index >= 1) tag_salto = "</br>";

            // if (index <= 0) {
            //     id_after_upload = $(me).attr("id");
            // } else if (index == 1) {
            //     class_style = " ;float:right;width:74%;margin-top:-2%";
            //     id_after_upload = $(me).attr("id") + "_0";
            // } else if (index >= 1) {
            //     class_style = " ;float:right;width:74%;margin-top:-2%";
            //     id_after_upload = $(me).attr("id") + "_" + (index - 1);
            // }

            // id_href = $(me).attr("id") + "_" + index;
            // class_container = "P_" + $(me).attr("id");

            // $("#" + id_href).remove();

            //  $("#" + id_after_upload).after(
            //     tag_salto +
            //         " <a class='previews " +
            //         class_container +
            //         "' id='" +
            //         id_href +
            //         "' style='display:inline" +
            //         class_style +
            //         "' href='javascript:void(0);'>" +
            //         label_vista_previa +
            //         "</a>&nbsp;&nbsp;&nbsp;&nbsp;"
            // );

            // $("#" + id_href).on("click", function () {
            //     mostrar_modal_preview(array_file[0], array_file[2]);
            // });
        }

        function valida_longitud_file_preview(me) 
        {
            var id_file_uploader = $(me).attr("id");
            var array_files_return = [];
            // var files = $(me).get(0).files[0];
            var files = $(me).get(0).files;

            $.each(files,function (index,file) {
                var nombre_file = "";
                if (file) {
                    ext_type = file.type;
                    nombre_file = file.name.split(".")[0];
                    var nombre_file = nombre_file.toString();
                    var len_file = nombre_file.length;
                    if (len_file > 10) {
                        nombre_file = nombre_file.substring(0, 9);
                        nombre_file = nombre_file + "...";
                        // return [file, nombre_file];
                        array_files_return.push([file, nombre_file, ext_type]);
                    } else {
                        // return [file, nombre_file];
                        array_files_return.push([file, nombre_file, ext_type]);
                    }
                } else {
                    return false;
                }
            });
            return array_files_return;
        }

        function mostrar_modal_preview(file, ext_type)
        {
            if (file) 
            {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#previewImg + embed").remove();

                    if (ext_type) ext_type = ext_type.split("/")[0];
                    if ($.trim(ext_type) == "image") {
                        $("#previewImg").after(
                            '<embed  src="' +
                                e.target.result +
                                '" width="25%" height="auto" style="margin-left:40%" />'
                        );
                    } else {
                        $("#previewImg").after(
                            '<embed  src="' + e.target.result + '" width="100%" height="400" />'
                        );
                    }
                };
                reader.readAsDataURL(file);
            }

            $("#large-Modal").modal();
        }
    },

    FormatMonedaMXN: function (total){

        total= total.toFixed(2);

        var intVal = function ( i ) {
          return typeof i === 'string' ?
              i.replace(/[\$,]/g, '')*1 :
              typeof i === 'number' ?
                  i : 0;
        };

        total= intVal(total);

        const exp = /(\d)(?=(\d{3})+(?!\d))/g;
        const rep = '$1,';
        let arr = total.toString().split('.');
        arr[0] = arr[0].replace(exp,rep);
        return arr[1] ? arr.join('.'): arr[0];
    },

    ToInt: function(total){

        var intVal = function ( i ) {
          return typeof i === 'string' ?
              i.replace(/[\$,]/g, '')*1 :
              typeof i === 'number' ?
                  i : 0;
        };

        return intVal(total);
    },

    ToString: function (letras){
        
        return letras.replace(/[\W\d]/g, ''); // AA
    },

    RunSQL: function(){
        var RunSQL= "/var/www/html/terminal/sql.sql";
        console.log(RunSQL);
        // $.post( "api_by_lumic/RunSQL", {"RunSQL":RunSQL }
        //     , function( data ){
        //         console.log("Response "+data);
        //     }
        // );
    },

    Noty: function(msg){
        var n = new Noty({
        type: "warning",
          close: false,
          text: "<b>"+msg+"<b>" ,
          timeout: 20e3,
            buttons: [
              Noty.button('Deshacer', 'btn btn-success', function () {

              }, {'data-status': 'ok'}),
                  Noty.button('Cerrar', 'btn btn-error', function () {
                      n.close();
                  })
            ]
        });
        n.show();
    },
    
    agent: function(){
        // android
        var ua = navigator.userAgent.toLowerCase();
        var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
        var get_width;

        // ipad
        // Para el uso dentro de los clientes web normales
        var isiPad = navigator.userAgent.match(/iPad/i) != null;

        // Para uso dentro iPad desarrollador UIWebView
        var ua = navigator.userAgent;

        var isiPad = /iPad/i.test(ua) || /iPhone OS 3_1_2/i.test(ua) || /iPhone OS 3_2_2/i.test(ua);
 
        if(isAndroid || navigator.userAgent.match(/iPhone/i)  || navigator.userAgent.match(/iPod/i)) {
        }
    },
    
    NotyCore: function(titulo, mensaje,from, align, icon, type, animIn, animOut){
        $.notify({
          icon: icon,
          // title: titulo + '<br>',
          message: mensaje,
          url: ''
        }, {
          element: 'body',
          type: type,
          allow_dismiss: true,
          placement: {
              from: from,
              align: align
          },
          offset: {
              x: 30,
              y: 80
          },
          spacing: 10,
          z_index: 999999,
          delay: 5,
          timer: 400,
          url_target: '_blank',
          mouse_over: false,
          animate: {
              enter: animIn,
              exit: animOut
          },
          icon_type: 'class',
          template: '<div data-notify="container" class="col-xs-12 col-sm-6 alert alert-{0}" role="alert">' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
              '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
          '</div>'
        });        
    },

    f_cargando: function(element_by_id, message){
        let effect = $('ios').data('loadingEffect');

        if ( $('#'+element_by_id).length ){
            let $loading = $('#'+element_by_id).waitMe({
                effect: effect,
                text: message,
                bg: 'rgba(255,255,255,0.90)',
                color: '#555'
            });
            return $loading;
        }
    },

    f_cargando_by_class: function(element_by_class, message){
        let effect = $('ios').data('loadingEffect');

        if ( $('.'+element_by_class).length ){

            let $loading = $('.'+element_by_class).waitMe({
                effect: effect,
                text: message,
                bg: 'rgba(255,255,255,0.90)',
                color: '#555'
            });
            return $loading;
        }
    },

    f_mask: function(){

        // if ($('.vc_telefono').length){
        //     new Cleave('.vc_telefono', {
        //         delimiters: ["(", ")", "-"],
        //         blocks: [0, 3, 3, 4]
        //     });
        // }
    },

    f_tel: function(){
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const tel = urlParams.get('tel');
        return tel;
    },

    FechaActual: function(){
        var date = new Date();
        date.setDate(date.getDate() -1);
        let fecha_dinamico= Core.formatDate(date);
        return fecha_dinamico;
    },

    url: function(){
        let url = window.location.pathname.split('/');
        return url[1];
    },

    version_php: function(){
        $.ajax({
            url:"version_php",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'GET',
            success: function(data)
            {
                $("#version_php").html(data);
            }
        });  
    },

};