<x-app-layout>
    
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Dashboard</span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <div id="product-list" class="row row-sm mt-3 ">
                {{-- @include('productos.partials.productos-grid', ['productos' => $productos]) --}}
            </div>
        </div>
    </div>
</x-app-layout>
