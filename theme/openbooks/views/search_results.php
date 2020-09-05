
    <?php

        // Set up some variables to easily refer to particular fields you've configured
        // in $config['skylight_searchresult_display']

        $title_field = $this->skylight_utilities->getField('Title');
        $author_field = $this->skylight_utilities->getField('Author');
        $type_field = $this->skylight_utilities->getField('Type');
        $bitstream_field = $this->skylight_utilities->getField('Bitstream');
        $thumbnail_field = $this->skylight_utilities->getField('Thumbnail');
        $date_field = $this->skylight_utilities->getField('Document Date');
        $shelfmark_field = $this->skylight_utilities->getField('Shelfmark');


        $base_parameters = preg_replace("/[?&]sort_by=[_a-zA-Z+%20. ]+/","",$base_parameters);
        if($base_parameters == "") {
            $sort = '?sort_by=';
        }
        else {
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
                <a href="<?php echo $base_search.$base_parameters.$sort.$field.'+asc' ?>">A-Z</a> |
                <a href="<?php echo $base_search.$base_parameters.$sort.$field.'+desc' ?>">Z-A</a>
            <?php } else { ?>
                <a href="<?php echo $base_search.$base_parameters.$sort.$field.'+desc' ?>">newest</a> |
                <a href="<?php echo $base_search.$base_parameters.$sort.$field.'+asc' ?>">oldest</a>
          <?php } } } ?>
            
        </span>

    </div>


    <ul class="listing">

       
    <?php foreach ($docs as $index => $doc) {
        ?>


        <?php
        $type = 'Unknown';

        if(isset($doc[$type_field])) {
                    $type = "media-" . strtolower(str_replace(' ','-',$doc[$type_field][0]));
                }

        ?>

    <li<?php if($index == 0) { echo ' class="first"'; } elseif($index == sizeof($docs) - 1) { echo ' class="last"'; } ?>>


        <div class = "iteminfo">
            <h3><a href="./record/<?php echo $doc['id']?>?highlight=<?php echo $query ?>"><?php echo $doc[$title_field][0]; ?></a></h3>

            <div class="tags">


        <?php if(array_key_exists($author_field,$doc)) { ?>

            <?php

            $num_authors = 0;


            foreach ($doc[$author_field] as $author) {

               // test author linking
               // quick hack that only works if the filter key
               // and recorddisplay key match and the delimiter is :
                $orig_filter = ucwords(urlencode($author));

                $lower_orig_filter = strtolower($author);
                $lower_orig_filter = urlencode($lower_orig_filter);
                echo '<a href="./search/*:*/Author:%22'.$lower_orig_filter.'%7C%7C%7C'.$orig_filter.'%22">'.$author.'</a>';
                $num_authors++;
                if($num_authors < sizeof($doc[$author_field])) {
                    echo ' ';
                }
            }


            ?>
        
            <?php } ?>


       <?php if(array_key_exists($date_field, $doc)) { ?>
            <span>
                <?php
                echo '(' . $doc[$date_field][0] . ')';
          }
                    //elseif(array_key_exists('dateIssuedyear', $doc)) {
                   //     echo '( ' . $doc['dateIssuedyear'][0] . ')';
                   // }

                ?>
                </span>


        </div> <!-- close tags div -->
            <?php if(isset($doc[$bitstream_field])) //&& $link_bitstream)
            {

                ?>

                <div class="record-bitstreams">

                    <?php

                    $pdfcount =  0;
                    foreach($doc[$bitstream_field] as $bitstream)
                    {
                        $bitstreamLink = $this->skylight_utilities->getBitstreamURI($bitstream);
                        if (strpos($bitstreamLink, ".pdf") > 0)
                        {
                            $pdfcount = $pdfcount + 1;
                        }
                    }

                    if ($pdfcount > 1)
                    {
                        echo 'Multiple PDFs. Open the record to view them all.';
                    }
                    else if ($pdfcount == 1)
                    {
                        foreach($doc[$bitstream_field] as $bitstream)
                        {
                            if (strpos($bitstreamLink, ".pdf") > 0) {
                                $bitstreamLink = $this->skylight_utilities->getBitstreamURI($bitstream);
                                echo '<a href="' . $bitstreamLink . '" target= "_blank" class="downloadButton">Download  PDF</a>';
                            }
                        }

                    }
                    else
                    {
                        echo '<div class="record-bitstreams"><a href="./unavailable" title="Click here to find out why this book may be unavailable">Book unavailable</a></div>';
                    }

                    ?>

                </div>

            <?php
            }
            else { ?>

                <div class="record-bitstreams"><a href="./unavailable" title="Click here to find out why this paper may be unavailable">Paper unavailable</a></div>

            <?php } ?>
            <p><?php


                echo 'Shelfmark: '.$doc[$shelfmark_field][0]; ?></p>

        </div>
    </li>
        <?php }?>
    </ul>


    <div class="pagination">
       <?php echo $pagelinks ?>
    </div>