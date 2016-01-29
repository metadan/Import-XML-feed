
<div class="moove-feed-importer-where moove-hidden">
    <h3>Matching</h3>
    <hr>
    <h4>Select a Post Type</h4>
    <?php if ( count( $data ) ) : ?>
        <select name="moove-importer-post-type-select" id="moove-importer-post-type-select" class="moove-importer-log-settings">
            <?php foreach ($data as $post_types) : ?>
                <option value="<?php echo $post_types['post_type']; ?>"> <?php echo ucfirst( $post_types['post_type'] ); ?> </option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>

    <?php if ( count( $data ) ) :

            foreach ($data as $post_types) :
                if ( count( $post_types['taxonomies'] ) ) : ?>
                    <div class="moove_cpt_tax_<?php echo $post_types['post_type']; ?>">
                        <?php foreach ($post_types['taxonomies'] as $taxonomy) : ?>
                            <div class="moove-importer-taxonomy-box">
                                <hr>
                                <p class="moove-importer-tax-title"><?php echo $taxonomy->labels->name; ?></p>
                                <hr>
                                <p> Title: </p>
                                <select name="moove-importer-post-type-select" id="moove-importer-post-type-select" class="moove-importer-log-settings">
                                    <?php foreach ($data as $post_types) : ?>
                                        <option value="<?php echo $post_types['post_type']; ?>"> <?php echo ucfirst( $post_types['post_type'] ); ?> </option>
                                    <?php endforeach; ?>
                                </select>
                                <p> Slug: </p>
                                 <select name="moove-importer-post-type-select" id="moove-importer-post-type-select" class="moove-importer-log-settings">
                                    <?php foreach ($data as $post_types) : ?>
                                        <option value="<?php echo $post_types['post_type']; ?>"> <?php echo ucfirst( $post_types['post_type'] ); ?> </option>
                                    <?php endforeach; ?>
                                </select>
                                <hr>
                                <br>
                            </div>
                            <!-- moove-importer-taxonomy-box -->
                        <?php endforeach; ?>
                    </div>
                    <!-- moove_cpt_tax -->
                <?php endif;
            endforeach;
        endif;?>
</div>
<!-- moove-feed-importer-where -->

<div class="moove-feed-importer-from">
    <h3>From</h3>
    <hr>
    <div class="moove-feed-xml-cnt">
        <h4>Select the feed source</h4>
        <div class="moove-importer-radio-cnt">
            <input type="radio" id="feed_url" value="url" name="moove-importer-feed-src" checked="true"/>
            <label for="feed_url">URL</label>
            <br>
            <input type="radio" id="feed_upload" value="upload" name="moove-importer-feed-src"/>
            <label for="feed_upload">UPLOAD</label>
        </div>
        <!-- moove-importer-radio-cnt -->
        <br />
        <div class="moove-importer-src-url moove-to-hide">
            <p>http://www.simplyhired.com/c/add-jobs/example-feed.xml</p>
            <label for="moove_importer_url">Type the file URL</label>
            <input type="text" name="moove_importer_url" id="moove_importer_url"><br /><br />
        </div>
        <!-- moove-importer-src-url -->

        <div class="file-upload moove-importer-src-upload moove-to-hide moove-hidden ">
            <?php _e('Select XML file','moove'); ?>:
            <br />
            <form id="moove_file_importer_form">
                <input type="file" name="moove_importer_file" id="moove_importer_file"><br />
            </form>
            <br />
        </div>
        <!-- file-upload moove-importer-src-upload -->
        <button class="button button-primary moove-importer-read-file">Check DATA</button>
        <div class="moove-feed-xml-error moove-hidden">
            <h4 style="color: red"><strong>Wrong or unreadable XML file! Please try again!</strong></h4>
        </div>
        <!-- moove-feed-xml-error -->
    </div>
    <!-- moove-feed-xml-cnt -->
    <div class="moove-feed-xml-preview moove-hidden">
        <h4>Moove Feed Xml Preview</h4>
    </div>
    <!-- moove-feed-xml-preview -->

</div>
<!-- moove-feed-importer-from -->




