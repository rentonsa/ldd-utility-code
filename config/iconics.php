<?php

$config['skylight_appname'] = 'iconics';

$config['skylight_theme'] = 'iconics';

// Uncomment this if you are using a url of the form http://.../art/...
$config['skylight_url_prefix'] = 'iconics';

$config['skylight_fullname'] = 'Library and University Collections - Iconics';

$config['skylight_adminemail'] = 'lddt@mlist.is.ed.ac.uk';

$config['skylight_oaipmhcollection'] = 'hdl_10683_117182';

// set ga code and dspace collection id
if (strpos($_SERVER['HTTP_HOST'], "test") !== false) {
    $config['skylight_ga_code'] = 'UA-25737241-6';
    $config['skylight_container_id'] = 'e9122b44-420c-4247-9fe7-364214db5f94';
}
else {
    $config['skylight_ga_code'] = 'UA-25737241-9';
    $config['skylight_container_id'] = '30';
}

$config['skylight_container_field'] = 'location.coll';

$config['skylight_fields'] = array('Title' => 'dc.title.en',
    'Author' => 'dc.contributor.author.en',
    'Subject' => 'dc.subject.en',
    'Tags' => 'dc.subject.crowdsourced.en',
    'Link' => 'dc.identifier.uri',
    'Type' => 'dc.type.en',
    'Abstract' => 'dc.description.abstract.en',
    'Date' => 'dc.coverage.temporal.en',
    'Bitstream'=> 'dc.format.original.en',
    'Thumbnail'=> 'dc.format.thumbnail.en',
    'Description'=>'dc.description.en',
    'Identifier'=>'dc.identifier.other.en',
    'Shelfmark'=>'dc.identifier.en'
);

$config['skylight_schema_links'] = array(
      'Title'=>'name',
      'Author'=>'creator',
      'Subject'=>'about',
      'Tags'=>'keywords',
      'Link'=>'url',
      'Abstract'=>'description',
      'Date'=>'dateCreated',
      'Thumbnail'=>'thumbnail',
      'Description'=>'description',
      'Identifier'=>'identifier',
      'Shelfmark'=>'identifier'
);

$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('Subject' => 'subject_filter', 'Type' => 'type_filter',  'Tags' => 'tags_filter' );
$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title' => 'dc.title.en',
    'Author' => 'dc.contributor.author.en',
    'Abstract' => 'dc.description.abstract.en',
    'Subject' => 'dc.subject.en',
    'Type' => 'dc.type.en',
    'Bitstream'=> 'dc.format.original',
    'Thumbnail'=> 'dc.format.thumbnail'
);

$config['skylight_related_fields'] = array(
    'Subject' => 'dc.subject.en',
    'Type' => 'dc.type.en'
);

$config['skylight_recorddisplay'] = array('Author','Date','Type','Subject','Shelfmark','Identifier');

$config['skylight_searchresult_display'] = array('Title','Author','Subject','Type','Abstract');

$config['skylight_search_fields'] = array('Keywords' => 'text',
    'Subject' => 'dc.subject.en',
    'Type' => 'dc.type.en',
    'Author' => 'dc.contributor.author',
    'Tags' => 'dc.subject.crowdsourced.en'
);

$config['skylight_sort_fields'] = array( 'Title' => 'dc.title_sort');

$config['skylight_default_sort'] = 'dc.title_sort+asc';

$config['skylight_feed_fields'] = array('Title' => 'Title',
    'Author' => 'Author',
    'Subject' => 'Subject',
    'Description' => 'Abstract',
    'Date' => 'Date');

$config['skylight_results_per_page'] = 20;
$config['skylight_share_buttons'] = false;

// $config['skylight_homepage_recentitems'] = false;

// limit of number of terms in each facet
$config['skylight_facet_limit'] = 30;

// limit of number of terms in each related items
$config['skylight_related_number'] = 5;

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
$config['skylight_highlight_fields'] = 'dc.title.en,dc.contributor.author,dc.subject.en,dc.description.en';

$config['skylight_homepage_recentitems'] = false;
$config['skylight_homepage_randomitems'] = true;
$config['skylight_homepage_fullwidth'] = true;
$config['skylight_search_header'] = false;
?>
