<?php

$author_field = $this->skylight_utilities->getField("Author");
$title_field = $this->skylight_utilities->getField("Title");
$maker_field = $this->skylight_utilities->getField("Maker");
$type_field = $this->skylight_utilities->getField("Type");
$bitstream_field = $this->skylight_utilities->getField("Bitstream");
$thumbnail_field = $this->skylight_utilities->getField("Thumbnail");
$filters = array_keys($this->config->item("skylight_filters"));
$placedisplay = $this->config->item("skylight_placedisplay");
$measurementdisplay = $this->config->item("skylight_measurementdisplay");
$associationdisplay = $this->config->item("skylight_associationdisplay");
$locationdisplay = $this->config->item("skylight_locationdisplay");
$datedisplay = $this->config->item("skylight_datedisplay");
$identificationdisplay = $this->config->item("skylight_identificationdisplay");
$descriptiondatadisplay = $this->config->item("skylight_descriptiondatadisplay");
$typedisplay = $this->config->item("skylight_typedisplay");
$link_uri_field = $this->skylight_utilities->getField("ImageURI");
$short_field = $this->skylight_utilities->getField("Short Description");
$date_field = $this->skylight_utilities->getField("Date");
$media_uri = $this->config->item("skylight_media_url_prefix");
$theme = $this->config->item("skylight_theme");
$acc_no_field = $this->skylight_utilities->getField("Accession Number");

//Insert Schema.org
$schema = $this->config->item("skylight_schema_links");
if(isset($solr[$type_field])) {
    $type = "media-" . strtolower(str_replace(' ','-',$solr[$type_field][0]));
}

$type = 'Unknown';
$mainImageTest = false;
$numThumbnails = 0;
$bitstreamLinks = array();
$image_id = "";

// booleans for video/audio
$mainImage = false;
$videoFile = false;
$audioFile = false;
$audioLink = "";
$videoLink = "";

// boolean for image box scaling
$portrait = false;
$width = 0;
$numPortrait = 0;
$numLandscape = 0;

if(isset($solr[$bitstream_field]) && $link_bitstream) {

    foreach ($solr[$bitstream_field] as $bitstream_for_array) {
        $b_segments = explode("##", $bitstream_for_array);
        $b_seq = $b_segments[4];
        $bitstream_array[$b_seq] = $bitstream_for_array;
    }

    ksort($bitstream_array);

    $mainImage = false;
    $videoFile = false;
    $audioFile = false;

    $b_seq = "";

    foreach ($bitstream_array as $bitstream) {
        $mp4ok = false;
        $b_segments = explode("##", $bitstream);
        $b_filename = $b_segments[1];
        if ($image_id == "") {
            $image_id = substr($b_filename, 0, 7);
        }
        $b_handle = $b_segments[3];
        $b_seq = $b_segments[4];
        $b_handle_id = preg_replace('/^.*\//', '', $b_handle);
        $b_uri = './record/' . $b_handle_id . '/' . $b_seq . '/' . $b_filename;

        if ((strpos($b_uri, ".mp3") > 0) or (strpos($b_uri, ".MP3") > 0)) {
            //Insert Schema for deetcting Audio
            echo '<div itemprop="audio" itemscope itemtype="http://schema.org/AudioObject"></div>';
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
                //Insert Schema for deetcting Video
                echo '<div itemprop="video" itemscope itemtype="http://schema.org/VideoObject"></div>';
                $videoLink .= '<div class="flowplayer" data-analytics="' . $ga_code . '" title="' . $record_title . ": " . $b_filename . '">';
                $videoLink .= '<video preload=auto loop width="100%" height="auto" controls preload="true" width="660">';
                $videoLink .= '<source src="' . $b_uri . '" type="video/mp4" />Video loading...';
                $videoLink .= '</video>';
                $videoFile = true;
            }
        }
        else if ((strpos($b_filename, ".webm") > 0) or (strpos($b_filename, ".WEBM") > 0))
        {
            //Microsoft Edge needs to be dealt with. Chrome calls itself Safari too, but that doesn't matter.
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') == false) {
                if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == true) {
                    //Insert Schema for deetcting Video
                    echo '<div itemprop="video" itemscope itemtype="http://schema.org/VideoObject"></div>';
                    $b_uri = $media_uri . $b_handle_id . '/' . $b_seq . '/' . $b_filename;
                    // if it's chrome, use webm if it exists
                    $videoLink .= '<div class="flowplayer" data-analytics="' . $ga_code . '" title="' . $record_title . ": " . $b_filename . '">';
                    $videoLink .= '<video preload=auto loop width="100%" height="auto" controls preload="true" width="660">';
                    $videoLink .= '<source src="' . $b_uri . '" type="video/webm" />Video loading...';
                    $videoLink .= '</video>';
                    $videoFile = true;
                }
            }
        }
        else if ((strpos($b_filename, ".json") > 0) or (strpos($b_filename, ".JSON") > 0))
        {
            if(isset($solr[$acc_no_field])) {
                $accno =  $solr[$acc_no_field][0];
            }
            $bitstreamLink = $this->skylight_utilities->getBitstreamLink($bitstream);
            $bitstreamUri = $this->skylight_utilities->getBitstreamUri($bitstream);
            $manifest  = base_url().'stcecilias/record/'.$b_handle_id.'/'.$b_seq.'/'.$b_filename;
            $jsonLink  = '<span class ="json-link-item"><a href="https://librarylabs.ed.ac.uk/iiif/uv/?manifest='.$manifest.'" target="_blank" class="uvlogo" title="View in UV"></a></span>';
            $jsonLink .= '<span class ="json-link-item"><a target="_blank" href="https://librarylabs.ed.ac.uk/iiif/mirador/?manifest='.$manifest.'" class="miradorlogo" title="View in Mirador"></a></span>';
            $jsonLink .= '<span class ="json-link-item"><a href="https://images.is.ed.ac.uk/luna/servlet/view/search?search=SUBMIT&q='.$accno.'" class="lunalogo" title="View in LUNA"></a></span>';
            $jsonLink .= '<span class ="json-link-item"><a href="'.$manifest.'" target="_blank"  class="iiiflogo" title="IIIF manifest"></a></span>';
            $jsonLink .= '<span class ="json-link-item"><a href = "https://creativecommons.org/licenses/by/3.0/" class ="ccbylogo" title="All images CC-BY" target="_blank" ></a></span>';
        }
    }
}
?>

