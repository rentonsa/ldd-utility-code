<?php

// Set up some variables to easily refer to particular fields you've configured
// in $config['skylight_searchresult_display']
$fielddisplay = $this->config->item('skylight_searchresult_display');
$filters = array_keys($this->config->item("skylight_filters"));
$title_field = $this->skylight_utilities->getField('Title');

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
                    <em><a href="<?php echo $base_search . $base_parameters . $sort . $field . '+desc' ?>"><?php echo $label ?></a></em>
                <?php
                } else {
                    ?>

                    <em><?php echo $label ?></em>
                <?php if ($label != "Date") { ?>
                        <a href="<?php echo $base_search . $base_parameters . $sort . $field . '+asc' ?>">A-Z</a> |
                <a href="<?php echo $base_search . $base_parameters . $sort . $field . '+desc' ?>">Z-A</a>
                    <?php } else { ?>
                        <a href="<?php echo $base_search . $base_parameters . $sort . $field . '+desc' ?>">newest</a> |
                <a href="<?php echo $base_search . $base_parameters . $sort . $field . '+asc' ?>">oldest</a>
                    <?php }
                }
            } ?>

            <strong>No. Results</strong>
                <a href="<?php echo $base_search . $base_parameters . '?num_results=15' ?>">15</a> |
                <a href="<?php echo $base_search . $base_parameters . '?num_results=50' ?>">50</a>
            </span>

            <a href="<?php echo $base_search . $base_parameters . '/?num_results=1000&format=.csv' ?>">Export to Excel</a>

</div>

<ul class="listing">

    <?php

    $j = 0;
    foreach ($docs as $index => $doc) {
        ?>

        <li<?php if ($index == 0) {
            echo ' class="first"';
        } elseif ($index == sizeof($docs) - 1) {
            echo ' class="last"';
        } ?>>
            <div class="item-div">
                <div class="iteminfo">
                    <h3>
                        <a href="./record/<?php echo $doc['id'] ?>"><?php echo $doc[$title_field][0]; ?></a>
                    </h3>

                    <div class="search-results">

                        <table>

                        <?php foreach($fielddisplay as $key) {
                            //echo var_dump($searchdisplay);
                            $element = $this->skylight_utilities->getField($key);
                            //echo var_dump($element);
                            if(isset($doc[$element])) {
                                echo '<tr><th>'. $key . '</th><td>';
                                foreach($doc[$element] as $index => $metadatavalue) {
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
                                    if($index < sizeof($doc[$element]) - 1) {
                                        echo '; ';
                                    }
                                }
                                echo '</td></tr>';
                            }
                        }
                        ?>
                      <!-- close table div -->

                         </table>
                    </div>
                </div>
                <!-- close item-info -->
                <div class="clearfix"></div>
            <!-- close item div -->
            </div>
        </li>
    <?php } ?>
</ul>


<div class="pagination">
        <span class="no-results">
            <strong><?php echo $startrow ?>-<?php echo $endrow ?></strong> of
            <strong><?php echo $rows ?></strong> results </span>
    <?php echo $pagelinks ?>
</div>
