@foreach ($productos as $producto)
    <div class="col-12 mb-3">
        <div class="card">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="{{ $producto->imagen }}" class="card-img" alt="{{ $producto->nombre }}">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p class="card-text">{{ $producto->descripcion }}</p>
                        <p class="card-text"><small class="text-muted">${{ $producto->precio }}</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
