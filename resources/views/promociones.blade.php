<x-app-layout>
    
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Promociones</span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <div id="product-list" class="row row-sm mt-3 ">
                @include('productos.partials.productos-grid', ['productos' => $productos])
            </div>
            <div class="spinner text-center mt-3 d-none">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var page = 1;
            var layout = 'grid';

            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                    page++;
                    loadMoreData(page, layout);
                }
            });

            $('#grid-view').click(function() {
                layout = 'grid';
                $('#product-list').html('');
                page = 1;
                loadMoreData(page, layout);
            });

            $('#list-view').click(function() {
                layout = 'list';
                $('#product-list').html('');
                page = 1;
                loadMoreData(page, layout);
            });

            function loadMoreData(page, layout) {
                $.ajax({
                    url: '/productos/fetch?page=' + page + '&layout=' + layout,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        $('.spinner').removeClass('d-none');
                    }
                })
                .done(function(data) {
                    if (data.trim() == "") {
                        $('.spinner').html("No more records found");
                        return;
                    }
                    $('.spinner').addClass('d-none');
                    $("#product-list").append(data);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    alert('server not responding...');
                });
            }
        });
    </script>

</x-app-layout>
