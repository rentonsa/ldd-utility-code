<div class="container">

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" id="search-results">
        <?php

        // Set up some variables to easily refer to particular fields you've configured
        // in $config['skylight_searchresult_display']

        $title_field = $this->skylight_utilities->getField('Title');
        $author_field = $this->skylight_utilities->getField('Author');
        $maker_field = $this->skylight_utilities->getField('Maker');
        $date_field = $this->skylight_utilities->getField('Date Coverage');
        $date_test_field = $this->skylight_utilities->getField('Date');
        $bitstream_field = $this->skylight_utilities->getField('Bitstream');
        $thumbnail_field = $this->skylight_utilities->getField('Thumbnail');
        $link_image_field = $this->skylight_utilities->getField('ImageUri');
        $owning_coll = $this->skylight_utilities->getField('OwningCollection');
        /*
        $score = $this->skylight_utilities->getField('Score');


        echo $score;

        foreach($docs as $index => $doc)
        {
            print_r($doc[$score]['score']."\n");
            print_r($doc[$owning_coll][0]."\n");
        }
        */


        $base_parameters = preg_replace("/[?&]sort_by=[_a-zA-Z+%20. ]+/","",$base_parameters);
        if($base_parameters == "") {
            $sort = '?sort_by=';
        }
        else {
            $sort = '&sort_by=';
        }
        ?>

        <div class="container-fluid">

            <div class="row">
                <?php

                foreach ($docs as $index => $doc) {

                    if ($doc[$owning_coll][0] == 1) {

                        if (isset($doc[$title_field][0])) {
                            $record_title = $doc[$title_field][0];
                        } else {
                            $record_title = 'No title';
                        }
                        $owning_id = $doc[$owning_coll][0];
                        $link_coll = "./";
                        switch ($owning_id) {
                            case 3:
                                $link_coll = base_url() . "art/";
                                $link_title = 'Art Collection';
                                break;
                            case 11:
                                $link_coll = base_url() . "mimed/";
                                $link_title = 'MIMEd Collection';
                                break;
                            case 1:
                                $link_coll = base_url();
                                $link_title = 'CLDs';
                                break;
                            case 14:
                                $link_coll = base_url() . "calendars/";
                                $link_title = 'Calendars';
                                break;
                            case 17:
                                $link_coll = "https://test.exhibitions.ed.ac.uk/";
                                $link_title = 'Exhibitions';
                                break;
                            case 64:
                                $link_coll = base_url() . "public-art/";
                                $link_title = 'Public Art Collection';
                                break;
                            case 48:
                                $link_coll = base_url() . "iconics/";
                                $link_title = 'Iconics Collection';
                                break;
                            case 50:
                                $link_coll = base_url() . "anatomy/";
                                $link_title = 'Anatomy Collection';
                                break;
                            case 84:
                                $link_coll = base_url() . "stcecilias/";
                                $link_title = 'St Cecilia\'s Hall';
                                break;
                            case 69:
                                $link_coll = base_url() . "speccoll/";
                                $link_title = 'Archives, Rare Books & Manuscripts';
                                break;
                            case 49:
                                $link_coll = base_url() . "cockburn/";
                                $link_title = 'Cockburn Collection';
                                break;
                        }

                        $thumbnailLink = '';

                        ?>
                        <div class="col-xs-6 col-md-3" id="box" -->
                            <?php
                            $bitstream_array = array();
                            $thumbnaildone = false;
                            if (isset($doc[$bitstream_field])) {
                                $i = 0;
                                $started = false;
                                // loop through to get min sequence

                                foreach ($doc[$bitstream_field] as $bitstream) {
                                    $b_segments = explode("##", $bitstream);
                                    $b_filename = $b_segments[1];
                                    $b_seq = $b_segments[4];
                                    $imageformat = false;
                                    if ((strpos($b_filename, ".jpg") > 0) || (strpos($b_filename, ".JPG") > 0)) {

                                        $imageformat = true;

                                        $bitstream_array[$b_seq] = $bitstream;

                                        if ($started) {
                                            if ($b_seq < $min_seq) {
                                                $min_seq = $b_seq;
                                            }
                                        } else {
                                            $min_seq = $b_seq;
                                            $started = true;
                                        }
                                    }
                                    $i++;
                                }
                                if (!$imageformat) {
                                    if (isset($doc[$link_image_field])) {
                                        $iiif_url = $doc[$link_image_field][0];
                                        $iiif_small = str_replace('full/full', 'full/200,', $iiif_url);
                                        $thumbnailLink = '<a title = "' . $record_title . '" class="fancybox" rel="group" href="' . $iiif_url . '"> ';
                                        $thumbnailLink .= '<div class ="imagebox"><img src = "' . $iiif_small . '" class="img-responsive"  title="' . $record_title . '" /></div></a>';
                                        echo $thumbnailLink;
                                    } else {
                                        $thumbnailLink .= '<div class ="imagebox"><img src ="../theme/iconics/images/comingsoon.gif" class="img-responsive" title="' . $record_title . '" /></div>';
                                        echo $thumbnailLink;
                                    }
                                }

                                // if there is a thumbnail and a bitstream
                                if (isset($min_seq) && count($bitstream_array) > 0) {
                                    // get all the information
                                    $b_segments = explode("##", $bitstream_array[$min_seq]);
                                    $b_filename = $b_segments[1];
                                    $b_handle = $b_segments[3];
                                    $b_seq = $b_segments[4];
                                    $b_handle_id = preg_replace('/^.*\//', '', $b_handle);
                                    //$b_uri = './record/'.$b_handle_id.'/'.$b_seq.'/'.$b_filename;
                                    $b_uri = $link_coll . 'record/' . $b_handle_id . '/' . $b_seq . '/' . $b_filename;

                                    $thumbnailLink = "";

                                    if (isset($doc[$thumbnail_field])) {
                                        foreach ($doc[$thumbnail_field] as $thumbnail) {

                                            $t_segments = explode("##", $thumbnail);
                                            $t_filename = $t_segments[1];

                                            if ($t_filename === $b_filename . ".jpg") {

                                                $t_handle = $t_segments[3];
                                                $t_seq = $t_segments[4];
                                                $t_uri = $link_coll . 'record/' . $b_handle_id . '/' . $t_seq . '/' . $t_filename;

                                                $thumbnailLink = '<a title = "' . $record_title . '" class="fancybox" rel="group" href="' . $b_uri . '"> ';
                                                $thumbnailLink .= '<div class ="imagebox"><img src = "' . $t_uri . '" class="img-responsive"  title="' . $record_title . '" /></div></a>';
                                            }
                                        }
                                    } // there isn't a thumbnail so display the bitstream itself

                                    else {
                                        $thumbnailLink = '<a title = "' . $record_title . '" class="fancybox" rel="group" href="' . $b_uri . '"> ';
                                        $thumbnailLink .= '<div class ="imagebox"><img src = "' . $b_uri . '" class="img-responsive"  title="' . $record_title . '" /></div></a>';
                                    }
                                    echo $thumbnailLink;
                                }
                            } else if (isset($doc[$link_image_field])) {
                                $iiif_url = $doc[$link_image_field];
                                $iiif_small = str_replace('full/full', 'full/200,', $iiif_url);


                                $thumbnailLink = '<a title = "' . $record_title . '" class="fancybox" rel="group" href="' . $iiif_url . '"> ';
                                $thumbnailLink .= '<div class ="imagebox"><img src = "' . $iiif_small . '" class="img-responsive"  title="' . $record_title . '" /></div></a>';
                            } else {
                                $thumbnailLink .= '<div class ="imagebox"><img src ="../theme/iconics/images/comingsoon.gif" class="img-responsive" title="' . $record_title . '" /></div>';
                                echo $thumbnailLink;
                            } ?>
                            <div class="recordtitle">
                                <p>
                                    <?php
                                    $recordlen = strlen($record_title);
                                    if ($recordlen > 26) {
                                        $record_title = substr($record_title, 0, 50) . '...';
                                    } else {
                                        $record_title = $record_title;
                                    }

                                    $creator = 'No creator';
                                    if (isset($doc[$maker_field][0])) {
                                        $lower_orig_filter = strtolower($doc[$maker_field][0]);
                                        $creator = '<a class="artist" href="./search/*:*/Maker:%22' . $lower_orig_filter . '+%7C%7C%7C+' . $doc[$maker_field][0] . '%22">' . $doc[$maker_field][0] . '</a>';

                                    } else if (isset($doc[$author_field][0])) {
                                        $lower_orig_filter = strtolower($doc[$author_field][0]);
                                        $creator = '<a class="artist" href="./search/*:*/Author:%22' . $lower_orig_filter . '+%7C%7C%7C+' . $doc[$author_field][0] . '%22">' . $doc[$author_field][0] . '</a>';
                                    }

                                    $date_made = '';
                                    if (isset($doc[$date_field][0])) {
                                        $date_made = ' | ' . '<a class="date_made" href="./search/*:*/Date:[' . $doc[$date_field][0] . ' TO ' . $doc[$date_field][0] . ']">' . $doc[$date_field][0] . '</a>';
                                    }


                                    $add_info = $creator . $date_made;


                                    ?>
                                    <!--<a href="./record/<?php // echo $doc['id']
                                    ?>?highlight=<?php //echo $query
                                    ?>"><?php //echo $recordtitle
                                    ?></a>-->

                                    <a href="<?php echo $link_coll ?>record/<?php echo $doc['id'] ?>?highlight=<?php echo $query ?>"
                                       target="_blank"><?php echo $record_title ?></a>

                                <div class="add-info"><b><?php echo $add_info; ?></b></div>
                                <div class="collection-info">( <i>link is to <a href="<?php echo $link_coll; ?>"
                                                                                title="<?php echo $link_coll; ?>"><b><?php echo $link_title; ?></b>
                                        </a>)</i></div>
                                </p>
                            </div>
                        </div>
                        <?php
                    } // end for each search result
                }

                foreach ($docs as $index => $doc)
                {
                    if ($doc[$owning_coll][0] != 1 )
                    {
                        if (isset($doc[$title_field][0])) {
                            $record_title = $doc[$title_field][0];
                        } else {
                            $record_title = 'No title';
                        }
                        $owning_id = $doc[$owning_coll][0];
                        $link_coll = "./";
                        switch ($owning_id) {
                            case 3:
                                $link_coll = base_url() . "art/";
                                $link_title = 'Art Collection';
                                break;
                            case 11:
                                $link_coll = base_url() . "mimed/";
                                $link_title = 'MIMEd Collection';
                                break;
                            case 1:
                                $link_coll = base_url();
                                $link_title = 'CLDs';
                                break;
                            case 14:
                                $link_coll = base_url() . "calendars/";
                                $link_title = 'Calendars';
                                break;
                            case 17:
                                $link_coll = "https://test.exhibitions.ed.ac.uk/";
                                $link_title = 'Exhibitions';
                                break;
                            case 64:
                                $link_coll = base_url() . "public-art/";
                                $link_title = 'Public Art Collection';
                                break;
                            case 48:
                                $link_coll = base_url() . "iconics/";
                                $link_title = 'Iconics Collection';
                                break;
                            case 50:
                                $link_coll = base_url() . "anatomy/";
                                $link_title = 'Anatomy Collection';
                                break;
                            case 84:
                                $link_coll = base_url() . "stcecilias/";
                                $link_title = 'St Cecilia\'s Hall';
                                break;
                            case 69:
                                $link_coll = base_url() . "speccoll/";
                                $link_title = 'Archives, Rare Books & Manuscripts';
                                break;
                            case 49:
                                $link_coll = base_url() . "cockburn/";
                                $link_title = 'Cockburn Collection';
                                break;
                        }

                        $thumbnailLink = '';

                        ?>
                        <div class="col-xs-6 col-md-3" id="box" -->
                            <?php
                            $bitstream_array = array();
                            $thumbnaildone = false;
                            if (isset($doc[$bitstream_field])) {
                                $i = 0;
                                $started = false;
                                // loop through to get min sequence

                                foreach ($doc[$bitstream_field] as $bitstream) {
                                    $b_segments = explode("##", $bitstream);
                                    $b_filename = $b_segments[1];
                                    $b_seq = $b_segments[4];
                                    $imageformat = false;
                                    if ((strpos($b_filename, ".jpg") > 0) || (strpos($b_filename, ".JPG") > 0)) {

                                        $imageformat = true;

                                        $bitstream_array[$b_seq] = $bitstream;

                                        if ($started) {
                                            if ($b_seq < $min_seq) {
                                                $min_seq = $b_seq;
                                            }
                                        } else {
                                            $min_seq = $b_seq;
                                            $started = true;
                                        }
                                    }
                                    $i++;
                                }
                                if (!$imageformat) {
                                    if (isset($doc[$link_image_field])) {
                                        $iiif_url = $doc[$link_image_field][0];
                                        $iiif_small = str_replace('full/full', 'full/200,', $iiif_url);
                                        $thumbnailLink = '<a title = "' . $record_title . '" class="fancybox" rel="group" href="' . $iiif_url . '"> ';
                                        $thumbnailLink .= '<div class ="imagebox"><img src = "' . $iiif_small . '" class="img-responsive"  title="' . $record_title . '" /></div></a>';
                                        echo $thumbnailLink;
                                    } else {
                                        $thumbnailLink .= '<div class ="imagebox"><img src ="../theme/iconics/images/comingsoon.gif" class="img-responsive" title="' . $record_title . '" /></div>';
                                        echo $thumbnailLink;
                                    }
                                }

                                // if there is a thumbnail and a bitstream
                                if (isset($min_seq) && count($bitstream_array) > 0) {
                                    // get all the information
                                    $b_segments = explode("##", $bitstream_array[$min_seq]);
                                    $b_filename = $b_segments[1];
                                    $b_handle = $b_segments[3];
                                    $b_seq = $b_segments[4];
                                    $b_handle_id = preg_replace('/^.*\//', '', $b_handle);
                                    //$b_uri = './record/'.$b_handle_id.'/'.$b_seq.'/'.$b_filename;
                                    $b_uri = $link_coll . 'record/' . $b_handle_id . '/' . $b_seq . '/' . $b_filename;

                                    $thumbnailLink = "";

                                    if (isset($doc[$thumbnail_field])) {
                                        foreach ($doc[$thumbnail_field] as $thumbnail) {

                                            $t_segments = explode("##", $thumbnail);
                                            $t_filename = $t_segments[1];

                                            if ($t_filename === $b_filename . ".jpg") {

                                                $t_handle = $t_segments[3];
                                                $t_seq = $t_segments[4];
                                                $t_uri = $link_coll . 'record/' . $b_handle_id . '/' . $t_seq . '/' . $t_filename;

                                                $thumbnailLink = '<a title = "' . $record_title . '" class="fancybox" rel="group" href="' . $b_uri . '"> ';
                                                $thumbnailLink .= '<div class ="imagebox"><img src = "' . $t_uri . '" class="img-responsive"  title="' . $record_title . '" /></div></a>';
                                            }
                                        }
                                    } // there isn't a thumbnail so display the bitstream itself

                                    else {
                                        $thumbnailLink = '<a title = "' . $record_title . '" class="fancybox" rel="group" href="' . $b_uri . '"> ';
                                        $thumbnailLink .= '<div class ="imagebox"><img src = "' . $b_uri . '" class="img-responsive"  title="' . $record_title . '" /></div></a>';
                                    }
                                    echo $thumbnailLink;
                                }
                            } else if (isset($doc[$link_image_field])) {
                                $iiif_url = $doc[$link_image_field];
                                $iiif_small = str_replace('full/full', 'full/200,', $iiif_url);


                                $thumbnailLink = '<a title = "' . $record_title . '" class="fancybox" rel="group" href="' . $iiif_url . '"> ';
                                $thumbnailLink .= '<div class ="imagebox"><img src = "' . $iiif_small . '" class="img-responsive"  title="' . $record_title . '" /></div></a>';
                            } else {
                                $thumbnailLink .= '<div class ="imagebox"><img src ="../theme/iconics/images/comingsoon.gif" class="img-responsive" title="' . $record_title . '" /></div>';
                                echo $thumbnailLink;
                            } ?>
                            <div class="recordtitle">
                                <p>
                                    <?php
                                    $recordlen = strlen($record_title);
                                    if ($recordlen > 26) {
                                        $record_title = substr($record_title, 0, 50) . '...';
                                    } else {
                                        $record_title = $record_title;
                                    }

                                    $creator = 'No creator';
                                    if (isset($doc[$maker_field][0])) {
                                        $lower_orig_filter = strtolower($doc[$maker_field][0]);
                                        $creator = '<a class="artist" href="./search/*:*/Maker:%22' . $lower_orig_filter . '+%7C%7C%7C+' . $doc[$maker_field][0] . '%22">' . $doc[$maker_field][0] . '</a>';

                                    } else if (isset($doc[$author_field][0])) {
                                        $lower_orig_filter = strtolower($doc[$author_field][0]);
                                        $creator = '<a class="artist" href="./search/*:*/Author:%22' . $lower_orig_filter . '+%7C%7C%7C+' . $doc[$author_field][0] . '%22">' . $doc[$author_field][0] . '</a>';
                                    }

                                    $date_made = '';
                                    if (isset($doc[$date_field][0])) {
                                        $date_made = ' | ' . '<a class="date_made" href="./search/*:*/Date:[' . $doc[$date_field][0] . ' TO ' . $doc[$date_field][0] . ']">' . $doc[$date_field][0] . '</a>';
                                    }


                                    $add_info = $creator . $date_made;


                                    ?>
                                    <!--<a href="./record/<?php // echo $doc['id']
                                    ?>?highlight=<?php //echo $query
                                    ?>"><?php //echo $recordtitle
                                    ?></a>-->

                                    <a href="<?php echo $link_coll ?>record/<?php echo $doc['id'] ?>?highlight=<?php echo $query ?>"
                                       target="_blank"><?php echo $record_title ?></a>

                                <div class="add-info"><b><?php echo $add_info; ?></b></div>
                                <div class="collection-info">( <i>link is to <a href="<?php echo $link_coll; ?>"
                                                                                title="<?php echo $link_coll; ?>"><b><?php echo $link_title; ?></b>
                                        </a>)</i></div>
                                </p>
                            </div>
                        </div>
                        <?php
                    } // end for each search result
                }
                ?>
            </div>
            <div class="row">
                <div class="centered text-center">
                    <nav>
                    <span class="pagination pagination-sm pagination-xs">
                        <?php
                        foreach ($paginationlinks as $pagelink)
                        { echo $pagelink; }
                        ?>
                    </span>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="centered text-center">
                    <nav>
                        <span class="searchFound"><?php echo $rows ?> results found</span>
                    </nav>
                </div>
            </div>
        </div>
    </div>
