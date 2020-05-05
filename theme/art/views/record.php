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
$sketchfab_field = $this->skylight_utilities->getField('SketchFabURI');
$type = 'Unknown';
$mainImage = false;
$mainImageTest = false;
$numThumbnails = 0;
$bitstreamLinks = array();
$image_id = "";
$accno = '';
//Insert Schema.org
$schema = $this->config->item("skylight_schema_links");

if(isset($solr[$type_field])) {
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
    $audioLink = "";
    $videoLink = "";
    $jsonLink = "";
    $b_seq =  "";
    foreach($bitstream_array as $bitstream)
    {
        $mp4ok = false;
        $b_segments = explode("##", $bitstream);
        $b_filename = $b_segments[1];
        if($image_id == "")
        {
            $image_id = substr($b_filename,0,7);
        }
        $b_handle = $b_segments[3];
        $b_seq = $b_segments[4];
        $b_handle_id = preg_replace('/^.*\//', '',$b_handle);
        $b_uri = './record/'.$b_handle_id.'/'.$b_seq.'/'.$b_filename;
        if ((strpos($b_uri, ".mp3") > 0) or (strpos($b_uri, ".MP3") > 0))
        {
            //Insert Schema for deetcting Audio
            echo '<div itemprop="audio" itemscope itemtype="https://schema.org/AudioObject"></div>';
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
                echo '<div itemprop="video" itemscope itemtype="https://schema.org/VideoObject"></div>';
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
                    echo '<div itemprop="video" itemscope itemtype="https://schema.org/VideoObject"></div>';
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
            $pdfLink .= 'Click ' . $bitstreamLink . 'to download. (<span class="bitstream_size">' . getBitstreamSize($bitstream) . '</span>)';
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
            $jsonLink .= '<span class ="json-link-item"><a href="https://images.is.ed.ac.uk/luna/servlet/view/search?search=SUBMIT&q='.$accno.'" class="lunalogo" title="View in LUNA" target="_blank"></a></span>';
            $jsonLink .= '<span class ="json-link-item"><a href="'.$manifest.'" target="_blank"  class="iiiflogo" title="View IIIF manifest"></a></span>';
            //$jsonLink .= '<span class ="json-link-item"><a href="https://www.example.com/'.$manifest.'" target="_blank"  class="iiifdndlogo" title="Drag and drop IIIF manifest"></a></span>'; $jsonLink .= '<span class ="json-link-item"><a href="http://www.example.com/'.$manifest.'" target="_blank"  class="iiifdndlogo" title="Drag and drop IIIF manifest"></a></span>';
        }

    }
}
?>

