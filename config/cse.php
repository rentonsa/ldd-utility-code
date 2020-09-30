<?php

$config['skylight_appname'] = 'cse';

$config['skylight_theme'] = 'cse';

$config['skylight_fullname'] = 'Centre for Sports and Exercise';

$config['skylight_adminemail'] = 'lddt@mlist.is.ed.ac.uk';

$config['skylight_oaipmhcollection'] = 'hdl_10683_24202';


// Container ID and the field used in solr index to store this ID. Used for restricting search/browse scope.
$config['skylight_container_id'] = '14';
$config['skylight_container_field'] = 'location.coll';



$config['skylight_fields'] = array('Title' => 'dc.title.en',
    'Author' => 'dc.contributor.author',
    'Subject' => 'dc.subject.en',
    'Instrument' => 'dc.type.en',
    'Abstract' => 'dc.description.abstract.en',
    'Date' => 'dc.date.issued',
    'Bitstream'=> 'dc.format.original.en',
    'Thumbnail'=> 'dc.format.thumbnail.en',
    'Place Made' => 'dc.coverage.spatial.en',
    'Date Made' => 'dc.date.created',
    'Accession Number' => 'dc.identifier.other',
    'Description' => 'dc.description.en',
    'Collection' => 'dc.relation.ispartof.en'
);

// HM 14/09/2020
// Date filtering broken in Skylight upgrade so disabling
//$config['skylight_date_filters'] = array('Date' => 'dateIssued.year_sort');
$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('Collection'=> 'collection_filter', 'Maker' => 'author_filter', 'Place Made' => 'place_filter', 'Instrument Type' => 'type_filter');
$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title' => 'dc.title',
    'Author' => 'dc.creator',
    'Abstract' => 'dc.description.abstract',
    'Subject' => 'dc.subject',
    'Date' => 'dc.date.issued',
    'Type' => 'dc.type',
    'Bitstream'=> 'dc.format.original.en',
    'Thumbnail'=> 'dc.format.thumbnail.en');

$config['skylight_recorddisplay'] = array('Title','Author','Subject','Type','Abstract', 'Place Made', 'Date Made', 'Accession Number', 'Description', 'Collection');

$config['skylight_searchresult_display'] = array('Title','Author','Subject','Type','Abstract', 'Bitstream', 'Thumbnail');


$config['skylight_search_fields'] = array('Keywords' => 'text',
    'Type' => 'dc.type',
    'Author' => 'dc.creator',
    'Subject' => 'dc.subject',
    'Date' => 'dc.date.issued',
    'Bitstream'=> 'dc.format.original',
    'Thumbnail'=> 'dc.format.thumbnail'
);

$config['skylight_sort_fields'] = array('Title' => 'dc.title_sort',
    'Date' => 'dc.date.issued_dt',
    'Author' => 'dc.contributor.author_sort'
);

$config['skylight_feed_fields'] = array('Title' => 'Title',
    'Author' => 'Author',    
    'Subject' => 'Subject',
    'Country' => 'Country',
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

$config['skylight_highlight_fields'] = 'dc.title.en,dc.contributor.author,dc.subject.en,lido.country.en,dc.description.en,dc.relation.ispartof.en';

?>