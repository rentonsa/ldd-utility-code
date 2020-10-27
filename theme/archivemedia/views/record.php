<?php
$author_field = $this->skylight_utilities->getField("Author");
$acc_no_field = $this->skylight_utilities->getField("Accession Number");
$type_field = $this->skylight_utilities->getField("Type");
$bitstream_field = $this->skylight_utilities->getField("Bitstream");
$thumbnail_field = $this->skylight_utilities->getField("Thumbnail");
$date_field = $this->skylight_utilities->getField("Date");
$filters = array_keys($this->config->item("skylight_filters"));
$link_uri_field = $this->skylight_utilities->getField("Link");
$tags_field = $this->skylight_utilities->getField("Tags");
$media_uri = $this->config->item("skylight_media_url_prefix");
$image_uri_field = $this->skylight_utilities->getField('ImageUri');
$permalink_field = $this->skylight_utilities->getField('Permalink');
$type = 'Unknown';
$mainImage = false;
$mainImageTest = false;
$numThumbnails = 0;
$bitstreamLinks = array();
$image_id = "";
$accno = '';
//Insert Schema.org
$schema = $this->config->item("skylight_schema_links");
if(isset($solr[$type_field]))
{
    $type = "media-" . strtolower(str_replace(' ','-',$solr[$type_field][0]));
}
//we are IIIF, so the only bitstreams we're interested in are video and audio (if art ever generate any!)
if(isset($solr[$bitstream_field]) && $link_bitstream)
{
    foreach ($solr[$bitstream_field] as $bitstream_for_array)
    {
        $b_segments = explode("##", $bitstream_for_array);
        $b_seq = $b_segments[4];
        $bitstream_array[$b_seq] = $bitstream_for_array;
    }
    ksort($bitstream_array);
    $mainImage = false;
    $videoFile = false;
    $audioFile = false;
    $pdfFile = false;
    $audioLink = "";
    $videoLink = "";
    $jsonLink = "";
    $pdfLink = "";
    $b_seq =  "";
    foreach($bitstream_array as $bitstream)
    {
        $mp4ok = false;
        $b_segments = explode("##", $bitstream);
        $b_filename = urlencode($b_segments[1]);
        if($image_id == "")
        {
            $image_id = substr($b_filename,0,7);
        }
        $b_handle = $b_segments[3];
        $b_seq = $b_segments[4];
        $b_handle_id = preg_replace('/^.*\//', '',$b_handle);
        $b_uri = './record/'.$b_handle_id.'/'.$b_seq.'/'.$b_filename;
        if ((strpos($b_uri, ".jpg") > 0) or (strpos($b_uri, ".JPG") > 0))
        {
            // if there are thumbnails
            if(isset($solr[$thumbnail_field]))
            {
                foreach ($solr[$thumbnail_field] as $thumbnail)
                {
                    $t_segments = explode("##", $thumbnail);
                    $t_filename = urlencode($t_segments[1]);
                    if ($t_filename === $b_filename . ".jpg")
                    {
                        $t_handle = $t_segments[3];
                        $t_seq = $t_segments[4];
                        $t_uri = './record/'.$b_handle_id.'/'.$t_seq.'/'.$t_filename;
                        $thumbnailLink[$numThumbnails] = '<div class="thumbnail-tile';
                        if($numThumbnails % 4 === 0)
                        {
                            $thumbnailLink[$numThumbnails] .= ' first';
                        }
                        $thumbnailLink[$numThumbnails] .= '"><a title = "' . $record_title . '" class="fancybox" rel="group" href="' . $b_uri . '"> ';
                        $thumbnailLink[$numThumbnails] .= '<img src = "'.$t_uri.'" class="record-thumbnail" title="'. $record_title .'" /></a></div>';
                        $numThumbnails++;
                    }
                }
            }
        }
        if ((strpos($b_uri, ".mp3") > 0) or (strpos($b_uri, ".MP3") > 0))
        {
            //Insert Schema for deetcting Audio
            echo '<div itemprop="audio" itemscope itemtype="http://schema.org/AudioObject"></div>';
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
                // Insert Schema for detecting Video
                echo '<div itemprop="video" itemscope itemtype="http://schema.org/VideoObject"></div>';
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
                    // Insert Schema
                    echo '<div itemprop="video" itemscope itemtype="http://schema.org/VideoObject"></div>';
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
        else if ((strpos($b_uri, ".pdf") > 0) or (strpos($b_uri, ".PDF") > 0))
        {
            $bitstreamLink = $this->skylight_utilities->getBitstreamLink($bitstream);
            $bitstreamUri = $this->skylight_utilities->getBitstreamUri($bitstream);
            //$pdfLink .= '<br><object class="pdfviewer" width="650" height="800" data="'.$b_uri.'" type="application/pdf"><p><span class="label">It appears you do not have a PDF plugin for this browser.</span> </p></object><br>';
            $pdfLink .= 'Click ' . $bitstreamLink . ' to download. (<span class="bitstream_size">' . getBitstreamSize($bitstream) . '</span>)<br>';
            $pdfFile = true;
        }
        else if ((strpos($b_uri, ".json") > 0) or (strpos($b_uri, ".JSON") > 0))
        {
            if(isset($solr[$acc_no_field])) {
                $accno =  $solr[$acc_no_field][0];
            }
            $bitstreamLink = $this->skylight_utilities->getBitstreamLink($bitstream);
            $bitstreamUri = $this->skylight_utilities->getBitstreamUri($bitstream);
            $manifest  = base_url().'art/record/'.$b_handle_id.'/'.$b_seq.'/'.$b_filename;
            $jsonLink  = '<span class ="json-link-item"><a href="https://librarylabs.ed.ac.uk/iiif/uv/?manifest='.$manifest.'" target="_blank" class="uvlogo" title="View in UV"></a></span>';
            $jsonLink .= '<span class ="json-link-item"><a target="_blank" href="https://librarylabs.ed.ac.uk/iiif/mirador/?manifest='.$manifest.'" class="miradorlogo" title="View in Mirador"></a></span>';
            $jsonLink .= '<span class ="json-link-item"><a href="https://images.is.ed.ac.uk/luna/servlet/view/search?search=SUBMIT&q='.$accno.'" class="lunalogo" title="View in LUNA"></a></span>';
            $jsonLink .= '<span class ="json-link-item"><a href="'.$manifest.'" target="_blank"  class="iiiflogo" title="IIIF manifest"></a></span>';
        }
    }
}
?>

<div class="content">
  <!--Insert Schema-->
  <div itemscope itemtype ="http://schema.org/CreativeWork">
    <div class="full-title">
        <h1 class="itemtitle"><?php echo $record_title ?>

            <?php if(isset($solr[$date_field])) {
                echo " (" . $solr[$date_field][0] . ")";
            } ?>
        </h1>
        <div class="tags">
            <?php
            if (isset($solr[$author_field])) {
                foreach($solr[$author_field] as $author) {
                    $orig_filter = urlencode($author);
                    $lower_orig_filter = strtolower($author);
                    $lower_orig_filter = urlencode($lower_orig_filter);
                    echo '<a class="artist" href="./search/*:*/Artist:%22'.$lower_orig_filter.'+%7C%7C%7C+'.$orig_filter.'%22">'.$author.'</a>';
                }
            }
            ?>
        </div>
    </div>

    <div class="full-metadata">

            <table>
                <tbody>
                <?php $excludes = array(""); ?>
                <?php
                foreach($recorddisplay as $key) {
                    $element = $this->skylight_utilities->getField($key);
                    if(isset($solr[$element]))
                    {
                        echo '<tr><th>' . $key . '</th><td>';
                        foreach ($solr[$element] as $index => $metadatavalue)
                        {
                            echo $metadatavalue;
                            if ($index < sizeof($solr[$element]) - 1)
                            {
                                echo '; ';
                            }
                            echo '</td></tr>';
                        }
                    }
                }
                 ?>

                <?php
                $i = 0;
                $lunalink = false; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="clearfix"></div>
<?php
    $i = 0;
    $newStrip = false;
    echo '<div class="clearfix"></div>';
    if(isset($solr[$bitstream_field]) && $link_bitstream)
    {
        echo '<div class="record_bitstreams">';
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
            echo '<br><br>'.$audioLink;
        }
        if($videoFile) {
            echo '<br><br>'.$videoLink;
        }
        if($pdfFile) {
            echo '<br><br>'.$pdfLink;
        }
        echo '</div>';
        echo '<!--</div>-->
    <div class="clearfix"></div>';
    }
    ?>

    <input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
</div>
