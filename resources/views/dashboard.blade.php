<x-app-layout>
    <div class="container mt-5">
        <div class="d-flex justify-content-end mb-3">
            <button id="grid-view" class="btn btn-primary">Grid View</button>
            <button id="list-view" class="btn btn-secondary ml-2">List View</button>
        </div>
        <div id="product-list" class="row">
            @include('productos.partials.productos-grid')
        </div>
        <div class="spinner text-center mt-3">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
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
                        $('.spinner').show();
                    }
                })
                .done(function(data) {
                    if (data.trim() == "") {
                        $('.spinner').html("No more records found");
                        return;
                    }
                    $('.spinner').hide();
                    $("#product-list").append(data);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    alert('server not responding...');
                });
            }
        });
    </script>
</x-app-layout>
