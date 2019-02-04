<?php


//Fast access to important variables
$id = $this->skylight_utilities->getField("ID");
$title = $this->skylight_utilities->getField("Title");
$coverImageName = $this->skylight_utilities->getField("Image Name");
$imageURI = $this->skylight_utilities->getField("Image URI");
$location = $this->skylight_utilities->getField("Map Reference");
$media_uri = $this->config->item("skylight_media_url_prefix");
$bitstream_field = $this->skylight_utilities->getField("Bitstream");
$thumbnail_field = $this->skylight_utilities->getField("Thumbnail");
$iiifJson = isset( $solr[$imageURI] ) ? $solr[$imageURI][0] : "";

//Image setup
if (isset( $solr[$coverImageName][0] )){
    $image_name = $solr[$coverImageName][0];
}
else{
    $collection_id = '10683';
    $id = end(explode('/', $_SERVER['REQUEST_URI']));
    $image_name = get_dspace_bitstream($collection_id, $id);
}

$imageServer = $this->config->item('skylight_image_server');

if($iiifJson != "") {
    $coverImageJSON = str_replace($iiifJson, '/full/full/0/default.jpg', '/info.json');
    $json = file_get_contents($iiifJson);
}
else {
    $coverImageJSON = $image_name;
}
if(isset($solr[$coverImageName][0])) {
  echo '<script>var imageSource = [];</script>';
  $imagetot = 0;
  foreach($solr[$imageURI] as $imageno)
  {
      $imagetot++;
  }
  for($i=0;$i<$imagetot;$i++){
      $coverImageURL = $solr[$imageURI][$i];
      $coverImageURL = str_replace('http', 'https', $coverImageURL);
      $coverImageJSON = str_replace('/full/full/0/default.jpg','/info.json', $coverImageURL);
      $coverImage = '<img class="record-image" src ="' .$coverImageURL .'"/>';
      $osjsonid = str_replace('/info.json','', $coverImageJSON);
      $json =  file_get_contents($coverImageJSON);
      $jobj = json_decode($json, true);
      $error = json_last_error();
      $jsonheight = $jobj['height'];
      $jsonwidth = $jobj['width'];
      $size = $jsonheight;
      if ($size < $jsonwidth){
        $size = $jsonwidth;
      }
      echo '
      <script>
      imageSource[' . $i . '] = {
          "@context": "http://iiif.io/api/image/2/context.json",
              "@id": "' . $osjsonid . '",
              "height": ' . $jsonheight . ',
              "width": ' . $jsonwidth . ',
              "profile": ["http://iiif.io/api/image/2/level2.json",
                  {
                      "formats": ["jpg"]
                  }
              ],
              "protocol": "http://iiif.io/api/image",
              "tiles": [{
              "scaleFactors": [1, 2, 8, 16, 32],
                  "width": "'. $jsonwidth .'",
                  "height": "'. $jsonheight .'"
              }],
              "tileSize": '. $size .'
          };
          </script>';
  }
}
else{
    echo '<script>var imageSource = [];</script>';
    $collection_id = '10683';
    $id = end(explode('/', $_SERVER['REQUEST_URI']));
    $image_name = get_dspace_bitstream($collection_id, $id);
    $coverImage = '<img class="record-image" src ="' .$image_name .'"/>';
    echo '
    <script>
    imageSource[0] = {
      type: "image",
      url:  "'.$image_name.'",
      buildPyramid: true
      };
      </script>';
}
if(isset($solr[$bitstream_field]))
{
    foreach ($solr[$bitstream_field] as $bitstream_for_array)
    {
        $b_segments = explode("##", $bitstream_for_array);
        $b_seq = $b_segments[4];
        $bitstream_array[$b_seq] = $bitstream_for_array;
    }
    ksort($bitstream_array);
    $mainImage = false;
    $videoFile = false;
    $audioFile = false;
    $audioLink = "";
    $videoLink = "";
    $jsonLink = "";
    $b_seq =  "";
    foreach($bitstream_array as $bitstream) {
        $mp4ok = false;
        $b_segments = explode("##", $bitstream);
        $b_filename = $b_segments[1];
        if ($image_id == "") {
            $image_id = substr($b_filename, 0, 7);
        }
        $b_handle = $b_segments[3];
        $b_seq = $b_segments[4];
        $b_handle_id = preg_replace('/^.*\//', '', $b_handle);
        $b_uri = './record/' . $b_handle_id . '/' . $b_seq . '/' . $b_filename;

        if ((strpos($b_filename, ".mp4") > 0) or (strpos($b_filename, ".MP4") > 0)) {
            $b_uri = $media_uri . $b_handle_id . '/' . $b_seq . '/' . $b_filename;
            // Use MP4 for all browsers other than Chrome
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == false) {
                $mp4ok = true;
            } //Microsoft Edge is calling itself Chrome, Mozilla and Safari, as well as Edge, so we need to deal with that.
            else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') == true) {
                $mp4ok = true;
            }
            if ($mp4ok == true) {
                // Insert Schema for detecting Video
                $videoSource = $b_uri;
                $type = 'video/mp4';
            }
        } else if ((strpos($b_filename, ".webm") > 0) or (strpos($b_filename, ".WEBM") > 0)) {
            //Microsoft Edge needs to be dealt with. Chrome calls itself Safari too, but that doesn't matter.
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') == false) {
                if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == true) {
                    $videoSource = $b_uri;
                    $type = 'video/webm';
                }
            }
        }
    }
}
?>


