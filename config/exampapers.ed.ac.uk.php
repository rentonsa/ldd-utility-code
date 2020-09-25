<?php

// Global CodeIgniter ENVIRONMENT variable is set in skylight/index.php
if (ENVIRONMENT == 'development') {
    $config['base_url'] = 'https://test.exampapers.ed.ac.uk/';
    $config['skylight_ga_code'] = 'UA-25737241-22';
}
else {
    $config['base_url'] = 'https://exampapers.ed.ac.uk/';
    $config['skylight_ga_code'] = 'UA-25737241-12';
}

$config['skylight_appname'] = 'exams';

$config['skylight_theme'] = 'exams';

$config['skylight_fullname'] = 'exams';

// Uncomment this if you are using a url of the form http://.../art/...
//$config['skylight_url_prefix'] = 'exams';

$config['skylight_adminemail'] = 'exam.papers@ed.ac.uk';

$config['skylight_oaipmhcollection'] = 'hdl_10683_23251';

$config['skylight_oaipmhallowed'] = false;

$config['skylight_repository_version'] = 'exams';
$config['skylight_homepage_recentitems'] = false;

// Container ID and the field used in solr index to store this ID. Used for restricting search/browse scope.
$config['skylight_container_id'] = '10';
$config['skylight_container_field'] = 'location.comm';
$config['skylight_sitemap_type'] = 'external';

// This array only appears to be used in Utilities to translate label to value and vice versa. Robin.
$config['skylight_fields'] = array(
    'School' => 'dc.creator.en',
    'Subject' => 'dc.subject.en',
    'Year' => 'dc.coverage.temporal.en',
    'Title' => 'dc.title.en',
    'Course Code' => 'dc.identifier',
    'Version' => 'dc.description.version.en',
    'Type' => 'dc.type.en',
    'Abstract' => 'dc.description.abstract',
    'Date' => 'dc.date.issued',
    'Accession Date' => 'dc.date.accessioned_dt'
);

$config['skylight_schema_links'] = array(
        'School'=>'creator',
        'Subject'=>'about',
        'Year'=>'temporalCoverage',
        'Title'=>'name',
        'Course Code'=>'identifier',
        'Version'=>'description',
        'Abstract'=>'description',
        'Date'=>'datePublished',
        'Accession Date'=>'identifier'
);

$config['skylight_date_filters'] = array();
//$config['skylight_date_filters'] = array('Date' => 'dateIssued.year_sort');
$config['skylight_filters'] = array('School' => 'creator_filter', 'Subject' => 'subject_filter', 'Year' => 'temporal_filter', 'Title' => 'title_filter');
$config['skylight_filter_delimiter'] = ':';

// These fields are 'displayed' in the html <head> section.
$config['skylight_meta_fields'] = array('Title' => 'dc.title', 'Course Code' => 'dc.identifier',
    'Author' => 'dc.creator',
    'Abstract' => 'dc.description.abstract',
    'Subject' => 'dc.subject',
    'Date' => 'dc.date.issued',
    'Type' => 'dc.type');

// These fields appear on the individual record page.
$config['skylight_recorddisplay'] = array('School','Subject','Title','Course Code','Version','Year');

// I suspect this one is redundant, they are currently hardcoded into search-results.php!
//$config['skylight_searchresult_display'] = array('Title','Author','Subject','Type','Abstract');

// Used for Related Items
$config['skylight_related_fields'] = array('Title' => 'dc.title.en', 'Course Code' => 'dc.identifier.en');
$config['skylight_related_number'] = 10;

// This is used for Advanced Search which I have hidden for the Exam Papers
$config['skylight_search_fields'] = array('School' => 'dc.creator',
    'Subject' => 'dc.subject',
    'Year' => 'dc.coverage.temporal',
    'Title' => 'dc.title'
);

$config['skylight_sort_fields'] = array('Title' => 'dc.title_sort',
    'Date' => 'dc.date.issued_dt'
);

$config['skylight_feed_fields'] = array('Title' => 'Title',
    'Author' => 'Author',
    'Subject' => 'Subject',
    'Description' => 'Abstract',
    'Date' => 'Date');

$config['skylight_results_per_page'] = 10;
$config['skylight_share_buttons'] = false;

$config['skylight_homepage_recentitems'] = false;

// Set to the number of minutes to cache pages for. Set to false for no caching.
// This overrides the setting in skylight.php so is commented by Demo
$config['skylight_cache'] = false;

// Digital object management
$config['skylight_bitstream_field'] = 'dc.format.original.en';
$config['skylight_thumbnail_field'] = 'dc.format.thumbnail.en';
$config['skylight_display_thumbnail'] = true;
$config['skylight_link_bitstream'] = true;


// Display common image formats in "light box" gallery?
$config['skylight_lightbox'] = true;
$config['skylight_lightbox_mimes'] = array('image/jpeg', 'image/gif', 'image/png');

// Language and locale settings
$config['skylight_language_default'] = 'en';
$config['skylight_language_options'] = array('en', 'ko', 'jp');

?>
