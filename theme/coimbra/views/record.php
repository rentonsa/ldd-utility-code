<?php

//Fast access to important variables
$title = $this->skylight_utilities->getField("Title");
$coverImageName = $this->skylight_utilities->getField("Image File Name");
$logoImageName = $this->skylight_utilities->getField("Logo");
$imageURI = $this->skylight_utilities->getField("Image URL");
$location = $this->skylight_utilities->getField("Institutional Map Reference");
$filters = array_keys($this->config->item("skylight_filters"));

$institutionUri= $this->skylight_utilities->getField("Institutional Web URL");

$title = isset( $solr[$title] ) ? $solr[$title][0] : "Untitled";
$institutionUri = isset( $solr[$institutionUri] ) ? $solr[$institutionUri][0] : "";
$iiifJson = isset( $solr[$imageURI] ) ? $solr[$imageURI][0] : "";

//Image setup
$image_name = isset( $solr[$coverImageName][0] ) ? $solr[$coverImageName][0] : "missing.jpg";
$imageServer = $this->config->item('skylight_image_server');

if($iiifJson != "") {
        $coverImageJSON = substr($iiifJson, 0, -10);
        $json = file_get_contents($iiifJson);
} else {
        $coverImageJSON = $imageServer . "/iiif/2/" . $image_name;
        $json = file_get_contents($coverImageJSON);
}

$coverImageURL = $coverImageJSON . '/full/full/0/default.jpg';
$jobj = json_decode($json, true);
$error = json_last_error();
$jsonheight = $jobj['height'];
$jsonwidth = $jobj['width'];

?>

<!--Seadragon image viewer-->
<div id="toolbarDiv" class="toolbar">
    <h2 id="zoom-in"></h2>
    <h2 id="zoom-out"></h2>
    <h2 id="home"></h2>
    <h2 class="visible-xs" onclick="$('html, body').animate({scrollTop: $('.record-info').offset().top-50},1000);">
        <i class="fa fa-info" aria-hidden="true"></i>
    </h2>
</div>

<div id="openseadragon" class="cover-image-container full-width">
</div>


<!--Page-specific script to load the record image-->
<script>
    var imageURL = <?php echo json_encode($coverImageJSON); ?>;
    var imageHeight = <?php echo json_encode($jsonheight); ?>;
    var imageWidth = <?php echo json_encode($jsonwidth); ?>;
</script>
<script src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/js/openseadragon.min.js"></script>
<script src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/js/openseadragonconfig.js"></script>

<!--Record information-->
<div class="record-info">
    <h1 class="itemtitle">
        <div class="backbtn">
            <i class="fa fa-arrow-left" aria-hidden="true" type="button" value="Back to Search Results" title="Back to Search Results" onClick="history.go(-1);"></i>
        </div>
        <?php echo $title ?>
    </h1>
    <div class="description">
        <?php
        foreach($recorddisplay as $key) {
            $element = $this->skylight_utilities->getField($key);

            if(isset($solr[$element])) {
                echo '<div class="row"><span class="field">' . $key . '</span>';
                foreach($solr[$element] as $index => $metadatavalue) {

                    if(in_array($key, $filters)) {

                        $orig_filter = urlencode($metadatavalue);
                        $lower_orig_filter = strtolower($metadatavalue);
                        $lower_orig_filter = urlencode($lower_orig_filter);

                        echo '<a href="./search/*:*/' . $key . ':%22'.$lower_orig_filter.'%7C%7C%7C'.$orig_filter.'%22" title="'.$metadatavalue.'">'.$metadatavalue.'</a>';
                    }
                    else {
                        if (stripos($element, "uri") !== FALSE) {
                            echo '<a href="' . $solr[$element][0] . '" title="URL Links for item" target="_blank">' . $solr[$element][0] . '</a>';

                        }
                        else {
                            echo $solr[$element][0];
                        }
                    }

                }
                echo '</div>';
            }
        }
        ?>
        <div id="map">
            <script>
                $(window).bind("load", function() {
                    <?php
                    echo 'initMap(convertToCoordinates("' . $solr[$location][0] . '"));';
                    $location = $solr[$location][0] . '", "' . addslashes($title) . '", 0, "../theme/coimbra/images/pinpoint.png", 1';
                    echo 'addLocation("' . $location . ');';
                    ?>
                });
            </script>
        </div>
        <div class="institution-logo row">
            <?php
            if (isset($solr[$logoImageName]))
            {
                $t_segments = explode("##", $solr[$logoImageName][0]);
                $t_filename = $t_segments[1];

                $t_handle = $t_segments[3];
                $t_handle_id = preg_replace('/^.*\//', '',$t_handle);
                $t_seq = $t_segments[4];
                $t_uri = './record/' . $t_handle_id . '/' . $t_seq . '/' . $t_filename;
                $LogoLink = '<a href="' . $institutionUri . '" title="Link to Institution" target="_blank"><img src = "' . $t_uri . '" class="uni-thumbnail" /></a>';

                echo $LogoLink;
            }
            ?>

        </div>
        <?php include('description.php');?>
        <i class="fa fa-angle-double-down hidden-xs hidden-sm" aria-hidden="true"></i>
    </div>
</div>

<div class="content hidden">



