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
?>
<div>
  <ul id="lightSlider" class="gallery list-unstyled cS-hidden">
    <?php
      foreach ($docs as $doc) {
        $title = isset($doc[$title_field][0]) ? $doc[$title_field][0] : "Untitled";
        if (isset($doc[$image_uri][0])){
            $image_name = $doc[$image_uri][0];
            echo '<li data-thumb="'.$image_name.'">';
              echo '<h3>' .$title. '</h3>';
              echo '<img src="'.$image_name.'" />';
            echo '</li>';
           }
        else {
          $bitstreams = get_dspace_bitstream($collection_id, $doc[$id_field]);
          $image_name = $bitstreams;
          echo '<li data-thumb="'.$image_name.'">';
            echo '<h3>' .$title. '</h3>';
            echo '<img src="'.$image_name.'" />';
          echo '</li>\n';
        }
      }
    ?>
  </ul>
</div>
    <div class="row">
    <div>
        <div class="gallery-container">
            <ul id="lightSlider" class="gallery list-unstyled cS-hidden">
              <?php
                foreach ($docs as $doc) {
                  $title = isset($doc[$title_field][0]) ? $doc[$title_field][0] : "Untitled";
                  if (isset($doc[$image_uri][0])){
                      $image_name = $doc[$image_uri][0];
                      echo '<li data-thumb="'.$image_name.'">';
                        echo '<h3>' .$title. '</h3>';
                        echo '<img src="'.$image_name.'" />';
                      echo '</li>';
                     }
                  else {
                    $bitstreams = get_dspace_bitstream($collection_id, $doc[$id_field]);
                    $image_name = $bitstreams;
                    echo '<li data-thumb="'.$image_name.'">';
                      echo '<h3>' .$title. '</h3>';
                      echo '<img src="'.$image_name.'" />';
                    echo '</li>\n';
                  }
                }
              ?>
            </ul>
          </div>
          </div>
<script type="text/javascript">
  $(document).ready(function() {
    $('#lightSlider').lightSlider({
    gallery: true,
    item: 1,
    loop: true,
    slideMargin: 0,
    thumbItem: 9
});
  });
</script>
