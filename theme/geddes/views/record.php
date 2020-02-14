<?php

$author_field = $this->skylight_utilities->getField("Creator");
$type_field = $this->skylight_utilities->getField("Type");
$date_field = $this->skylight_utilities->getField("Date");
$parent_id_field = $this->skylight_utilities->getField("Parent_Id");
$parent_type_field = $this->skylight_utilities->getField("Parent_Type");
$id_field = $this->skylight_utilities->getField("Identifier");
$filters = array_keys($this->config->item("skylight_filters"));
$link_uri_field = $this->skylight_utilities->getField("Link");
$image_uri_field = $this->skylight_utilities->getField("ImageUri");
$id = $this->skylight_utilities->getField("Id");
//Insert Schema.org
$schema = $this->config->item("skylight_schema_links");


$link_uri_prefix  = $this->config->item("skylight_link_url");


$mainImageTest = false;
$numThumbnails = 0;
$bitstreamLinks = array();
?>

<div class="col-md-9 col-sm-9 col-xs-12" xmlns="http://www.w3.org/1999/html">

    <div itemscope itemtype ="http://schema.org/CreativeWork">
    <div class="row">
        <h1 class="itemtitle"><?php echo strip_tags($record_title) ?></h1>
    </div>

    <div class="row">
            <div class="btn btn-info"><a href ="<?php echo $solr[$link_uri_field][0]?>" target="_blank">More information</a></div>
    </div>

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
            $nullid = false;
            foreach($recorddisplay as $key) {
                $element = $this->skylight_utilities->getField($key);

                if(isset($solr[$element])) {
                    if (!in_array($key, $excludes)) {
                        echo '<tr><th>' . $key . '</th><td>';
                        foreach ($solr[$element] as $index => $metadatavalue) {
                            // if it's a facet search
                            // make it a clickable search link

                            if (in_array($key, $filters))
                            {
                                $orig_filter = urlencode($metadatavalue);
                                //if ($key == 'Date') {

                                    echo '<a href="./search/*:*/' . $key . ':%22' . strtolower($orig_filter) . '%7C%7C%7C' . $orig_filter . '%22">' . $metadatavalue . '</a>';
                                //}
                                //else
                               // {
                                //    echo '<a href="./search/*:*/' . $key . ':%22' . $orig_filter . '%22">' . $metadatavalue . '</a>';
                                //}
                            }
                            else
                            {
                                if ($key == 'Identifier')
                                {
                                    $nullid = false;
                                    if ((!ctype_digit($metadatavalue)) and (strpos($metadatavalue, "oai:") !== 0) and (strpos($metadatavalue, "http:") !== 0))
                                    {
                                        echo $metadatavalue;
                                    }
                                    else
                                    {
                                        $nullid = true;
                                    }
                                }
                                else
                                {
                                    echo '<span itemprop="'.$schema[$key].'">'. $metadatavalue. "</span>";
                                }
                            }

                            if ($index < sizeof($solr[$element]) - 1) {
                                if(!$nullid) {
                                    echo '<br/>';
                                }
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
    if (isset($solr[$bitstream_field]) && $link_bitstream) {
        echo '<div class="record_bitstreams">';
        $numThumbnails = 0;
        $mainImage = false;
        $videoFile = false;
        $audioFile = false;
        $pdfFile = false;
        $audioLink = "";
        $videoLink = "";
        $pdfLink = "";
        $bitstream_array = array();
        foreach ($solr[$bitstream_field] as $bitstream) {
            $mp4ok = false;
            $b_segments = explode("##", $bitstream);
            $b_filename = $b_segments[1];
            $b_handle = $b_segments[3];
            $b_seq = $b_segments[4];
            $b_handle_id = preg_replace('/^.*\//', '', $b_handle);
            $b_uri = './record/' . $b_handle_id . '/' . $b_seq . '/' . $b_filename;
            if ((strpos($b_filename, ".jpg") > 0) || (strpos($b_filename, ".JPG") > 0)) {
                $bitstream_array[$b_seq] = $bitstream;
            } else if ((strpos($b_uri, ".mp3") > 0) or (strpos($b_uri, ".MP3") > 0)) {
                $audioLink .= '<audio controls>';
                $audioLink .= '<source src="' . $b_uri . '" type="audio/mpeg" />Audio loading...';
                $audioLink .= '</audio>';
                $audioFile = true;
            } else if ((strpos($b_filename, ".mp4") > 0) or (strpos($b_filename, ".MP4") > 0)) {
                $b_uri = $media_uri . $b_handle_id . '/' . $b_seq . '/' . $b_filename;
                // Use MP4 for all browsers other than Chrome
                if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == false) {
                    $mp4ok = true;
                } //Microsoft Edge is calling itself Chrome, Mozilla and Safari, as well as Edge, so we need to deal with that.
                else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') == true) {
                    $mp4ok = true;
                }
                if ($mp4ok == true) {
                    $videoLink .= '<div class="flowplayer" data-analytics="' . $ga_code . '" title="' . $record_title . ": " . $b_filename . '">';
                    $videoLink .= '<video preload=auto loop width="100%" height="auto" controls preload="true" width="660">';
                    $videoLink .= '<source src="' . $b_uri . '" type="video/mp4" />Video loading...';
                    $videoLink .= '</video>';
                    $videoLink .= '</div>';
                    $videoFile = true;
                }
            } else if ((strpos($b_filename, ".webm") > 0) or (strpos($b_filename, ".WEBM") > 0)) {
                //Microsoft Edge needs to be dealt with. Chrome calls itself Safari too, but that doesn't matter.
                if (strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') == false) {
                    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == true) {
                        $b_uri = $media_uri . $b_handle_id . '/' . $b_seq . '/' . $b_filename;
                        // if it's chrome, use webm if it exists
                        $videoLink .= '<div class="flowplayer" data-analytics="' . $ga_code . '" title="' . $record_title . ": " . $b_filename . '">';
                        $videoLink .= '<video preload=auto loop width="100%" height="auto" controls preload="true" width="660">';
                        $videoLink .= '<source src="' . $b_uri . '" type="video/webm" />Video loading...';
                        $videoLink .= '</video>';
                        $videoLink .= '</div>';
                        $videoFile = true;
                    }
                }
            } else if ((strpos($b_uri, ".pdf") > 0) or (strpos($b_uri, ".PDF") > 0)) {
                $bitstreamLink = $this->skylight_utilities->getBitstreamLink($bitstream);
                $bitstreamUri = $this->skylight_utilities->getBitstreamUri($bitstream);
                $pdfLink .= 'Click ' . $bitstreamLink . ' to download. (<span class="bitstream_size">' . getBitstreamSize($bitstream) . '</span>)';
                $pdfFile = true;
            }
        }
        if (count($bitstream_array) > 0) {
            // sorting array so main image is first
            ksort($bitstream_array);
        }
        $b_seq = "";
        foreach ($bitstream_array as $bitstream) {
            $b_segments = explode("##", $bitstream);
            $b_filename = $b_segments[1];
            $b_handle = $b_segments[3];
            $b_seq = $b_segments[4];
            $b_title = $b_segments[6];
            $b_handle_id = preg_replace('/^.*\//', '', $b_handle);
            $b_uri = './record/' . $b_handle_id . '/' . $b_seq . '/' . $b_filename;
            // is there a main image
            if (!$mainImage) {
                $bitstreamLink = '<div class="main-image">';
                $bitstreamLink .= '<a title = "' . $record_title . ' ' . $b_filename . '" class="fancybox" rel="group" href="' . $b_uri . '"> ';
                $bitstreamLink .= '<img class="responsive" src = "' . $b_uri . '">';
                $bitstreamLink .= '</a>';
                $bitstreamLink .= '</div>';
                $mainImage = true;
            } // we need to display a thumbnail
            else {
                // if there are thumbnails
                if (isset($solr[$thumbnail_field])) {
                    foreach ($solr[$thumbnail_field] as $thumbnail) {

                        $t_segments = explode("##", $thumbnail);
                        $t_filename = $t_segments[1];
                        if ($t_filename === $b_filename . ".jpg") {
                            $t_handle = $t_segments[3];
                            $t_seq = $t_segments[4];
                            $t_uri = './record/' . $b_handle_id . '/' . $t_seq . '/' . $t_filename;
                            $thumbnailLink[$numThumbnails] = '<div class="thumbnail-tile';
                            $thumbnailLink[$numThumbnails] .= '"><a title = "' . $record_title . '" class="fancybox" rel="group" href="' . $b_uri . '"> ';
                            $thumbnailLink[$numThumbnails] .= '<img src = "' . $t_uri . '" class="record-thumbnail" title="' . $record_title . ' ' . $t_filename . '" /></a></div>';
                            $numThumbnails++;
                        }
                    }
                }
            }
        }
        // end for each bitstream
        if ($pdfFile) {
            echo '<tr><th>Supporting Document: </th><td>' . $pdfLink . '</td></tr>';
        }



        $i = 0;
        $newStrip = false;
        /*
        if ($numThumbnails > 0) {
            echo '<div class="thumbnail-strip">';
            foreach ($thumbnailLink as $thumb) {
                echo $thumb;
            }
            echo '</div><div class="clearfix"></div>';
        }*/
        if ($audioFile) {
            echo '<br>.<br>' . $audioLink;
        }
        if ($videoFile) {
            echo '<br>.<br>' . $videoLink;
        }
        echo '</div><div class="clearfix"></div>';
        // end if there are bitstreams
        echo '</div>';


    }
    if (isset($solr[$image_uri_field])) {
        if (strpos($solr[$image_uri_field][0], "|") > 0) {
            $image_uri = explode("|", $solr[$image_uri_field][0]);
            $image_filename = $image_uri[0];
            $image_title = $image_uri[1];
        }
        else
        {
            $image_uri = $solr[$image_uri_field][0];
            $image_filename = $image_uri[0];
            $image_title = '';
        }

        $mainImage = true;

        if ($mainImage) { ?>
            <div class="main-image">
                <?php echo '<span itemprop="thumbnailUrl" style="display:none;">'. $image_filename. '</span>';?>
                <!--<img src = "<?php //echo $image_filename ;?>"/>-->
                <div id="openseadragon"> <!--style = "width:600px; height= 450px;">-->
                    <script src="<?php echo base_url() ?>assets/openseadragon/openseadragon.min.js"></script>
                    <script type="text/javascript">
                        OpenSeadragon({
                            id: "openseadragon",
                            prefixUrl: "<?php echo base_url()?>assets/openseadragon/images/",
                            preserveViewport: false,
                            visibilityRatio: 1,
                            minZoomLevel: 0,
                            defaultZoomLevel: 0,
                            panHorizontal: true,
                            sequenceMode: true,
                            tileSources: [{
                                //"height": 600,
                                // tileSize:600,
                                type: 'image',
                                url: '<?php echo $image_filename ; ?>'
                            }]
                        });
                    </script>

                </div>
            </div>
            <br>
            <?php
            if (!$image_title == '') {
                ?>
                <div>
                    <p><i>Image: <?php echo $image_title; ?></i></p>
                </div>

                <?php
            }
        }
    }
        // echo $bitstreamLink;
        echo '<div class="clearfix"></div>';
        ?>

    <div class="row">
        <button class="btn btn-info" onClick="history.go(-1);"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Back to Search Results</button>
    </div>
</div>
    </div>