
    <?php

        // Set up some variables to easily refer to particular fields you've configured
        // in $config['skylight_searchresult_display']

        $title_field = $this->skylight_utilities->getField('Title');
        $author_field = $this->skylight_utilities->getField('Creator');
        $exhibition_field = $this->skylight_utilities->getField('Exhibition');
        $date_field = $this->skylight_utilities->getField('Date');
        $type_field = $this->skylight_utilities->getField('Type');
        $bitstream_field = $this->skylight_utilities->getField('Bitstream');
        $thumbnail_field = $this->skylight_utilities->getField('Thumbnail');
        $subject_field = $this->skylight_utilities->getField('Subject');

        $item_count = 1;

        $base_parameters = preg_replace("/[?&]sort_by=[_a-zA-Z+%20. ]+/","",$base_parameters);
        if($base_parameters == "") {
            $sort = '?sort_by=';
        }
        else {
            $sort = '&sort_by=';
        }
    ?>

    <!-- RESULTS NAVIGATION AND FILTERS -->
    <div class="listing-filter">
        <div class="listing-block" id="num">
            <span class="no-results">
                <strong><?php echo $startrow ?>-<?php echo $endrow ?></strong> of
                <strong><?php echo $rows ?></strong> results
            </span>
        </div>

        <!-- LINKS TO RELSULT PAGES BY NUMBER -->
        <div class="listing-block" id="page" alt="links to pages by number">
            <?php echo $pagelinks ?>
        </div>

        <!-- SORT BY FILTERS -->
        <div class="listing-block" id="sort" alt="sort by filters">
            <span class="sort">
                <strong>Sort by</strong>
                <?php foreach($sort_options as $label => $field) {
                    if($label == 'Relevancy')
                    {
                        ?>
                        <em><a href="<?php echo $base_search.$base_parameters.$sort.$field.'+desc'?>"><?php echo $label ?></a></em>
                        <?php
                    }
                    else {
                ?>

                    <em><?php echo $label ?></em>
                    <?php if($label != "Date") { ?>
                    <a id="a-z" href="<?php echo $base_search.$base_parameters.$sort.$field.'+asc' ?>" alt="sort by a-z" title="Sort by a-z">a-z</a> |
                    <a id="z-a" href="<?php echo $base_search.$base_parameters.$sort.$field.'+desc' ?>" alt="sort by z-a" title="Sort by z-a">z-a</a>
                    <br>
                <?php } else { ?>
                    <a href="<?php echo $base_search.$base_parameters.$sort.$field.'+desc' ?>" alt="sort by newest first" title="Sort by newest first">newest</a> |
                    <a href="<?php echo $base_search.$base_parameters.$sort.$field.'+asc' ?>" alt="sort by oldest first" title="Sort by oldest first">oldest</a>
            <?php } } } ?>
                
            </span>
        </div>

    </div>

    
    <!-- FULL RESLUTS LIST -->
    <ul class="listing">

        <?php

        $j = 0;
        foreach ($docs as $index => $doc) {
        ?>

        <li<?php if($index == 0) { echo ' class="first"'; } elseif($index == sizeof($docs) - 1) { echo ' class="last"'; } ?>>
            <!--span class="icon <?php echo $type?>"></span-->
        <div class="item-div" >

            <?php 
                    if ($item_count == 1) {
                        echo '<div class = "iteminfo" id="first-item">';
                        $item_count = $item_count +1;
                    }
                    else {
                        echo '<div class = "iteminfo" id="second-item">';
                        $item_count = 1;
                    }
            ?>

            <!-- INDIVIDUAL ITEM INFO -->
            <!--<div class = "iteminfo" > data-100-bottom-top="transform: translateY(0px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1"-->
            <div class="item-info-block">

                <!-- ITEM TITLE -->
                <h3 class="item-header" alt="item title"><a><?php echo $doc[$title_field][0]; ?> <!-- href="./record/<?php echo $doc['id']?>?highlight=<?php echo $query ?>" -->
                <?php if(array_key_exists($date_field, $doc)) { ?>
                <?php
                echo '(' . $doc[$date_field][0] . ')';
                }
                elseif(array_key_exists('dateIssuedyear', $doc)) {
                    echo '( ' . $doc['dateIssuedyear'][0] . ')';
                }

                ?></a></h3>

                <!-- ITEM TAGS -->
                <div class="tags" alt="item tags">
                    <p class="item-tags">Tags:</p>
                    <?php if(array_key_exists($exhibition_field,$doc)) { ?>
                        <?php

                        $num_ex = 0;
                        foreach ($doc[$exhibition_field] as $exhibition) {
                            // quick hack that only works if the filter key

                            $orig_filter = urlencode($exhibition);

                            $lower_orig_filter = strtolower($exhibition);
                            $lower_orig_filter = urlencode($lower_orig_filter);

                            echo '<a class="reverse" href="./search/*:*/Exhibition:%22'.$lower_orig_filter.'%7C%7C%7C'.$orig_filter.'%22" alt="item exhibition tag filter" title="Filter by tag">'.$exhibition.'</a>';
                            $num_ex++;
                            if($num_ex < sizeof($doc[$exhibition_field])) {
                                echo ' ';
                            }
                        }

                        ?>
                    <?php } ?>

                    <?php if(array_key_exists($author_field,$doc)) { ?>
                        <?php

                        $num_authors = 0;
                        foreach ($doc[$author_field] as $author) {
                            // test author linking
                            // quick hack that only works if the filter key

                            $orig_filter = urlencode($author);

                            $lower_orig_filter = strtolower($author);
                            $lower_orig_filter = urlencode($lower_orig_filter);

                            echo '<a href="./search/*:*/Creator:%22'.$lower_orig_filter.'%7C%7C%7C'.$orig_filter.'%22" alt="item author tag filter" title="Filter by tag">'.$author.'</a>';
                            $num_authors++;
                            if($num_authors < sizeof($doc[$author_field])) {
                                echo ' ';
                            }
                        }

                        ?>
                    <?php } ?>

                </div> <!-- close tags div -->

                <!-- VIEW ITEM BUTTON -->
                <a id="search-item-view" href="./record/<?php echo $doc['id']?>?highlight=<?php echo $query ?>" alt="view item button" title="Lick to item details page">
                    <button class="exhibit-button">
                        <p>View Item</p>
                    </button>
                </a>

            </div> <!-- close item-info -->
            
            <!-- IMAGE THUMBNAIL -->
            <div class = "thumbnail-image">
                <?php

                $bitstream_array = array();

                if(isset($doc[$bitstream_field])) {

                    $i = 0;
                    $started = false;
                    // loop through to get min sequence
                    foreach ($doc[$bitstream_field] as $bitstream)
                    {
                        $b_segments = explode("##", $bitstream);
                        $b_filename = $b_segments[1];
                        $b_seq = $b_segments[4];

                        if((strpos($b_filename, ".jpg") > 0) || (strpos($b_filename, ".JPG") > 0)) {

                            $bitstream_array[$b_seq] = $bitstream;

                            if ($started) {
                                if ($b_seq < $min_seq) {
                                    $min_seq = $b_seq;
                                }
                            }
                            else {
                                $min_seq = $b_seq;
                                $started = true;
                            }
                        }

                        $i++;

                    }

                    // if there is a thumbnail and a bitstream
                    if(isset($min_seq) && count($bitstream_array) > 0) {

                        // get all the information
                        $b_segments = explode("##", $bitstream_array[$min_seq]);
                        $b_filename = $b_segments[1];
                        $b_handle = $b_segments[3];
                        $b_seq = $b_segments[4];
                        $b_handle_id = preg_replace('/^.*\//', '',$b_handle);
                        $b_uri = './record/'.$b_handle_id.'/'.$b_seq.'/'.$b_filename;
                        $thumbnailLink = "";

                        if(isset($doc[$thumbnail_field])) {
                            foreach ($doc[$thumbnail_field] as $thumbnail) {

                                $t_segments = explode("##", $thumbnail);
                                $t_filename = $t_segments[1];

                                if ($t_filename === $b_filename . ".jpg") {

                                    $t_handle = $t_segments[3];
                                    $t_seq = $t_segments[4];
                                    $t_uri = './record/'.$b_handle_id.'/'.$t_seq.'/'.$t_filename;

                                    $thumbnailLink = '<a title = "' . $doc[$title_field][0] . '" class="fancybox" rel="group' . $j .'" href="' . $b_uri . '" alt="link to item"> ';
                                    $thumbnailLink .= '<img src = "'.$t_uri.'" class="search-thumbnail" title="'. $doc[$title_field][0] .'" alt="item thumbnail image"/></a>';
                                }
                            }
                        }
                        // there isn't a thumbnail so display the bitstream itself
                        else {
                            $thumbnailLink = '<a title = "' . $doc[$title_field][0] . '" class="fancybox" rel="group' . $j .'" href="' . $b_uri . '" alt="link to item"> ';
                            $thumbnailLink .= '<img src = "'.$b_uri.'" class="search-thumbnail" title="'. $doc[$title_field][0] .'" alt="item thumbnail image"/></a>';
                        }

                        echo $thumbnailLink;
                    }

                } //end if there are bitstreams ?>

            </div>
            </div> <!-- close block -->
            
            
            </div> <!-- close item div -->
        </li>

            <?php

            $j++;

        } // end for each search result

        ?>

        <!-- LINKS TO RELSULT PAGES BY NUMBER -->
        <div class="listing-block" id="page-bottom">
            <?php echo $pagelinks ?>
        </div>

        <!-- BACK BUTTONS -->
        <a href="./past">
            <button id="results-button" class="exhibit-button" alt="link back to past exhibitions">
                <p>Back to Past Exhibitions</p>
            </button>
        </a>
        <?php
            $current_url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
            if (strpos($current_url, '/*') == true){
                echo '<a href="./search">
                    <button id="results-button" class="exhibit-button" alt="link back to list of full items">
                        <p>Back to Full Item List</p>
                    </button>
                </a>';
            }
        ?>
    </ul>

        


    </div>


    <!--<div class="listing-filter">
        <span class="no-results">
            <strong><?php echo $startrow ?>-<?php echo $endrow ?></strong> of
            <strong><?php echo $rows ?></strong> results </span>
        <?php echo $pagelinks ?>
    </div>-->