<script src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/js/scrollify.js"></script>
<script>
    $(function() {
        if(!(/Android|webOS|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i.test(navigator.userAgent) )) {
            $.scrollify({
                section: ".scroll",
                offset: -50,
                updateHash: false,
                standardScrollElements: "#openseadragon, .record-info",
                interstitialSection: ".footer"
            });
        }
    });
</script>
<section class="image-view full-height-section scroll">

    <!--Seadragon image viewer-->
    <div id="toolbarDiv" class="toolbar">
        <h2 id="previous-pic"></h2>
        <h2 id="next-pic"></h2>
    </div>

    <div id="openseadragon" class="cover-image-container full-width"></div>
    <script>
        var imageURL = <?php echo json_encode($osjsonid); ?>;
        var imageHeight = <?php echo json_encode($jsonheight); ?>;
        var imageWidth = <?php echo json_encode($jsonwidth); ?>;
    </script>
    <script src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/js/openseadragon.min.js"></script>
    <script src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/js/openseadragonconfig.js"></script>
    <h3 class="more-info" onclick="$.scrollify.next();">Information</h3>
</section>
<section class="section-divisor hidden-sm hidden-xs"></section>

<section class="info-view full-height-section scroll">
    <div class="record-info col-md-4 col-md-offset-2">
        <h2 class="itemtitle">
            <?php echo $solr[$title][0] ?>
        </h2>
        <?php echo '<img style="display: block; box-shadow: 5px 5px 5px rgb(220, 220, 220); margin-bottom: 10px;" width = "100%" src ="' .$coverImageURL .'"/>'; ?>

        <div class="description">
            <?php
            if (isset($videoSource)){
                echo '<video width="100%"  controls>
                        <source src="' . $videoSource . '" type="'.$type.'">
                        Your browser does not support the video tag.
                        </video>';
            }
            /*if(isset($solr[$bitstream_field]) && $link_bitstream)
            {

                if($videoFile) {
                    echo '<br>.<br>'.$videoLink;
                }
                echo '</div>';

            }
            $id = end(explode('/', $_SERVER['REQUEST_URI']));
            if ($id == "124625"){
              echo '<video width="100%"  controls>
                    <source src="../theme/public-art/videos/william_darrell.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                    </video>';
            }
            if ($id == "124626"){
              echo '<video width="100%"  controls>
                    <source src="../theme/public-art/videos/david_forsyth.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                    </video>';
            }
            if ($id == "156608"){
              echo '<video width="100%"  controls>
                    <source src="../theme/public-art/videos/nathan_coley.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                    </video>';
            }*/
            ?>
            <?php
            foreach($recorddisplay as $key) {
                $element = $this->skylight_utilities->getField($key);
                if(isset( $solr[$element][0] )) {
                    echo '<div class="row"><span class="field">' . $key . '</span>' . $solr[$element][0] . '</div>';
                }
            }
            ?>
        </div>
    </div>
    <script>
        (function($){
            $(window).on("load",function(){
                $(".record-info").mCustomScrollbar({
                    theme: "light-thick",
                    scrollInertia: 100,
                    mouseWheel:{ preventDefault: true}
                });
            });
        })(jQuery);
    </script>
    <div id="map" class="col-md-2"></div>

    <script>
    //this gets the location from solr
    <?php $map_location = explode(',',$solr[$location][0]);?>
    //this takes the appropriate latitude and longitude from $map_location
    lon = <?php echo $map_location[1];?>;
    lat = <?php echo $map_location[0];?>;
    </script>
    <script src="../theme/public-art/map/bundle.js" ></script>
    <h4 class="back-to-search" value="Back to Search Results" onClick="history.go(-1);">Back to search</h4>
</section>
<div class="content hidden">
