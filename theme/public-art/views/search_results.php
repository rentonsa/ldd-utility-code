<?php
// Set up some variables to easily refer to particular fields you've configured
$id_field = $this->skylight_utilities->getField('ID');
$title_field = $this->skylight_utilities->getField('Title');
$image_uri = $this->skylight_utilities->getField("Image URI");
$spatiallocation = $this->skylight_utilities->getField("Location");
//$locations = array("Old College", "Central Campus and George Square", "Pollock Halls", "King’s Buildings", "Easter Bush","ECA", "Moray House", "Medical School", "Location TBC");

//This is temporary as a test until such times as we have correct locations coming through.
$locations = array (array("King's Buildings","Ashworth Building, Kings Building Campus"),
    array("Central Campus","Bristo Square"),
    array("King's Buildings","Crew Building/King's Buildings"),
    array("Easter Bush","Equine Centre/Easter Bush campus"),
    array("Central Campus","George Square Gardens"),
    array("King's Buildings","Grant Institute/Geology Department"),
    array("Central Campus","Informatics Building"),
    array("King's Buildings","Joseph Black Building/Chemistry Department"),
    array("Central Campus","Main Library"),
    array("King's Buildings","Molecular Biology Department/Darwin Building/King's Buildings"),
    array("Old College","Old College"),
    array("Pollock Halls","Romero Place"),
    array("King's Buildings","Sanderson Building/Engineering"),
    array("ECA","Sculpture Court/Edinburgh College of Art"),
    array("Easter Bush","Small Animal Hospital/Easter Bush campus"),
    array("King's Buildings","Swann Building/King's Buildings"));

$uniquelocations = array("King's Buildings","Central Campus","Easter Bush","Old College","Pollock Halls","ECA");

$type = $_GET['type'];

