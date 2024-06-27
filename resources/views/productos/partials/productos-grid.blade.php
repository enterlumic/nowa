@php
    use Illuminate\Support\Facades\Crypt;
    use Illuminate\Support\Str;
@endphp

@foreach ($productos as $promocion)
    <div class="col-md-4 col-lg-6 col-xl-4 col-xxl-3 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body h-100 product-grid6">
                <div class="">
                    <a href="detalle?id={{ Crypt::encrypt($promocion->id) }}">
                        <img class="pic-1 promocion-img" src="{{ asset('uploads/productos/' . $promocion->foto) }}" alt="{{ $promocion->titulo }}">
                    </a>
                </div>
                <div class="text-center pt-2">
                    <h3 class="h6 mb-2 mt-4 text-uppercase">{{ Str::limit($promocion->titulo, 70) }}</h3>
                    <h4 class="h5 mb-0 mt-1 text-center fw-bold fs-22">${{ $promocion->precio }} <span class="text-secondary fw-normal fs-13 ms-1 prev-price text-decoration-line-through">${{ $promocion->precio_anterior }}</span></h4>
                </div>
            </div>
        </div>
    </div>
@endforeach

<style>
    .promocion-img {
        width: 100%; /* Asegura que la imagen ocupe el 100% del contenedor */
        height: 300px; /* Establece una altura fija para las imágenes */
        object-fit: contain; /* Asegura que la imagen se ajuste sin recortarse */
        object-position: center; /* Centra la imagen en el contenedor */
    }
</style>
