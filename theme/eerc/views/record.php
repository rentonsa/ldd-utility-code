<?php

$author_field = $this->skylight_utilities->getField("Creator");
$type_field = $this->skylight_utilities->getField("Type");
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

                                $value .= '<a href="./search/*:*/' . $key . ':%22'.$orig_filter.'%22">'.$metadatavalue.'</a>';
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

                                    $json_obj = json_decode($json, TRUE)['response']['docs'][0]['json'];
                                    //print_r(json_decode($json, TRUE)['response']['docs']);

                                    $jsonIterator = new RecursiveIteratorIterator(
                                        new RecursiveArrayIterator(json_decode($json_obj, TRUE)),
                                        RecursiveIteratorIterator::SELF_FIRST);

                                    foreach ($jsonIterator as $key2 => $val) {
                                        if(!is_array($val) && $key2 == 'file_uri')   {
                                            if(strpos($val, '.wav') !== false || strpos($val, '.mp3') !== false) {
                                                $audio .= '<audio controls src="'.$val.'" style="margin-top: 8px;"> Your browser does not support the <code>audio</code> element.</audio></br>';
                                            }
                                            else if(strpos($val, '.jpg') !== false || strpos($val, '.jpeg') !== false) {
                                                $photo .= '<a href="'. $val . '"><img src="'.$val.'" style="width: 300px; padding: 8px;"></a>';
                                            }
                                            else if(strpos($val, '.odt') !== false || strpos($val, '.doc') !== false) {
                                                $trans .= '<a href="' . $val . '"><img src="/theme/eerc/images/file-word-icon.png"></a>';
                                            }
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
                                        $value .= '<div id="intsum">' . $interview_summary . '</div><script>$("#intsum").readmore({"collapsedHeight": 50, "moreLink": \'<a href = "#" class="moreless" >...read more </a>\', "lessLink": \'<a href = "#" class="moreless" >...read less </a >\'});</script>';
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

                        echo '<td><a href="http://www.lhsa.lib.ed.ac.uk/" target="_blank"
                        title="Lothian Health Services Archive">Lothian Health Services Archive</a></td>';
                    ?>
                </tr>-->
            </tbody>
        </table>

        <div class="row" style="float: right;">
            <button class="btn btn-info" onClick="history.go(-1);"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Back to Search Results</button>
            <button class="btn btn-info" onClick="location.href= '<?php echo $link_uri_prefix . $solr[$id][0] ?>"><span title="Full record at archives online">View full record in University of Edinburgh Archives Online</span> <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></button>
        </div>

        <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox" style="clear: both; float: right;"></div>

        <?php //print_r($solr['dates']) ?>
    </div>
    <!--<div class="row">

    </div>-->
</div>