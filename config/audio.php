<?php

// set the base url and ga code
//if (ENVIRONMENT == 'development') {
    //$config['base_url'] = 'http://test.stuartsound.is.ed.ac.uk/';
  //  $config['skylight_ga_code'] = 'UA-25737241-6';
//}
//else {
    //$config['base_url'] = 'http://www.stuartsound.is.ed.ac.uk/';
  //  $config['skylight_ga_code'] = 'UA-25737241-6';
//}

$config['skylight_appname'] = 'audio';

// Uncomment this if you are using a url of the form http://.../art/...
$config['skylight_url_prefix'] = 'audio';

$config['skylight_theme'] = 'audio';

$config['skylight_fullname'] = 'Audio Recordings';

$config['skylight_adminemail'] = 'lddt@mlist.is.ed.ac.uk';

$config['skylight_oaipmhcollection'] = 'hdl_10683_53855';

$config['skylight_oaipmhallowed'] = true;

// Container ID and the field used in solr index to store this ID. Used for restricting search/browse scope.
$config['skylight_container_id'] = '15';
$config['skylight_container_field'] = 'location.coll';
$config['skylight_sitemap_type'] = 'internal';


$config['skylight_fields'] = array(
    'Title' => 'dc.title.en',
    'Alternative Title' => 'dc.title.alternative.en',
    'Author' => 'dc.contributor.author.en',
    'Subject' => 'dc.subject.en',
    'Type' => 'dc.type.en',
    'Abstract' => 'dc.description.abstract.en',
//    'Date' => 'dc.date.created',
    'Bitstream'=> 'dc.format.original.en',
    'Thumbnail'=> 'dc.format.thumbnail.en',
    'Place Made' => 'dc.coverage.spatial.en',
    'Date' => 'dc.coverage.temporal.en',
    'Period' => 'dc.coverage.temporalperiod.en',
    'Accession ' => 'dc.identifier.en',
    'Description' => 'dc.description.en',
    'Collection' => 'dc.relation.ispartof.en',
    'Rights Holder' => 'dc.rights.holder.en',
    'Part of' => 'dc.relation.subpartof.en',
    'Box' => 'dc.relation.boxpartof.en',
    'Extent' => 'dc.format.extenteq.en',
    'Radius' => 'dc.format.extentradius.en',
    'Stylus' => 'dc.format.extentstylus.en'

);

$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('Type' => 'type_filter', 'Author' => 'author_filter');
$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title' => 'dc.title',
    'Author' => 'dc.contributor.author.en',
    'Subject' => 'dc.subject',
    'Type' => 'dc.type');

$config['skylight_recorddisplay'] = array('Title',
    'Author',
    'Abstract',
    'Subject',
    'Date',
    'Rights Holder',
    'Part of',
    'Box');

$config['skylight_descriptiondisplay'] = array(
    'Description',
    'Notes',
    'Collection',
    'Type');

$config['skylight_creatordisplay'] = array(
    'Extent',
    'Radius',
    'Stylus');

$config['skylight_fullrecorddisplay'] = array(
    'Title',
    'Author',
    'Subject',
    'Abstract',
    'Description',
    'Other Information',
    'Notes',
    'Collection');

$config['skylight_searchresult_display'] = array('Title','Author','Subject','Abstract', 'Bitstream');


$config['skylight_search_fields'] = array(
    'Title' => 'dc.title',
    'Type' => 'dc.type',
    'Author' => 'dc.contributor.author'
);

$config['skylight_related_fields'] = array('Title' => 'dc.relation.boxpartof.en');

//only by title, no date at the moment
$config['skylight_sort_fields'] = array(
    'Author' => 'dc.contributor.author_sort ', 'Title' => 'dc.title_sort'
);
$config['skylight_default_sort'] = 'dc.title_sort+asc';


$config['skylight_feed_fields'] = array('Title' => 'Title',
    'Author' => 'Author',
    'Subject' => 'Subject',
    'Description' => 'Abstract',
    'Date' => 'Date');

$config['skylight_related_number'] = 20;
$config['skylight_results_per_page'] = 20;
$config['skylight_show_facets'] = false;
$config['skylight_share_buttons'] = false;

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

$config['skylight_highlight_fields'] = 'dc.title.en';

$config['skylight_homepage_recentitems'] = false;
$config['skylight_homepage_randomitems'] = false;
$config['skylight_homepage_fullwidth'] = true;

?>