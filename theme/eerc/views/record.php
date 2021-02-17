<?php


set_error_handler('exceptions_error_handler');

function exceptions_error_handler($severity, $message, $filename, $lineno) {
    if (error_reporting() == 0) {
        return;
    }
    if (error_reporting() & $severity) {
        throw new ErrorException($message, 0, $severity, $filename, $lineno);
    }
}

function endsWith( $haystack, $needles ) {
    foreach ($needles as $needle) {
        if (substr($haystack, -strlen($needle)) === $needle) {
            return true;
        }
    }
    return false;
}

function humanFileSize($size,$unit="") {
    if( (!$unit && $size >= 1<<30) || $unit == "GB")
        return number_format($size/(1<<30),2)."GB";
    if( (!$unit && $size >= 1<<20) || $unit == "MB")
        return number_format($size/(1<<20),2)."MB";
    if( (!$unit && $size >= 1<<10) || $unit == "KB")
        return number_format($size/(1<<10),2)."KB";
    return number_format($size)." bytes";
}

function curl_get_file_size( $url ) {
    // Assume failure.
    $result = -1;

    $curl = curl_init( $url );

    //curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
    //curl_setopt($curl, CURLOPT_CONNECTTIMEOUT_MS, 1000);

    // Issue a HEAD request and follow any redirects.
    curl_setopt( $curl, CURLOPT_NOBODY, true );
    curl_setopt( $curl, CURLOPT_HEADER, true );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );

    /* For some reason digitalpreservation isn't verified */
    curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );

    $data = curl_exec( $curl );
    curl_close( $curl );

    //log_message('debug', $data);

    if( $data ) {
        $content_length = "unknown";
        $status = "unknown";

        if( preg_match( "/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches ) ) {
            $status = (int)$matches[1];
        }

        if( preg_match( "/Content-Length: (\d+)/", $data, $matches ) ) {
            $content_length = (int)$matches[1];
        }

        // http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
        if( $status == 200 || ($status > 300 && $status <= 308) ) {
            $result = $content_length;
        }

    }

    // Result is -1 if the connection times out
    // Timeout set at 1 second, we don't want to have the user waiting
    // just to print out file size
    if($result != -1) {
        return " (" . humanFileSize($result) . ")";
    }
    else {
        return "";
    }
}


$author_field = $this->skylight_utilities->getField("Creator");
$type_field = $this->skylight_utilities->getField   ("Type");
$date_field = $this->skylight_utilities->getField("Date");
$parent_id_field = $this->skylight_utilities->getField("Parent_Id");
$parent_type_field = $this->skylight_utilities->getField("Parent_Type");
$id_field = $this->skylight_utilities->getField("Identifier");
$filters = array_keys($this->config->item("skylight_filters"));
$link_uri_field = $this->skylight_utilities->getField("Link");
$id = $this->skylight_utilities->getField("Id");
//$d_objs = $this->skylight_utilities->getField("Digital Object Id");

$solr_base = $this->config->item("skylight_solrbase");
$link_uri_prefix  = $this->config->item("skylight_link_url");


$mainImageTest = false;
$numThumbnails = 0;
$bitstreamLinks = array();
?>

