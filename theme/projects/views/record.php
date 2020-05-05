<?php

$author_field = $this->skylight_utilities->getField("Principal Investigator");
$type_field = $this->skylight_utilities->getField("Type");
$bitstream_field = $this->skylight_utilities->getField("Bitstream");
$thumbnail_field = $this->skylight_utilities->getField("Thumbnail");
$area_field = $this->skylight_utilities->getField("Business Area");
$link_uri_field = $this->skylight_utilities->getField("Link");
$filters = array_keys($this->config->item("skylight_filters"));
$admin_link = $this->config->item("skylight_admin_link");

$type = 'Unknown';
$numThumbnails = 0;
$bitstreamLinks = array();

?>

<h1 class="itemtitle"><?php echo $record_title ?></h1>
<div class="tags">
    <?php

    if (isset($solr[$area_field])) {
        foreach($solr[$area_field] as $area) {

            $orig_filter = urlencode($area);

            $lower_orig_filter = strtolower($area);
            $lower_orig_filter = urlencode($lower_orig_filter);

            echo '<a class="$month" href="./search/*:*/Business Area:%22'.$lower_orig_filter.'%7C%7C%7C'.$orig_filter.'%22">'.$area.'</a>';
        }
    }

    ?>
</div>

<div class="content">
    <table>
        <tbody>
        <?php foreach($recorddisplay as $key) {

            $element = $this->skylight_utilities->getField($key);
            if(isset($solr[$element])) {
                echo '<tr><th>'.$key.'</th><td>';
                foreach($solr[$element] as $index => $metadatavalue) {
                    // if it's a facet search
                    // make it a clickable search link
                    if(in_array($key, $filters)) {

                        $orig_filter = urlencode($metadatavalue);
                        $lower_orig_filter = strtolower($metadatavalue);
                        $lower_orig_filter = urlencode($lower_orig_filter);

                        echo '<a href="./search/*:*/' . $key . ':%22'.$lower_orig_filter.'%7C%7C%7C'.$orig_filter.'%22" title="'.$metadatavalue.'">'.$metadatavalue.'</a>';
                    }
                    else {
                        echo $metadatavalue;
                    }
                    if($index < sizeof($solr[$element]) - 1) {
                        echo '; ';
                    }
                }
                echo '</td></tr>';
            }

        }
        ?>
        </tbody>
    </table>

    <a href="https://collectionsmanager.is.ed.ac.uk/tools/edit-item?item_id=<?php echo($solr['searchresourceid'][0]) ?>&submit=Edit..." target="_blank">Link to Admin</a>

    <?php if(isset($solr[$bitstream_field]) && $link_bitstream) { ?>

        <div class="record_bitstreams"><?php

        $mainImage = false;
        $videoFile = false;
        $audioFile = false;
        $audioLink = "";
        $videoLink = "";

        foreach ($solr[$bitstream_field] as $bitstream)
        {
            $b_segments = explode("##", $bitstream);
            $b_filename = $b_segments[1];
            $b_seq = $b_segments[4];

            if((strpos($b_filename, ".jpg") > 0) || (strpos($b_filename, ".JPG") > 0)) {

                $bitstream_array[$b_seq] = $bitstream;

            }
        }

        // sorting array so main image is first
        ksort($bitstream_array);

        $b_seq =  "";

        foreach($bitstream_array as $bitstream) {

            $mp4ok = false;
            $b_segments = explode("##", $bitstream);
            $b_filename = $b_segments[1];
            $b_handle = $b_segments[3];
            $b_seq = $b_segments[4];
            $b_handle_id = preg_replace('/^.*\//', '',$b_handle);
            $b_uri = './record/'.$b_handle_id.'/'.$b_seq.'/'.$b_filename;

            if ((strpos($b_uri, ".jpg") > 0) or (strpos($b_uri, ".JPG") > 0))
            {
                // is there a main image
                if (!$mainImage) {

                    $bitstreamLink = '<div class="main-image">';

                    $bitstreamLink .= '<a title = "' . $record_title . '" class="fancybox" rel="group" href="' . $b_uri . '"> ';
                    $bitstreamLink .= '<img class="record-main-image" src = "'. $b_uri .'">';
                    $bitstreamLink .= '</a>';

                    $bitstreamLink .= '</div>';

                    $mainImage = true;

                }
                // we need to display a thumbnail
                else {

                    // if there are thumbnails
                    if(isset($solr[$thumbnail_field])) {
                        foreach ($solr[$thumbnail_field] as $thumbnail) {

                            $t_segments = explode("##", $thumbnail);
                            $t_filename = $t_segments[1];

                            if ($t_filename === $b_filename . ".jpg") {

                                $t_handle = $t_segments[3];
                                $t_seq = $t_segments[4];
                                $t_uri = './record/'.$b_handle_id.'/'.$t_seq.'/'.$t_filename;

                                $thumbnailLink[$numThumbnails] = '<div class="thumbnail-tile';

                                if($numThumbnails % 4 === 0) {
                                    $thumbnailLink[$numThumbnails] .= ' first';
                                }

                                $thumbnailLink[$numThumbnails] .= '"><a title = "' . $record_title . '" class="fancybox" rel="group" href="' . $b_uri . '"> ';
                                $thumbnailLink[$numThumbnails] .= '<img src = "'.$t_uri.'" class="record-thumbnail" title="'. $record_title .'" /></a></div>';

                                $numThumbnails++;
                            }
                        }
                    }

                }

            }
            else if ((strpos($b_uri, ".mp3") > 0) or (strpos($b_uri, ".MP3") > 0)) {

                $audioLink .= '<audio controls>';
                $audioLink .= '<source src="' . $b_uri . '" type="audio/mpeg" />Audio loading...';
                $audioLink .= '</audio>';
                $audioFile = true;

            }

            else if ((strpos($b_filename, ".mp4") > 0) or (strpos($b_filename, ".MP4") > 0))
            {
                $b_uri = $media_uri.$b_handle_id.'/'.$b_seq.'/'.$b_filename;
                // Use MP4 for all browsers other than Chrome
                if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == false)
                {
                    $mp4ok = true;
                }
                //Microsoft Edge is calling itself Chrome, Mozilla and Safari, as well as Edge, so we need to deal with that.
                else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') == true)
                {
                    $mp4ok = true;
                }

                if ($mp4ok == true)
                {
                    $videoLink .= '<div class="flowplayer" data-analytics="' . $ga_code . '" title="' . $record_title . ": " . $b_filename . '">';
                    $videoLink .= '<video preload=auto loop width="100%" height="auto" controls preload="true" width="660">';
                    $videoLink .= '<source src="' . $b_uri . '" type="video/mp4" />Video loading...';
                    $videoLink .= '</video>';
                    $videoLink .= '</div>';
                    $videoFile = true;
                }
            }

            else if ((strpos($b_filename, ".webm") > 0) or (strpos($b_filename, ".WEBM") > 0))
            {
                //Microsoft Edge needs to be dealt with. Chrome calls itself Safari too, but that doesn't matter.
                if (strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') == false)
                {
                    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == true)
                    {
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
            }

            ?>
        <?php
        } // end for each bitstream


        if($mainImage) {

            echo $bitstreamLink;
            echo '<div class="clearfix"></div>';
        }

        $i = 0;
        $newStrip = false;
        if($numThumbnails > 0) {

            echo '<div class="thumbnail-strip">';

            foreach($thumbnailLink as $thumb) {

                if($newStrip)
                {

                    echo '</div><div class="clearfix"></div>';
                    echo '<div class="thumbnail-strip">';
                    echo $thumb;
                    $newStrip = false;
                }
                else {

                    echo $thumb;
                }

                $i++;

                // if we're starting a new thumbnail strip
                if($i % 4 === 0) {
                    $newStrip = true;
                }
            }

            echo '</div><div class="clearfix"></div>';
        }

        if($audioFile) {

            echo $audioLink;
        }

        if($videoFile) {

            echo $videoLink;
        }

        echo '</div><div class="clearfix"></div>';

        }

        echo '</div>';
        ?>




<input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">


