<?php

function process_items($json, $type)
{

    $dispersal = 'nil';

    if(array_key_exists($type, $json)) {

        if (isset($json[$type][0]['label'])) {
            $dispersal = 'multiple';
        } else {
            if (isset($json[$type]['label'])) {
                $dispersal = 'single';
            }
        }
    }

    if ($dispersal !==  'nil')
    {
        echo "<h3>".ucfirst($type)."s</h3>";
        if ($dispersal == 'single')
        {
            foreach ($json[$type] as $key => $value)
            {
                $viaf = '';
                $lc ='';
                if ($key == 'label') {
                    $label = $value;
                }

                if ($key = 'sameAs') {
                    $viaf = '<a href = "' . $value . '" target = "_blank">VIAF |</a>';
                }

                if ($key = '@id') {
                    $lc = '<a href = "' . $value . '" target = "_blank">LC</a>';
                }
            }
            $display = "<p>" . $label . "<sup>" . $viaf .  $lc . "</sup></p>";
            echo $display;
        }
        else
        {
            $i = 0;
            foreach ($json[$type] as $key => $value)
            {
                $label = $json[$type][$i]['label'];
                $viaf = '';
                if(array_key_exists('sameAs', $json[$type][$i])) {
                    $viaf = '<a href = "' . $json[$type][$i]['sameAs'] . '" target = "_blank">VIAF |</a>';
                }
                $lc ='';
                if(array_key_exists('@id', $json[$type][$i])) {
                    $lc = '<a href = "' . $json[$type][$i]['@id'] . '" target = "_blank">LC</a>';
                }
                $array[$i] = "<p>" . $label . "<sup>" . $viaf .  $lc . "</sup></p>";
                $i++;
            }

            foreach ($array as $display)
            {
                echo $display;

            }
        }

    }

}

$title_field = $this->skylight_utilities->getField('Title');
$author_field = $this->skylight_utilities->getField('Author');
$shelfmark_field =  $this->skylight_utilities->getField('Shelfmark');
$date_field = $this->skylight_utilities->getField('Date Made');
$bitstream_field = $this->skylight_utilities->getField('Bitstream');
$thumbnail_field = $this->skylight_utilities->getField('Thumbnail');
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
$manifest_field =  $this->skylight_utilities->getField("Manifest");

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

require_once('SimpleRDFElement.php');


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
        $hasalma = 'N';
        if ((strpos($b_filename, ".json") > 0) or (strpos($b_filename, ".JSON") > 0))
        {
            $manifest = base_url() . 'speccoll/record/' . $b_handle_id . '/' . $b_seq . '/' . $b_filename;


            $json = file_get_contents($manifest);
            $jobj = json_decode($json, true);
            $error = json_last_error();

            $linkURI = $jobj['related'];
            $linkURI = str_replace('detail', 'iiif', $linkURI);
            $linkURI = $linkURI.'/full/!300,300/0/default.jpg';

            $jsonLink = '<span class ="json-link-item"><a href="https://librarylabs.ed.ac.uk/iiif/uv/?manifest=' . $manifest . '" target="_blank" class="uvlogo" title="View in UV"></a></span>';
            $jsonLink .= '<span class ="json-link-item"><a target="_blank" title="View in Mirador" href="https://librarylabs.ed.ac.uk/iiif/mirador/?manifest='.$manifest.'" class="miradorlogo"></a></span>';
            //  $jsonLink .= '<span class ="json-link-item"><a href="https://images.is.ed.ac.uk/luna/servlet/view/search?search=SUBMIT&q=' . $accno . '" class="lunalogo" title="View in LUNA"></a></span>';
            $jsonLink .= '<span class ="json-link-item"><a href="' . $manifest . '" target="_blank"  class="iiiflogo" title="IIIF manifest"></a></span>';
            //$jsonLink .= '<span class ="json-link-item"><a href = "https://creativecommons.org/licenses/by/3.0/" class ="ccbylogo" title="All images CC-BY" target="_blank" ></a></span>';
            $hasprimo = '';
            $hasalma ='';
            foreach ( $jobj['sequences'][0]['canvases'][0]['metadata']as $metadatapair) {
                $label = $metadatapair['label'];
                $value = $metadatapair['value'];

                if (strpos($value, "discovered") !== false) {
                    $value = str_replace("<span>", "",$value);
                    $value = str_replace("</span>","",$value);
                    $primourl = $value;
                    $hasprimo = 'Y';

                }

                if ($label == 'Catalogue Number')
                {
                    $value =str_replace("<span>","",$value);
                    $value =str_replace("</span>","",$value);
                    $almaurl = "https://open-na.hosted.exlibrisgroup.com/alma/44UOE_INST/bibs/".$value;

                    $hasalma = 'Y';
                }
            }
        }
    }

}
else
{
    $manifest = 'https://librarylabs.ed.ac.uk/iiif/speccollprototype/manifest/'.$solr[$manifest_field][0].'.json';
}


