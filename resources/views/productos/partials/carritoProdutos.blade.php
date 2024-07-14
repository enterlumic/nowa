<x-app-layout>
    <!-- breadcrumb (migas de pan) -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Carrito</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item fs-15"><a href="javascript:void(0);">Carrito</a></li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- fila abierta -->
     <div class="row">
        <div class="col-lg-12 col-xl-9 col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Carrito de Compras -->
                    <div class="table-rep-plugin">
                        <div class="product-details table-responsive ">
                            <table class="table table-bordered table-hover mb-0 ">
                                <thead>
                                    <tr>
                                        <th class="text-start" style="width: 400px;">Producto</th>
                                        <th class="w-150">Cantidad</th>
                                        <th>Precio</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="content-carrito">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xl-3 col-md-12">
            <div class="card custom-card cart-details">
                <div class="card-body p-0">
                    <hr>
                    <div class="px-4">
                        <dl class="dlist-align">
                            <dt>Total:</dt>
                            <dd class="text-end ms-auto fs-20"><strong id="precio_nuevo"> </strong></dd>
                        </dl>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="column"><a class="btn btn-warning" href="check_out?id={{ $carrito }}"> <span class="text-dark">Proceder al pago   </span></a></div>
                </div>
            </div>
        </div>
    </div>
    <!-- fila cerrada -->

</x-app-layout>

<!-- Color Picker Css -->
<link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css">
<link rel="stylesheet" href="assets/libs/@simonwep/pickr/themes/nano.min.css">

<!-- Choices Css -->
<link rel="stylesheet" href="assets/libs/choices.js/public/assets/styles/choices.min.css">

<!-- Handle-counter js -->
<script src="assets/js/handlecounter.js"></script>

<script type="text/javascript">
    
$(document).ready(function() {

    $.ajax({
        url: '/getCarritoProductos',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var tableRow = '';
            var totalPrecio = 0;

            $.each(data, function(index, producto) {
                var precioFormateado = parseFloat(producto.precio).toLocaleString('es-MX', {
                    style: 'currency',
                    currency: 'MXN',
                    minimumFractionDigits: 2
                });
                var subtotal = producto.precio * producto.cantidad;
                totalPrecio += subtotal;

                tableRow += '<tr>';
                tableRow += '<td><div class="media"><div class="card-aside-img"><img src="' + producto.foto_url + '" class="h-60 w-60" style="max-width: 100%; height: auto;"></div><div class="media-body"><div class="card-item-desc mt-0"><h6 class="fw-semibold mt-0 text-uppercase">' + producto.titulo + '</h6></div></div></div></td>';
                tableRow += '<td class="text-center"><div class="handle-counter input-group border rounded flex-nowrap">';
                tableRow += '<select class="form-control form-control-sm quantity-select" aria-label="quantity" data-id="' + producto.id + '" data-precio="' + producto.precio + '">';
                for (let i = 1; i <= 10; i++) {
                    let selected = producto.cantidad === i ? ' selected' : '';
                    tableRow += '<option value="' + i + '"' + selected + '>' + i + '</option>';
                }
                tableRow += '</select></div></td>';
                tableRow += '<td class="text-center text-lg text-medium fw-bold fs-15">' + precioFormateado + '</td>';
                tableRow += '<td class="text-center"><a class="btn btn-sm btn-danger-light" href="javascript:void(0);" data-id="' + producto.id + '"><i class="fe fe-trash"></i></a></td>';
                tableRow += '</tr>';
            });

            $('#content-carrito').html(tableRow);
            $('#precio_nuevo').text(parseFloat(totalPrecio.toFixed(2)).toLocaleString('es-MX', {
                style: 'currency',
                currency: 'MXN',
                minimumFractionDigits: 2
            }));
        }
    });

    $('#content-carrito').on('change', '.quantity-select', function() {
        var id = $(this).data('id');
        var newQuantity = $(this).val();
        var precio = $(this).data('precio');
        var newSubtotal = precio * newQuantity;

        $.ajax({
            url: '/updateQuantity',
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                id: id,
                cantidad: newQuantity
            },
            success: function(response) {
                // Recalcular y mostrar el nuevo total
                var total = 0;
                $('.quantity-select').each(function() {
                    var cantidad = $(this).val();
                    var precio = $(this).data('precio');
                    total += cantidad * precio;
                });
                $('#precio_nuevo').text(parseFloat(total.toFixed(2)).toLocaleString('es-MX', {
                    style: 'currency',
                    currency: 'MXN',
                    minimumFractionDigits: 2
                }));
            },
            error: function() {
                alert('Error al actualizar la cantidad');
            }
        });
    });

    // Agregar manejador de evento click para eliminar producto
    $('#content-carrito').on('click', '.btn-danger-light', function() {
        var id = $(this).data('id'); // Obtiene el ID del producto

        if(confirm('¿Estás seguro de que deseas eliminar este producto?')) {
            $.ajax({
                url: '/deleteProductoCarrito', // Asegúrate de que esta URL es correcta
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: { id: id },
                success: function(response) {
                    // Elimina la fila del producto del DOM
                    $('a[data-id="' + id + '"]').closest('tr').remove();
                    // Actualiza el precio total
                    actualizarTotal();
                },
                error: function() {
                    alert('Error al eliminar el producto');
                }
            });
        }
    });

    function actualizarTotal() {
        var total = 0;
        $('.quantity-select').each(function() {
            var cantidad = $(this).val();
            var precio = $(this).data('precio');
            total += cantidad * precio;
        });
        $('#precio_nuevo').text('$' + parseFloat(total.toFixed(2)).toLocaleString('es-MX', {
            style: 'currency',
            currency: 'MXN',
            minimumFractionDigits: 2
        }));
    }

});

</script>
