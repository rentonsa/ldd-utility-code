<?php

$config['skylight_appname'] = 'stcecilias';

// Uncomment this if you are using a url of the form http://.../art/...
$config['skylight_url_prefix'] = 'stcecilias';

$config['skylight_theme'] = 'stcecilia';

$config['skylight_fullname'] = 'St Cecilia\'s Hall';

// Global CodeIgniter ENVIRONMENT variable is set in skylight/index.php
if (ENVIRONMENT == 'development') {
    $config['skylight_ga_code'] = '';
    $config['skylight_container_id'] = 'bac433ed-36a9-4660-b49c-49d3fd0bed2c';
}
else {
    $config['skylight_ga_code'] = 'UA-25737241-9';

    $config['skylight_container_id'] = '5f407bc8-1f6c-4ab7-830a-66fac8e07c7f'; // This is the correct container_id mate, seriously
}

$config['skylight_adminemail'] = 'lddt@mlist.is.ed.ac.uk';

$config['skylight_oaipmhcollection'] = 'hdl_10683_14558';

$config['skylight_oaipmhallowed'] = true;

$config['skylight_container_field'] = 'location.coll';
$config['skylight_sitemap_type'] = 'internal';

$config['skylight_fields'] = array(
    'Title' => 'dc.title.en',
    'Alternative Title' => 'dc.title.alternative.en',
    'Maker' => 'dc.contributor.author.en',
    'Author' => 'dc.contributor.author.en',
    'Country' => 'dc.coverage.spatialcountry.en',
    'City' => 'dc.coveragespatialcity.en',
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
    'Technical Description' => 'dc.description.en',
    'Other Information' => 'dc.description.usage.en',
    'Collection' => 'dc.relation.ispartof.en',
    'Notes' => 'dc.description.cataloguernotes',
    'Measurements' => 'dc.format.extent.en',
    'Signature Date' => 'dc.format.signature.en',
    'Inscription' => 'dc.format.inscription.en',
    'Rights Holder' => 'dc.rights.holder.en',
    'Instrument Family' => 'dc.type.family.en',
    'Genus' => 'dc.type.genus.en',
    'Provenance' => 'dc.provenance.en',
    'Decorations' => 'dc.description.decoration.en',
    'Link' => 'dc.identifier.uri.en',
    'Maker Biography' => 'dc.contributor.authorbio.en',
    'Associated Musician Name' => 'dc.contributor.assocfull.en',
    'Associated Musician' => 'dc.contributor.assoc.en',
    'Piccolo Description' => 'dc.description.piccolo.en',
    'Short Description' => 'dc.description.level1.en',
    'Description' => 'dc.description.level2.en',
    'Associated Musician Biography' => 'dc.contributor.assocbio.en',
    'Instrument Type' => 'dc.type.desc.en',
    'Instrument Type History' => 'dc.type.history.en',
    'ImageURI' => 'dc.identifier.imageUri',
    'Rights Statement' => 'dc.rights.en',
    'Case' => 'dc.coverage.spatialcase.en',
    'Gallery' => 'dc.coverage.spatialgallery.en',
    'Maker Name' => 'dc.contributor.authorfull.en',
    'Hornbostel Sachs Classification' => 'dc.subject.classification.en',
    'Grouping' => 'dc.coverage.spatiallogical.en',
    'Specific Type' => 'dc.type.specific.en',
);

