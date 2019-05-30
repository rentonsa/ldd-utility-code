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
$item_image_filed = $this->skylight_utilities->getField('ItemImage');

$link_uri_prefix  = $this->config->item("skylight_link_url");

$schema = $this->config->item("skylight_schema_links");

$mainImageTest = false;
$numThumbnails = 0;
$bitstreamLinks = array();
?>

<!---->
<div itemscope itemtype ="http://schema.org/CreativeWork">
<div class="col-md-9 col-sm-9 col-xs-12" xmlns="http://www.w3.org/1999/html">
    <div class="row">
        <h1 class="itemtitle"><?php echo strip_tags($record_title) ?></h1>
    </div>

    <!--<div class="row">
    <button class="btn btn-info"><a href ="<?php echo $link_uri_prefix ?><?php echo $solr[$id][0] ?>"
                                    title="Full record at archives online " target="_blank">
            View full record in University of Edinburgh Archives Online <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a></button>
    </div>-->

    <div class="row full-metadata">
        <table class="table">
            <tbody>

            <?php
            
            

            if(isset($solr[$parent_id_field])) {

                echo '<tr><th>Hierarchy</th><td>';
                echo '<a href ="./record/' . $solr[$parent_id_field][0] .'/'. $solr[$parent_type_field][0] . '" > Parent Record </a>';
                echo '</td><tr>';
            }
            ?>

            <?php $excludes = array("");
            $idset = false;
           
            $tileSource = $this->config->item("skylight_image_server") . "/iiif/2/" . $solr[$item_image_filed][0] . "/info.json";


            $imagesmall = str_replace('/info.json', '/full/150,/0/default.jpg', $tileSource);
            //Insert Schema
            echo '<span itemprop="thumbnailUrl" style="display:none;">'. $imagesmall . '</span>';


            ?>

            
            
            <div class="full-image">
                    <div id="openseadragon" class="image-toggle">
                        <script type="text/javascript">
                            OpenSeadragon({
                                id: "openseadragon",
                                prefixUrl: "<?php echo base_url();?>theme/jlss/images/buttons/",
                                preserveViewport: false,
                                visibilityRatio: 1,
                                minZoomLevel: 0,
                                defaultZoomLevel: 0,
                                panHorizontal: true,
                                sequenceMode: false,
                                tileSources: ["<?php echo $tileSource; ?>"]
                            });
                        </script>
                    </div>
                </div>

                <div class="image-disclaimer">
                    <p class="image-disclaimer">
                        * All reasonable steps have been taken to establish copyright on the above image. If you feel that copyright has been infringed 
                        and would like to request that this image be taken down, please contact a member of <a href="https://www.sjac.org.uk/contact/" class="image-disclaimer">SJAC</a>
                    </p>

            <!--echo '<img class="record_image" src="' .  . 'http://test.cantaloupe.is.ed.ac.uk/iiif/2/info.json">';-->

            <?php

            $colName = "";

            foreach($recorddisplay as $key) {
                $element = $this->skylight_utilities->getField($key);

                
                if(isset($solr[$element])) {
                    if(!in_array($key, $excludes)) {
                        echo '<tr><th>'.$key.'</th><td>';

                        foreach($solr[$element] as $index => $metadatavalue) {

                            // Get collection name for return button
                            if($key == 'Collection'){
                                $colName = $metadatavalue;
                            }
                            
                            // if it's a facet search
                            // make it a clickable search link

                            if($key == 'Subject') {

                                $orig_filter = urlencode($metadatavalue);
                                $lower_orig_filter = strtolower($metadatavalue);
                                $lower_orig_filter = urlencode($lower_orig_filter);

                                echo '<span itemprop="'.$schema[$key].'"><a href="./search/*:*/' . $key . ':%22'.$lower_orig_filter.'%7C%7C%7C'.$orig_filter.'%22">'.$metadatavalue.'</a></span>';
                            }
                            else {

                                //Insert Schema.org
                                if (isset ($schema[$key]))
                                {
                                    echo '<span itemprop="'.$schema[$key].'">' . $metadatavalue . '</span>';
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
            </tbody>
        </table>
    </div>
    <?php
    $title = preg_replace('/\s/', "+", $colName);
    echo '<div class="row">
        <a href="' . base_url() . $this->config->item('skylight_theme') . '/search/*:*/Collection:%22' .strtolower(preg_replace('/([A-Z]+)/', "$1", $title)) .'%7C%7C%7C' . $title .'%22"><button class="btn btn-info"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Back to '. $colName .'</button>
    </div>'
    ?>

    <!-- regular expression for search url string -->
    <?php /*
        $test = preg_replace('/\s/', "+", $colName);
        print_r($test);
        $final = strtolower(preg_replace('/([A-Z]+)/', "$1", $test));
        print_r($final);*/
    ?>


</div>
</div>