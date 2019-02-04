<?php

// Set up some variables to easily refer to particular fields you've configured
$id_field = $this->skylight_utilities->getField('ID');
$title_field = $this->skylight_utilities->getField('Title');
$coverImageName = $this->skylight_utilities->getField("Image File Name");
$location = $this->skylight_utilities->getField("Institutional Map Reference");
$image = $this->skylight_utilities->getField("Image URL");
$imageServer = $this->config->item('skylight_image_server');


$base_parameters = preg_replace("/[?&]sort_by=[_a-zA-Z+%20. ]+/", "", $base_parameters);
if ($base_parameters == "") {
    $sort = '?sort_by=';
} else {
    $sort = '&sort_by=';
}
?>

<div class="row">
    <div class="col-md-7 col-xs-12 gallery">
        <div class="col-xs-12 text-center visible-xs">
            <h5 class="text-muted">All <?php echo urldecode($searchbox_query) ?> records </h5>
        </div>
        <div id="gallery-container">
            <script>
                $(window).bind("load", function() {
                    initMap();
                });
            </script>
            <?php
            foreach ($docs as $doc) {

                $title = isset( $doc[$title_field][0] ) ? $doc[$title_field][0] : "Untitled";

                /* temporarily commenting out thumbnail from external IIIF because of LUNA
                   scaling issues making the thumbnails look grainy
                //              Finding image
                if(isset( $doc[$image][0] )){
                    // Remove json.config from the end of the link
                    $coverImageJSON = substr($doc[$image][0], 0, -10);
                }
                else */if(isset( $doc[$coverImageName][0] )) {
                    $coverImageJSON = $imageServer . "/iiif/2/" . $doc[$coverImageName][0];
                }
                else{
                    $coverImageJSON = $imageServer . "/iiif/2/missing.jpg";
                }
                $coverImageURL = $coverImageJSON . '/full/400,/0/default.jpg';
                $coverImageURLMap = $coverImageJSON . '/full/50,/0/default.jpg';
                $thumbnailLink = '<img class="img-responsive" src ="' . $coverImageURL . '" title="' . $title . '" />';

                if(isset( $doc[$location][0])) {
                    echo '
                        <script>
                            $(window).bind("load", function() {
                                addLocation("', $doc[$location][0], '", "', addslashes($title), '", "', $doc['id'],
                                            '", "', $coverImageURLMap, '");
                            });
                        </script>
                    ';
                }

                ?>
                <a href="./record/<?php echo $doc['id'] ?>" class="<?php echo $doc['id'] ?> row record visible">
                    <!--                    Title-->
                    <h4 class="result-info record-title">
                        <?php echo $title;?>
                    </h4>
                    <!--                    Thumbnail-->
                    <?php echo $thumbnailLink; ?>
                </a>
                <?php
            } // end for each search result
            ?>
        </div>
    </div>

