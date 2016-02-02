
(function($) {
    var file;
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

                if ( xmlaction === 'check') {
                    if ( msg === 'true' ) {
                        valid_xml_action();
                    } else {
                        invalid_xml_action();
                    }
                } else if ( xmlaction === 'preview' ) {

                    $('.moove-feed-xml-preview-container').empty().append(msg);
                } else if ( xmlaction === 'getnodes' ) {
                    $('.moove-feed-xml-node-select').append(msg);
                    $('.moove-feed-importer-src-form').slideToggle('fast');
                }
            }
        )
    }
    function getXmlString(xml) {
      if (window.ActiveXObject) { return xml.xml; }
      return new XMLSerializer().serializeToString(xml);
    }
    function invalid_xml_action() {
        $('.moove-feed-xml-error').removeClass('moove-hidden');
    }
    function valid_xml_action() {
        // $('.moove-feed-xml-error').addClass('moove-hidden');
        // $('.moove-feed-xml-cnt').slideToggle('fast');
        // $('.moove-feed-xml-preview').slideToggle('fast');
        // $('.moove-feed-importer-where').removeClass('moove-hidden');

        if ( $('input[name=moove-importer-feed-src]:checked', '.moove-feed-importer-from').val() == 'url' ) {
            xml = $('#moove_importer_url').val();
            //MooveReadXML(xml,'url','preview');
            MooveReadXML(xml,'url','getnodes');
        } else {

            //MooveReadXML(getXmlString(file),'file','preview');
            MooveReadXML(getXmlString(file),'file','getnodes');
        }
    }
    $(document).ready(function() {

        $("input[name=moove-importer-feed-src]:radio").change(function() {
            $('.moove-to-hide').toggleClass('moove-hidden');
        });

        function moove_read_xml_file(e) {
            var files = e.target.files;
            var reader = new FileReader();
            reader.onload = function() {
                var parsed = new DOMParser().parseFromString(this.result, "text/xml");
                file = parsed;
            };
            reader.readAsText(files[0]);
        }
        $('#moove-importer-post-type-select').on('change',function(e){
            var selected = $(this).find('option:selected').val();
            if ( selected !== '0' ) {
                $('.moove-feed-importer-taxonomies').removeClass('moove-hidden');
                $('.moove_cpt_tax').addClass('moove-hidden');
                $('.moove_cpt_tax_'+selected).removeClass('moove-hidden');
            } else {
                $('.moove-feed-importer-taxonomies').addClass('moove-hidden');
            }
        });
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
        if ($('#moove_importer_file').length) {
            document.getElementById("moove_importer_file").addEventListener("change", moove_read_xml_file, false );
        }
        $('.select_another_source').on('click',function(e){
            e.preventDefault();
            $('.moove-feed-importer-src-form').trigger('reset');

            $('.moove-feed-importer-where').addClass('moove-hidden');
            $('.moove-importer-src-upload').addClass('moove-hidden');
            $('.moove-importer-src-url').removeClass('moove-hidden');
            $('.moove_cpt_tax').addClass('moove-hidden');
            $('.moove-feed-xml-preview').hide();
            $('.moove-feed-importer-where').addClass('moove-hidden');
            $('.moove-feed-xml-cnt').show();
        });

        $('.moove-feed-xml-preview-container').on( 'click', '.moove-xml-preview-pagination', function(e) {
            e.preventDefault();
            $('.moove-xml-preview-pagination').show();
            $active = $('.moove-feed-xml-preview-container .moove-importer-readed-feed.moove-active');
            if ( $(this).hasClass('button-next') ) {
                $('.moove-importer-readed-feed.moove-active').addClass('moove-hidden').removeClass('moove-active').next('.moove-importer-readed-feed').addClass('moove-active').removeClass('moove-hidden');
            } else {
                $('.moove-importer-readed-feed.moove-active').addClass('moove-hidden').removeClass('moove-active').prev('.moove-importer-readed-feed').addClass('moove-active').removeClass('moove-hidden');
            }
            if ( $('.moove-importer-readed-feed.moove-active').attr('data-no') == $('.moove-importer-readed-feed.moove-active').attr('data-total') ) {
                $('.moove-feed-xml-preview-container .moove-xml-preview-pagination.button-next').hide();
            }
            if ( $('.moove-importer-readed-feed.moove-active').attr('data-no') == 1 ) {
                $('.moove-feed-xml-preview-container .moove-xml-preview-pagination.button-previous').hide();
            }

        });

    }); // end document ready
})(jQuery);