<div class="col-md-9 col-sm-9 col-xs-12">
    <div class="row">
        <h1 class="itemtitle"><?php

            $strip_rec_title = strip_tags($record_title);

            if(substr($strip_rec_title, -1) == ',') {
                echo substr($strip_rec_title, 0, strlen($strip_rec_title) - 1);
            }
            else    {
                echo $strip_rec_title;
            }
            ?></h1>
    </div>

    <div class="row full-metadata">
        <table class="table">
            <tbody>

            <?php
            /*if(isset($solr[$parent_id_field])) {
                echo '<tr><th class="table-header">Hierarchy</th><td>';
                echo '<a href ="./record/' . $solr[$parent_id_field][0] .'/'. $solr[$parent_type_field][0] . '" > Parent Record </a>';
                echo '</td><tr>';
            }*/
            ?>

            <?php $excludes = array("");
            $idset = false;
            $interviewer = '';
            foreach($recorddisplay as $key) {
                $element = $this->skylight_utilities->getField($key);

                if(isset($solr[$element])) {
                    if(!in_array($key, $excludes)) {

                        $value = '';
                        $photo = '';
                        $audio = '';
                        $trans = '';
                        $interview_summary = '';

                        foreach($solr[$element] as $index => $metadatavalue) {
                            // if it's a facet search
                            // make it a clickable search link

                            if(in_array($key, $filters)) {

                                $orig_filter = urlencode($metadatavalue);

                                $value .= '<a href="./search/*:*/' . $key . ':%22'.$orig_filter.'%22" title="Search for items with the subject: '. $metadatavalue .'">'.$metadatavalue.'</a>';
                            }
                            else {
                                if($key == 'Interviewer') {
                                    $interviewer = $metadatavalue;
                                }

                                if ($key == 'Identifier') {
                                    if ($idset == false) {
                                        $value .= $metadatavalue;
                                        $idset = true;
                                    }
                                }
                                else if ($key == 'Extent') {
                                    $value .= $metadatavalue['number'] . " " . $metadatavalue['extent_type'];

                                }
                                else if ($key == 'Dates') {
                                    if($metadatavalue['label'] == 'coverage')
                                        $value .= $metadatavalue['label'] . ": " . $metadatavalue['expression'] . '<br/>';
                                    else
                                        $value .= $metadatavalue['label'] . ": " . $metadatavalue['begin'] . '<br/>';

                                }
                                else if ($key == 'Audio links and images') {
                                    $json = file_get_contents($solr_base . 'collection1/select?q=id%3A%22'.$metadatavalue.'%22%0A&wt=json&indent=true');

                                    $json_array = (array) json_decode($json, TRUE)['response']['docs'][0]['json'];

                                    // Iterate through all the digital objects as a PHP array

                                    foreach($json_array as $digital_obj)  {
                                        try {
                                            $digital_obj = json_decode($digital_obj, TRUE);

                                            $do_file = $digital_obj['title'];
                                            $do_title_short = substr($do_file, 0, strpos($do_file, '.'));
                                            $do_url = $digital_obj['file_versions'][0]['file_uri'];
                                            $file_size = curl_get_file_size($do_url);

                                            if (endsWith($do_file, ['.wav', '.mp3'])) {
                                                $audio .= '<audio controls src="' . $do_url . '" title="Embedded audio file ' . $do_file . $file_size . '">';
                                                $audio .= 'Your browser does not support the <code>audio</code> element.</audio>';
                                                //$audio .= $file_size;
                                            } else if (endsWith($do_file, ['.mp4','.mov'])) {
                                                $audio .= '<video controls width="480" preload="metadata" title="Embedded video file ' . $do_file . $file_size . '">';
                                                $audio .= '<source src="' . $do_url . '">';
                                                $audio .= 'Sorry, your browser doesn\'t support embedded videos.</video>';
                                                //$audio .= $file_size;
                                            } else if (endsWith($do_file, ['.jpg','.jpeg'])) {
                                                log_message('debug', print_r($digital_obj, true));
                                                $photo .= '<a href="' . $do_url . '" title="Photograph ' . $do_title_short .  $file_size . '">';
                                                $photo .= '<img src="' . $do_url . '" alt="Photograph ' . $do_title_short .  $file_size . '" class="photos" style="width: 300px; padding: 8px;"></a>';
                                            } /*else if (endsWith($do_file, ['.doc'])) {
                                                $do_title_short = substr($do_title_short, 0, -2);
                                                $trans .= '<a href="' . $do_url . '" title="Transcript of interview ' . $do_title_short . ' in Microsoft Word format">';
                                                $trans .= '<img src="/theme/eerc/images/file-word-icon.png" alt="Transcript of interview ' . $do_title_short . ' in Microsoft Word format"></a>';
                                            } else if (strpos($do_file, '.odt') !== false) {
                                                $do_title_short = substr($do_title_short, 0, -2);
                                                $trans .= '<a href="' . $do_url . '" title="Transcript of interview ' . $do_title_short . ' in ODT format">';
                                                $trans .= '<img src="/theme/eerc/images/file-odt-icon.png" alt="Transcript of interiew ' . $do_title_short . ' in ODT format"></a>';
                                            }*/ else if (endsWith($do_file, ['.pdf'])) {
                                                $do_title_short = substr($do_title_short, 0, -2);
                                                $trans .= '<a href="' . $do_url . '" title="Transcript of interview ' . $do_title_short . ' in PDF format' . $file_size . '" target="_blank">';
                                                $trans .= '<img src="/theme/eerc/images/file-pdf-icon.png" alt="Transcript of interview ' . $do_title_short . ' in PDF format' . $file_size . '"></a>';
                                                //$trans .= $file_size;
                                            }
                                        }
                                        catch (Exception $e) {
                                            // Something was wrong in the digital object data
                                            // but well log it
                                            // echo 'Caught exception: ',  $e->getMessage(), "\n";
                                            log_message('error', 'Error parsing digital object: ' . $e->getMessage());
                                        }
                                    }

                                    if(sizeof($solr[$element])-1 == $index) {
                                        $value .= '<div>' . $photo . '</div><div style="float: left;">' . $audio . '</div>';
                                    }
                                    //echo sizeof($solr[$element]);

                                }
                                else if($key == 'Interview summary')    {
                                    $interview_summary .= '<p>' . $metadatavalue . '</p>';

                                    if(sizeof($solr[$element])-1 == $index) {
                                        $value .= '<div id="intsum">' . $interview_summary . '</div><script>$("#intsum").readmore({"collapsedHeight": 50, "moreLink": \'<a href = "#" class="moreless" title="Click to expand the interview summary box">...read more </a>\', "lessLink": \'<a href = "#" title="Click to shrink the interview summary box" class="moreless" >...read less </a >\'});</script>';
                                    }
                                    //$value .= '<div>' . $metadatavalue . '</div><script>$("#intsum").readmore({"collapsedHeight": 50, "moreLink": \'<a href="#" class="moreless">...read more</a>\', "lessLink": \'<a href="#" class="moreless">...read less</a>\'});</script>';
                                }
                                else if($key != 'Notable persons / organisations' || trim($metadatavalue) != trim($interviewer)){
                                    $value .= $metadatavalue;
                                }
                            }

                            if($value != '' && $index < sizeof($solr[$element]) - 1 && $element != 'digital_object_uris' && $element != 'dates'&& $element != 'component_id') {
                                $value .= ', ';
                            }
                        }

                        if(trim($value) != '')
                            echo '<tr><th class="table-header">'.$key.'</th><td>' . $value . '</td></tr>';

                        if($key == 'Audio links and images' && $trans != '')
                            echo '<tr><th class="table-header">Transcript</th><td>' . $trans . '</td></tr>';

                    }
                }
            }
            ?>

            <!--<tr><th>Consult at</th>
                    <?php

                        /*echo '<td><a href="http://www.lhsa.lib.ed.ac.uk/" target="_blank"
                        title="Lothian Health Services Archive">Lothian Health Services Archive</a></td>';
                        */
                    ?>
                </tr>-->
            </tbody>
        </table>

        <div class="row" style="float: right;">
            <button class="btn btn-info" onClick="history.go(-1);"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Back to Search Results</button>
            <button class="btn btn-info" onClick="location.href= '<?php echo $link_uri_prefix . $solr[$id][0] ?>'"><span title="Full record at archives online">View full record in University of Edinburgh Archives Online</span> <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></button>
        </div>

        <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox" style="clear: both; float: right;"></div>

        <?php //print_r($solr['dates']) ?>
    </div>
    <!--<div class="row">

    </div>-->
</div>