<!--<nav class="navbar navbar-fixed-top second-navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#record-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div>
            <div class="collapse navbar-collapse" id="record-navbar">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo $_SERVER['REQUEST_URI'];?>#stc-section1">Top</a></li>
                    <li><a href="<?php echo $_SERVER['REQUEST_URI'];?>#stc-section2">Image</a></li>
                    <li><a href="<?php echo $_SERVER['REQUEST_URI'];?>#stc-section3">Description</a></li>
                    <?php if($audioLink != '') {
                        echo '<li ><a href ="'.$_SERVER['REQUEST_URI'].'#stc-section4" >Audio</a ></li >';
                    } ?>
                    <li><a href="<?php echo $_SERVER['REQUEST_URI'];?>#stc-section5">Instrument Data</a></li>
                    <li><a href="<?php echo $_SERVER['REQUEST_URI'];?>#stc-section6">Related Instruments</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>-->
<?php


foreach($recorddisplay as $key)
{
    $element = $this->skylight_utilities->getField($key);

    if(isset($solr[$element]))
    {
        foreach($solr[$element] as $index => $metadatavalue)
        {
            // if it's a facet search
            // make it a clickable search link

            if($key == 'Date Made') {
                $date = $metadatavalue;
            }
            if (!(isset($date))){
                $date = 'Undated';
            }
            if($key == 'Maker') {
                $maker = $metadatavalue;
            }
            if (!(isset($maker))){
                $maker = 'Unknown maker';
            }
            if($key == 'Title') {
                $title = $metadatavalue;
            }
            if (!(isset($title))){
                $title = 'Unnamed item';
            }
        }
    }
}

?>

<div id="stc-section1" class="container-fluid record-content">
    <h2 class="itemtitle hidden-sm hidden-xs"><?php echo $title .' | '. $maker. ' | '.$date;?></h2>
    <h4 class="itemtitle hidden-lg hidden-md"><?php echo $title .' | '. $maker. ' | '.$date;?></h4>
</div>

<div id="stc-section1" class="container-fluid record-content">
    <ul class="center-nav">
        <?php if(isset($solr[$link_uri_field]))
            {
                // CHECK RECORD HAS IMAGE
                echo '<li><a class="cnav-link" href="' . $_SERVER['REQUEST_URI'] . '#stc-section2">Image</a></li>';
            }
            if(!$audioLink == '' || !$videoLink == '')
            {
                // CHECK RECORD HAS AUDIO OR VIDEO FILES
                echo '<li><a class="cnav-link" href="' . $_SERVER['REQUEST_URI'] . '#stc-section4">Audio/Visual</a></li>';
            }

            if(!$recorddisplay == NULL)
            {
                // CHECK RECORD HAS TAGS
                echo '<li><a class="cnav-link" href="' . $_SERVER['REQUEST_URI'] . '#stc-section3">Categories</a></li>';
            }

            if(!$identificationdisplay == NULL)
            {
                // CHECK RECORD HAS INSTRUMENT METADATA
                echo '<li><a class="cnav-link" href="' . $_SERVER['REQUEST_URI'] . '#stc-section5">Instrument Data</a></li>';
            }

            // GET NO. OF RELATED ITEMS
            $numrel = count($related_items);
            if($numrel > 0)
            {
                // CHECK RECORD HAS ANY RELATED ITEMS
                echo '<li><a class="cnav-link" href="' . $_SERVER['REQUEST_URI'] . '#stc-section6">Related Items</a></li>';
            } ?>
    </ul>