if ($type == 'images') {
    ?>

    <div class="row">
    <div class="col-sm-9 col-xs-12">
        <div class="gallery-container">
            <?php
            $n = 0;
            foreach ($docs as $doc) {

//               Setting up variables if they exist
                $image_name = isset($doc[$image_uri][0]) ? $doc[$image_uri][0] : 'missing.jpg';
                $title = isset($doc[$title_field][0]) ? $doc[$title_field][0] : "Untitled";
                // $coverImageJSON = "http://127.0.0.1:8182/iiif/2/" . $image_name;
                $thumbnailLink = '<a  class= "record-link" href="./record/' . $doc['id'] . '" title = "' . $title . '"> ';
                $thumbnailLink .= '<img class="img-responsive" src ="' . $image_name . '" title="' . $title . '" /></a>';
                ?>

                <!--                Displaying-->
                <div class="row record invisible <?php echo $doc[$id_field] ?>">
                    <?php echo $thumbnailLink; ?>

                    <div class="col-sm-9 hidden-xs result-info">
                        <h4 class="record-title">
                            <a href="./record/<?php echo $doc['id'] ?>"><?php echo $title; ?></a>
                        </h4>
                    </div>
                </div>
                <hr class="visible-xs">
                <?php
//                End of for each
                $n++;
            } ?>
        </div>
        <!--        Pagination  -->
        <div class="row">
            <div class="centered text-center">
                <nav>
                    <ul class="pagination">
                        <?php
                        /*
                        foreach ($paginationlinks as $pagelink) {
                            echo $pagelink;
                        }*/
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <?php

}
else
{

    ?>
    <div class="row">
    <?php //foreach ($locations as $index => $location) {
foreach($uniquelocations as $uniquelocation)
{
    //if ($index % 2 == 0) {
    ?>
    <section class="full-height-section">
    <h3 class="col-xs-12 col-md-8 text-center"><?php echo $uniquelocation; ?></h3>
    <div class="gallery-container col-xs-12 col-md-8">
    <?php
    foreach($locations as $location)
    {
        if ($location[0] == $uniquelocation)
        {
            foreach ($docs as $doc)
            {
                if (isset($doc[$spatiallocation]))
                {

                    $ourloc= $doc[$spatiallocation][0];

                    if ($location[1] == $ourloc)
                    {
                        $image_name = isset($doc[$image_uri][0]) ? $doc[$image_uri][0] : 'missing.jpg';
                        $title = isset($doc[$title_field][0]) ? $doc[$title_field][0] : "Untitled";
                        // $coverImageJSON = "http://127.0.0.1:8182/iiif/2/" . $image_name;
                        $thumbnailLink = '<a  class= "record-link" href="./record/' . $doc['id'] . '" title = "' . $title . '"> ';
                        $thumbnailLink .= '<img class="img-responsive" src ="' . $image_name . '" title="' . $title . '" /></a>';
                        ?>

                        <!--                Displaying-->
                        <div class="row record invisible <?php echo $doc[$id_field] ?>">
                            <?php echo $thumbnailLink; ?>

                            <div class="col-sm-9 hidden-xs result-info">
                                <h4 class="record-title">
                                    <a href="./record/<?php echo $doc['id'] ?>"><?php echo $title; ?></a>
                                </h4>
                            </div>
                        </div>
                        <hr class="visible-xs">
                        <?php
                        //                End of for each

                    }
                }
            }
        }
    }
    // echo '</div></section>';
}

    //For now, let's make everything hidden
    /*
    foreach (array_slice($docs, 0, rand(2, 7), true) as $doc) {











        $image_name = isset($doc[$coverImageName][0]) ? $doc[$coverImageName][0] : 'missing.jpg';
        $title = isset($doc[$title_field][0]) ? $doc[$title_field][0] : "Untitled";
        $coverImageJSON = "http://127.0.0.1:8182/iiif/2/" . $image_name;
        $coverImageURL = $coverImageJSON . '/full/,400/0/default.jpg';
        $thumbnailLink = '<a  class= "record-link" href="./record/' . $doc['id'] . '" title = "' . $title . '"> ';
        $thumbnailLink .= '<img class="img-responsive" src ="' . $coverImageURL . '" title="' . $title . '" /></a>';
        */?>
    <!-- <div class="row record invisible <?php //echo $doc[$id_field] ?>">
                        <?php //echo $thumbnailLink; ?>

                        <div class="col-sm-9 hidden-xs result-info">
                            <h4 class="record-title">
                                <a href="./record/<?php //echo $doc['id'] ?>"><?php echo $title; ?></a>
                            </h4>
                        </div>
                    </div>-->
    <?php
    // }
    ?>
    <!-- </div>-->
    <div class="col-xs-12 col-md-4 map">
        <!--                Add the id of the record in the id of the map, then change the initMap to accept
                            an argument which is the if of the map so that we do not have multiple id's-->

        <!--                Add the location of each item in the quotes-->

        <div id="map">
            <script>
                $(window).bind("load", function() {
                    initMap(); addLocation("");
                });
            </script>
        </div>
    </div>
    </section>


    <!--<section class="full-height-section bg-darker">
        <div class="col-xs-12 col-md-4 map">
            <!--                Add the id of the record in the id of the map, then change the initMap to accept
                                an argument which is the if of the map so that we do not have multiple id's-->

    <!--                Add the location of each item in the quotes-->

    <!-- <div id="map">
                <script>
                    $(window).bind("load", function() {
                        initMap(); addLocation("");
                    });
                </script>
            </div>
        </div>
        <h3 class="col-xs-12 col-md-8 text-center"><?php //echo $location; ?></h3>
        <div class="gallery-container col-xs-12 col-md-8">-->
    <?php/*
            foreach (array_slice($docs, 0, rand(2, 7), true) as $doc) {
                $image_name = isset($doc[$coverImageName][0]) ? $doc[$coverImageName][0] : 'missing.jpg';
                $title = isset($doc[$title_field][0]) ? $doc[$title_field][0] : "Untitled";
                $coverImageJSON = "http://127.0.0.1:8182/iiif/2/" . $image_name;
                $coverImageURL = $coverImageJSON . '/full/,400/0/default.jpg';
                $thumbnailLink = '<a  class= "record-link" href="./record/' . $doc['id'] . '" title = "' . $title . '"> ';
                $thumbnailLink .= '<img class="img-responsive" src ="' . $coverImageURL . '" title="' . $title . '" /></a>';*/
    ?>
    <!-- <div class="row record invisible <?php //echo $doc[$id_field] ?>">
                    <?php //echo $thumbnailLink; ?>

                    <div class="col-sm-9 hidden-xs result-info">
                        <h4 class="record-title">
                            <a href="./record/<?php //echo $doc['id'] ?>"><?php //echo $title; ?></a>
                        </h4>
                    </div>
                </div>-->
    <?php
    //}
    ?>
    <!-- </div>
 </section>
</div>-->
    <?php

}
?>