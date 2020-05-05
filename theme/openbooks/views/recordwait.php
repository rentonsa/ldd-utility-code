<?php

$type_field = $this->skylight_utilities->getField("Type");
$subject_field = $this->skylight_utilities->getField("Subject");
$uri_field = $this->skylight_utilities->getField("Link");
$filters = array_keys($this->config->item("skylight_filters"));
$media_uri = $this->config->item("skylight_media_url_prefix");

$type = 'Unknown';
$numThumbnails = 0;
$bitstreamLinks = array();

if(isset($solr[$type_field])) {
    $type = "media-" . strtolower(str_replace(' ','-',$solr[$type_field][0]));
}


?>

<h1 class="itemtitle"><?php echo $record_title ?></h1>
<div class="tags">
    <?php

    if (isset($solr[$subject_field])) {
        foreach($solr[$subject_field] as $subject) {

            $orig_filter = urlencode($subject);

            $lower_orig_filter = strtolower($subject);
            $lower_orig_filter = urlencode($lower_orig_filter);

            echo '<a class="$month" href="./search/*:*/%22Subject'.$lower_orig_filter.'%7C%7C%7C'.$orig_filter.'%22">'.$subject.'</a>';
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

    if(isset($solr[$uri_field])) {

        foreach($solr[$uri_field] as $uri) {
            $find   = 'http://hdl.handle.net';
            $findPrimo = 'http://discovered.ed.ac.uk';
            $pos = strpos($uri, $find);

            if ($pos === false)
            {
                echo '<tr><th>Link</th><td>';
                $primopos = strpos($uri, $findPrimo);

                if ($primopos !== false)
                {

                    echo '<a href="'.$uri.'" title="Link to Library catalogue entry" target="_blank">Library Catalogue Entry</a>';
                }
                else{
                    echo '<a href="'.$uri.'" title="Link to '.$uri.'" target="_blank">'.$uri.'</a>';
                }
                if($index < sizeof($solr[$uri_field]) - 1) {
                    echo '<br />';
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
    //only bitstreams to process will be pdfs as it stands. If images are required, we will create a JIRA for them.
    if(isset($solr[$bitstream_field]) && $link_bitstream) {
    ?><div class="record_bitstreams"><?php

        $numBitstreams = 0;
        $videoFile = false;
        $audioFile = false;
        $audioLink = "";
        $videoLink = "";
        $b_seq =  "";
    foreach($solr[$bitstream_field] as $bitstream) {
        $bitstreamLink = $this->skylight_utilities->getBitstreamLink($bitstream);
        $bitstreamUri = $this->skylight_utilities->getBitstreamUri($bitstream);

        if (strpos($bitstreamLink, ".pdf") >0) {
            ?>

            <object class="pdfviewer" width="660" height="928" data="<?php echo $bitstreamUri ?>"
                    type="application/pdf">
                <p><span class="label">
            It appears you do not have a PDF plugin for this browser.</span>
                </p>
            </object>
            <br>
            Click <?php echo $bitstreamLink ?> to download.
            (<span class="bitstream_size"><?php echo getBitstreamSize($bitstream); ?></span>)<br><br>

            <?php
        }

        else {

            $b_segments = explode("##", $bitstream);
            $b_filename = $b_segments[1];
            $b_handle = $b_segments[3];
            $b_seq = $b_segments[4];
            $b_handle_id = preg_replace('/^.*\//', '', $b_handle);

            if ((strpos($b_filename, ".jpg") > 0) or (strpos($b_filename, ".JPG") > 0)) {
                echo 'FILE'.$b_filename;
                echo 'SIZE'.getimagesize($b_uri);
                $b_uri = './record/' . $b_handle_id . '/' . $b_seq . '/' . $b_filename;

                echo '<img src = "'.$b_uri.'">';


                $bitstreamLinks[$numBitstreams] = '<div class="bitstream-image">';

                $bitstreamLinks[$numBitstreams] .= '<a title = "' . $record_title . '" class="fancybox" rel="group" href="' . $b_uri . '"> ';
                echo 'NUM'.$numBitstreams;
                if ($numBitstreams == 0) {
                    $bitstreamLinks[$numBitstreams] .= '<img id="main-image"';
                } else if ($numBitstreams == 1) {
                    $bitstreamLinks[$numBitstreams] .= '<img id="second-image" class="record-image"';
                } else {
                    $bitstreamLinks[$numBitstreams] .= '<img class="record-image"';
                }
                $bitstreamLinks[$numBitstreams] .= ' src = "' . $b_uri . '">';
                $bitstreamLinks[$numBitstreams] .= '</a>';

                $bitstreamLinks[$numBitstreams] .= '</div>';
                $numBitstreams++;

            } else if ((strpos($b_filename, ".mp3") > 0) or (strpos($b_filename, ".MP3") > 0)) {

                $b_uri = './record/' . $b_handle_id . '/' . $b_seq . '/' . $b_filename;
                $audioLink .= '<audio controls>';
                $audioLink .= '<source src="' . $b_uri . '" type="audio/mpeg" />Audio loading...';
                $audioLink .= '</audio>';
                $audioFile = true;

            } else if ((strpos($b_filename, ".mp4") > 0) or (strpos($b_filename, ".MP4") > 0)) {
                $b_uri = $media_uri . $b_handle_id . '/' . $b_seq . '/' . $b_filename;
                // if it's chrome, use webm if it exists
                if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == false) {


                    $videoLink .= '<div class="flowplayer" data-analytics="' . $ga_code . '" title="' . $b_filename . '">';
                    $videoLink .= '<video preload=auto loop width="100%" height="auto" controls preload="true" width="660">';
                    $videoLink .= '<source src="' . $b_uri . '" type="video/mp4" />Video loading...';
                    $videoLink .= '</video>';
                    $videoLink .= '</div>';
                    $videoFile = true;

                }
            } else if ((strpos($b_filename, ".webm") > 0) or (strpos($b_filename, ".WEBM") > 0)) {

                $b_uri = $media_uri . $b_handle_id . '/' . $b_seq . '/' . $b_filename;
                // if it's chrome, use webm if it exists
                if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == true) {

                    $videoLink .= '<div class="flowplayer" data-analytics="' . $ga_code . '" title="' . $record_title . ": " . $b_filename . '">';
                    $videoLink .= '<video preload=auto loop width="100%" height="auto" controls preload="true" width="660">';
                    $videoLink .= '<source src="' . $b_uri . '" type="video/webm" />Video loading...';
                    $videoLink .= '</video>';
                    $videoLink .= '</div>';

                    $videoFile = true;

                }
            }
        }

        } ?></div> <?php
}


        foreach($bitstreamLinks as $bitstreamLink) {

            echo $bitstreamLink;
        }

    ?>

<div class="clearfix"></div>

<?php

if(isset($solr[$bitstream_field]) && $link_bitstream) {

    echo '<div class="record_bitstreams">';

    if($audioFile) {

        echo $audioLink;
    }

    if($videoFile) {

        echo $videoLink;
    }

    echo '</div><div class="clearfix"></div>';

}?>

<input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">





