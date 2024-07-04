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
                    <div class="product-details table-responsive text-nowrap">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-start">Producto</th>
                                    <th class="w-150">Cantidad</th>
                                    <th>Precio</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="card-aside-img">
                                                <img src="../assets/images/ecommerce/2.jpg" alt="img" class="h-60 w-60">
                                            </div>
                                            <div class="media-body">
                                                <div class="card-item-desc mt-0">
                                                    <h6 class="fw-semibold mt-0 text-uppercase">ropa de fiesta</h6>
                                                    <dl class="card-item-desc-1">
                                                      <dt>Tamaño: </dt>
                                                      <dd>XXL</dd>
                                                    </dl>
                                                    <dl class="card-item-desc-1">
                                                      <dt>Color: </dt>
                                                      <dd>color morado</dd>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                   <td class="text-center">
                                    <div class="handle-counter input-group border rounded flex-nowrap">
                                        <button class="btn btn-icon btn-light input-group-text product-quantity-minus" ><i class="ri-subtract-line"></i></button>
                                        <input type="text" class="form-control form-control-sm border-0 text-center" aria-label="quantity" value="2">
                                        <button class="btn btn-icon btn-light input-group-text product-quantity-plus" ><i class="ri-add-line"></i></button>
                                    </div>
                                    </td>
                                    <td class="text-center text-lg text-medium fw-bold fs-15">$80.00</td>
                                    <td class="text-center">
                                       <a class="btn btn-sm btn-danger-light" href="javascript:void(0);" data-bs-toggle="tooltip" title="" data-bs-original-title="Eliminar artículo" data-bs-container=".btn"><i class="fe fe-trash"></i></a>
                                    </td>
                                 </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between flex-wrap gap-2">
                        <div>
                            <a class="btn btn-secondary" href="shop.html"><i class="fe fe-corner-up-left mx-2"></i>Volver a la Tienda</a>
                        </div>
                        <div class="btn-list">
                            <a class="btn btn-outline-primary" href="check-out.html"><i class="fe fe-log-in mx-2"></i>Pasar por Caja</a>
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
                                <dd class="text-end ms-auto fs-20"><strong>$252.97</strong></dd>
                            </dl>
                        </div>
                    </div>
                        <div class="card-footer">
                            <div class="column"><a class="btn btn-primary" href="shop.html">Proceder</a></div>
                        </div>
                </div>
            </div>
    </div>
    <!-- fila cerrada -->

</x-app-layout>
