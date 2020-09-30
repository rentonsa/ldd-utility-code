<?php

$type_field = $this->skylight_utilities->getField("Type");
$subject_field = $this->skylight_utilities->getField("Subject");
$uri_field = $this->skylight_utilities->getField("Link");
$filters = array_keys($this->config->item("skylight_filters"));

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

            echo '<a class="$month" href="./search/*:*/%22Subject'.$lower_orig_filter.'+%7C%7C%7C+'.$orig_filter.'%22">'.$subject.'</a>';
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

                    echo '<a href="./search/*:*/' . $key . ':%22'.$lower_orig_filter.'+%7C%7C%7C+'.$orig_filter.'%22" title="'.$metadatavalue.'">'.$metadatavalue.'</a>';
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
            $findLuna = 'http://images.is.ed.ac.uk';
            $pos = strpos($uri, $find);

            if ($pos === false)
            {
                echo '<tr><th>Link</th><td>';
                $Lunapos = strpos($uri, $findLuna);

                if ($Lunapos !== false)
                {

                    echo '<a href="'.$uri.'" title="Link to High resolution version of image" target="_blank">High resolution version of photo</a>';
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
<?php if(isset($solr[$bitstream_field]) && $link_bitstream) {
    ?><div class="record_bitstreams"><?php
    foreach($solr[$bitstream_field] as $bitstream) {
        $bitstreamLink = $this->skylight_utilities->getBitstreamLink($bitstream);
        $bitstreamUri = $this->skylight_utilities->getBitstreamUri($bitstream);
        ?>

        <object class="pdfviewer" height="800" data="<?php echo $bitstreamUri ?>" type="application/pdf" width="700">
            <p><span class="label">
            It appears you do not have a PDF plugin for this browser.</span>
            </p>
        </object>
        Click <?php echo $bitstreamLink ?> to download.
        (<span class="bitstream_size"><?php echo getBitstreamSize($bitstream); ?></span>)

    <?php
    } ?></div> <?php
} ?>

<input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">





