<div class="moove-importer-ajax-spinner">
</div>
<!-- moove-importer-ajax-spinner -->
<div class="moove-importer-ajax-import-overlay import-work-on moove-hidden">
    <div class="import-notice">
        <h2><?php _e( 'Feed import started' , 'moove' ); ?> </h2>
        <h4><?php _e( 'Please wait finishing the import!' , 'moove' ); ?></h4>
    </div>
    <!-- import-notice -->
    <div class="moove-importer-ajax-import-progress-bar">
        <span></span>
    </div>
    <!-- moove-importer-ajax-import-progress-bar -->
    <div class="moove-importer-percentage">
        0%
    </div>
    <!-- moove-importer-percentage -->
    <div class="moove-start-new-import">
        <a href="<?php echo home_url( '/wp-admin/options-general.php?page=moove-importer&tab=feed_importer' ); ?>" class="button button-secondary"><?php _e( 'Start new import' , 'moove' ); ?> </a>
    </div>
    <!-- moove-start-new-import -->
</div>
<!-- moove-importer-ajax-import-overlay -->
<div class="moove-feed-importer-where moove-hidden">
<!-- <div class="moove-feed-importer-where "> -->
    <h3>Matching</h3>
    <hr>
    <h4><?php _e( 'Select a Post Type' , 'moove' ); ?></h4>
    <?php if ( count( $data ) ) : ?>
        <select name="moove-importer-post-type-select" id="moove-importer-post-type-select" class="moove-importer-log-settings">
            <option value="0"><?php _e( 'Select a post type' , 'moove' ); ?></option>
            <?php
            foreach ($data as $post_types) :
                $obj = get_post_type_object( $post_types['post_type'] ); ?>
                <option value="<?php echo $post_types['post_type']; ?>">
                    <?php echo $obj->labels->singular_name; ?> </option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>
    <?php if ( count( $data ) ) : ?>
        <div class="moove-feed-importer-taxonomies moove-hidden">
            <div class="moove-post-fields">
                <h4><?php _e( 'Post title' , 'moove' ); ?> *</h4>
                <span class="moove-title-error"></span>
                <select name="moove-importer-post-type-posttitle" id="moove-importer-post-type-posttitle" class="moove-importer-dynamic-select" required>
                </select>

                <h4><?php _e( 'Post content' , 'moove' ); ?></h4>
                <select name="moove-importer-post-type-postcontent" id="moove-importer-post-type-postcontent" class="moove-importer-dynamic-select" required>
                </select>

                <h4><?php _e( 'Post excerpt' , 'moove' ); ?></h4>
                <select name="moove-importer-post-type-postexcerpt" id="moove-importer-post-type-postexcerpt" class="moove-importer-dynamic-select" required>
                </select>

                <h4><?php _e( 'Post status' , 'moove' ); ?></h4>
                <select name="moove-importer-post-type-status" id="moove-importer-post-type-status" >
                    <option value="publish"><?php _e( 'Published' , 'moove' ); ?></option>
                    <option value="pending"><?php _e( 'Pending review' , 'moove' ); ?></option>
                    <option value="draft"><?php _e( 'Draft' , 'moove' ); ?></option>
                </select>

                <h4><?php _e( 'Post author' , 'moove' ); ?></h4>
                <select name="moove-importer-post-type-author" id="moove-importer-post-type-author" >
                    <?php $wp_users = get_users( array( 'who' => 'authors' ) ); ?>
                    <?php foreach ( $wp_users as $wp_user ) : ?>
                        <option value="<?php echo $wp_user->ID ?>" <?php if ( wp_get_current_user()->ID === $wp_user->ID ) : echo "selected='selected'"; endif; ?> ><?php echo $wp_user->user_nicename; ?></option>
                    <?php endforeach; ?>
                </select>

                <h4><?php _e( 'Featured image url' , 'moove' ); ?></h4>
                <select name="moove-importer-post-type-ftrimage" id="moove-importer-post-type-ftrimage" class="moove-importer-dynamic-select">
                </select>
            </div>
            <!-- "moove-post-fields -->
        <br />
        <hr>
        <?php foreach ($data as $post_types) :
            if ( count( $post_types['taxonomies'] ) ) :
                $i = 0; ?>
                <div class="moove_cpt_tax_<?php echo $post_types['post_type']; ?> moove_cpt_tax moove-hidden">
                    <h4><?php _e( 'Taxonomies' , 'moove'); ?></h4>
                    <?php foreach ($post_types['taxonomies'] as $tax_name => $taxonomy) :
                        $i++;
                        ?>
                        <div class="moove-importer-taxonomy-box" data-taxonomy="<?php echo $tax_name; ?>">
                            <p class="moove-importer-tax-title"><?php echo $taxonomy->labels->name; ?></p>
                            <hr>
                            <p><?php _e( 'Title' , 'moove' ); ?>: </p>
                            <select name="moove-importer-tax-title<?php echo $i; ?>" class="moove-importer-dynamic-select moove-importer-taxonomy-title">

                            </select>
                            <br />
                        </div>
                        <!-- moove-importer-taxonomy-box -->
                    <?php endforeach; ?>
                </div>
                <!-- moove_cpt_tax -->
            <?php endif;
        endforeach; ?>
        </div>
        <!-- moove-feed-importer-taxonomies -->
    <?php endif;?>
    <div class="moove-submit-btn-cnt moove-hidden">
        <br />
        <a href="#" class="button button-primary moove-start-import-feed"><?php _e( 'START IMPORT' , 'moove' ); ?></a>
    </div>
    <!-- moove-submit-btn-cnt -->
