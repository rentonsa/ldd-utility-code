<?php

$config['skylight_appname'] = 'physics';

// Global CodeIgniter ENVIRONMENT variable is set in skylight/index.php
if (ENVIRONMENT == 'development') {
    $config['base_url'] = 'https://test.sopacollection.ph.ed.ac.uk/';
    $config['skylight_ga_code'] = 'UA-25737241-6';
}
else {
    $config['base_url'] = 'https://sopacollection.ph.ed.ac.uk/';
    $config['skylight_ga_code'] = 'UA-25737241-10';
}

$config['skylight_theme'] = 'physics';

$config['skylight_fullname'] = 'School of Physics and Astronomy Image Archive';

// Uncomment this if you wish to restrict access to high res images to these IP ranges or addresses.
$config['skylight_ip_ranges'] = array('/^::1/', '/^129\.215/');

//$config['skylight_ga_code'] = 'UA-XXXX-Y';

$config['skylight_adminemail'] = 'lddt@mlist.is.ed.ac.uk';

$config['skylight_oaipmhcollection'] = 'hdl_10683_8';

// Container ID and the field used in solr index to store this ID. Used for restricting search/browse scope.
$config['skylight_container_id'] = '4';
$config['skylight_container_field'] = 'location.coll';
$config['skylight_sitemap_type'] = 'internal';

$config['skylight_fields'] = array('Title' => 'dc.title.en',
    'Author' => 'dc.creator.en',
    'Department' => 'dc.creator.en',
    'Subject' => 'dc.subject.en',
    'Type' => 'dc.type.en',
    'Abstract' => 'dc.description.abstract',
    //'Date' => 'dc.date.issued_dt',
    'Bitstream'=> 'dc.format.original.en',
    'Thumbnail'=> 'dc.format.thumbnail.en',
    'Description'=>'dc.description.en',
    'Date' => 'dc.date.issued',
    'Accession Date' => 'dc.date.accessioned_dt'
);

// HM 14/09/2020
// Date filtering broken in Skylight upgrade so disabling
//$config['skylight_date_filters'] = array('Date' => 'dateIssued.year_sort');
$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('Department' => 'creator_filter', 'Subject' => 'subject_filter');

$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title' => 'dc.title',
    'Author' => 'dc.creator',
    //'Abstract' => 'dc.description.abstract',
    'Subject' => 'dc.subject',
    'Date' => 'dc.date.issued_dt',
    //'Type' => 'dc.type',
    //'File'=> 'dc.format.original.en',
    //'Thumbnail'=> 'dc.format.thumbnail.en',
    //'Date' => 'dc.date.issued',
    'Type' => 'dc.type');


$config['skylight_recorddisplay'] = array('Title', 'Department', 'Date', 'Subject', 'Type', 'Description');

$config['skylight_searchresult_display'] = array('Title','Author','Subject','Type','Abstract', 'File', 'Thumbnail');

$config['skylight_search_fields'] = array('Title' => 'dc.title.en',
    'Subject' => 'dc.subject.en',
    'Type' => 'dc.type.en',
    'Author' => 'dc.creator.en',
);

$config['skylight_sort_fields'] = array('Title' => 'dc.title_sort',
    'Date' => 'dc.date.issued_dt',
    'Department' => 'dc.creator_sort'
);

$config['skylight_feed_fields'] = array('Title' => 'Title',
    'Author' => 'Author',
    'Subject' => 'Subject',
    'Description' => 'Abstract',
    'Date' => 'Date');

$config['skylight_results_per_page'] = 10;
$config['skylight_share_buttons'] = false;

// $config['skylight_homepage_recentitems'] = false;

// Set to the number of minutes to cache pages for. Set to false for no caching.
// This overrides the setting in skylight.php so is commented by Demo
$config['skylight_cache'] = false;

// Digital object management
$config['skylight_display_thumbnail'] = true;
$config['skylight_link_bitstream'] = true;

// Display common image formats in "light box" gallery?
$config['skylight_lightbox'] = true;
$config['skylight_lightbox_mimes'] = array('image/jpeg', 'image/gif', 'image/png');

// Language and locale settings
$config['skylight_language_default'] = 'en';
$config['skylight_language_options'] = array('en', 'ko', 'jp');

$config['skylight_highlight_fields'] = 'dc.title.en,dc.contributor.author,dc.subject.en,dc.description.en,dc.relation.ispartof.en';

?>