$config['skylight_schema_links'] = array(
    'Title' => 'name',
    'Alternative Title' => 'alternateName',
    'Author' => 'creator',
    'Subject' => 'about',
    'Instrument' => 'name',
    //'Abstract' => 'description',
    'Date' => 'dateCreated',
    'Thumbnail' => 'thumbnailUrl',
    'Place Made' => 'locationCreated',
    'Date Made' => 'dateCreated',
    'Period' => 'temporalCoverage',
    'Accession Number' => 'identifier',
    'Technical Description' => 'description',
    'Collection' => 'isPartOf',
    'Notes' => 'musicalKey',
    'Rights Holder' => 'copyrightHolder',
    'Instrument Family' => 'category',
    'Genus' => 'category',
    'Link' => 'url',
    //'Maker Biography' => 'description',
    'Associated Musician Name' => 'creator',
    'Associated Musician' => 'creator',
    //'Piccolo Description' => 'description',
    //'Short Description' => 'description',
    'Description'=> 'description',
    //'Associated Musician Biography' => 'description',
    'Instrument Type' => 'Category',
    'ImageURI' => 'image',
    'Rights Statement' => 'copyrightHolder',
    'Case' => 'location',
    'Gallery'=> 'location',
    'Maker Name' => 'creator',
    'Hornbostel Sachs Classification' => 'identifier'
);


$config['skylight_recorddisplay'] = array(
    'Title',
    'Alternative Title',
    'Instrument',
    'Instrument Family',
    'Maker',
    'Subject',
    'Place Made',
    'Date Made',
    'Measurements (in mm)',
    'Inscription',
    'Author',
    'Country',
    'City',
    'Subject',
    'Abstract',
    'Date',
    'Period',
    'Accession Number',
    'Technical Description',
    'Other Information',
    'Collection',
    'Notes',
    'Signature',
    'Rights Holder',
    'Genus',
    'Provenance',
    'Decorations',
    'Maker Biography',
    'Associated Musician Full',
    'Associated Musician',
    'Piccolo Description',
    'Short Description',
    'Description',
    'Associated Musician Biography',
    'Instrument Type',
    'Instrument Type History');

$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('Instrument' => 'type_filter', 'Maker' => 'author_filter', 'Place Made' => 'place_filter', 'Gallery' => 'gallery_filter');
$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title',
    'Alternative Title',
    'Maker',
    'Subject',
    'Type');

$config['skylight_identificationdisplay'] = array(
    'Title',
    'Alternative Title',
    'Accession Number',
    'Collection',
    'Inscription',
    'Rights Statement'
);

$config['skylight_locationdisplay'] = array(
    'Gallery',
    'Case'
);

$config['skylight_descriptiondisplay'] = array(
    'Short Description',
    'Description'
    );

$config['skylight_descriptiondatadisplay'] = array(
    'Decorations',
    'Other Information',
    'Technical Description',
    'Provenance');

$config['skylight_measurementdisplay'] = array(
    'Measurements');

$config['skylight_placedisplay'] = array(
    'City',
    'Country');

$config['skylight_creatordisplay'] = array(
    'Maker Name',
    'Maker Biography',);

$config['skylight_typedisplay'] = array(
    'Instrument',
    'Genus',
    'Instrument Family',
    'Grouping',
    'Hornbostel Sachs Classification',
    'Specific Type');

$config['skylight_datedisplay'] = array(
    'Date Made',
    'Period',
    'Signature Date');

$config['skylight_associationdisplay'] = array(
    'Associated Musician Full',
    'Associated Musician',
    'Associated Musician Biography',);

$config['skylight_searchresult_display'] = array('Title','Instrument','Maker','Subject','Abstract','Bitstream','Thumbnail');

$config['skylight_search_fields'] = array(
    'Title' => 'dc.title',
    'Type' => 'dc.type',
    'Maker' => 'dc.contributor.author',
    'Place Made' => 'dc.coverage.spatial',
    'Accession Number' => 'dc.identifier.en'
);

$config['skylight_related_fields'] = array('Instrument' => 'dc.type.en');

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

$config['skylight_related_number'] = 6;
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
$config['skylight_language_options'] = array('en');

$config['skylight_highlight_fields'] = 'dc.title.en,dc.contributor.author,dc.subject.en,lido.country.en,dc.description.en,dc.relation.ispartof.en';

$config['skylight_homepage_recentitems'] = false;
$config['skylight_homepage_randomitems'] = false;
$config['skylight_homepage_fullwidth'] = true;

?>
