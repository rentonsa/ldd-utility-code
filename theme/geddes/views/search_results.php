
<?php

// Set up some variables to easily refer to particular fields you've configured
// in $config['skylight_searchresult_display']

$title_field = $this->skylight_utilities->getField('Title');
$author_field = $this->skylight_utilities->getField('Creator');
$date_field = $this->skylight_utilities->getField('Date');
$type_field = $this->skylight_utilities->getField('Type');
$abstract_field = $this->skylight_utilities->getField('Agents');
$subject_field = $this->skylight_utilities->getField('Subject');
$image_uri_field = $this->skylight_utilities->getField("ImageUri");

$base_parameters = preg_replace("/[?&]sort_by=[_a-zA-Z+%20. ]+/","",$base_parameters);
if($base_parameters == "") {
    $sort = '?sort_by=';
}
else {
    $sort = '&sort_by=';
}
?>

<div class="col-md-9 col-sm-9 col-xs-12">
    <div>
        <p>This is the online portal to the Patrick Geddes Archives held by the Universities of Edinburgh and Strathclyde.  Search the collections by using the free text search box below, using a keyword or a phrase.
        You can also browse by author, subject, place or date using the navigation panels on the right of the page.  Please note that, at this time, the author, subject, place and date browse facility is indicative of only a proportion of the collections holdings and is not exhaustive.
        Search results are displayed in lists of up to 30 items per page.  If you wish the search results to be displayed alphabetically by title, click the ‘Sort by A-Z’ at the top right of the search results list.
        You can view more detailed document descriptions by clicking on the item title on the search results page; each display will give you the title, description, reference number, date and access information.  Some search results will include a digital image of the document.
        You can see more information and view the individual item in context by clicking ‘see more’.  This will take you to the holding institution’s online catalogue in a new browser tab.
        To view the actual document it is necessary to visit the holding institution’s reading rooms in person.</p>
    </div>
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
            <div class="text">
            <h3><a href="./record/<?php echo $doc['id']?>/<?php //echo $doc['types'][0]?>"><?php echo strip_tags($doc[$title_field][0]); ?></a></h3>

            <?php
            if (isset($doc["component_id"])) {
                $component_id = $doc["component_id"];
                echo'<div class="component_id">' . $component_id . '</div>';
            } ?>

            <?php if(array_key_exists($author_field,$doc)) { ?>
                <?php

                $num_authors = 0;
                foreach ($doc[$author_field] as $author) {
                    $orig_filter = urlencode($author);

                   // echo '<a class="agent" href="./search/*:*/Agent:%22'.$orig_filter.'%22">'.$author.'</a>';
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
                      //  echo '<a class="subject" href="./search/*:*/Subject:%22'.$orig_filter.'%22">'.$subject.'</a>';
                        $num_subject++;
                        if($num_subject < sizeof($doc[$subject_field])) {
                            echo ' ';
                        }
                    }

                    ?>
                </div>
            <?php } ?>
            </div>
            <div class = "thumbnail-image">

                <?php
                $numThumbnails = 0;
                $imageset = false;
                $thumbnailLink = array();
                if (isset($doc[$image_uri_field]))
                {
                    foreach ($doc[$image_uri_field] as $imageUri)
                    {
                        if (strpos($imageUri, "|") > 0) {
                            $image_uri = explode("|", $imageUri);
                            $imageUri = $image_uri[0];
                            $image_title = $image_uri[1];
                        }
                        list($fullwidth, $fullheight) = getimagesize($imageUri);
                        //echo 'WIDTH'.$width.'HEIGHT'.$height
                        if ($fullwidth > $fullheight) {
                            $dims ='width = "40"';
                            $parms = '40,';

                        } else {
                            $dims ='height = "40"';
                            $parms = ',40';
                        }

                        if (strpos($imageUri, 'iiif') > 0)
                        {

                            //change to stop LUNA erroring on redirect
                            $imageUri = str_replace('http://', 'https://', $imageUri);
                            $iiifurlsmall = str_replace('/full/0/', '/'.$parms.'/0/', $imageUri);
                            echo $iiifurlsmall;
                            $thumbnailLink[$numThumbnails]  = '<a title = "' . $doc[$title_field][0] . '" href="./record/'.$doc['id'].'"> ';
                            $thumbnailLink[$numThumbnails] .= '<img src = "' . $iiifurlsmall . '" class="record-thumbnail-search" title="' . $doc[$title_field][0] . '" /></a>';
                            $numThumbnails++;
                            $imageset = true;
                        }
                        else
                        {
                            $thumbnailLink[$numThumbnails]  = '<a title = "' . $doc[$title_field][0] . '" href="./record/'.$doc['id'].'"> ';
                            $thumbnailLink[$numThumbnails] .= '<img src = "' . $imageUri . '" '.$dims.' class="record-thumbnail-search" title="' . $doc[$title_field][0] . '" /></a>';
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

            </div><!-- close row-->
        </div>


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