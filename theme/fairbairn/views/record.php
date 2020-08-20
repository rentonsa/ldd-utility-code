<?php

$author_field = $this->skylight_utilities->getField("Creator");
$type_field = $this->skylight_utilities->getField("Type");
$date_field = $this->skylight_utilities->getField("Date");
$parent_id_field = $this->skylight_utilities->getField("Parent_Id");
$parent_type_field = $this->skylight_utilities->getField("Parent_Type");
$id_field = $this->skylight_utilities->getField("Identifier");
$filters = array_keys($this->config->item("skylight_filters"));
$link_uri_field = $this->skylight_utilities->getField("Link");

$mainImageTest = false;
$numThumbnails = 0;
$bitstreamLinks = array();
//Insert Schema.org
$schema = $this->config->item("skylight_schema_links");
?>

<div class="content">
  <!--Insert Schema-->
  <div itemscope itemtype ="http://schema.org/CreativeWork">

    <div class="full-title">
        <h1 class="itemtitle"><?php echo $record_title ?></h1>
    </div>
    <?php
    if(isset($solr[$parent_id_field])) {
       echo '<a href ="./record/' . $solr[$parent_id_field][0] .'/'. $solr[$parent_type_field][0] . '" > Parent Record </a>';
    }
    ?>


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
                                //Insert Schema.org
                                if (isset ($schema[$key]))
                                {
                                    echo '<span itemprop="'.$schema[$key].'"><a href="./search/*:*/' . $key . ':%22' . $orig_filter . '%22" title="'. $metadatavalue . '">' . $metadatavalue . '</a></span>';
                                }
                                else
                                {
                                    echo '<a href="./search/*:*/' . $key . ':%22'.$orig_filter.'%22" title="'. $metadatavalue . '">'.$metadatavalue.'</a>';
                                }

                            }
                            else {
                                if ($key == 'Identifier')
                                {
                                    if ($idset == false)
                                    {
                                        echo '<span itemprop="'.$schema[$key].'">'. $metadatavalue. "</span>";
                                        $idset = true;
                                    }
                                }
                                else
                                {
                                    if (isset ($schema[$key]))
                                    {
                                        echo '<span itemprop="'.$schema[$key].'">'. $metadatavalue. "</span>";
                                    }
                                    else
                                    {
                                        echo $metadatavalue;
                                    }
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
                    if (isset($solr[$id_field]) && 0 === strpos($solr[$id_field][0], 'MS'))
                    {
                        echo '<td><a href="https://www.nls.uk/" target="_blank" title="National Library of Scotland">National Library of Scotland</a></td>';
                    }
                    else
                    {
                        echo '<td><a href="https://www.ed.ac.uk/information-services/library-museum-gallery/crc" target="_blank"
                        title="University of Edinburgh, Centre for Research Collections">University of Edinburgh, Centre for Research Collections</a></td>';
                    }
                    ?>
                </tr>
            </tbody>
        </table>
    <div class="clearfix"></div>


    <input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
</div>
</div>
</div>
