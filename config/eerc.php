<?php
$config['skylight_appname'] = 'eerc';

// Uncomment this if you are using a url of the form http://.../art/...
$config['skylight_url_prefix'] = 'eerc';

// Global CodeIgniter ENVIRONMENT variable is set in skylight/index.php
if(ENVIRONMENT == 'development') {
    if (strpos($_SERVER['HTTP_HOST'], "localhost") !== false) {
        $config['skylight_ga_code'] = '';
        $config['skylight_solrbase'] = 'http://lac-archives-live.is.ed.ac.uk:8090/';
        $config['skylight_link_url'] = 'http://lac-archives-live.is.ed.ac.uk:8081';
    } else if (strpos($_SERVER['HTTP_HOST'], "test") !== false) {
        $config['skylight_ga_code'] = '';
        $config['skylight_solrbase'] = 'http://lac-archives-live.is.ed.ac.uk:8090/';
        $config['skylight_link_url'] = 'http://lac-archives-live.is.ed.ac.uk:8081';
        //$config['skylight_solrbase'] = 'http://lac-repo-live14.is.ed.ac.uk:8090/';
        //$config['skylight_link_url'] = 'http://archives.collections.ed.ac.uk';
    }
}
else {
    $config['skylight_ga_code'] = 'UA-25737241-9';
    $config['skylight_solrbase'] = 'http://lac-archives-live.is.ed.ac.uk:8090/';
    $config['skylight_link_url'] = 'http://lac-archives-live.is.ed.ac.uk:8081';
    //$config['skylight_solrbase'] = 'http://lac-repo-live11.is.ed.ac.uk:8090/';
    //    $config['skylight_link_url'] = 'http://archives.collections.ed.ac.uk';
}

$config['skylight_archivesspace_user'] = 'admin';
$config['skylight_archivesspace_password'] = '?';
$config['skylight_archivesspace_url'] = 'http://lac-archives-live.is.ed.ac.uk:8089';
$config['skylight_archivesspace_tree'] = '/repositories/15/resources/86984/tree';

$config['skylight_repository_type'] = 'archivesspace'; // Demo 'dspace'
$config['skylight_repository_version'] = '1';

$config['skylight_theme'] = 'eerc';

$config['skylight_handle_prefix'] = '/repositories/15/';

$config['skylight_fullname'] = 'Regional Ethnology of Scotland Project';

$config['skylight_adminemail'] = 'lddt@mlist.is.ed.ac.uk';

$config['skylight_oaipmhcollection'] = '';

$config['skylight_oaipmhallowed'] = true;


// Container ID and the field used in solr index to store this ID. Used for restricting search/browse scope.
$config['skylight_container_id'] = array('"/repositories/15/resources/86984"');
//$config['skylight_container_id'] = array('"/repositories/16/resources/86794"');
$config['skylight_container_field'] = 'resource';
$config['skylight_sitemap_type'] = 'external';

//$config['skylight_query_restriction'] = array('publish' => 'true');
$config['skylight_query_restriction'] = array();

$config['skylight_fields'] = array('Title' => 'title',
    'Interviewer' => 'creators',
    'Subject' => 'subjects',
    'Type' => 'primary_type',
    'Level' => 'level',
    'Resource_Id' => 'resource',
    'Date' => 'create_time',
    'JSON' => 'json',
    'Notable persons / organisations' => 'agents',
    'Publish' => 'publish',
    'Notes' => 'notes',
    'Language' => 'langmaterial',
    'Interview summary' => 'scopecontent',
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
    'Physical Description' => 'physdesc',
    'Audio links and images' => 'digital_object_uris',
);

$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('Subject' => 'subjects', 'Person' => 'agents');
$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title' => 'title',
    'Notable persons/organisations' => 'agents',
    'Subject' => 'subjects',
    'Type' => 'primary_type',
    'Level' => 'level',);

$config['skylight_recorddisplay'] = array('Identifier','Interviewer','Dates','Extent','Extent Type','Notable persons / organisations','Subject',
    'Rights','Interview summary','Related','Bibliography','Physical','Access','Alternative Format', 'Audio links and images', 'Language' );

$config['skylight_searchresult_display'] = array('Title','Interviewer','Subject','Notable persons/organisations', 'Identifier', 'Interview summary');

$config['skylight_search_fields'] = array('Title' => 'title',
    'Subject' => 'subjects',
    'Notable persons/organisations' => 'agents',
    'Interviewer' => 'creators',
    'Identifier' =>'component_id',
    'Interview summary' => 'scopecontent',
);

$config['skylight_sort_fields'] = array('Title' => 'title_sort');

$config['skylight_related_fields'] = array('Parent' => 'parent', 'Id' => 'id');

$config['skylight_feed_fields'] = array('Title' => 'title',
    'Interviewer' => 'creator',
    'Subject' => 'subjects',
    'Notable persons/organisations' => 'agents');

$config['skylight_results_per_page'] = 10;
$config['skylight_share_buttons'] = false;

$config['skylight_homepage_recentitems'] = false;
$config['skylight_homepage_randomitems'] = false;
$config['skylight_related_number'] = 10;

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
