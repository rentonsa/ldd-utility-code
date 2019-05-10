<?php

    function process_images($doc, $bitstream_field, $link_coll, $link_image_field, $record_title, $thumbnail_field)
    {
        /**
         * Process images based upon either a physically attached image, or a referential IIIF URL link
         * @param $doc full solr doc
         * @param $bitstream_field bitstream field as defined globally
         * @param $link_coll underlying url to specific collection
         * @param $link_image_field generally field that stores IIIF URLS
         * @param $record_title record titles to link to
         * @param $thumbnail_field $thumbnail field defined globally
         */

        $thumbnailLink = '';
        $bitstream_array = array();

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

                    if ($started)
                    {
                        if ($b_seq < $min_seq)
                        {
                            $min_seq = $b_seq;
                        }
                    }
                    else
                    {
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
        }
        else if (isset($doc[$link_image_field]))
        {
            $iiif_url = $doc[$link_image_field][0];
            $iiif_small = str_replace('full/full', 'full/200,', $iiif_url);
            $thumbnailLink = '<a title = "' . $record_title . '" class="fancybox" rel="group" href="' . $iiif_url . '"> ';
            $thumbnailLink .= '<div class ="imagebox"><img src = "' . $iiif_small . '" class="img-responsive"  title="' . $record_title . '" /></div></a>';
            echo $thumbnailLink;
        }
        else
        {
            $thumbnailLink .= '<div class ="imagebox"><img src ="../theme/iconics/images/comingsoon.gif" class="img-responsive" title="' . $record_title . '" /></div>';
            echo $thumbnailLink;
        }
    }

    function process_title($record_title)
    {
        /**
         * Reduce title down to a displayable length
         * @param $record_title record titles to link to
         * @return $record_title adjusted
         */
        $recordlen = strlen($record_title);
        if ($recordlen > 26) {
            $record_title = substr($record_title, 0, 50) . '...';
        } else {
            $record_title = $record_title;
        }
        return $record_title;
    }


    function process_creator($doc, $maker_field, $author_field)
    {
        /**
         * Reduce title down to a displayable length
         * @param $doc full solr doc for item
         * @param $maker_field generally musical instruments use makers
         * @param $author_field other collections use authors!
         * @return $creator catch-all term
         */
        $creator = 'No creator';
        if (isset($doc[$maker_field][0])) {
            $lower_orig_filter = strtolower($doc[$maker_field][0]);
            $creator = '<a class="artist" href="./search/*:*/Maker:%22' . $lower_orig_filter . '%7C%7C%7C' . $doc[$maker_field][0] . '%22">' . $doc[$maker_field][0] . '</a>';
        } else if (isset($doc[$author_field][0])) {
            $lower_orig_filter = strtolower($doc[$author_field][0]);
            $creator = '<a class="artist" href="./search/*:*/Author:%22' . $lower_orig_filter . '%7C%7C%7C' . $doc[$author_field][0] . '%22">' . $doc[$author_field][0] . '</a>';
        }
        return $creator;
    }

    function process_date($doc, $date_field)
    {
        /**
         * Reduce title down to a displayable length
         * @param $doc full solr doc for item
         * @param $date_field which date field to use
         * @return $date_made catch-all term
         */
        $date_made = '';
        if (isset($doc[$date_field][0])) {
            $date_made = ' | ' . '<a class="date_made" href="./search/*:*/Date:[' . $doc[$date_field][0] . ' TO ' . $doc[$date_field][0] . ']">' . $doc[$date_field][0] . '</a>';
        }
        return $date_made;
    }

?>
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
        $link_colls = $this->config->item("skylight_link_colls");
        $link_titles = $this->config->item("skylight_link_titles");

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
                //We're going to loop twice- this is not the nicest- but we want to return the CLDs to be the first items returned,
                //so we do it for collection 1....

                foreach ($docs as $index => $doc) {
                    if ($doc[$owning_coll][0] == 1) {

                        if (isset($doc[$title_field][0])) {
                            $record_title = $doc[$title_field][0];
                        } else {
                            $record_title = 'No title';
                        }
                        $owning_id = trim($doc[$owning_coll][0]);
                        $link_coll = "./";
                        $link_coll = $link_colls[$owning_id];
                        $link_title = $link_titles[$owning_id];
                        ?>
                        <div class="col-xs-6 col-md-3" id="box" -->
                            <?php

                            process_images($doc, $bitstream_field, $link_coll, $link_image_field,$record_title, $thumbnail_field )
                            ?>
                            <div class="recordtitle">
                                <p>
                                    <?php
                                    $record_title = process_title($record_title);
                                    $creator = process_creator($doc, $maker_field, $author_field);
                                    $date_made = process_date($doc, $date_field);

                                    $add_info = $creator . $date_made;
                                    ?>
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
                    }
                }

               //Second loop.... for everything else

                foreach ($docs as $index => $doc)
                {
                    if ($doc[$owning_coll][0] != 1 )
                    {

                        if (isset($doc[$title_field][0])) {
                            $record_title = $doc[$title_field][0];
                        } else {
                            $record_title = 'No title';
                        }
                        $owning_id = trim($doc[$owning_coll][0]);
                        $link_coll = "./";
                        $link_coll = $link_colls[$owning_id];
                        $link_title = $link_titles[$owning_id];
                        ?>
                        <div class="col-xs-6 col-md-3" id="box" -->
                            <?php
                                process_images($doc, $bitstream_field, $link_coll, $link_image_field, $record_title, $thumbnail_field)
                            ?>
                            <div class="recordtitle">
                                <p>
                                    <?php
                                    $record_title = process_title($record_title);
                                    $creator = process_creator($doc, $maker_field, $author_field);
                                    $date_made = process_date($doc, $date_field);
                                    $add_info = $creator . $date_made;
                                    ?>

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