<?php

$config['skylight_appname'] = 'clds';

$config['skylight_theme'] = 'clds';

$config['skylight_fullname'] = 'Edinburgh University Collections';

$config['skylight_tagline'] = 'Explore the University of Edinburgh Collections';

// set ga code
if (strpos($_SERVER['HTTP_HOST'], "test") !== false) {
    $config['skylight_ga_code'] = 'UA-25737241-6';
}
else {
    $config['skylight_ga_code'] = 'UA-25737241-9';
}

$config['skylight_adminemail'] = 'is-crc@ed.ac.uk';

$config['skylight_oaipmhcollection'] = 'hdl_10683_4';

$config['skylight_oaipmhallowed'] = true;

// Container ID and the field used in solr index to store this ID. Used for restricting search/browse scope.
if (strpos($_SERVER['HTTP_HOST'], "test") !== false) {
	$config['skylight_container_id'] = '7f32ba59-795e-40e8-b869-5b2a5114a4be';
}
else {
	$config['skylight_container_id'] = '1';
}
//$config['skylight_container_id'] = '1';
$config['skylight_container_field'] = 'location.coll';
$config['skylight_sitemap_type'] = 'internal';

$config['skylight_fields'] = array('Title' => 'dc.title.en',
    'Custodian' => 'dc.creator.en',
    'Custodial History' => 'cld.custodialHistory.en',
    'Identifier' => 'dc.identifier.other',
    'Subject' => 'dc.subject.en',
    'Highlight' => 'dc.subject.highlight',
    'Type' => 'dc.type.en',
    'Date' => 'dc.coverage.temporal.en',
    'Brief'=> 'dc.abstract.en',
    'Bitstream'=> 'dc.format.original.en',
    'Thumbnail'=> 'dc.format.thumbnail.en',
    'Description'=>'dc.description.en',
    'Summary'=>'dc.description.abstract.en',
    'Origin' => 'dc.coverage.spatial.en',
    'Parent Collection' => 'dc.relation.ispartof.en',
    'Sub Collections' => 'dc.relation.haspart.en',
    'Internal URI' => 'cld.internalURI.en',
    'ASpace URI' => 'cld.externalURI.ArchivesSpace',
    'LUNA URI' => 'cld.externalURI.LUNA',
    'LMS URI' => 'cld.externalURI.LMS',
    'Other URI'=> 'cld.externalURI.other'
);

$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('Type' => 'type_filter', 'Subject' => 'subject_filter', 'Origin' => 'place_filter');

$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title' => 'dc.title',
    'Subject' => 'dc.subject',
    'Type' => 'dc.type',
);

$config['skylight_recorddisplay'] = array('Title','Type','Summary', 'Description','Custodian','Custodial History','Origin','Date','Identifier', 'Further Resources');

$config['skylight_searchresult_display'] = array('Title','Brief','Custodian','Custodial History', 'Subject','Type','Origin', 'Bitstream', 'Thumbnail');

$config['skylight_search_fields'] = array('Keywords' => 'text',
    'Subject' => 'dc.subject',
    'Type' => 'dc.type',
    'Highlight' => 'dc.subject.highlight.en',
    'Bitstream'=> 'dc.format.original.en',
    'Thumbnail'=> 'dc.format.thumbnail.en'
);

$config['skylight_related_fields'] = array('Type' => 'dc.type.en', 'Subject' => 'dc.subject.en');

$config['skylight_sort_fields'] = array('Title' => 'dc.title_sort',
    'Subject' => 'dc.subject_sort'
);

$config['skylight_default_sort'] = 'dc.title_sort+asc';

$config['skylight_feed_fields'] = array('Title' => 'Title',
    'Subject' => 'Subject',
    'Origin' => 'Origin',
    'Identifier' => 'Identifier');

$config['skylight_results_per_page'] = 10;
$config['skylight_share_buttons'] = false;

// $config['skylight_homepage_recentitems'] = false;

// Set to the number of minutes to cache pages for. Set to false for no caching.
// This overrides the setting in skylight.php so is commented by default
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
$config['skylight_highlight_fields'] = 'dc.title.en,dc.creator,dc.subject.en,dc.description.en,dc.relation.ispartof.en';

$config['skylight_homepage_recentitems'] = false;
$config['skylight_homepage_fullwidth'] = true;
$config['skylight_search_header'] = true;

?>