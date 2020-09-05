<?php


// Set up some variables to easily refer to particular fields you've configured
// in $config['skylight_searchresult_display']

$title_field = $this->skylight_utilities->getField('Title');
$course_field = $this->skylight_utilities->getField('Course Code');
$version_field = $this->skylight_utilities->getField('Version');
$year_field = $this->skylight_utilities->getField('Year');
$date_field = $this->skylight_utilities->getField('Date');

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
        <strong>No. Results</strong>
                <a href="<?php echo $base_search . $base_parameters . '?num_results=20' ?>">20</a> |
                <a href="<?php echo $base_search . $base_parameters . '?num_results=50' ?>">50</a> |
                <a href="<?php echo $base_search . $base_parameters . '?num_results=100' ?>">100</a>
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
                        <a href="<?php echo $base_search.$base_parameters.$sort.$field.'+asc'.'&num_results='.$num_results ?>">A-Z</a> |
                <a href="<?php echo $base_search.$base_parameters.$sort.$field.'+desc'.'&num_results='.$num_results ?>">Z-A</a>
                    <?php } else { ?>
                        <a href="<?php echo $base_search.$base_parameters.$sort.$field.'+desc'.'&num_results='.$num_results ?>">newest</a> |
                <a href="<?php echo $base_search.$base_parameters.$sort.$field.'+asc'.'&num_results='.$num_results ?>">oldest</a>
                    <?php } } } ?>

        </span>

</div>


<ul class="listing">


    <?php foreach ($docs as $index => $doc) { ?>

        <li<?php if($index == 0) { echo ' class="first"'; } elseif($index == sizeof($docs) - 1) { echo ' class="last"'; } ?>>

            <h3><a href="./record/<?php echo $doc['id']?>?highlight=<?php echo $query ?>"><?php echo $doc[$title_field][0]; ?>

                    <?php
                    if(array_key_exists($year_field, $doc)) {
                        echo " " . $doc[$year_field][0];
                    }
                    if(array_key_exists($version_field, $doc)) {
                        if($doc[$version_field][0] == "Resit")
                            echo " Resit";
                    }
                    ?>
            </a></h3>

            <div class="result_row">

                <div class="tags">

                    <?php if(array_key_exists($author_field,$doc)) { ?>
                        <?php

                        $num_titles = 0;
                        foreach ($doc[$title_field] as $the_title) {

                            $orig_filter = urlencode($the_title);

                            $lower_orig_filter = strtolower($the_title);
                            $lower_orig_filter = urlencode($lower_orig_filter);

                            echo '<a href="./search/*:*/Title:%22'.$lower_orig_filter.'%7C%7C%7C'.$orig_filter.'%22">All papers for this course title</a>';
                            $num_titles++;
                            if($num_titles < sizeof($doc[$title_field])) {
                                echo ' ';
                            }
                        }

                        ?>
                    <?php } ?>

                    <?php if(array_key_exists($course_field,$doc)) { ?>

                        <?php

                        $num_courses = 0;
                        foreach ($doc[$course_field] as $course) {

                            echo '<a href="./search/'.strtoupper($course).'">'.strtoupper($course).'</a>';
                            $num_courses++;
                            if($num_courses < sizeof($doc[$course_field])) {
                                echo ' ';
                            }
                        }


                        ?>

                    <?php } ?>


                </div> <!-- close tags div -->

                <?php if(isset($doc[$bitstream_field]) && $link_bitstream) {

                    ?>

                    <div class="record-bitstreams">

                        <?php
                        foreach($doc[$bitstream_field] as $bitstream) {

                            $bitstreamLink = $this->skylight_utilities->getBitstreamURI($bitstream);
                            ?>
                            <a href="<?php echo $bitstreamLink; ?>" class="downloadButton" onclick="ga('send', 'event', '<?php echo $doc[$course_field][0].'||'.$doc[$title_field][0].' '.$doc[$year_field][0]; ?>', 'Download', 'Search page – PDF Download');">Download Paper</a>

                            <?php
                        }
                        ?>

                    </div>

                <?php
                }
                else { ?>

                    <div class="record-bitstreams"><a href="./unavailable" title="Click here to find out why this paper may be unavailable">Paper unavailable</a></div>

                <?php } ?>

            </div>
            <div class="clearfix"></div>


        </li>
    <?php } ?>
</ul>

<div class="pagination">
    <?php echo $pagelinks ?>
</div>
