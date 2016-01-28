
<div class="moove-feed-importer-where">
    <h3>Where</h3>
    <hr>
    <h4>Post Type</h4>
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
                    <div class="moove-importer-taxonomy-box-cnt <?php echo $post_types ?>">
                    <?php foreach ($post_types['taxonomies'] as $taxonomy) : ?>
                        <div class="moove-importer-taxonomy-box">
                            <p class="moove-importer-tax-title"><?php echo $taxonomy->labels->name; ?></p>

                        </div>
                        <!-- moove-importer-taxonomy-box -->
                    <?php endforeach; ?>
                    </div>
                    <!-- moove-importer-taxonomy-box -->
                <?php endif;
            endforeach;
        endif;?>
</div>
<!-- moove-feed-importer-where -->

<div class="moove-feed-importer-from">
    <h3>From</h3>
    <hr>
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
        <input type="file" name="moove_importer_file" id="moove_importer_file"><br />
        <br />
    </div>
    <!-- file-upload moove-importer-src-upload -->
    <a href="#" class="button button-primary moove-importer-read-file">Check DATA</a>

</div>
<!-- moove-feed-importer-from -->




