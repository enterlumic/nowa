@foreach ($productos as $producto)
    <div class="col-md-4 mb-4">
        <div class="card">
            <img class="card-img-top" src="{{ $producto->imagen }}" alt="{{ $producto->nombre }}">
            <div class="card-body">
                <h5 class="card-title">{{ $producto->nombre }}</h5>
                <p class="card-text">{{ $producto->descripcion }}</p>
                <p class="card-text"><small class="text-muted">${{ $producto->precio }}</small></p>
            </div>
        </div>
    </div>
@endforeach