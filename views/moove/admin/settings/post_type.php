
<div class="moove-feed-importer-where moove-hidden">
<!-- <div class="moove-feed-importer-where "> -->
    <h3>Matching</h3>
    <hr>
    <h4>Select a Post Type</h4>
    <?php if ( count( $data ) ) : ?>
        <select name="moove-importer-post-type-select" id="moove-importer-post-type-select" class="moove-importer-log-settings">
            <option value="0">Select a post type</option>
            <?php foreach ($data as $post_types) : ?>
                <option value="<?php echo $post_types['post_type']; ?>"> <?php echo ucfirst( $post_types['post_type'] ); ?> </option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>

    <?php if ( count( $data ) ) : ?>
        <div class="moove-feed-importer-taxonomies moove-hidden">
            <div class="moove-post-fields">
                <h4>Post status</h4>
                <select name="moove-importer-post-type-status" id="moove-importer-post-type-status" >
                    <option value="publish">Published</option>
                    <option value="pending">Pending review</option>
                    <option value="draft">Draft</option>
                </select>
                <h4>Post title</h4>
                <select name="moove-importer-post-type-posttitle" id="moove-importer-post-type-posttitle" class="moove-importer-dynamic-select">

                </select>
                <h4>Featured image url</h4>
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
                    <h4>Taxonomies</h4>
                    <?php foreach ($post_types['taxonomies'] as $taxonomy) :
                        $i++;
                        ?>
                        <div class="moove-importer-taxonomy-box">
                            <p class="moove-importer-tax-title"><?php echo $taxonomy->labels->name; ?></p>
                            <hr>
                            <p> Title: </p>
                            <select name="moove-importer-post-type-title<?php echo $i; ?>" id="moove-importer-post-type-title-<?php echo $i; ?>" class="moove-importer-log-settings moove-importer-dynamic-select">
                                <?php foreach ($data as $post_types) : ?>

                                    <option value="<?php echo $post_types['post_type']; ?>"> <?php echo ucfirst( $post_types['post_type'] ); ?> </option>
                                <?php endforeach; ?>
                            </select>
                            <p> Slug: </p>
                             <select name="moove-importer-post-type-title<?php echo $i; ?>" id="moove-importer-post-type-slug-<?php echo $i; ?>" class="moove-importer-log-settings moove-importer-dynamic-select">
                                <?php foreach ($data as $post_types) : ?>
                                    <option value="<?php echo $post_types['post_type']; ?>"> <?php echo ucfirst( $post_types['post_type'] ); ?> </option>
                                <?php endforeach; ?>
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
        <a href="#" class="button button-primary moove-start-import-feed">IMPORT</a>
    </div>
    <!-- moove-submit-btn-cnt -->
</div>
<!-- moove-feed-importer-where -->

<div class="moove-feed-importer-from">
    <h3>From</h3>
    <span> <a href="#" class="select_another_source button button-secondary"> Select Another Source </a> </span>
    <hr>
    <div class="moove-feed-xml-cnt">

        <form action="" class="moove-feed-importer-src-form">
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
                <input type="file" name="moove_importer_file" id="moove_importer_file"><br /><br />
            </div>
            <!-- file-upload moove-importer-src-upload -->
            <button class="button button-primary moove-importer-read-file">Check DATA</button>
            <div class="moove-feed-xml-error moove-hidden">
                <h4 style="color: red"><strong>Wrong or unreadable XML file! Please try again!</strong></h4>
            </div>
            <!-- moove-feed-xml-error -->
        </form>
        <div class="moove-feed-xml-node-select moove-hidden">
            <div class="node-select-cnt">

            </div>
            <button class="button button-primary moove-importer-create-preview">Create Preview</button>
        </div>
        <!-- moove-feed-xml-node-select -->

    </div>
    <!-- moove-feed-xml-cnt -->
    <div class="moove-feed-xml-preview moove-hidden">
        <h4>Moove Feed Xml Preview</h4>

        <div class="moove-feed-xml-preview-container">

        </div>
        <!-- moove-feed-xml-preview-container -->

    </div>
    <!-- moove-feed-xml-preview -->

</div>
<!-- moove-feed-importer-from -->




