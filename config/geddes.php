<?php

$config['skylight_appname'] = 'geddes';

// Global CodeIgniter ENVIRONMENT variable is set in skylight/index.php
if (ENVIRONMENT == 'development') {
    $config['skylight_container_id'] = '50092146-e1bb-4d9f-8755-b024a27ae0ae';
}
else {
    $config['skylight_container_id'] = '73';
}

$config['skylight_theme'] = 'geddes';

$config['skylight_url_prefix'] = 'geddes';

$config['skylight_fullname'] = 'Evergreen - Geddes Project';

$config['skylight_adminemail'] = 'lddt@mlist.is.ed.ac.uk';

$config['skylight_oaipmhcollection'] = 'hdl_10683_103618';

$config['skylight_oaipmhallowed'] = true;

$config['skylight_container_field'] = 'location.coll';
$config['skylight_sitemap_type'] = 'external';

$config['skylight_fields'] = array('Title' => 'dc.title.en',
    'Creator' => 'dc.creator.en',
    'Description' => 'dc.description.en',
    'Extent and Media' => 'dc.format.en',
    'Places' => 'dc.coverage.spatial.en',
    'Identifier' => 'dc.identifier.en',
    'Publisher' => 'dc.publisher.en',
    'Link' => 'dc.identifier.uri.en',
    'Subject' => 'dc.subject.en',
    'Date' => 'dc.coverage.temporal.en', //should be dc.coverage.temporal.en
    'Rights' => 'dc.rights.en',
    'Source' => 'dc.source.en',
    'Parent' => 'dc.relation.ispartof.en',
    'ImageUri' => 'dc.identifier.imageUri.en',
    'Language' => 'dc.language.en'

);

$config['skylight_schema_links'] = array(
    'Title'=> 'name',
    'Creator'=> 'creator',
    'Description'=> 'description',
    'Date'=>'dateCreated',
    'ImageUri'=>'thumbnailUrl',
    'Rights'=>'copyrightHolder',
    'Subject'=> 'about',
    'Places'=> 'locationCreated'
);

$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('Author' => 'creator_filter', 'Subject' => 'subject_filter', 'Place'=> 'place_filter', 'Collection' => 'publisher_filter','Date' => 'datetemporal_filter');
$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title' => 'dc.title.en',
    'Author' => 'dc.contributor.authorza.en',
    'Subject' => 'dc.subject',
    'Date' => 'dc.date.issued',
    'Type' => 'dc.type');

$config['skylight_recorddisplay'] = array('Title',
    'Creator' ,
    'Description',
    'Identifier',
    'Extent and Media',
    'Places',
    'Publisher',
    'Subject',
    'Date',
    'Rights',
    'Source',
    'Language');

$config['skylight_searchresult_display'] = array('Title',
    'Author' ,    'Subject',
    'Type');

$config['skylight_search_fields'] = array(
    'Subject' => 'dc.subject',
    'Type' => 'dc.type',
    'Author' => 'dc.contributor.authorza.en',
    'Collection' => 'dc.relation.ispartof.en',
);

$config['skylight_sort_fields'] = array(
    'Title' => 'dc.title_sort'
);

$config['skylight_related_fields'] = array('Creator' => 'dc.creator.en', 'Subject' => 'dc.subject.en', 'Title' => 'dc.title.en', );

$config['skylight_feed_fields'] = array('Title' => 'Title',
    'Author' => 'Author',
    'Subject' => 'Subject',
    'Description' => 'Abstract',
    'Date' => 'Date');

$config['skylight_results_per_page'] = 30;
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

$config['skylight_homepage_recentitems'] = false;
$config['skylight_homepage_randomitems'] = false;
$config['skylight_homepage_fullwidth'] = true;
$config['skylight_facet_limit'] = 5;


?>
