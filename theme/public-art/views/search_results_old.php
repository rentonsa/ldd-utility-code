<?php
//search results script for showing image thumbnails
$id_field = $this->skylight_utilities->getField('ID');
$collection_id = '10683';
$title_field = $this->skylight_utilities->getField('Title');
$image_uri = $this->skylight_utilities->getField("Image URI");
$spatiallocation = $this->skylight_utilities->getField("Location");

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
$type = 'images';
if ($type == 'images') {
    ?>
    <div class="row">
    <div class="col-sm-9 col-xs-12">
        <div class="gallery-container">
            <?php
            $n = 0;
            foreach ($docs as $doc) {
                $title = isset($doc[$title_field][0]) ? $doc[$title_field][0] : "Untitled";
                if (isset($doc[$image_uri][0])){
                  $image_name = $doc[$image_uri][0];
                  $thumbnailLink = '<img class="img-responsive" src ="' . $image_name . '" title="' . $title . '" /></a>';
                  }
                else {
                    $bitstreams = get_dspace_bitstream($collection_id, $doc[$id_field]);
                    $image_name = $bitstreams;
                    $thumbnailLink = '<img class="img-responsive" src ="' . $image_name . '" title="' . $title . '" /></a>';
                    }
                $thumbnailLink = '<a  class= "record-link" href="./record/' . $doc['id'] . '" title = "' . $title . '"> '. $thumbnailLink;
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
                $n++;
            }// end for loop ?>
        </div>
        <!--        Pagination  -->
        <div class="row">
            <div class="centered text-center">
                <nav>
                    <ul class="pagination">
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <?php
}
else {
    ?>
    <div class="row">
    <div class="col-sm-9 col-xs-12">
        <div class="gallery-container">
            <?php
            $n = 0;
            foreach ($docs as $doc) {
                $image_name = isset($doc[$image_uri][0]) ? $doc[$image_uri][0] : 'missing.jpg';
                $title = isset($doc[$title_field][0]) ? $doc[$title_field][0] : "Untitled";
                $thumbnailLink .= '<img class="img-responsive" src ="' . $image_name . '" title="' . $title . '" /></a>';
                ?>
                <div class="row record invisible <?php echo $doc[$id_field] ?>">
                    <div class="col-sm-9 hidden-xs result-info" >
                        <h4 class="record-title">
                            <a href="./record/<?php echo $doc['id'] ?>"><?php echo $title; ?>
                              <?php echo $thumbnailLink; ?>
                            </a>
                        </h4>
                    </div>
                </div>
                <hr class="visible-xs">
                <?php
                $n++;
            } ?>
        </div>
        <div class="row">
            <div class="centered text-center">
                <nav>
                    <ul class="pagination">
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <?php
}
?>