</div>

<!-- START IMAGE IF -->
<?php if(isset($solr[$link_uri_field]))
{
    ?> <div id="stc-section2" class="container-fluid">
        <?php
        if (isset($solr[$link_uri_field]))
        {
        $imageCounter = 0;

        foreach($solr[$link_uri_field] as $linkURI)
        {
            $tileSource[$imageCounter] = str_replace('full/full/0/default.jpg', 'info.json', $linkURI);
            $tileSource[$imageCounter] = str_replace('http', 'https', $tileSource[$imageCounter]);

            list($width, $height) = getimagesize($linkURI);
            $portrait = true;
            if ($width > $height)
            {
                $numLandscape++;
                $portrait = false;
            }
            else
            {
                $numPortrait++;
            }

            $imageCounter++;
        }

        echo "<div id='imageCounter' style='display:none;'>$imageCounter</div>
            <div>" . $numLandscape . " : " . $numPortrait . "</div>
            <div>" . $width . "</div>";
        ?>


        <div id='toolbarDiv'>
            <div class='toolbarItem' id='zoom-in'></div><div class='toolbarItem' id='zoom-out'></div><div class='toolbarItem' id='home'></div><div class='toolbarItem' id='full-page'></div><?php if($imageCounter > 1){ ?><div class='toolbarItem image-toggler' id='prev' data-image-id="#openseadragon<?php echo ($imageCounter - 1);?>"></div><div class='toolbarItem image-toggler' id='next' data-image-id="#openseadragon1"><?php } ?></div>
        </div>

        <div class="col-lg-12 main-image">

            <?php  $divCounter = 0;
            $freshIn = true;
            while ($divCounter < $imageCounter)

            { ?>
                <?php

                    // determine if the image box should be styled for portrait or landscape
                    if ($numPortrait > $numLandscape)
                    {
                        $portrait = true;
                        $landscape = false;
                    }
                    if($numPortrait <= 0)
                    {
                        $portrait = false;
                        $landscape = true;
                    }
                    if ($numLandscape > $numPortrait)
                    {
                        $portrait = false;
                        $landscape = true;
                    }
                    if ($numLandscape === $numPortrait)
                    {
                        $portrait = true;
                        $landscape = false;
                    }

                    // determine if additional image box styles are required
                    // normal portrait (seems to freakout if num = 1)
                    if ($portrait && !$numPortrait = 1) {?>
                        <div id="openseadragon<?php echo $divCounter; ?>" class="image-toggle portrait-img"<?php if (!$freshIn) { echo ' style="display:none;"'; } else { echo ' style="display:block;"'; }?>>
                            <script type="text/javascript">
                                OpenSeadragon({
                                    id: "openseadragon<?php echo $divCounter;?>",
                                    prefixUrl: "<?php echo base_url() ?>theme/stcecilia/images/buttons/",
                                    zoomPerScroll: 1.2,
                                    toolbar:       "toolbarDiv",
                                    showNavigator:  true,
                                    autoHideControls: false,
                                    zoomInButton:   "zoom-in",
                                    zoomOutButton:  "zoom-out",
                                    homeButton:     "home",
                                    fullPageButton: "full-page",
                                    nextButton:     "next",
                                    previousButton: "previous",
                                    tileSources: ["<?php echo $tileSource[$divCounter]; ?>"]
                                });
                            </script>
                        </div>
                    <?php }
                    // normal portrait (fix if num = 1)
                    if ($portrait && $numPortrait = 1)
                    { ?>
                        <div id="openseadragon<?php echo $divCounter; ?>" class="image-toggle"<?php if (!$freshIn) { echo ' style="display:none;"'; } else { echo ' style="display:block;"'; }?>>
                            <script type="text/javascript">
                                OpenSeadragon({
                                    id: "openseadragon<?php echo $divCounter;?>",
                                    prefixUrl: "<?php echo base_url() ?>theme/stcecilia/images/buttons/",
                                    zoomPerScroll: 1.2,
                                    toolbar:       "toolbarDiv",
                                    showNavigator:  true,
                                    autoHideControls: false,
                                    zoomInButton:   "zoom-in",
                                    zoomOutButton:  "zoom-out",
                                    homeButton:     "home",
                                    fullPageButton: "full-page",
                                    nextButton:     "next",
                                    previousButton: "previous",
                                    tileSources: ["<?php echo $tileSource[$divCounter]; ?>"]
                                });
                            </script>
                        </div>
                    <?php }
                    // large portrait
                    if ($portrait && $width > 1024)
                    { ?>
                        <div id="openseadragon<?php echo $divCounter; ?>" class="image-toggle portrait-img-lrg"<?php if (!$freshIn) { echo ' style="display:none;"'; } else { echo ' style="display:block;"'; }?>>
                            <script type="text/javascript">
                                OpenSeadragon({
                                    id: "openseadragon<?php echo $divCounter;?>",
                                    prefixUrl: "<?php echo base_url() ?>theme/stcecilia/images/buttons/",
                                    zoomPerScroll: 1.2,
                                    toolbar:       "toolbarDiv",
                                    showNavigator:  true,
                                    autoHideControls: false,
                                    zoomInButton:   "zoom-in",
                                    zoomOutButton:  "zoom-out",
                                    homeButton:     "home",
                                    fullPageButton: "full-page",
                                    nextButton:     "next",
                                    previousButton: "previous",
                                    tileSources: ["<?php echo $tileSource[$divCounter]; ?>"]
                                });
                            </script>
                        </div>
                    <?php }
                    // normal landscape (seems to freakout if num = 2)
                    if ($landscape && !$numLandscape = 2)
                    { ?>
                        <div id="openseadragon<?php echo $divCounter; ?>" class="image-toggle"<?php if (!$freshIn) { echo ' style="display:none;"'; } else { echo ' style="display:block;"'; }?>>
                            <script type="text/javascript">
                                OpenSeadragon({
                                    id: "openseadragon<?php echo $divCounter;?>",
                                    prefixUrl: "<?php echo base_url() ?>theme/stcecilia/images/buttons/",
                                    zoomPerScroll: 1.2,
                                    toolbar:       "toolbarDiv",
                                    showNavigator:  true,
                                    autoHideControls: false,
                                    zoomInButton:   "zoom-in",
                                    zoomOutButton:  "zoom-out",
                                    homeButton:     "home",
                                    fullPageButton: "full-page",
                                    nextButton:     "next",
                                    previousButton: "previous",
                                    tileSources: ["<?php echo $tileSource[$divCounter]; ?>"]
                                });
                            </script>
                        </div>
                    <?php }
                    // normal landscape (seems to freakout if num = 1)
                    if ($landscape && $numLandscape = 1)
                    { ?>
                        <div id="openseadragon<?php echo $divCounter; ?>" class="image-toggle"<?php if (!$freshIn) { echo ' style="display:none;"'; } else { echo ' style="display:block;"'; }?>>
                            <script type="text/javascript">
                                OpenSeadragon({
                                    id: "openseadragon<?php echo $divCounter;?>",
                                    prefixUrl: "<?php echo base_url() ?>theme/stcecilia/images/buttons/",
                                    zoomPerScroll: 1.2,
                                    toolbar:       "toolbarDiv",
                                    showNavigator:  true,
                                    autoHideControls: false,
                                    zoomInButton:   "zoom-in",
                                    zoomOutButton:  "zoom-out",
                                    homeButton:     "home",
                                    fullPageButton: "full-page",
                                    nextButton:     "next",
                                    previousButton: "previous",
                                    tileSources: ["<?php echo $tileSource[$divCounter]; ?>"]
                                });
                            </script>
                        </div>
                    <?php } ?>
                    

                <?php
                $divCounter++;
                $freshIn = false;
            }
            ?>
        </div>


        <?php
        $numThumbnails = 0;
        $imageset = false;
        $thumbnailLink = array();

        $countThumbnails = count($solr[$link_uri_field]);
        echo '<div itemscope itemtype ="http://schema.org/CreativeWork"><div class="thumb-strip">';
        if ($countThumbnails > 1)
        {
            foreach ($solr[$link_uri_field] as $linkURI)
            {
                $linkURI = $solr[$link_uri_field][$numThumbnails];
                //change to stop LUNA erroring on redirect
                $linkURI = str_replace('http://', 'https://', $linkURI);

                $thumbnailLink[$numThumbnails] = '<label class="image-toggler" data-image-id="#openseadragon'.$numThumbnails.'">';
                $thumbnailLink[$numThumbnails] .= '<input type="radio" name="options" id="option'.$numThumbnails.'">';

                list($width, $height) = getimagesize($linkURI);
                $imagesmall = str_replace ('full/full/0/default.jpg', 'full/150,/0/default.jpg', $linkURI);
                //Insert Schema for thumbnail
                echo '<span itemprop="thumbnailUrl" style="display:none;">'. $imagesmall. '</span>';
                $portrait = true;
                if ($width > $height)
                {
                    $portrait = false;
                }
                if ($portrait)
                {
                    $thumbnailLink[$numThumbnails] .= '<img src = "' . $linkURI . '" class="record-thumb-strip" title="' . $solr[$title_field][0];
                } else
                {
                    $thumbnailLink[$numThumbnails] .= '<img src = "' . $linkURI . '" class="record-thumb-strip" title="' . $solr[$title_field][0];
                }

                $manifest = str_replace("iiif/", "iiif/m/", $linkURI);
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

                echo $thumbnailLink[$numThumbnails];
                $numThumbnails++;
                $imageset = true;

            }
        }
        else if ($countThumbnails == 1)
        {
            foreach ($solr[$link_uri_field] as $linkURI)
            {
                $imagefull = $linkURI;
                list($fullwidth, $fullheight) = getimagesize($imagefull);
                if ($fullwidth > $fullheight)
                {
                    $parms = '/150,/0/';
                }
                else
                {
                    $parms = '/,150/0/';
                }
                $imagesmall = str_replace('/full/0/', $parms, $imagefull);
                //Insert Schema for thumbnail
                echo '<span itemprop="thumbnail" style="display:none;">' . $imagesmall . '</span>';
            }
        }
        ?>
    </div>
<?php }
} ?>
<!-- END IMAGE IF -->

