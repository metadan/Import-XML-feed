
(function($) {
    function MooveReadXML(data, type) {
        $.post(
            ajaxurl,
            {
                action: "moove_read_xml",
                data: data,
                type: type
            },
            function(msg) {
                console.log(msg);
            }
        )
    }
    $(document).ready(function() {
        var file;

        $("input[name=moove-importer-feed-src]:radio").change(function() {
            $('.moove-to-hide').toggleClass('moove-hidden');
        });

        function moove_read_xml_file(e) {
            var files = e.target.files;
            var reader = new FileReader();
            reader.onload = function() {
                var parsed = new DOMParser().parseFromString(this.result, "text/xml");
                file = this.result;
            };
            reader.readAsText(files[0]);
        }
        $('.moove-importer-read-file').on('click',function(e){
            e.preventDefault();
            if ( $('input[name=moove-importer-feed-src]:checked', '.moove-feed-importer-from').val() == 'url' ) {
                xml = $('#moove_importer_url').val();
                MooveReadXML(xml,'url');
            } else {
                MooveReadXML ( file  ,'file');
            }
        });
        document.getElementById("moove_importer_file").addEventListener("change", moove_read_xml_file, false );

    }); // end document ready
})(jQuery);
