
    <?php

        // Set up some variables to easily refer to particular fields you've configured
        // in $config['skylight_searchresult_display']

        $title_field = $this->skylight_utilities->getField('Title');
        $author_field = $this->skylight_utilities->getField('Creator');
        $date_field = $this->skylight_utilities->getField('Date');
        $type_field = $this->skylight_utilities->getField('Type');
        $abstract_field = $this->skylight_utilities->getField('Agents');
        $subject_field = $this->skylight_utilities->getField('Subject');

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

        <?php
        $j = 0;
        foreach ($docs as $index => $doc) {
        ?>

        <li<?php if($index == 0) { echo ' class="first"'; } elseif($index == sizeof($docs) - 1) { echo ' class="last"'; } ?>>
        <div class="item-div">


            <h3><a href="./record/<?php echo $doc['id']?>/<?php echo $doc['types'][0]?>"><?php echo $doc[$title_field]; ?></a></h3>
            <?php
            if (isset($doc["component_id"])) {
                $component_id = $doc["component_id"];
                echo'<div class="component_id">' . $component_id . '</div>';
            } ?>
            <div class = "iteminfo">

                <?php if(array_key_exists($author_field,$doc)) { ?>
                    <?php

                    $num_authors = 0;
                    foreach ($doc[$author_field] as $author) {
                        $orig_filter = urlencode($author);

                        echo '<a class="agent" href="./search/*:*/Agent:%22'.$orig_filter.'%22">'.$author.'</a>';
                        $num_authors++;
                        if($num_authors < sizeof($doc[$author_field])) {
                            echo ' ';
                        }
                    }
                    ?>
                <?php } ?>

                <?php if(array_key_exists($subject_field,$doc)) { ?>
                    <div class="tags">
                    <?php

                    $num_subject = 0;
                    foreach ($doc[$subject_field] as $subject) {

                        $orig_filter = urlencode($subject);
                        echo '<a class="subject" href="./search/*:*/Subject:%22'.$orig_filter.'%22">'.$subject.'</a>';
                        $num_subject++;
                        if($num_subject < sizeof($doc[$subject_field])) {
                            echo ' ';
                        }
                    }

                    ?>
                    </div>
                <?php } ?>


            </div> <!-- close item-info -->

            <div class="clearfix"></div>
            </div> <!-- close item div -->
        </li>
            <?php

            $j++;

        } // end for each search result

        ?>
    </ul>


    <div class="pagination">
        <span class="no-results">
            <strong><?php echo $startrow ?>-<?php echo $endrow ?></strong> of
            <strong><?php echo $rows ?></strong> results </span>
        <?php echo $pagelinks ?>
    </div>