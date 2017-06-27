jQuery(document).ready(function($) {

    var link = $('#guestGenerator');
    function getStuff() {
        $.getJSON( "https://lumen.o2n/api/v1/guests", function( data ) {

            var str = [];

            data.forEach(function(e, i) {
                if (i > 0) {
                    e.email.substr(1, e.email.length-1);
                    e.post_code.substr(1, e.email.length-1);
                }
                str.push(e.email + ';' + e.post_code);
            });

            var csvContent = "data:text/csv;charset=utf-8," + str.join('\n');
            var encodedUri = encodeURI(csvContent);

            link.attr('href', encodedUri);
            link.attr("download", "upload_data" + (new Date()).getTime() + ".csv");
        });
    }

    getStuff();
});