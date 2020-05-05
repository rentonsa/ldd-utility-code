<?php

$author_field = $this->skylight_utilities->getField("Creator");
$type_field = $this->skylight_utilities->getField("Type");
$date_field = $this->skylight_utilities->getField("Date");
$parent_id_field = $this->skylight_utilities->getField("Parent_Id");
$parent_type_field = $this->skylight_utilities->getField("Parent_Type");
$id_field = $this->skylight_utilities->getField("Identifier");
$filters = array_keys($this->config->item("skylight_filters"));
$link_uri_field = $this->skylight_utilities->getField("Link");
$id = $this->skylight_utilities->getField("Id");

$link_uri_prefix  = $this->config->item("skylight_link_url");


$mainImageTest = false;
$numThumbnails = 0;
$bitstreamLinks = array();
?>

<div class="content">

    <div class="full-title">
        <h1 class="itemtitle"><?php echo $record_title ?></h1>
    </div>



    <a href ="<?php echo $link_uri_prefix ?><?php echo $solr[$id][0] ?>" title="Full record at archive collections online " target="_blank">View full record in University of Edinburgh archives catalogue</a>
    <div class="full-metadata">
        <table>
            <tbody>
            <?php $excludes = array("");
            $idset = false;
            foreach($recorddisplay as $key) {
                $element = $this->skylight_utilities->getField($key);

                if(isset($solr[$element])) {
                    if(!in_array($key, $excludes)) {
                        echo '<tr><th>'.$key.'</th><td>';
                        foreach($solr[$element] as $index => $metadatavalue) {
                            // if it's a facet search
                            // make it a clickable search link
                            if(in_array($key, $filters)) {

                                $orig_filter = urlencode($metadatavalue);

                                echo '<a href="./search/*:*/' . $key . ':%22'.$orig_filter.'%22">'.$metadatavalue.'</a>';
                            }
                            else
                            {
                                if ($key == 'Identifier')
                                {
                                    if ($idset == false)
                                    {
                                        echo $metadatavalue;
                                        $idset = true;
                                    }
                                }
                                else
                                {
                                    echo $metadatavalue;
                                }

                            }

                            if($index < sizeof($solr[$element]) - 1) {
                                echo '<br/>';
                            }
                        }
                        echo '</td></tr>';
                    }
                }
            }
            ?>

            <tr><th>Consult at</th>
                    <?php

                        echo '<td><a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc/visitor-information/opening-times-location" target="_blank"
                        title="University of Edinburgh, Centre for Research Collections">University of Edinburgh, Centre for Research Collections</a></td>';
                    ?>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>


    <input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
</div>