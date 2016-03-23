<div class="wrap moove-importer-plugin-wrap">
<a href="http://mooveagency.com" target="blank" title="WordPress agency"><span class="moove-logo"></span></a>
	<h1><?php _e('Feed Importer','moove'); ?></h1>
    <?php
        $current_tab_feed = sanitize_text_field( wp_unslash( $_GET[ 'tab' ]  ) );
        if( isset( $current_tab_feed ) && $current_tab_feed !== '' ) {
            $active_tab = $current_tab_feed;
        } else {
            $active_tab = "feed_importer";
        } // end if
    ?>
    <h2 class="nav-tab-wrapper">
        <a href="?page=moove-importer&tab=feed_importer" class="nav-tab <?php echo $active_tab == 'feed_importer' ? 'nav-tab-active' : ''; ?>">
            <?php _e('Feed Import','moove'); ?>
        </a>
        <a href="?page=moove-importer&tab=plugin_documentation" class="nav-tab <?php echo $active_tab == 'plugin_documentation' ? 'nav-tab-active' : ''; ?>">
            <?php _e('Documentation','moove'); ?>
        </a>
    </h2>
    <div class="moove-form-container <?php echo $active_tab; ?>">
        <?php
        if( $active_tab == 'feed_importer' ) :
            echo Moove_Importer_View::load( 'moove.admin.settings.post_type', $data );
        elseif( $active_tab == 'plugin_documentation' ):
            echo Moove_Importer_View::load( 'moove.admin.settings.documentation' , null );
        endif; ?>
    </div>
    <!-- moove-form-container -->
</div>
<!-- wrap -->