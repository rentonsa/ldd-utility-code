<?php

if (strpos($_SERVER['HTTP_HOST'], "test") !== false || strpos($_SERVER['HTTP_HOST'], "localhost") !== false) {
    $config['skylight_ga_code'] = 'UA-25737241-6';
    $config['skylight_container_id'] = '83';
    $config['skylight_image_server'] = 'https://test.cantaloupe.is.ed.ac.uk';
}
else {
    $config['skylight_ga_code'] = 'UA-25737241-6';
    $config['skylight_container_id'] = '79';
    $config['skylight_image_server'] = 'https://cantaloupe.is.ed.ac.uk';
}

$config['skylight_appname'] = 'umis';

// Uncomment this if you are using a url of the form http://.../art/...
$config['skylight_url_prefix'] = 'umis';

$config['skylight_theme'] = 'umis';

$config['skylight_fullname'] = 'UMIS Virtual Exhibition';

$config['skylight_adminemail'] = 'lddt@mlist.is.ed.ac.uk';

$config['skylight_oaipmhcollection'] = 'hdl_10683_53855';

$config['skylight_oaipmhallowed'] = true;

// Container ID and the field used in solr index to store this ID. Used for restricting search/browse scope.

$config['skylight_container_field'] = 'location.coll';
//$config['skylight_container_id'] = '62';
$config['skylight_sitemap_type'] = 'internal';

$config['skylight_fields'] = array(
    'ID'                                    => 'dc.identifier.en',
    'Title'                                 => 'dc.title.en',
    'Finding Info'                          => 'dc.description.abstract.en',
    'Description'                           => 'dc.description.en',
    'Metadata Rights'                       => 'dc.rights.en',
    'Image File Name'                       => 'dc.format.bitstream.en',
    'Logo'                                  => 'dc.format.original.en',
    'Tags'                                  => 'dc.subject.en',
    'Category'                              => 'dc.relation.ispartofexhibition.en',
    'Logo Thumbnail'                        => 'dc.format.thumbnail.en',
    'Institutional Web URL'                 => 'dc.relation.uri.en',
    'Institutional Map Reference'           => 'dc.coverage.spatial.en',
    'Contact email'                         => 'dc.contributor.otheremail.en',
    'Additional info'                       => 'dc.title.alternative.en',
    'Institution'                           => 'dc.relation.ispartof.en'
);

$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('Category' => 'exhibition_filter', 'Institution'=> 'collection_filter', 'Tags' => 'subject_filter'); //TODO
$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title' => 'dc.title',
    'Alternative Title' => 'dc.title.alternative.en',
    'Maker' => 'dc.contributor.author.en',
    'Subject' => 'dc.subject',
    'Type' => 'dc.type');

$config['skylight_recorddisplay'] = array(
    'ID',
    'Title' ,
    'Finding Info',
    'Description',
    'Metadata Rights',
    'Image File Name',
    'Logo',
    'Tags',
    'Category',
    'Logo Thumbnail',
    'Institutional Web URL',
    'Institutional Map Reference',
    'Contact email',
    'Additional info',
    'Institution'
);


/*$config['skylight_descriptiondisplay'] = array(
    'Dimensions',
    'Material/Medium',
    'Category',
    'Physical Location',
    'Featured image',
    'Image License',
    'Image Rights Holder',
    'Photographic Credits',
    'Metadata Rights',
    'Contact email');*/

$config['skylight_searchresult_display'] = array('Title','Institution');


$config['skylight_search_fields'] = array(
    'Title' => 'dc.title',
    'Subject' => 'dc.type',
);

$config['skylight_related_fields'] = array('Institution' => 'dc.relation.ispartof');

//only by title, no date at the moment
$config['skylight_sort_fields'] = array(
    'Maker' => 'dc.contributor.author_sort ', 'Title' => 'dc.title_sort'
);
$config['skylight_default_sort'] = 'dc.title_sort+asc';

$config['skylight_feed_fields'] = array('Title' => 'Title',
    'Author' => 'Author',
    'Maker' => 'Maker',
    'Subject' => 'Subject',
    'Country' => 'Country',
    'Description' => 'Abstract',
    'Date' => 'Date');

$config['skylight_related_number'] = 20;
$config['skylight_results_per_page'] = 80;
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

$config['skylight_highlight_fields'] = 'dc.title.en,dc.contributor.author,dc.subject.en,lido.country.en,dc.description.en,dc.relation.ispartof.en';

$config['skylight_homepage_recentitems'] = false;
$config['skylight_homepage_randomitems'] = false;
$config['skylight_homepage_fullwidth'] = true;

?>