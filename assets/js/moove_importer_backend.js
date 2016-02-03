
(function($) {
    var file;
    var selected_node;
    var ajax_action = "";
    function MooveReadXML(data, type, xmlaction, node) {
        ajax_action = 'read';
        $.post(
            ajaxurl,
            {
                action: "moove_read_xml",
                data: data,
                type: type,
                xmlaction: xmlaction,
                node: node,
            },
            function(msg) {
                if ( xmlaction === 'check') {
                    msg = JSON.parse(msg);
                    console.log(msg);
                    if ( msg.response !== 'false' ) {
                        $('.moove-feed-xml-node-select .node-select-cnt').empty().append(msg.select_nodes).parent().show();
                        $('.moove-feed-importer-src-form').hide();
                        selected_node = msg.selected_element;
                    } else {
                        invalid_xml_action();
                    }
                } else if ( xmlaction === 'preview' ) {
                    msg = JSON.parse(msg);
                    $('.moove-feed-xml-preview-container').empty().append(msg.content);
                    $('.moove-importer-dynamic-select').empty().append(msg.select_option);

                    $('.moove-feed-xml-error').addClass('moove-hidden');
                    $('.moove-feed-xml-cnt').slideToggle('fast');
                    $('.moove-feed-xml-preview').slideToggle('fast');
                    $('.moove-feed-importer-where').removeClass('moove-hidden');
                }
            }
        )
    }

    function MooveCreatePost( post_data ) {
        ajax_action = 'import';
        $.post(
            ajaxurl,
            {
                action: "moove_create_post",
                post_data: post_data,
            },
            function(msg) {
                console.log(msg);
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

    function moove_array_to_object(arr) {
      var rv = {};
      for (var i = 0; i < arr.length; ++i)
        if (arr[i] !== undefined) rv[i] = arr[i];
      return rv;
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

        $('.moove-importer-create-preview').on('click', function(e){
            e.preventDefault();
            if ( $('input[name=moove-importer-feed-src]:checked', '.moove-feed-importer-from').val() == 'url' ) {
                xml = $('#moove_importer_url').val();
                MooveReadXML(xml,'url','preview', selected_node );
            } else {
                MooveReadXML(getXmlString(file),'file','preview', selected_node);
            }
        });

        $('#moove-importer-post-type-select').on('change',function(e){
            var selected = $(this).find('option:selected').val();
            if ( selected !== '0' ) {
                $('.moove-feed-importer-taxonomies').removeClass('moove-hidden');
                $('.moove_cpt_tax').addClass('moove-hidden');
                $('.moove_cpt_tax_'+selected).removeClass('moove-hidden');
                $('.moove-submit-btn-cnt').removeClass('moove-hidden');
            } else {
                $('.moove-feed-importer-taxonomies').addClass('moove-hidden');
                $('.moove-submit-btn-cnt').addClass('moove-hidden');
            }
        });

        $('.moove-start-import-feed').on('click',function(e){
            e.preventDefault();

            var post_selected = $('#moove-importer-post-type-select option:selected').val();
            var taxonomies = [];
            if ( $('#moove-importer-post-type-posttitle option:selected').val() !== "0") {
                $('.moove-feed-xml-cnt .moove-title-error').empty();
                $('.moove_cpt_tax_'+post_selected+' .moove-importer-taxonomy-box').each(function( index, value ){
                    taxonomies[index] = ({
                        taxonomy    :   $(this).attr('data-taxonomy'),
                        slug        :   $(this).find('select.moove-importer-taxonomy-slug option:selected').val(),
                        title       :   $(this).find('select.moove-importer-taxonomy-title option:selected').val()
                    });
                });

                var post_data_select = ({
                    post_type           :   $('#moove-importer-post-type-select option:selected').val(),
                    post_status         :   $('#moove-importer-post-type-status option:selected').val(),
                    post_title          :   $('#moove-importer-post-type-posttitle option:selected').val(),
                    post_content        :   $('#moove-importer-post-type-postcontent option:selected').val(),
                    post_excerpt        :   $('#moove-importer-post-type-postexcerpt option:selected').val(),
                    post_featured_image :   $('#moove-importer-post-type-ftrimage option:selected').val(),
                    taxonomies          :   moove_array_to_object(taxonomies)
                });
                MooveCreatePost( JSON.stringify(post_data_select) );
            } else {
                $('.moove-feed-importer-taxonomies .moove-title-error').text('Please select a field for title');
                $('#moove-importer-post-type-posttitle').focus();
            }

        });
        $('.moove-feed-importer-taxonomies').on('change','#moove-importer-post-type-posttitle',function(){
            var selected = $(this).find('option:selected').val();
            if ( selected !== '0' ) {
                $('.moove-title-error').empty();
            } else {
                $('.moove-feed-importer-taxonomies .moove-title-error').text('Please select a field for title');
            }
        });
        $('.moove-feed-xml-cnt').on('change','.node-select-cnt select',function(){
            selected_node = $(this).find('option:selected').val();
        });
        $('.moove-importer-read-file').on('click',function(e){
            e.preventDefault();
            if ( $('input[name=moove-importer-feed-src]:checked', '.moove-feed-importer-from').val() == 'url' ) {
                xml = $('#moove_importer_url').val();
                var ext = xml.substr(xml.lastIndexOf('.') + 1);
                if($.inArray(ext, ['xml','rss']) == -1) {
                    invalid_xml_action();
                } else {
                    MooveReadXML(xml,'url','check','');
                }
            } else {
                var ext = $('#moove_importer_file').val().split('.').pop().toLowerCase();
                if($.inArray(ext, ['xml','rss']) == -1) {
                    invalid_xml_action();
                } else {
                    if ( typeof file !== 'undefined') {
                        MooveReadXML(getXmlString(file),'file','check','');
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
            $('.moove-feed-xml-node-select').hide();
            $('.moove-feed-importer-src-form').show();
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
                $(this).parent().attr('data-current', parseInt($(this).parent().attr('data-current'))+1);
                $('.moove-importer-readed-feed.moove-active').addClass('moove-hidden').removeClass('moove-active').next('.moove-importer-readed-feed').addClass('moove-active').removeClass('moove-hidden');
            } else {
                $(this).parent().attr('data-current',parseInt($(this).parent().attr('data-current'))-1);
                $('.moove-importer-readed-feed.moove-active').addClass('moove-hidden').removeClass('moove-active').prev('.moove-importer-readed-feed').addClass('moove-active').removeClass('moove-hidden');
            }
            if ( $('.moove-importer-readed-feed.moove-active').attr('data-no') == $('.moove-importer-readed-feed.moove-active').attr('data-total') ) {
                $('.moove-feed-xml-preview-container .moove-xml-preview-pagination.button-next').hide();
            }
            if ( $('.moove-importer-readed-feed.moove-active').attr('data-no') == 1 ) {
                $('.moove-feed-xml-preview-container .moove-xml-preview-pagination.button-previous').hide();
            }
            $('.moove-form-container.feed_importer .pagination-info').text( 'Current item: '+$(this).parent().attr('data-current')+' / '+$('.moove-importer-readed-feed.moove-active').attr('data-total'));
        });
    }); // end document ready
    $(document).ajaxSend(function () {
        if ( ajax_action === 'read' ) {
            $('.moove-form-container.feed_importer').addClass('ajax-loading-process');
        }
    })
    .ajaxComplete(function () {
        if ( ajax_action === 'read' ) {
            $('.moove-form-container.feed_importer').removeClass('ajax-loading-process');
        }
    });
})(jQuery);
