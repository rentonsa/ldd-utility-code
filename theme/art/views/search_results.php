<div class="row">
    <div class="col-lg-9">
        <?php
        // Set up some variables to easily refer to particular fields you've configured
        // in $config['skylight_searchresult_display']
        $title_field = $this->skylight_utilities->getField('Title');
        $author_field = $this->skylight_utilities->getField('Author');
        $date_field = $this->skylight_utilities->getField('Date');
        $type_field = $this->skylight_utilities->getField('Type');
        $bitstream_field = $this->skylight_utilities->getField('Bitstream');
        $thumbnail_field = $this->skylight_utilities->getField('Thumbnail');
        $abstract_field = $this->skylight_utilities->getField('Abstract');
        $subject_field = $this->skylight_utilities->getField('Subject');
        $link_uri_field = $this->skylight_utilities->getField('Link');
        $image_uri_field = $this->skylight_utilities->getField('ImageUri');
        $base_parameters = preg_replace("/[?&]sort_by=[_a-zA-Z+%20. ]+/", "", $base_parameters);
        if ($base_parameters == "") {
            $sort = '?sort_by=';
        } else {
            $sort = '&sort_by=';
        }
        ?>
        <div class="listing-filter">
        <span class="no-results">
            <strong><?php echo $startrow ?>-<?php echo $endrow ?></strong> of
            <strong><?php echo $rows ?></strong> results
        </span>

            <span class="sort">
            <strong>Sort by</strong>
            <?php foreach ($sort_options as $label => $field) {
                if ($label == 'Relevancy') {
                    ?>
                    <em><a href="<?php echo $base_search . $base_parameters . $sort . $field . '+desc' ?>" title="<?php echo $label ?>"><?php echo $label ?></a></em>
                    <?php
                } else {
                    ?>

                    <em><?php echo $label ?></em>
                <?php if ($label != "Date") { ?>
                        <a href="<?php echo $base_search . $base_parameters . $sort . $field . '+asc' ?>" title="Sort by alphabetical order">A-Z</a> |

                        <a href="<?php echo $base_search . $base_parameters . $sort . $field . '+desc' ?>" title="Sort by reverse alphabetical order">Z-A</a>
                    <?php } else { ?>
                        <a href="<?php echo $base_search . $base_parameters . $sort . $field . '+desc' ?>" title="Sort by newest">newest</a> |

                        <a href="<?php echo $base_search . $base_parameters . $sort . $field . '+asc' ?>" title="Sort by oldest">oldest</a>
                    <?php }
                }
            } ?>

        </span>

        </div>

        <ul class="listing">

            <?php
            $j = 0;
            foreach ($docs as $index => $doc) {
                ?>
                <?php
                $type = 'Unknown';
                if (isset($doc[$type_field])) {
                    $type = "media-" . strtolower(str_replace(' ', '-', $doc[$type_field][0]));
                }
                ?>

                <li <?php if ($index == 0) {
                    echo ' class="first"';
                } elseif ($index == sizeof($docs) - 1) {
                    echo ' class="last"';
                } ?>>
                    <!--span class="icon <?php echo $type ?>"></span-->
                    <div class="item-div">

                        <div class="iteminfo">

                            <?php if (array_key_exists($author_field, $doc)) { ?>
                                <?php
                                $num_authors = 0;
                                foreach ($doc[$author_field] as $author) {
                                    // test author linking
                                    // quick hack that only works if the filter key
                                    $orig_filter = urlencode($author);
                                    $lower_orig_filter = strtolower($author);
                                    $lower_orig_filter = urlencode($lower_orig_filter);
                                    echo '<a class="artist" href="./search/*:*/Artist:%22' . $lower_orig_filter . '%7C%7C%7C' . $orig_filter . '%22" title="' . $author . '">' . $author . '</a>';
                                    $num_authors++;
                                    if ($num_authors < sizeof($doc[$author_field])) {
                                        echo ' ';
                                    }
                                }
                                ?>
                            <?php } ?>

                            <h3 class="record-title">
                                <a href="./record/<?php echo $doc['id'] ?>?highlight=<?php echo $query ?>"><?php echo $doc[$title_field][0]; ?>
                                    <?php if (array_key_exists($date_field, $doc)) { ?>
                                        <?php
                                        echo '(' . $doc[$date_field][0] . ')';
                                    } elseif (array_key_exists('dateIssuedyear', $doc)) {
                                        //echo '( ' . $doc['dateIssuedyear'][0] . ')';
                                        echo '';
                                    }
                                    ?></a></h3>

                            <div class="tags">

                                <?php
                                if (array_key_exists($abstract_field, $doc)) {
                                    echo '<p>';
                                    $abstract = $doc[$abstract_field][0];
                                    $abstract_words = explode(' ', $abstract);
                                    $shortened = '';
                                    $max = 40;
                                    $suffix = '...';
                                    if ($max > sizeof($abstract_words)) {
                                        $max = sizeof($abstract_words);
                                        $suffix = '';
                                    }
                                    for ($i = 0; $i < $max; $i++) {
                                        $shortened .= $abstract_words[$i] . ' ';
                                    }
                                    echo $shortened . $suffix;
                                    echo '</p>';
                                }
                                ?>

                            </div> <!-- close tags div -->

                        </div> <!-- close item-info -->

                        <div class="thumbnail-image-search">

                            <?php
                            $numThumbnails = 0;
                            $imageset = false;
                            $thumbnailLink = array();
                            if (isset($doc[$image_uri_field])) {
                                foreach ($doc[$image_uri_field] as $imageUri) {

                                    if (strpos($imageUri, 'luna') > 0) {
                                        //change to stop LUNA erroring on redirect
                                        $imageUri = str_replace('http://', 'https://', $imageUri);
                                        $iiifurlsmall = str_replace('/full/0/', '/!250,250/0/', $imageUri);
                                        $thumbnailLink[$numThumbnails] = '<a title = "' . $doc[$title_field][0] . '" class="fancybox" rel="group" href="' . $imageUri . '"> ';
                                        $thumbnailLink[$numThumbnails] .= '<img src = "' . $iiifurlsmall . '" class="record-thumbnail-search" alt="' . $doc[$title_field][0] . '" /></a>';
                                        $numThumbnails++;
                                        $imageset = true;
                                    }
                                }
                                if ($imageset == true) {
                                    echo $thumbnailLink[0];
                                }
                            }
                            ?>
                            <!--</div>-->

                        </div>
                        <div class="clearfix"></div>
                    </div> <!-- close item div -->
                </li>
                <?php
                $j++;
            } // end for each search result
            ?>
        </ul>


        <div class="pagination search">
        <span class="no-results">
            <strong><?php echo $startrow ?>-<?php echo $endrow ?></strong> of
            <strong><?php echo $rows ?></strong> results </span>
            <?php echo $pagelinks ?>
        </div>

        <br/>
        <br/>
    </div>
    <div class="col-lg-3 search">