<div class="content">
  <!--Insert Schema-->
  <div itemscope itemtype ="https://schema.org/CreativeWork">
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
                    echo '<a class="artist" href="./search/*:*/Artist:%22'.$lower_orig_filter.'%7C%7C%7C'.$orig_filter.'%22" title="'.$author.'">'.$author.'</a>';
                }
            }
            ?>
        </div>
    </div>
      <?php


    $numThumbnails = 0;
    $imageCounter = 0;
    if (isset($solr[$image_uri_field])) {
            foreach($solr[$image_uri_field] as $linkURI)
            {
                if (strpos($linkURI, 'luna') > 0) {
                    $tileSource[$imageCounter] = str_replace('full/full/0/default.jpg', 'info.json', $linkURI);
                    $tileSource[$imageCounter] = str_replace('http', 'https', $tileSource[$imageCounter]);

                    list($width, $height) = getimagesize($linkURI);
                    $portrait = true;
                    if ($width > $height) {
                        $portrait = false;
                    }

                    $imageCounter++;
                }
            }



        echo "<div id='imageCounter' style='display:none;'>$imageCounter</div>";
        echo "<div class ='imageContainer'>";
        $divCounter = 0;
        $freshIn = true;
        while ($divCounter < $imageCounter) {

            if (!$mainImage) {
                $mainImageTest = true;
                ?>
                <div class="full-image">
                    <div id="openseadragon<?php echo $divCounter; ?>" class="image-toggle"<?php if (!$freshIn) {
                        echo ' style="display:none;"';
                    } else {
                        echo ' style="display:block;"';
                    } ?>>
                        <script type="text/javascript">
                            OpenSeadragon({
                                id: "openseadragon<?php echo $divCounter; ?>",
                                prefixUrl: "<?php echo base_url();?>theme/mimed/images/buttons/",
                                preserveViewport: false,
                                visibilityRatio: 1,
                                minZoomLevel: 0,
                                defaultZoomLevel: 0,
                                panHorizontal: true,
                                sequenceMode: true,
                                tileSources: ["<?php echo $tileSource[$divCounter]; ?>"]
                            });
                        </script>
                    </div>
                </div>


                <?php
            }
            $divCounter++;
            $freshIn = false;
        }

        echo '</div>';
        if(isset($solr[$acc_no_field])) {
            $accno =  $solr[$acc_no_field][0];
        }

        $numThumbnails = 0;
        $imageset = false;
        $thumbnailLink = array();
        $countThumbnails = count($solr[$image_uri_field]);

        $widthtotal = 0;
        $i = 0;
        foreach ($solr[$image_uri_field] as $imageURI)
        {
            $imageURI = str_replace('http://', 'https://', $imageURI);
            $imagefull[$i] = $imageURI;
            list($fullwidth, $fullheight) = getimagesize($imagefull[$i]);

            if ($fullwidth > $fullheight) {
                $parms = '/150,/0/';
            } else {
                $parms = '/,150/0/';
            }

            $imagesmall[$i] = str_replace('/full/0/', $parms, $imagefull[$i]);
            //Insert Schema
            echo '<span itemprop="thumbnailUrl" style="display:none;">'. $imagesmall[$i]. '</span>';
            list($width, $height) = getimagesize($imagesmall[$i]);
            $widthtotal = $widthtotal + $width;

            $i++;
        }
        if ($countThumbnails > 1)
        {
            if ($widthtotal > 540)
            {
                echo '<div class="jcarousel-wrapper">
               <div class="jcarousel" data-jcarousel="true">
               <ul >';
            }
            else
            {
                echo ' <div class="thumb-strip">';
            }

            for ($numThumbnails = 0; $numThumbnails<$countThumbnails; $numThumbnails++)
            {
                if ($widthtotal > 540)
                {
                    $thumbnailLink[$numThumbnails] = '<li>';
                }
                else
                {
                    $thumbnailLink[$numThumbnails] = '';
                }
                $thumbnailLink[$numThumbnails] .= '<label class="image-toggler" data-image-id="#openseadragon' . $numThumbnails . '">';
                $thumbnailLink[$numThumbnails] .= '<input type="radio" name="options" id="option' . $numThumbnails . '">';

                $thumbnailLink[$numThumbnails] .= '<img src = "' . $imagesmall[$numThumbnails] . '" class="record-thumb-strip" title="' . $solr[$title_field][0];

                $manifest = str_replace("iiif/", "iiif/m/", $imagefull[$numThumbnails]);
                $manifest = str_replace("full/full/0/default.jpg", "manifest", $manifest);

                $json = file_get_contents($manifest);

                $jobj = json_decode($json, true);
                //print_r ($jobj);
                $error = json_last_error();
                $jsonMD = $jobj['sequences'][0]['canvases'][0]['metadata'];
                $rights = '';
                $photographer = '';
                $photoline = '';
                foreach ($jsonMD as $jsonMDPair)
                {

                    if ($jsonMDPair['label'] == 'Repro Creator Name')
                    {
                        $photographer = str_replace("<span>", "", $jsonMDPair['value']);
                        $photographer = str_replace("</span>", "", $photographer);
                    }
                    if ($jsonMDPair['label'] == 'Repro Rights Statement')
                    {
                        $rights = str_replace("<span>", "", $jsonMDPair['value']);
                        $rights = 'Photograph '.str_replace("</span>", "", $rights);
                    }

                }
                if ($photographer !== '')
                {
                    $photoline = ' Photo by '.$photographer;
                }
                $thumbnailLink[$numThumbnails] .= '. '. $photoline.' '.$rights.'"/></label>';

                if ($widthtotal > 540)
                {
                    $thumbnailLink[$numThumbnails] .= '</li>';
                }
                else
                {
                    $thumbnailLink[$numThumbnails] .= '';
                }
                echo $thumbnailLink[$numThumbnails];

                $imageset = true;

            }

            if ($widthtotal > 540)
            {
                echo '</ul>
                </div>
                <a class="jcarousel-control-prev" href="'.$_SERVER['REQUEST_URI'].'/#" data-jcarouselcontrol="true">‹</a>
                <a class="jcarousel-control-next" href="'.$_SERVER['REQUEST_URI'].'/#" data-jcarouselcontrol="true">›</a>';
            }
            echo '</div>';
        }

        else
        {

            $imageUri = $solr[$image_uri_field] ;

            $manifest = str_replace("iiif/", "iiif/m/", $imageURI);
            $manifest = str_replace("full/full/0/default.jpg", "manifest", $manifest);

            $json = file_get_contents($manifest);

            $jobj = json_decode($json, true);
            //print_r ($jobj);
            $error = json_last_error();
            $jsonMD = $jobj['sequences'][0]['canvases'][0]['metadata'];
            $rights = '';
            $photographer = '';
            $photoline = '';
            $mdexists = false;
            foreach ($jsonMD as $jsonMDPair)
            {

                if ($jsonMDPair['label'] == 'Repro Creator Name')
                {
                    $photographer = str_replace("<span>", "", $jsonMDPair['value']);
                    $photographer = ' Photo by '.str_replace("</span>", "", $photographer).' ';
                    $mdexists = true;
                }
                if ($jsonMDPair['label'] == 'Repro Rights Statement')
                {
                    $rights = str_replace("<span>", "", $jsonMDPair['value']);
                    $rights = "Photograph ". str_replace("</span>", "", $rights);
                    $mdexists = true;
                }
                if ($jsonMDPair['label'] == 'Repro Link ID')
                {
                    $crowd_image = str_replace("<span>", "", $jsonMDPair['value']);
                }
            }
            if ($mdexists)
            {
                echo '<div class="json-link">';
                echo '<p>'.$photographer.$rights.'</p>';
                echo '</div>';
            }
        }
        ?>




        <div class = "json-link">
            <p>
                <?php if (isset($jsonLink)){echo $jsonLink;} ?>
            </p>
        </div>
    <?php } ?>