$json = file_get_contents($manifest);
$jobj = json_decode($json, true);
$error = json_last_error();

$linkURI = $jobj['related'];
$linkURI = str_replace('detail', 'iiif', $linkURI);
$linkURI = $linkURI.'/full/!300,300/0/default.jpg';

$jsonLink = '<span class ="json-link-item"><a href="https://librarylabs.ed.ac.uk/iiif/uv/?manifest=' . $manifest . '" target="_blank" class="uvlogo" title="View in UV"></a></span>';
$jsonLink .= '<span class ="json-link-item"><a target="_blank" title="View in Mirador" href="https://librarylabs.ed.ac.uk/iiif/mirador/?manifest='.$manifest.'" class="miradorlogo"></a></span>';
//  $jsonLink .= '<span class ="json-link-item"><a href="https://images.is.ed.ac.uk/luna/servlet/view/search?search=SUBMIT&q=' . $accno . '" class="lunalogo" title="View in LUNA"></a></span>';
$jsonLink .= '<span class ="json-link-item"><a href="' . $manifest . '" target="_blank"  class="iiiflogo" title="IIIF manifest"></a></span>';
//$jsonLink .= '<span class ="json-link-item"><a href = "https://creativecommons.org/licenses/by/3.0/" class ="ccbylogo" title="All images CC-BY" target="_blank" ></a></span>';
$hasprimo = '';
$hasalma ='';
$catalogue_link = '';
foreach ( $jobj['sequences'][0]['canvases'][0]['metadata']as $metadatapair) {
    $label = $metadatapair['label'];
    $value = $metadatapair['value'];

    if (strpos($value, "discovered") !== false) {
        $value = str_replace("<span>", "", $value);
        $value = str_replace("</span>", "", $value);
        $primourl = $value;
        $hasprimo = 'Y';

    }

    if ($label == 'Catalogue Number') {
        $value = str_replace("<span>", "", $value);
        $value = str_replace("</span>", "", $value);
        $almaurl = "https://open-na.hosted.exlibrisgroup.com/alma/44UOE_INST/bibs/" . $value;

        $hasalma = 'Y';
    }


    if ($label == 'Catalogue Link') {
        $value = str_replace("<span>", "", $value);
        $value = str_replace("</span>", "", $value);
        if ($value !== 'N/A') {
            $catalogue_link = '<h3><a  class ="cat-link"href="' . $value . '" target = "_blank">See the item in context</a></h3>';
        }
    }
}

?>

