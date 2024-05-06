var Dashboard = {

    init: function() {
        Dashboard.revisar_tookan();
        Dashboard.fn_gnu();
    },

    fn_gnu: function() {
        // $.ajax({
        //     url:"gnu",
        //     cache: false,
        //     contentType: false,
        //     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        //     type: 'GET',
        //     success: function(data)
        //     {
        //         console.log("data", data);
        //     },
        //     error: function(response)
        //     {
        //         console.log("response", response);
        //     }
        // });
    },

    revisar_tookan: function() {
        $.ajax({
            url:"tookan",
            cache: false,
            contentType: false,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'GET',
            success: function(data)
            {
                if (! (data > 0) ){
                    $(".tookan-danger").removeClass("d-none");
                }else{
                    $(".tookan-success").removeClass("d-none");
                }
            },
            error: function(response)
            {
            }
        });
    },

};

Dashboard.init();