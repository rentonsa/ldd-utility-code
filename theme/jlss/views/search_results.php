
<?php

// Set up some variables to easily refer to particular fields you've configured
// in $config['skylight_searchresult_display']

$title_field = $this->skylight_utilities->getField('Title');
$author_field = $this->skylight_utilities->getField('Creator');
$date_field = $this->skylight_utilities->getField('OldDate');
$image_date_field = $this->skylight_utilities->getField('Date');
$type_field = $this->skylight_utilities->getField('Type');
$abstract_field = $this->skylight_utilities->getField('Agents');
$subject_field = $this->skylight_utilities->getField('Subject');
$collection_field = $this->skylight_utilities->getField('Collection');
$collection_description_field = $this->skylight_utilities->getField('Collection-Description');
$item_image_filed = $this->skylight_utilities->getField('ItemImage');
$image_uri_field = $this->skylight_utilities->getField('ImageUri');

$base_parameters = preg_replace("/[?&]sort_by=[_a-zA-Z+%20. ]+/","",$base_parameters);
if($base_parameters == "") {
    $sort = '?sort_by=';
}
else {
    $sort = '&sort_by=';
}
?>

<!-- Serve up collection title at top of indiviual results page. Not the cleanest solution with PHP placement but functions correctly -->
<div class="collection-title">

    <?php
        $count = 0;
        $display = true;
        $prev = $docs[0]["collection"][0];

        foreach ($docs as $index => $doc) {

                if (isset($doc["collection"][0])) {
                    $collection_title = $doc["collection"][0];
                    $collection_description = $doc[$collection_description_field][0];
                   
                    if(trim($prev) !== trim($collection_title)){

                        $display = false;
                    }
                }
                
                $count++;
            }
        if($display){
            // conditional to prevent collection titles appearing in search resaults
            if(!strpos($_SERVER['REQUEST_URI'],'/Collection:')){
            }
            else {
                echo'<h1 class="collection-title-h1">' . $collection_title . '</h1>';  
            }
        }
   
        echo'</div>

    <div class="col-md-9 col-sm-9 col-xs-12">
    <div class="row">';
    if($display){
        // conditional to prevent collection titles appearing in search resaults
        if(!strpos($_SERVER['REQUEST_URI'],'/Collection:')){
        }
        else {
            echo '<div class="content-divider-search"><p>divider</p></div>';
            echo '<img class="collection-title-image" src="'.base_url() .'theme/' . $this->config->item('skylight_theme') . '/images/clickboxes/' . $collection_title . '-1.jpg" class="img-responsive">';
            echo '<img class="collection-title-image" src="'.base_url() .'theme/' . $this->config->item('skylight_theme') . '/images/clickboxes/' . $collection_title . '-2.jpg" class="img-responsive">';
            echo '<img class="collection-title-image" src="'.base_url() .'theme/' . $this->config->item('skylight_theme') . '/images/clickboxes/' . $collection_title . '-3.jpg" class="img-responsive">';
            echo'<p class="collection-description-p">' . $collection_description . '</p>'; 
        } 
    }
    ?>

        <div class="centered text-center">
            <nav>
                <ul class="pagination pagination-sm pagination-xs">
                    <?php
                    foreach ($paginationlinks as $pagelink)
                    {
                        echo $pagelink;
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
    <div class="row search-row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 results-num">
            <h5 class="text-muted">Showing <?php echo $rows ?> results </h5>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 results-num sort">
            <h5 class="text-muted">Sort By:
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
            </h5>
        </div>

    </div>
    <?php
    foreach ($docs as $index => $doc) {
        ?>
        <div class="row search-row">
            <?php 
                echo'
                <div class="collection-image-box">
                <figure class="clickbox">
                    <img class="component_image" src="' . $this->config->item("skylight_image_server") . '/iiif/2/' . $doc[$item_image_filed][0] . '/square/96,/0/default.jpg">

                    <div class="clickbox-text">
                        <i class="fa fa-camera"></i>
                        <i class="ion-arrow-right-c"></i>

                        <div class="curl"></div>
                        <a class="component_image_link" href="./record/'.  $doc['id'] . '"></a>
                    </div>
                </figure>
                </div>
            ';
            ?>

            <?php if(!isset($doc[$image_date_field])){
                //print_r(strip_tags($doc[$title_field][0]));
                    echo '<h3><a href="./record/' . $doc['id'] . '">' . strip_tags($doc[$title_field][0]) . '</a> (Undated)</h3>';
                }
                else {    
                    echo '<h3><a href="./record/' . $doc['id'] . '">' . strip_tags($doc[$title_field][0]) . '</a> (' . strip_tags($doc[$image_date_field][0]) . ')</h3>';
                }?>

            <?php
            if (isset($doc["component_id"])) {
                $component_id = $doc["component_id"];
                echo'<div class="component_id">sfsdfsfsfs' . $component_id . '</div>';
            }?>
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
                        $lower_orig_filter = strtolower($subject);
                        $lower_orig_filter = urlencode($lower_orig_filter);

                        echo '<a class="subject" href="./search/*:*/Subject:%22'.$lower_orig_filter.'%7C%7C%7C'.$orig_filter.'%22">'.$subject.'</a>';
                        $num_subject++;
                        if($num_subject < sizeof($doc[$subject_field])) {
                            echo ' ';
                        }
                    }

                    ?>
                </div>
            <?php } ?>
        </div> <!-- close row-->
        <?php

    } // end for each search result

    ?>
    <div class="row">
        <div class="centered text-center">
            <nav>
                <ul class="pagination pagination-sm pagination-xs">
                    <?php
                    foreach ($paginationlinks as $pagelink)
                    {
                        echo $pagelink;
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div> <!-- close col 9 -->