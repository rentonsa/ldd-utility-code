<?php

$config['skylight_appname'] = 'jlss';

// Uncomment this if you are using a url of the form http://.../art/...
//$config['skylight_url_prefix'] = 'jlss';

// set ga code
if (strpos($_SERVER['HTTP_HOST'], "test") !== false || strpos($_SERVER['HTTP_HOST'], "localhost") !== false) {
    $config['skylight_ga_code'] = 'UA-25737241-6';
    $config['skylight_container_id'] = 'e78a064c-8d18-4e96-a160-f4e58a58cb39';
    $config['skylight_image_server'] = 'https://test.cantaloupe.is.ed.ac.uk';
    $config['base_url'] = 'https://test.sjac-collection.is.ed.ac.uk/';
}
else {
    $config['skylight_ga_code'] = 'UA-25737241-14';
    $config['skylight_container_id'] = '77';
    $config['skylight_image_server'] = 'https://cantaloupe.is.ed.ac.uk';
    $config['base_url'] = 'https://sjac-collection.is.ed.ac.uk/';
}

$config['skylight_adminemail'] = 'is-crc@ed.ac.uk';

$config['skylight_theme'] = 'jlss';

$config['skylight_fullname'] = 'Jewish Lives Scottish Spaces';

$config['skylight_adminemail'] = 'lddt@mlist.is.ed.ac.uk';

$config['skylight_oaipmhcollection'] = '';

$config['skylight_oaipmhallowed'] = true;

$config['skylight_container_field'] = 'location.coll';

$config['skylight_fields'] = array(
    'Title' => 'dc.title.en',
    'Alternative Title' => 'dc.title.alternative.en',
    'Artist' => 'dc.contributor.authorfull.en',
    'Author' => 'dc.contributor.author.en',
    'Classification' => 'dc.subject.classification.en',
    'Type' => 'dc.type.en',
    'Abstract' => 'dc.description.abstract.en',
    'OldDate' => 'dc.coverage.temporal.en',
    'Bitstream'=> 'dc.format.original.en',
    'Thumbnail'=> 'dc.format.thumbnail.en',
    'Description'=>'dc.description.en',
    'Rights' => 'dc.rights.holder.en',
    'Accession Number'=> 'dc.identifier.en',
    'Collection' => 'dc.relation.ispartof.en',
    'Provenance' => 'dc.description.provenance',
    'Material' => 'dc.format.en',
    'Dimensions' => 'dc.format.extent.en',
    'Signature' => 'dc.format.signature.en',
    'Inscription' => 'dc.format.inscription.en',
    'Subject' => 'dc.subject.en',
    'Place Made' => 'dc.coverage.spatial.en',
    'Period' => 'dc.coverage.temporalperiod.en',
    'Link' => 'dc.identifier.uri',
    'Tags' => 'dc.subject.crowdsourced.en',
    'ImageUri' => 'dc.identifier.imageUri.en',
    'Permalink' => 'dc.contributor.authorpermalink.en',
    'SketchFabURI' => 'dc.identifier.sketchuri.en',
    'Collection-Description' => 'dc.description.other.en',
    'ItemImage' => 'dc.format.bitstream.en',
    'Date' => 'dc.date.created.en',
);

$config['skylight_schema_links'] = array(
    'Title'=> 'name',
    'Alternative Title'=> 'alternativeName',
    'Artist'=> 'creator',
    'Author'=> 'creator',
    'Classification'=> 'keywords',
    'Date'=>'dateCreated',
    'Thumbnail'=>'thumbnailUrl',
    'Description'=> 'description',
    'Rights'=>'copyrightHolder',
    'Accession Number'=> 'identifier',
    'Collection'=> 'isPartOf',
    'Material'=>'material',
    'Signature'=> 'creator',
    'Subject'=> 'about',
    'Place Made'=> 'locationCreated',
    'Period'=> 'temporalCoverage',
    'Link'=> 'url',
    'ImageUri'=> 'image',
    'Tags'=> 'keywords',
    'ItemDate' => 'itemDate'

);

$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('Collection'=> 'collection_filter');

$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array(
    'Title' => 'dc.title.en',
    'Artist' => 'dc.contributor.authorfull.en',
    'Description' => 'dc.description.en',
    'Classification' => 'dc.subject.classification.en',
    'Date' => 'dc.coverage.temporal.en',
    'Type' => 'dc.type.en',
    'Tags' => 'dc.subject.crowdsourced.en',
);

$config['skylight_recorddisplay'] = array( 'Permalink','Artist','Title','Alternative Title','OldDate','Period','Description','Material','Dimensions','Type','Place Made','Date','Subject','Collection','Classification','Signature', 'Inscription','Accession Number');

$config['skylight_searchresult_display'] = array('Author','Title','Medium','Type','Description', 'Bitstream', 'Thumbnail', 'Date');

$config['skylight_search_fields'] = array(
    'Artist' => 'dc.contributor.author.en',
    'Title' => 'dc.title.en',
    'Classification' => 'dc.subject.en',
    'Accession Number'=> 'dc.identifier.en',
    'Tags' => 'dc.subject.crowdsourced.en'
);

$config['skylight_related_fields'] = array('Artist' => 'dc.contributor.authorfull.en', 'Subject' => 'dc.subject.en');
$config['skylight_related_number'] = 5;

$config['skylight_sort_fields'] = array(
    'Subject' => 'dc.subject_sort ', 'Title' => 'dc.title_sort'
);

$config['skylight_default_sort'] = 'dc.contributor.author_sort+asc';

$config['skylight_feed_fields'] = array('Title' => 'Title',
    'Artist' => 'Artist',
    'Classification' => 'Classification',
    'Description' => 'Description',
    'Date' => 'Date');


$config['skylight_results_per_page'] = 10;
$config['skylight_share_buttons'] = false;

$config['skylight_facet_limit'] = 15;

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
