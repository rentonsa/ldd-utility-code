<?php

$config['skylight_appname'] = 'fairbairn';

// Uncomment this if you are using a url of the form http://.../art/...
//$config['skylight_url_prefix'] = 'fairbairn';

// Global CodeIgniter ENVIRONMENT variable is set in skylight/index.php
if (ENVIRONMENT == 'development') {
    $config['base_url'] = 'http://test.fairbairn.ac.uk/';
    $config['skylight_ga_code'] = '';
    $config['skylight_solrbase'] = 'http://lac-archivesspace-live1.is.ed.ac.uk:8090/';
}
else {
    $config['base_url'] = 'http://www.fairbairn.ac.uk/';
    $config['skylight_ga_code'] = 'UA-25737241-19';
    $config['skylight_solrbase'] = 'http://lac-archivesspace-live1.is.ed.ac.uk:8090/';
}

$config['skylight_repository_type'] = 'archivesspace'; // Demo 'dspace'
$config['skylight_repository_version'] = '1';

$config['skylight_theme'] = 'fairbairn';

$config['skylight_handle_prefix'] = '/repositories/6/';

$config['skylight_fullname'] = 'W. Ronald D. Fairbairn';

$config['skylight_adminemail'] = 'lac-fairbairn@mlist.is.ed.ac.uk';

$config['skylight_oaipmhcollection'] = '';

$config['skylight_oaipmhallowed'] = true;

// Container ID and the field used in solr index to store this ID. Used for restricting search/browse scope.
$config['skylight_container_id'] = array('"/repositories/6"');
$config['skylight_container_field'] = 'repository';
$config['skylight_sitemap_type'] = 'external';

$config['skylight_query_restriction'] = array();

$config['skylight_fields'] = array('Title' => 'title',
    'Creator' => 'creators',
    'Subject' => 'subjects',
    'Type' => 'primary_type',
    'Level' => 'level',
    'Date' => 'create_time',
    'JSON' => 'json',
    'Agent' => 'agents',
    'Publish' => 'publish',
    'Notes' => 'notes',
    'Language' => 'langmaterial',
    'Scope and Contents' => 'scopecontent',
    'Related' => 'relatedmaterial',
    'Physical' => 'phystech',
    'Access' => 'accessrestrict',
    'Rights' => 'rights_statements',
    'Dates' =>'dates',
    'Extent' => 'extents',
    'Identifier' =>'component_id',
    'Parent' => 'parent',
    'Parent_Id' => 'parent_id',
    'Parent_Type' => 'parent_type',
    'Bibliography' => 'note_bibliography',
    'Id' => 'id',
    'Alternative Format' => 'altformavail',
    'Physical Description' => 'physdesc'

);

$config['skylight_schema_links'] = array(
      'Title'=>'name',
      'Creator'=>'creator',
      'Subject'=>'keywords',
      'Agent'=>'creator',
      'Notes'=>'description',
      'Language'=>'inLanguage',
      'Scope and Contents'=>'text',
      'Related'=>'isRelatedTo',
      'Extent'=>'about',
      'Identifier'=>'identifier',
      'Id'=>'identifier',
      'Physical Description'=>'description'
);

$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('Subject' => 'subjects', 'Agent' => 'agents');
$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title' => 'title',
    'Agent' => 'agents',
    'Subject' => 'subjects',
    'Type' => 'primary_type',
    'Level' => 'level',);

$config['skylight_recorddisplay'] = array('Identifier','Creator','Dates','Extent','Extent Type','Agent','Subject',
    'Notes','Rights','Language','Scope and Contents','Related','Bibliography','Physical','Physical Description',
    'Access','Alternative Format' );

$config['skylight_searchresult_display'] = array('Title','Creator','Subject','Agent');

$config['skylight_search_fields'] = array('Title' => 'title',
    'Subject' => 'subjects',
    'Agent' => 'agents',
    'Creator' => 'creators'
);

$config['skylight_sort_fields'] = array('Title' => 'title_sort');

$config['skylight_related_fields'] = array('Parent' => 'parent', 'Id' => 'id');

$config['skylight_feed_fields'] = array('Title' => 'title',
    'Creator' => 'creator',
    'Subject' => 'subjects',
    'Agent' => 'agents');

$config['skylight_results_per_page'] = 10;
$config['skylight_share_buttons'] = false;

$config['skylight_homepage_recentitems'] = false;
$config['skylight_homepage_randomitems'] = false;
$config['skylight_related_number'] = 20;

// Set to the number of minutes to cache pages for. Set to false for no caching.
// This overrides the setting in skylight.php so is commented by Demo
$config['skylight_cache'] = false;

// Digital object management
$config['skylight_bitstream_field'] = '';
$config['skylight_thumbnail_field'] = '';
$config['skylight_display_thumbnail'] = false;
$config['skylight_link_bitstream'] = false;


// Display common image formats in "light box" gallery?
$config['skylight_lightbox'] = true;
$config['skylight_lightbox_mimes'] = array('image/jpeg', 'image/gif', 'image/png');

// Language and locale settings
$config['skylight_language_default'] = 'en';
$config['skylight_language_options'] = array('en');


?>
