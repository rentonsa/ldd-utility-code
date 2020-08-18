<?php

$config['skylight_appname'] = 'mimed';

// Uncomment this if you are using a url of the form http://.../art/...
$config['skylight_url_prefix'] = 'mimed';

$config['skylight_theme'] = 'mimed';

$config['skylight_fullname'] = 'MUSICAL INSTRUMENT MUSEUMS EDINBURGH';

// set ga code
if (strpos($_SERVER['HTTP_HOST'], "test") !== false) {
    $config['skylight_ga_code'] = 'UA-25737241-6';
}
else {
    $config['skylight_ga_code'] = 'UA-25737241-9';
}

$config['skylight_adminemail'] = 'schgals@ed.ac.uk';

$config['skylight_oaipmhcollection'] = 'hdl_10683_14558';

$config['skylight_oaipmhallowed'] = true;

// Container ID and the field used in solr index to store this ID. Used for restricting search/browse scope.
if (strpos($_SERVER['HTTP_HOST'], "test") !== false) {
	$config['skylight_container_id'] = '21f59b48-a294-4960-b926-e1f56d32d90b';
}
else {
	$config['skylight_container_id'] = '11';
}
//$config['skylight_container_id'] = '11';
$config['skylight_container_field'] = 'location.coll';
$config['skylight_sitemap_type'] = 'internal';

$config['skylight_fields'] = array(
    'Title' => 'dc.title.en',
    'Alternative Title' => 'dc.title.alternative.en',
    'Maker' => 'dc.contributor.author.en',
    'Author' => 'dc.contributor.author.en',
    'Country' => 'lido.country.en',
    'City' => 'lido.city.en',
    'Subject' => 'dc.subject.en',
    'Instrument' => 'dc.type.en',
    'Abstract' => 'dc.description.abstract.en',
    'Date' => 'dc.date.created',
    'Bitstream'=> 'dc.format.original.en',
    'Thumbnail'=> 'dc.format.thumbnail.en',
    'Place Made' => 'dc.coverage.spatial.en',
    'Date Made' => 'dc.coverage.temporal.en',
    'Period' => 'dc.coverage.temporalperiod.en',
    'Accession Number' => 'dc.identifier.en',
    'Description' => 'dc.description.en',
    'Other Information' => 'dc.description.usage.en',
    'Collection' => 'dc.relation.ispartof.en',
    'Notes' => 'dc.description.cataloguernotes',
    'Measurements' => 'dc.format.extent.en',
    'Signature' => 'dc.format.signature.en',
    'Inscription' => 'dc.format.inscription.en',
    'Rights Holder' => 'dc.rights.holder.en',
    'Instrument Family' => 'dc.type.family.en',
    'Genus' => 'dc.type.genus.en',
    'Provenance' => 'dc.provenance.en',
    'Decorations' => 'dc.description.decoration.en',
    'Link' => 'dc.identifier.uri',
    'ImageUri' => 'dc.identifier.imageUri.en',
    'Permalink' => 'dc.contributor.authorpermalink'
);

$config['skylight_schema_links'] = array(
    'Title'=> 'name',
    'Alternative Title'=> 'alternativeName',
    'Maker'=> 'creator',
    'Author'=> 'author',
    'Subject'=> 'about',
    'Instrument'=> 'name',
    'Abstract'=> 'description',
    'Date'=>'dateCreated',
    'Thumbnail'=>'thumbnailUrl',
    'Place Made'=> 'locationCreated',
    'Date Made'=>'dateCreated',
    'Period'=> 'temporalCoverage',
    'Accession Number'=> 'identifier',
    'Description'=> 'description',
    'Collection' => 'isPartOf',
    'Notes'=> 'musicalKey',
    'Rights Holder'=>'copyrightHolder',
    'Instrument Family'=> 'category',
    'Link'=> 'url',
    'ImageUri'=> 'image'

);


$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('Instrument' => 'type_filter', 'Maker' => 'author_filter', 'Place Made' => 'place_filter', 'Period' => 'period_filter', 'Collection'=> 'collection_filter' );
$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title' => 'dc.title',
    'Alternative Title' => 'dc.title.alternative.en',
    'Maker' => 'dc.contributor.author.en',
    'Subject' => 'dc.subject',
    'Type' => 'dc.type');

$config['skylight_recorddisplay'] = array('Alternative Title','Instrument','Instrument Family','Maker','Subject','Abstract','Place Made','Date Made','Description','Other Information','Notes','Decorations','Measurements','Provenance','Inscription','Signature','Collection','Rights Holder','Accession Number');

$config['skylight_searchresult_display'] = array('Title','Instrument','Maker','Subject','Abstract', 'Bitstream', 'Thumbnail');


$config['skylight_search_fields'] = array(
    'Title' => 'dc.title',
    'Type' => 'dc.type',
    'Maker' => 'dc.contributor.author',
    'Place Made' => 'dc.coverage.spatial',
    'Accession Number' => 'dc.identifier.en'
);

// BUGFIX: Identifier added as a hack to prevent records missing either dc.type.en or dc.type.genus.en from passing *all* their solr data to the getRelatedItems function and overloading the URL
// We used identifier, because it shouldn't change the returned results at all, following this logic:
// 1) The search terms are quoted, so a search on the quoted identifier should only ever return the same record
// 2) The function adds a query parameter to remove matches with the same handle (to prevent the same record showing up in its own Related Items block)
// 3) Therefore, the two operations will cancel each other out and not return an additional result
// Sebastian + Mike - 10th Aug 2020
$config['skylight_related_fields'] = array('Instrument' => 'dc.type.en', 'Genus' => 'dc.type.genus.en', 'Identifier' => 'dc.identifier.en');

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

$config['skylight_results_per_page'] = 10;
$config['skylight_share_buttons'] = false;

$config['skylight_homepage_recentitems'] = false;

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