<div class = "json-link">
    <p>
        <?php if (isset($jsonLink)){echo $jsonLink;} ?>
    </p>
</div>

<!-- AUDIO FILE IF -->
<?php if(isset($solr[$bitstream_field]) && $link_bitstream) {

    if (!$audioLink == '')
    {
        echo '<div id="stc-section4" class="container-fluid">
            <h3 class="inst-desc">Audio/Visual Clips</h3>
            <!--h1 class="itemtitle hidden-sm hidden-xs">Audio/Visual</h1-->
            <!--h4 class="itemtitle hidden-lg hidden-md">Audio/Visual</h4-->'.
            $audioLink . '</div>';
    }
} ?>
<!-- END AUDIO FILE IF -->

<?php if(!$descriptiondisplay == NULL || !$recorddisplay == NULL)
{?>
    <div id="stc-section3" class="container-fluid">
        <!--TODO Display Short description and description-->
        <div class="col-description">
            <?php foreach($descriptiondisplay as $key) {

                $element = $this->skylight_utilities->getField($key);

                if(isset($solr[$element])) {
                    foreach($solr[$element] as $index => $metadatavalue) {
                        if ($key == "Short Description" or $key == "Description") {
                            echo "<span class='description'>";
                            echo $metadatavalue;
                            echo "</span>";
                        }
                    }
                }
            } ?>
        </div>

        <?php
        foreach($recorddisplay as $key) {

            $element = $this->skylight_utilities->getField($key);

            if(isset($solr[$element])) {

                foreach($solr[$element] as $index => $metadatavalue) {
                    echo '<div class="stc-tags">';

                    // if it's a facet search
                    // make it a clickable search link
                    if(in_array($key, $filters)) {
                        if (!strpos($metadatavalue, "/")> 0)
                        {
                            $orig_filter = urlencode($metadatavalue);
                            $lower_orig_filter = strtolower($metadatavalue);
                            $lower_orig_filter = urlencode($lower_orig_filter);


                            echo '<a href="./search/*:*/' . urlencode($key) . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22">' . $metadatavalue . '</a>';
                        }
                     }
                    echo '</div>';

                }
            }
        }
        ?>
    </div>
<?php } ?>

