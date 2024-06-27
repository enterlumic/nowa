@php
    use Illuminate\Support\Str;

@endphp

@foreach ($productos as $promocion)
    <div class="col-12 mb-3">
        <div class="card">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="{{ asset('uploads/productos/' . $promocion->foto) }}" class="card-img" alt="{{ $promocion->titulo }}">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ Str::limit($promocion->titulo, 70) }}</h5>
                        <p class="card-text">{{ $promocion->descripcion }}</p>
                        <p class="card-text"><small class="text-muted">${{ $promocion->precio }}</small></p>
                        <p class="card-text"><small class="text-muted">Antes: ${{ $promocion->precio_anterior }}</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