<nav class="navbar navbar-fixed-top second-navbar">
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
                        echo '<li ><a href ="'.$_SERVER['REQUEST_URI'].'#stc-section4" >Audio-Visual</a ></li >';
                    } ?>
                    <li><a href="<?php echo $_SERVER['REQUEST_URI'];?>#stc-section5">Catalogue Data</a></li>
                    <li><a href="<?php echo $_SERVER['REQUEST_URI'];?>#stc-section6">Related Items</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
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

            if($key == 'Date') {
                $date = $metadatavalue;
            }
            if (!(isset($date))){
                $date = 'Undated';
            }
            if($key == 'Author') {
                $maker = $metadatavalue;
            }
            if (!(isset($maker))){
                $maker = 'Unknown author';
            }
            if($key == 'Title') {
                $title = $metadatavalue;
            }
            if (!(isset($title))){
                $title = 'Unnamed item';
            }

            if($key == 'Shelfmark') {
                $date = $metadatavalue;
            }
        }
    }
}

?>

<div id="stc-section1" class="container-fluid record-content">
    <h2 class="itemtitle hidden-sm hidden-xs"><?php echo $title .' | '. $maker. ' | '.$date;?></h2>
    <h4 class="itemtitle hidden-lg hidden-md"><?php echo $title .' | '. $maker. ' | '.$date;?></h4>
</div>

<div id="stc-section2" class="container-fluid">
<?php
if (isset($jsonLink)) {

    $viewlink = '<div class="uv-cell"><div class="uv-fill"><iframe class ="uv-sizer" allowfullscreen="true" src="https://librarylabs.ed.ac.uk/iiif/uv/?manifest='.$manifest.'" ></iframe></div></div>';

echo $viewlink;
}
    ?>
    <div class = "json-link">
        <p>
            <?php if (isset($jsonLink)){echo $jsonLink;} ?>
        </p>
    </div>
</div>

<div id="stc-section5" class="panel panel-default container-fluid">
    <div class="panel-heading straight-borders">
        <h2 class="panel-title hidden-sm hidden-xs ">
            <a class="accordion-toggle" data-toggle="collapse" href="#collapse1">Catalogue Data <i class="fa fa-chevron-down" aria-hidden="true"></i>
            </a>
        </h2>
        <h4 class="panel-title hidden-md hidden-lg ">
            <a class="accordion-toggle" data-toggle="collapse" href="#collapse1">Catalogue Data <i class="fa fa-chevron-down" aria-hidden="true"></i>

            </a>
        </h4>
    </div>


    <?php
    if ($catalogue_link !== '' and $catalogue_link !== 'N/A')
    {
        echo $catalogue_link;
    }
    if ($hasalma == 'Y' or $hasprimo == 'Y')
    {


        if ($hasprimo == 'Y') {
            echo '<p><a href= "' . $primourl . '" target="_blank">See this item on DiscoverEd.</a></p>';
        }

        if ($hasalma == 'Y' )
        {
            $curl = curl_init();
            // $fp = fopen("/var/tmp/curl.json", "w");
            curl_setopt($curl, CURLOPT_URL, $almaurl);
            //curl_setopt($curl, CURLOPT_FILE, $fp);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl,  CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ( $httpCode == 404 ) {
                echo "404";
            }
            else
            {
                //fwrite($fp, $response);
                $alma_json = json_decode($response, true);

            }
            // var_dump($response);
            curl_close($curl);
            echo "<h3>Main volume data</h3>";

            foreach($alma_json as $key=>$value)
            {
                if (($key !== 'creator') and ($key !== 'note')and ($key !== 'contributor')  and ($key !== 'subject')and ($key !== 'identifier'))
                {
                    $key =str_replace("@", "", $key);
                    echo "<p>".ucfirst($key)." : ".$value."</p>";
                }
            }

            process_items($alma_json, 'creator');
            process_items($alma_json, 'contributor');
            process_items($alma_json, 'subject');
            process_items($alma_json, 'identifier');

            echo "<h3>Notes</h3>";
            $j=1;
            foreach ($alma_json['note'] as $note)
            {

                echo "<p>" .$j. ". ".$note."</p>";
                $j++;
            }
        }
    }


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

                        echo '<a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '%7C%7C%7C' . $orig_filter . '%22">' . $metadatavalue . '</a>';
                    }
                }
                echo '</div>';

            }
        }
    }


    ?>
</div>