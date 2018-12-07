
<section class="info col-xs-12 full-height-section">
<h3>Public Artwork Locations</h3>
        <div class="map"></div>
<script>
//this gets the location from solr
<?php $map_location = explode(',',$solr[$location][0]);?>
//this takes the appropriate latitude and longitude from $map_location
lon = <?php echo $map_location[1];?>
lat = <?php echo $map_location[0];?>
<?php
$imageServer = $this->config->item('skylight_image_server');
echo $imageServer;
?>
<?php echo $config['skylight_appname'];?>
</script>
</section>
<script src="../theme/public-art/map/bundle.js" ></script>