<!--Insert Schema.org-->
    <div class="full-metadata">

            <table>
                <tbody>
                <?php $excludes = array(""); ?>
                <?php
                $viafvalue = '';
                $isnivalue = '';
                $lcvalue = '';
                $isni = '';
                $viaf = '';
                $lc = '';

                $artistcount = 0;
                foreach($recorddisplay as $key)
                {
                    //Find out how many artists we have for authority permalink generation
                    if ($key == 'Artist')
                    {
                        $artistcount++;
                    }
                }
                foreach($recorddisplay as $key) {
                    $element = $this->skylight_utilities->getField($key);
                    if(isset($solr[$element])) {
                        if(!in_array($key, $excludes)) {
                            //Generate Permalinks for artist name
                            if ($key == "Permalink")
                            {
                                //Do not attempt to attribute authority link if we have > 1 artist, as there is no direct relationship in the metadata
                                if ($artistcount == 1) {
                                    foreach ($solr[$element] as $index => $metadatavalue) {
                                        if (strpos($metadatavalue, "viaf") > 0) {
                                            $viafvalue = $metadatavalue;
                                        } else if (strpos($metadatavalue, "isni") > 0) {
                                            $isnivalue = $metadatavalue;
                                        } else if (strpos($metadatavalue, "gov") > 0) {
                                            $lcvalue = $metadatavalue;
                                        }
                                    }
                                }
                            }
                            else
                            {
                                echo '<tr><th>' . $key . '</th><td>';
                                foreach ($solr[$element] as $index => $metadatavalue) {
                                    // if it's a facet search
                                    // make it a clickable search link
                                    if (in_array($key, $filters) && $key != "Artist") {
                                        $orig_filter = urlencode($metadatavalue);
                                        $lower_orig_filter = strtolower($metadatavalue);
                                        $lower_orig_filter = urlencode($lower_orig_filter);

                                        //Insert Schema.org
                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="'.$schema[$key].'"><a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '%7C%7C%7C' . $orig_filter . '%22" title="'. $metadatavalue . '">' . $metadatavalue . '</a></span>';
                                        }
                                        else
                                        {
                                            echo '<a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '%7C%7C%7C' . $orig_filter . '%22" title="'. $metadatavalue . '">' . $metadatavalue . '</a>';
                                        }

                                    } else {
                                        if ($key == "Artist") {
                                            //for artist, add superscript authority links if available
                                            if ($viafvalue !== '') {
                                                $viaf = '<a href = "' . $viafvalue . '" title="'. $viafvalue . '" target = "_blank"><sup>VIAF</sup></a>';
                                            }
                                            if ($isnivalue !== '') {
                                                $isni = '<a href = "' . $isnivalue . '" title="'. $isnivalue . '" target = "_blank"><sup>ISNI</sup></a>';
                                            }
                                            if ($lcvalue !== '') {
                                                $lc = '<a href = "' . $lcvalue . '" title="'. $lcvalue . '" target = "_blank"><sup>LC</sup></a>';
                                            }

                                            //Insert Schema.org

                                            if (isset ($schema[$key]))
                                            {
                                                echo '<span itemprop="' . $schema[$key] . '">' . $metadatavalue . ' ' . $viaf . ' ' . $isni . ' ' . $lc . "</span>";
                                            }

                                            else

                                            {
                                                echo $metadatavalue . ' ' . $viaf . ' ' . $isni . ' ' . $lc;
                                            }

                                        }
                                        else {

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
                                    if ($index < sizeof($solr[$element]) - 1) {
                                        echo '; ';
                                    }
                                }
                                echo '</td></tr>';
                            }

                        }
                    }
                } ?>

                <?php
                $i = 0;
                $lunalink = false; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="clearfix"></div>
    <!-- print out crowdsourced tags -->
    <?php
    if (isset($solr[$sketchfab_field]))
    {
        $sketchfab_hash = substr($solr[$sketchfab_field][0],-32);
        $sketchfab_embed = "https://sketchfab.com/models/" . $sketchfab_hash. "/embed";
        ?>
        <br>
        <div class="sketchfab-embed-wrapper"><iframe width="660" height="480" src="<?php echo $sketchfab_embed?>" frameborder="0" allow="autoplay; fullscreen; vr" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>

            <p style="font-size: 13px; font-weight: normal; margin: 5px; color: #4A4A4A;">
                <a href="<?php echo $solr[$sketchfab_field][0]?>" target="blank">See <?php echo $record_title?> at Sketchfab</a>
                <!--<a href="https://sketchfab.com/openededinburgh?utm_medium=embed&utm_source=website&utm_campaign=share-popup" target="_blank" style="font-weight: bold; color: #1CAAD9;">The University of Edinburgh</a>
                <a href="https://sketchfab.com?utm_medium=embed&utm_source=website&utm_campaign=share-popup" target="_blank" style="font-weight: bold; color: #1CAAD9;">Sketchfab</a>-->
            </p>
        </div>
        <?php
    }
    $crowd_image = '';
    if (isset($solr[$image_uri_field])) {
        foreach ($solr[$image_uri_field] as $linkURI) {
            if (strpos($linkURI, 'luna') > 0) {

                $manifest = str_replace('full/full/0/default.jpg', 'manifest', $linkURI);
                $manifest = str_replace('iiif/', 'iiif/m/', $manifest);
                $json = file_get_contents($manifest);

                $jobj = json_decode($json, true);
                //print_r ($jobj);
                $error = json_last_error();
                $jsonMD = $jobj['sequences'][0]['canvases'][0]['metadata'];
                $crowd_image = '';
                foreach ($jsonMD as $jsonMDPair) {
                    if ($jsonMDPair['label'] == 'Work Record ID') {
                        $crowd_image = str_replace("<span>", "", $jsonMDPair['value']);
                        $crowd_image = str_replace("</span>", "", $crowd_image) . "c";
                    }
                }
            }
        }
    }
    if(isset($solr[$tags_field])) { ?>
        <div class="crowd-tags"><span class="crowd-title"
                                      title="User generated tags created through crowd sourcing games"><i
                class="fa fa-users fa-lg">&nbsp;</i>Tags:</span>
        <?php foreach ($solr[$tags_field] as $tag) {
            $orig_filter = urlencode($tag);
            $lower_orig_filter = strtolower($tag);
            $lower_orig_filter = urlencode($lower_orig_filter);
            echo '<span class="crowd-tag">' . '<a href="./search/*:*/Tags:%22' . $lower_orig_filter . '%7C%7C%7C' . $orig_filter . '%22" title="' . $tag . '"><i class="fa fa-tags fa-lg">&nbsp;</i>' . $tag . '</a>' . '</span>';
        }


        if ($crowd_image !== '') { ?>
            <div class="crowd-info">
                <form id="libraylabs" method="get" action="https://librarylabs.ed.ac.uk/games/gameCrowdSourcing.php"
                      target="_blank">
                    <input type="hidden" name="image_id" value="<?php echo $crowd_image ?>">
                    <input type="hidden" name="theme" value="art">
                    Add more tags at <a href="#" onclick="document.forms[1].submit();return false;"
                                        title="University of Edinburgh, Library Labs Metadata Games">Library Labs
                        Games</a>
                    (Create a login at <a href="https://www.ease.ed.ac.uk/friend/" target="_blank" title="EASE Friend">Edinburgh
                        Friend Account</a>)
                </form>
            </div>
            </div>

        <?php
        }
    }
    else {
    if ($crowd_image !== '') { ?>
        <div class="crowd-tags">
            <div class="crowd-info">
                <form id="libraylabs" method="get" action="https://librarylabs.ed.ac.uk/games/gameCrowdSourcing.php"
                      target="_blank">
                    <input type="hidden" name="image_id" value="<?php echo $crowd_image ?>">
                    <input type="hidden" name="theme" value="art">
                    Add tags to this image at <a href="#" onclick="document.forms[1].submit();return false;"
                                                 title="University of Edinburgh, Library Labs Metadata Games">Library
                        Labs Games</a>
                    (Create a login at <a href="https://www.ease.ed.ac.uk/friend/" target="_blank" title="EASE Friend">Edinburgh
                        Friend Account</a>)
                </form>
            </div>
        </div>


        <?php
    }
    }
    $i = 0;
    $newStrip = false;

    echo '<div class="clearfix"></div>';
    if(isset($solr[$bitstream_field]) && $link_bitstream)
    {
        echo '<div class="record_bitstreams">';
        if($audioFile) {
            echo '<br>.<br>'.$audioLink;
        }
        if($videoFile) {
            echo '<br>.<br>'.$videoLink;
        }
        echo '</div>';
        echo '<!--</div>-->
    <div class="clearfix"></div>';
    }

    ?>

    <input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
</div>
