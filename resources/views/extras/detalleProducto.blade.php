    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Resumen del Pedido</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">

                    @if($productos->isNotEmpty())
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th style="width: 90px;" scope="col">Producto</th>
                                    <th scope="col">Información del Producto</th>
                                    <th scope="col" class="text-end">Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $promocion)
                                    <tr>
                                        <td>
                                            <div class="avatar-md bg-light rounded p-1">
                                                <img src="{{ asset('uploads/productos/' . $promocion->foto_url) }}" alt="{{ $promocion->titulo }}" class="img-fluid d-block rounded-3">
                                            </div>
                                        </td>
                                        <td>
                                            <h5 class="fs-14"><a href="javascript:void(0);" class="text-body">{{ $promocion->titulo }}</a></h5>
                                            <p class="text-muted mb-0">${{ number_format($promocion->precio, 2) }} x {{ $promocion->cantidad }}</p>
                                        </td>
                                        <td class="text-end">
                                            ${{ number_format($promocion->precio * $promocion->cantidad, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="table-active">
                                    <th colspan="2">Total (MXN) :</th>
                                    <td class="text-end">
                                        <span class="fw-semibold">${{ number_format($productos->sum('precio'), 2) }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <p>No se encontraron productos.</p>
                    @endif

            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
