
(function($) {
    function MooveReadXML(data, type, xmlaction) {
        $.post(
            ajaxurl,
            {
                action: "moove_read_xml",
                data: data,
                type: type,
                xmlaction: xmlaction,
            },
            function(msg) {
                if ( msg === 'true' ) {
                    valid_xml_action();
                } else {
                    invalid_xml_action();
                }
            }
        )
    }
    function invalid_xml_action() {
        $('.moove-feed-xml-error').removeClass('moove-hidden');
    }
    function valid_xml_action() {
        $('.moove-feed-xml-error').addClass('moove-hidden');
        $('.moove-feed-xml-cnt').slideToggle('fast');
        $('.moove-feed-xml-preview').slideToggle('fast');
        $('.moove-feed-importer-where').removeClass('moove-hidden');
    }
    $(document).ready(function() {
        var file;

        $("input[name=moove-importer-feed-src]:radio").change(function() {
            $('.moove-to-hide').toggleClass('moove-hidden');
        });

        function getXmlString(xml) {
          if (window.ActiveXObject) { return xml.xml; }
          return new XMLSerializer().serializeToString(xml);
        }

        function moove_read_xml_file(e) {
            var files = e.target.files;
            var reader = new FileReader();
            reader.onload = function() {
                var parsed = new DOMParser().parseFromString(this.result, "text/xml");
                file = parsed;
            };
            reader.readAsText(files[0]);
        }

        $('.moove-importer-read-file').on('click',function(e){
            e.preventDefault();
            if ( $('input[name=moove-importer-feed-src]:checked', '.moove-feed-importer-from').val() == 'url' ) {
                xml = $('#moove_importer_url').val();
                var ext = xml.substr(xml.lastIndexOf('.') + 1);
                if($.inArray(ext, ['xml','rss']) == -1) {
                    invalid_xml_action();
                } else {
                    MooveReadXML(xml,'url','check');
                }
            } else {
                var ext = $('#moove_importer_file').val().split('.').pop().toLowerCase();
                if($.inArray(ext, ['xml','rss']) == -1) {
                    invalid_xml_action();
                } else {
                    if ( typeof file !== 'undefined') {
                        MooveReadXML(getXmlString(file),'file','check');
                    } else {
                        invalid_xml_action();
                    }
                }
            }
        });
        document.getElementById("moove_importer_file").addEventListener("change", moove_read_xml_file, false );

    }); // end document ready
})(jQuery);