</div>
<!-- moove-feed-importer-where -->
<div class="moove-feed-importer-from">
    <h3>From</h3>
    <span> <a href="#" class="select_another_source button button-secondary"><?php _e( 'Select Another Source' , 'moove' ); ?></a> </span>
    <hr>
    <div class="moove-feed-xml-cnt">
        <form action="" class="moove-feed-importer-src-form">
            <h4><?php _e( 'Select the feed source' , 'moove' ); ?></h4>
            <div class="moove-importer-radio-cnt">
                <input type="radio" id="feed_url" value="url" name="moove-importer-feed-src" checked="true"/>
                <label for="feed_url"><?php _e( 'URL' , 'moove' ); ?></label>
                <br>
                <input type="radio" id="feed_upload" value="upload" name="moove-importer-feed-src"/>
                <label for="feed_upload"><?php _e( 'UPLOAD' , 'moove' ); ?></label>
            </div>
            <!-- moove-importer-radio-cnt -->
            <br />
            <div class="moove-importer-src-url moove-to-hide">
                <label for="moove_importer_url"><?php _e( 'Type the file URL' , 'moove' ); ?></label>
                <input type="text" name="moove_importer_url" id="moove_importer_url"><br /><br />
            </div>
            <!-- moove-importer-src-url -->
            <div class="file-upload moove-importer-src-upload moove-to-hide moove-hidden ">
                <?php _e('Select XML/RSS file','moove'); ?>:
                <br />
                <input type="file" name="moove_importer_file" id="moove_importer_file"><br /><br />
            </div>
            <!-- file-upload moove-importer-src-upload -->
            <button class="button button-primary moove-importer-read-file"><?php _e( 'Check DATA' , 'moove' ); ?></button>
            <div class="moove-feed-xml-error moove-hidden">
                <h4 style="color: red">
                    <strong><?php _e( 'Wrong or unreadable XML file! Please try again!', 'moove' ); ?></strong>
                </h4>
            </div>
            <!-- moove-feed-xml-error -->
        </form>
        <div class="moove-feed-xml-node-select moove-hidden">
            <div class="node-select-cnt">
            </div>
            <!-- node-select-cnt -->
            <button class="button button-primary moove-importer-create-preview"><?php _e( 'Create Preview' , 'moove' ); ?></button>
        </div>
        <!-- moove-feed-xml-node-select -->
    </div>
    <!-- moove-feed-xml-cnt -->
    <div class="moove-feed-xml-preview moove-hidden">
        <h4><?php _e( 'Moove Feed Xml Preview' , 'moove' ); ?></h4>
        <div class="moove-feed-xml-preview-container">
        </div>
        <!-- moove-feed-xml-preview-container -->
    </div>
    <!-- moove-feed-xml-preview -->
</div>
<!-- moove-feed-importer-from -->




