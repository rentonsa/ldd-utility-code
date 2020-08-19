<?php

$config['skylight_appname'] = 'guardbook';

$config['skylight_url_prefix'] = 'guardbook';

// Global CodeIgniter ENVIRONMENT variable is set in skylight/index.php
if(ENVIRONMENT == 'development') {
    if (strpos($_SERVER['HTTP_HOST'], "localhost") !== false) {
        $config['skylight_ga_code'] = '';
        $config['skylight_container_id'] = 'f0c7bb72-ab20-4693-be0d-43918440a8cd';
    } else if (strpos($_SERVER['HTTP_HOST'], "test") !== false) {
        $config['skylight_ga_code'] = 'UA-25737241-6';
        $config['skylight_container_id'] = 'f0c7bb72-ab20-4693-be0d-43918440a8cd';
    }
}
else {
    $config['skylight_ga_code'] = 'UA-25737241-9';
    $config['skylight_container_id'] = '51'; //Pick the ID from the else statement (51) with the uuid from (51) and put that uuid in the if statement
}

// The platform and version of your repository.
// Currently DSpace 1.7.1+ is the only supported repository
$config['skylight_repository_type'] = 'dspace'; // Demo 'dspace'
$config['skylight_repository_version'] = 'exams'; // Demo '171'


$config['skylight_theme'] = 'guardbook';

$config['skylight_fullname'] = 'Guardbook';

$config['skylight_adminemail'] = 'lddt@mlist.is.ed.ac.uk';

$config['skylight_oaipmhcollection'] = 'hdl_10683_52783';

$config['skylight_oaipmhallowed'] = true;

$config['skylight_container_field'] = 'location.coll';
$config['skylight_sitemap_type'] = 'external';

$config['skylight_fields'] = array('Title' => 'dc.title.en',
    'Subject' => 'dc.subject.en',
    'Shelfmark' => 'dc.identifier.en',
    'Bitstream' => 'dc.format.original.en',
    'Link' => 'dc.identifier.uri.en'
);

$config['skylight_schema_links'] = array(
      'Title'=>'name',
      'Subject'=>'about',
      'Shelfmark'=>'identifier',
      'Link'=>'url'
);

$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('A-Z' => 'subject_filter');
$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title' => 'dc.title.en',
    'Subject' => 'dc.subject');

$config['skylight_recorddisplay'] = array('Title',
    'Subject',
    'Shelfmark');

$config['skylight_searchresult_display'] = array('Title', 'Subject',
    'Shelfmark');

$config['skylight_search_fields'] = array(
    'Subject' => 'dc.subject'
);

$config['skylight_sort_fields'] = array('Title' => 'dc.title_sort');

$config['skylight_related_fields'] = array('Subject' => 'dc.subject.en');

$config['skylight_feed_fields'] = array('Title' => 'Title',
    'Subject' => 'Subject');

$config['skylight_results_per_page'] = 10;
$config['skylight_share_buttons'] = false;

$config['skylight_homepage_recentitems'] = false;

// Set to the number of minutes to cache pages for. Set to false for no caching.
// This overrides the setting in skylight.php so is commented by Demo
$config['skylight_cache'] = false;

// Digital object management
$config['skylight_bitstream_field'] = 'dc.format.original.en';
$config['skylight_thumbnail_field'] = 'dc.format.thumbnail';
$config['skylight_display_thumbnail'] = false;
$config['skylight_link_bitstream'] = true;


// Display common image formats in "light box" gallery?
$config['skylight_lightbox'] = true;
$config['skylight_lightbox_mimes'] = array('image/jpeg', 'image/gif', 'image/png');

// Language and locale settings
$config['skylight_language_default'] = 'en';
$config['skylight_language_options'] = array('en', 'ko', 'jp');


?>
