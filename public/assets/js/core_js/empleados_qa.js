let empleados_qa = {

    init: function () {
        // Asignar valores específicos a cada campo cuando el modal se muestra
        $('#modalFormIUempleados').on('shown.bs.modal', function() {

           function setValue(selector, value) {
                var element = $(selector);
                if (element.length) {
                    element.val(value);
                    console.log('Setting value for', selector);
                } else {
                    console.log('Element not found:', selector);
                }
            }

            // Asignar valores a los campos dentro del modal
            setValue('#nombre', "Juan Pérez");
            setValue('#direccion', "Calle Falsa 123, Ciudad Ficticia, 45678");
            setValue('#telefono', "+529991234567");
            setValue('#email', "juan.perez@example.com");
            setValue('#fecha_ingreso', "2021-04-15");
            setValue('#puesto', "Gerente de Ventas");
            setValue('#salario', "75000.00");
            setValue('#usuario', "juanperez");
            setValue('#contrasena', "una_contraseña_segura"); // Asumiendo que el hash se hará en el servidor
        });        
    },
};

empleados_qa.init();