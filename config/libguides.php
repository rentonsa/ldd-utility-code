<?php

$config['skylight_appname'] = 'libguides';

$config['skylight_theme'] = 'libguides';

$config['skylight_fullname'] = 'Library Guides';

$config['skylight_adminemail'] = 'lddt@mlist.is.ed.ac.uk';

$config['skylight_oaipmhcollection'] = 'hdl_10683_18892';


// Container ID and the field used in solr index to store this ID. Used for restricting search/browse scope.

$config['skylight_container_id'] = '12';
$config['skylight_container_field'] = 'location.coll';

$config['skylight_fields'] = array('Title' => 'dc.title.en',
    'Author' => 'dc.contributor.author',
    'Subject' => 'dc.subject.en',
    'Type' => 'dc.type.en',
    'Abstract' => 'dc.description.abstract',
    'Date' => 'dc.date.issued_dt',
    'Bitstream'=> 'dc.format.original',
    'Thumbnail'=> 'dc.format.thumbnail',
    'Description'=>'dc.description'
);

// HM 14/09/2020
// Date filtering broken in Skylight upgrade so disabling
//$config['skylight_date_filters'] = array('Date' => 'dateIssued.year_sort');
$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('Author' => 'author_filter', 'Subject' => 'subject_filter', 'Type' => 'type_filter');

$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title' => 'dc.title',
    'Author' => 'dc.creator',
    'Abstract' => 'dc.description.abstract',
    'Subject' => 'dc.subject',
    'Date' => 'dc.date.issued_dt',
    'Type' => 'dc.type',
    'Bitstream'=> 'dc.format.original',
    'Thumbnail'=> 'dc.format.thumbnail'

);

$config['skylight_recorddisplay'] = array('Title','Author','Subject','Type','Abstract', 'Bitstream', 'Thumbnail','Place Made', 'Date Made', 'Accession Number', 'Description', 'Collection');

$config['skylight_searchresult_display'] = array('Title','Author','Subject','Type','Abstract', 'Bitstream', 'Thumbnail');

$config['skylight_search_fields'] = array('Keywords' => 'text',
    'Subject' => 'dc.subject',
    'Type' => 'dc.type',
    'Author' => 'dc.creator',
    'Bitstream'=> 'dc.format.original',
    'Thumbnail'=> 'dc.format.thumbnail'
);

$config['skylight_sort_fields'] = array('Title' => 'dc.title',
    'Date' => 'dc.date.issued_dt',
    'Author' => 'dc.creator'
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
$config['skylight_highlight_fields'] = 'dc.title.en,dc.contributor.author,dc.subject.en,lido.country.en,dc.description.en,dc.relation.ispartof.en';

?>