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

if (isset($solr[$coverImageName][0]))
{

    if (strpos($solr[$coverImageName][0], 'ttps') > 0)
    {
        $coverImageJSON = str_replace("/full/full/0/default.jpg", '/info.json', $solr[$coverImageName][0]);
        $coverImageURL = $solr[$coverImageName][0];
    }
    else
    {
        $coverImageJSON = $imageServer . "/iiif/2/" . $solr[$coverImageName][0]."/info.json";
        $coverImageURL = $coverImageJSON . '/full/full/0/default.jpg';

    }

}


?>


<script src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/js/openseadragon.min.js"></script>

<div id="openseadragon" class="cover-image-container full-width" >
    <script type="text/javascript">
        OpenSeadragon({
            id: "openseadragon",
            prefixUrl: "<?php echo base_url();?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/buttons/",
            preserveViewport: false,
            visibilityRatio: 1,
            minZoomLevel: 0,
            defaultZoomLevel: 0,
            panHorizontal: true,
            sequenceMode: true,
            tileSources: ["<?php echo $coverImageJSON; ?>"]
        });
    </script>
</div>





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
                $n = 0;
                foreach($solr[$element] as $index => $metadatavalue) {

                    if(in_array($key, $filters)) {

                        $orig_filter = urlencode($metadatavalue);
                        $lower_orig_filter = strtolower($metadatavalue);
                        $lower_orig_filter = urlencode($lower_orig_filter);

                        echo '<a href="./search/*:*/' . $key . ':%22'.$lower_orig_filter.'%7C%7C%7C'.$orig_filter.'%22">'.$metadatavalue.'</a><br>';
                    }
                    else {
                        if (stripos($element, "uri") !== FALSE)
                        {
                            if (stripos($solr[$element][$n], "http") !== FALSE) {
                                $solr[$element][$n] = $solr[$element][$n];
                            }
                            else
                            {
                                $solr[$element][$n] = "https://". $solr[$element][$n];
                            }

                            echo '<a href="' . $solr[$element][$n] . '" title="URL Links for item" target="_blank">' . $solr[$element][$n] . '</a>';

                        }
                        else
                        {

                            echo $solr[$element][$n]."\n";
                        }
                    }
                    $n = $n + 1;

                }
                echo '</div>';
            }
        }
        ?>
        <div id="map">
           <!-- <h2>MAP HERE!</h2>-->
            <script>
                $(window).bind("load", function() {
                    <?php
                    echo 'initMap(convertToCoordinates("' . $solr[$location][0] . '"));';
                    $location = $solr[$location][0] . '", "' . addslashes($title) . '", 0, "../theme/coimbra/images/pinpoint.png", 1';
                    echo 'addLocation("' . $location . ');';
                    ?>
                });
            </script>-
        </div>
        <div class="institution-logo row">
            <?php
            if (isset($solr[$logoImageName]))
            {
                echo $solr[$logoImageName][0];
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
        <?php //include('description.php');?>
        <i class="fa fa-angle-double-down hidden-xs hidden-sm" aria-hidden="true"></i>
    </div>
</div>

<div class="content hidden">