<!--Insert Schema.org-->
<div class="full-metadata">

<div id="stc-section5" class="panel panel-default container-fluid">
    <div class="panel-heading straight-borders">
        <h3 class="panel-title hidden-sm hidden-xs inst-desc">
            <a class="accordion-toggle" data-toggle="collapse" href="#collapse1">Instrument Data <i class="fa fa-chevron-down" aria-hidden="true"></i>
            </a>
        </h3>
        <h4 class="panel-title hidden-md hidden-lg ">
            <a class="accordion-toggle" data-toggle="collapse" href="#collapse1">Instrument Data <i class="fa fa-chevron-down" aria-hidden="true"></i>

            </a>
        </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="col-sm-6 col-xs-12 col-md-8 col-lg-12 metadata" itemscope itemtype="https://schema.org/instrument">

                <div class="info-box">

                    <h3>Identification Information</h3>
                    <dl class="dl-horizontal">
                        <?php
                        $infofound = false;
                        foreach($identificationdisplay as $key) {

                            $element = $this->skylight_utilities->getField($key);

                            if(isset($solr[$element])) {

                                echo '<dt>' . $key . '</dt>';

                                echo '<dd>';
                                foreach($solr[$element] as $index => $metadatavalue) {
                                    // if it's a facet search
                                    // make it a clickable search link
                                    if(in_array($key, $filters)) {

                                        $orig_filter = urlencode($metadatavalue);
                                        $lower_orig_filter = strtolower($metadatavalue);
                                        $lower_orig_filter = urlencode($lower_orig_filter);

                                        //Insert Schema.org
                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="'.$schema[$key].'"><a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22">' . $metadatavalue . '</a></span>';
                                        }
                                        else
                                        {
                                            echo '<a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22" title="' . $metadatavalue . '">' . $metadatavalue . '</a>';
                                        }
                                    }
                                    else {

                                        //Insert Schema.org

                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="' . $schema[$key] . '">' . $metadatavalue . "</span>";
                                        }

                                        else {
                                            echo $metadatavalue;
                                        }
                                    }

                                    if($index < sizeof($solr[$element]) - 1) {

                                        echo '; ';
                                    }
                                }
                                $infofound = true;
                                echo '</dd>';
                            }
                        }
                        if (!$infofound) {
                            echo '<dt>No information recorded.</dt><dd></dd>';
                        }?>
                    </dl>
                </div> <!-- main-info -->

                <div class="info-box">
                    <h3>Date Information</h3>
                    <dl class="dl-horizontal">
                        <?php
                        $infofound = false;
                        foreach($datedisplay as $key) {

                            $element = $this->skylight_utilities->getField($key);

                            if(isset($solr[$element])) {

                                echo '<dt>' . $key . '</dt>';

                                echo '<dd>';
                                foreach($solr[$element] as $index => $metadatavalue) {
                                    // if it's a facet search
                                    // make it a clickable search link
                                    if(in_array($key, $filters)) {

                                        $orig_filter = urlencode($metadatavalue);
                                        $lower_orig_filter = strtolower($metadatavalue);
                                        $lower_orig_filter = urlencode($lower_orig_filter);

                                        //Insert Schema.org
                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="'.$schema[$key].'"><a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22">' . $metadatavalue . '</a></span>';
                                        }
                                        else
                                        {
                                            echo '<a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22" title="' . $metadatavalue . '">' . $metadatavalue . '</a>';
                                        }
                                    }
                                    else {
                                        //Insert Schema.org

                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="' . $schema[$key] . '">' . $metadatavalue . "</span>";
                                        }

                                        else {
                                            echo $metadatavalue;
                                        }
                                    }
                                    if($index < sizeof($solr[$element]) - 1) {

                                        echo '; ';
                                    }
                                }
                                $infofound = true;
                                echo '</dd>';
                            }

                        }
                        if (!$infofound) {
                            echo '<dt>No information recorded.</dt><dd></dd>';
                        }
                        ?>
                    </dl>
                </div> <!-- meta-info -->

                <div class="info-box">
                    <h3>Maker</h3>
                        <dl class="dl-horizontal" id="table-text-desc">
                        <?php
                        $infofound = false;
                        foreach($creatordisplay as $key) {

                            $element = $this->skylight_utilities->getField($key);

                            if(isset($solr[$element])) {

                                if ($key === "Maker Name")
                                {
                                    echo '<dt class="center-dt">' . $key . '</dt>';
                                }
                                else
                                {
                                    echo '<dt>' . $key . '</dt>';
                                }
                                echo '<dd class="table-text-justify">';
                                foreach($solr[$element] as $index => $metadatavalue) {
                                    // if it's a facet search
                                    // make it a clickable search link
                                    if(in_array($key, $filters)) {

                                        $orig_filter = urlencode($metadatavalue);
                                        $lower_orig_filter = strtolower($metadatavalue);
                                        $lower_orig_filter = urlencode($lower_orig_filter);

                                        //Insert Schema.org
                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="'.$schema[$key].'" class="offset-dd"><a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22">' . $metadatavalue . '</a></span>';
                                        }
                                        else
                                        {
                                            echo '<a href="./search/*:*/' . $key . ':%22'.$lower_orig_filter.'+%7C%7C%7C+'.$orig_filter.'%22" title="'.$metadatavalue.'">'.$metadatavalue.'</a>';
                                        }
                                    }

                                    else {
                                        //Insert Schema.org

                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="' . $schema[$key] . '" class="offset-dd">' . $metadatavalue . "</span>";
                                        }
                                        else
                                        {
                                            echo $metadatavalue;
                                        }
                                    }
                                    if($index < sizeof($solr[$element]) - 1) {

                                        echo '; ';
                                    }
                                }
                                $infofound = true;
                                echo '</dd>';
                            }
                        }
                        if (!$infofound) {
                            echo '<dt>No information recorded.</dt><dd></dd>';
                        }?>
                    </dl>
                </div> <!-- creator-info -->

                <div class="info-box">
                    <h3>Production Place</h3>
                    <dl class="dl-horizontal">
                        <?php
                        $infofound = false;
                        foreach($placedisplay as $key) {

                            $element = $this->skylight_utilities->getField($key);

                            if(isset($solr[$element])) {

                                echo '<dt>' . $key . '</dt>';

                                echo '<dd>';
                                foreach($solr[$element] as $index => $metadatavalue) {
                                    // if it's a facet search
                                    // make it a clickable search link
                                    if(in_array($key, $filters)) {

                                        $orig_filter = urlencode($metadatavalue);
                                        $lower_orig_filter = strtolower($metadatavalue);
                                        $lower_orig_filter = urlencode($lower_orig_filter);

                                        //Insert Schema.org
                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="'.$schema[$key].'"><a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22">' . $metadatavalue . '</a></span>';
                                        }
                                        else
                                        {
                                            echo '<a href="./search/*:*/' . $key . ':%22'.$lower_orig_filter.'+%7C%7C%7C+'.$orig_filter.'%22" title="'.$metadatavalue.'">'.$metadatavalue.'</a>';
                                        }
                                    }
                                    else {

                                        //Insert Schema.org

                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="' . $schema[$key] . '">' . $metadatavalue . "</span>";
                                        }
                                        else
                                        {
                                            echo $metadatavalue;
                                        }
                                    }
                                    if($index < sizeof($solr[$element]) - 1) {

                                        echo '; ';
                                    }
                                }
                                $infofound = true;
                                echo '</dd>';
                            }
                        }
                        if (!$infofound) {
                            echo '<dt>No information recorded.</dt><dd></dd>';
                        }?>
                    </dl>
                </div> <!--place-info -->

                <div class="info-box">
                    <h3>Object Type Information</h3>
                    <dl class="dl-horizontal">
                        <?php
                        $infofound = false;
                        foreach($typedisplay as $key) {

                            $element = $this->skylight_utilities->getField($key);

                            if(isset($solr[$element])) {

                                echo '<dt>' . $key . '</dt>';

                                echo '<dd>';
                                foreach($solr[$element] as $index => $metadatavalue) {
                                    // if it's a facet search
                                    // make it a clickable search link
                                    if(in_array($key, $filters)) {

                                        $orig_filter = urlencode($metadatavalue);
                                        $lower_orig_filter = strtolower($metadatavalue);
                                        $lower_orig_filter = urlencode($lower_orig_filter);

                                        //Insert Schema.org
                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="'.$schema[$key].'"><a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22">' . $metadatavalue . '</a></span>';
                                        }
                                        else
                                        {
                                            echo '<a href="./search/*:*/' . $key . ':%22'.$lower_orig_filter.'+%7C%7C%7C+'.$orig_filter.'%22" title="'.$metadatavalue.'">'.$metadatavalue.'</a>';
                                        }
                                    }
                                    else {

                                        //Insert Schema.org

                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="' . $schema[$key] . '">' . $metadatavalue . "</span>";
                                        }
                                        else
                                        {
                                            echo $metadatavalue;
                                        }
                                    }

                                    if($index < sizeof($solr[$element]) - 1) {

                                        echo '; ';
                                    }
                                }
                                $infofound = true;
                                echo '</dd>';
                            }
                        }
                        if (!$infofound) {
                            echo '<dt>No information recorded.</dt><dd></dd>';
                        }?>
                    </dl>
                </div> <!--type-info -->

                <div class="info-box">
                    <h3>Location</h3>
                    <dl class="dl-horizontal">
                        <?php
                        $infofound = false;
                        foreach($locationdisplay as $key) {

                            $element = $this->skylight_utilities->getField($key);

                            if(isset($solr[$element])) {

                                echo '<dt>' . $key . '</dt>';

                                echo '<dd>';
                                foreach($solr[$element] as $index => $metadatavalue) {
                                    // if it's a facet search
                                    // make it a clickable search link
                                    if(in_array($key, $filters)) {

                                        $orig_filter = urlencode($metadatavalue);
                                        $lower_orig_filter = strtolower($metadatavalue);
                                        $lower_orig_filter = urlencode($lower_orig_filter);

                                        //Insert Schema.org
                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="'.$schema[$key].'"><a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22">' . $metadatavalue . '</a></span>';
                                        }
                                        else
                                        {
                                            echo '<a href="./search/*:*/' . $key . ':%22'.$lower_orig_filter.'+%7C%7C%7C+'.$orig_filter.'%22" title="'.$metadatavalue.'">'.$metadatavalue.'</a>';
                                        }
                                    }
                                    else {

                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="' . $schema[$key] . '">' . $metadatavalue . "</span>";
                                        }
                                        else
                                        {
                                            echo $metadatavalue;
                                        }
                                    }
                                    if($index < sizeof($solr[$element]) - 1) {

                                        echo '; ';
                                    }
                                }
                                $infofound = true;
                                echo '</dd>';
                            }
                        }
                        if (!$infofound) {
                            echo '<dt>No information recorded.</dt><dd></dd>';
                        }?>
                    </dl>
                </div> <!--location-info -->

                <!-- <div class="info-box">
                    <h3>Associated Performers</h3>
                    <dl class="dl-horizontal">
                        <?php
                        $infofound = false;
                        foreach($associationdisplay as $key) {

                            $element = $this->skylight_utilities->getField($key);

                            if(isset($solr[$element])) {

                                echo '<dt>' . $key . '</dt>';

                                echo '<dd>';
                                foreach($solr[$element] as $index => $metadatavalue) {
                                    // if it's a facet search
                                    // make it a clickable search link
                                    if(in_array($key, $filters)) {

                                        $orig_filter = urlencode($metadatavalue);
                                        $lower_orig_filter = strtolower($metadatavalue);
                                        $lower_orig_filter = urlencode($lower_orig_filter);

                                        //Insert Schema.org
                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="'.$schema[$key].'"><a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22">' . $metadatavalue . '</a></span>';
                                        }
                                        else
                                        {
                                            echo '<a href="./search/*:*/' . $key . ':%22'.$lower_orig_filter.'+%7C%7C%7C+'.$orig_filter.'%22" title="'.$metadatavalue.'">'.$metadatavalue.'</a>';
                                        }
                                    }
                                    else {

                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="' . $schema[$key] . '">' . $metadatavalue . "</span>";
                                        }
                                        else
                                        {
                                            echo $metadatavalue;
                                        }
                                    }

                                    if($index < sizeof($solr[$element]) - 1) {

                                        echo '; ';
                                    }
                                }
                                $infofound = true;
                                echo '</dd>';
                            }
                        }
                        if (!$infofound) {
                            echo '<dt>No information recorded.</dt><dd></dd>';
                        }?>
                    </dl>
                </div> association-info -->

                <!-- <div class="info-box">
                    <h3>Measurements</h3>
                    <dl class="dl-horizontal">
                        <?php
                        $infofound = false;
                        foreach($measurementdisplay as $key) {

                        $element = $this->skylight_utilities->getField($key);

                        if(isset($solr[$element])) {

                            echo '<dt>' . $key . '</dt>';

                            echo '<dd>';
                            foreach($solr[$element] as $index => $metadatavalue)
                            {
                                // if it's a facet search
                                // make it a clickable search link
                                if(in_array($key, $filters)) {
                                    $orig_filter = urlencode($metadatavalue);
                                    $lower_orig_filter = strtolower($metadatavalue);
                                    $lower_orig_filter = urlencode($lower_orig_filter);
                                    //insert Schema
                                    if (isset ($schema[$key])) {
                                        echo '<span itemprop="' . $schema[$key] . '"><a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22">' . $metadatavalue . '</a></span>';
                                    } else {
                                        echo '<a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22" title="' . $metadatavalue . '">' . $metadatavalue . '</a>';
                                    }
                                }
                                else
                                {

                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="' . $schema[$key] . '">' . $metadatavalue . "</span>";
                                        }
                                        else
                                        {
                                            echo $metadatavalue;
                                        }
                                }

                                if($index < sizeof($solr[$element]) - 1)
                                {

                                    echo '; ';
                                }
                            }
                            $infofound = true;
                            echo '</dd>';
                        }
                        }
                        if (!$infofound)
                        {
                            echo '<dt>No information recorded.</dt><dd></dd>';
                        }?>
                    </dl>
                </div> measurement-info -->

                <div class="info-box">
                    <h3>Description</h3>
                    <dl class="dl-horizontal" id="table-text-desc">
                        <?php
                        $infofound = false;
                        foreach($descriptiondatadisplay as $key) {

                            $element = $this->skylight_utilities->getField($key);

                            if(isset($solr[$element])) {

                                echo '<dt>' . $key . '</dt>';

                                echo '<dd class="table-text-justify">';
                                foreach($solr[$element] as $index => $metadatavalue) {
                                    // if it's a facet search
                                    // make it a clickable search link
                                    if(in_array($key, $filters)) {

                                        $orig_filter = urlencode($metadatavalue);
                                        $lower_orig_filter = strtolower($metadatavalue);
                                        $lower_orig_filter = urlencode($lower_orig_filter);

                                        //insert schema

                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="'.$schema[$key].'"><a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22">' . $metadatavalue . '</a></span>';
                                        }
                                        else
                                        {
                                            echo '<a href="./search/*:*/' . $key . ':%22'.$lower_orig_filter.'+%7C%7C%7C+'.$orig_filter.'%22" title="'.$metadatavalue.'">'.$metadatavalue.'</a>';
                                        }
                                    }
                                    else {

                                        if (isset ($schema[$key]))
                                        {
                                            echo '<span itemprop="' . $schema[$key] . '">' . $metadatavalue . "</span>";
                                        }
                                        else
                                        {
                                            echo $metadatavalue;
                                        }
                                    }
                                    if($index < sizeof($solr[$element]) - 1) {

                                        echo '; ';
                                    }
                                }
                                $infofound = true;
                                echo '</dd>';
                            }
                        }
                        if (!$infofound) {
                            echo '<dt>No information recorded.</dt><dd></dd>';
                        }?>
                    </dl>
                </div> <!--description info -->


            </div> <!-- metadata -->
        </div> <!-- panel body -->
    </div>
</div>
</div>
