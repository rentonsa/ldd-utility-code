<?php

$author_field = $this->skylight_utilities->getField("Author");
$type_field = $this->skylight_utilities->getField("Type");
$year_field = $this->skylight_utilities->getField("Year");
$version_field = $this->skylight_utilities->getField("Version");
$course_field = $this->skylight_utilities->getField('Course Code');
$filters = array_keys($this->config->item("skylight_filters"));
$bitstreamLinks = array();
//Insert Schema.org
$schema = $this->config->item("skylight_schema_links");
?>


<h1 class="itemtitle"><?php echo $record_title ?>
    <?php if(isset($solr[$year_field])) {
        echo " " . $solr[$year_field][0];
        if(isset($solr[$version_field]) && $solr[$version_field][0] == "Resit") {
            echo " Resit";
        }
    } ?>
</h1>

    <div class="content">
      <!--Insert Schema-->
      <div itemscope itemtype ="http://schema.org/CreativeWork">
        <table>
            <tbody>
            <?php foreach($recorddisplay as $key) {

                $element = $this->skylight_utilities->getField($key);
                if(isset($solr[$element])) {
                    echo '<tr><th>'.$key.'</th><td>';
                    foreach($solr[$element] as $index => $metadatavalue) {
                        // if it's a facet search
                        // make it a clickable search link
                        if(in_array($key, $filters) && $key != "Year") {

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
                              echo '<a href="./search/*:*/' . $key . ':%22'.$lower_orig_filter.'%7C%7C%7C'.$orig_filter.'%22" title="'. $metadatavalue . '">'.$metadatavalue.'</a>';
                            }

                        }
                        else if($key == "Course Code") {
                              if (isset ($schema[$key]))
                              {
                                  echo '<span itemprop="'.$schema[$key].'">'. strtoupper($metadatavalue). "</span>";
                                }
                                else
                                {
                                  echo strtoupper($metadatavalue);
                                }
                            }
                            else
                            {

                              if (isset ($schema[$key]))
                              {
                                  echo '<span itemprop="'.$schema[$key].'">'. $metadatavalue. "</span>";
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
                    echo '</td></tr>';
                }

            } ?>
            <tr>
                <th>PDF Version</th>
                <td>
                    <?php if(isset($solr[$bitstream_field]) && $link_bitstream) {

                        foreach($solr[$bitstream_field] as $bitstream) {

                            $bitstreamLink = $this->skylight_utilities->getBitstreamURI($bitstream);?>
                            <a href="<?php echo $bitstreamLink; ?>" title="Download paper" onclick="ga('send', 'event', '<?php echo $solr[$course_field][0].'||'.$record_title.' '.$solr[$year_field][0]; ?>', 'Download', 'Search page – PDF Download');">Download Paper</a>

                            <?php
                        }
                    }
                    else { ?>

                        <a href="./unavailable" title="Paper unavailable">Paper unavailable</a>

                    <?php } ?>
            </td></tr>
            </tbody>
        </table>


        <?php if(isset($solr[$bitstream_field]) && $link_bitstream) {
            ?><div class="record_bitstreams"><?php
            foreach($solr[$bitstream_field] as $bitstream) {
                $bitstreamLink = $this->skylight_utilities->getBitstreamLink($bitstream);
                $bitstreamUri = $this->skylight_utilities->getBitstreamUri($bitstream);
                ?>
                <br />
                <object data="<?php echo $bitstreamUri ?>" type="application/pdf" width="660" height="928">
                    <p><span class="label">
                        It appears you don't have a PDF plugin for this browser.</span>
                        Click <?php echo $bitstreamLink ?> to download.
                        (<span class="bitstream_size"><?php echo getBitstreamSize($bitstream); ?></span>)
                    </p>

                </object>



            <?php
            } ?></div> <?php
        } ?>

    </div>
  </div>

<input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
