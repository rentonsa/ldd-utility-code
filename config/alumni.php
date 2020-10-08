<?php

$config['skylight_appname'] = 'alumni';

$config['skylight_theme'] = 'alumni';

// Uncomment this if you are using a url of the form http://.../art/...
$config['skylight_url_prefix'] = 'alumni';

$config['skylight_fullname'] = 'University of Edinburgh Historical Alumni';

$config['skylight_adminemail'] = 'is-crc@ed.ac.uk';

$config['skylight_oaipmhcollection'] = 'hdl_10683_47417';

$config['skylight_oaipmhallowed'] = true;


// Global CodeIgniter ENVIRONMENT variable is set in skylight/index.php
// Container ID and the field used in solr index to store this ID. Used for restricting search/browse scope.
if (ENVIRONMENT == 'development') {
    $config['skylight_container_id'] = '8f5e9ab3-98cb-4665-b911-4507a72bb788';
    $config['skylight_ga_code'] = 'UA-25737241-6';
}
else {
    $config['skylight_container_id'] = '13';
    $config['skylight_ga_code'] = 'UA-25737241-9';
}

$config['skylight_container_field'] = 'location.comm';
$config['skylight_sitemap_type'] = 'internal';

$config['skylight_fields'] = array('Name' => 'dc.contributor.author.en',
    'Title' => 'dc.title.en',
    'Bitstream'=> 'dc.format.original.en',
    'Thumbnail'=> 'dc.format.thumbnail.en',
    'Description'=>'dc.description.en',
//    'Year'=> 'dc.date.issued',
    'Birthplace' => 'dc.contributor.authorplace.en',
    'Previous School Education' => 'dc.description.schoolprev.en',
    'Matriculation Number' => 'dc.identifier.matric',
    'Gender' => 'dc.contributor.authorgender.en',
    'Age' => 'dc.contributor.authorage',
    'Faculty' => 'dc.description.faculty.en',
    'Nationality' => 'dc.contributor.authorcountry.en',
    'Year'=>'dc.coverage.temporal.en',
    'Collection'=>'dc.relation.ispartof.en',
    'Date of award'=>'dc.coverage.temporalaward.en',
    'Award'=>'dc.description.award.en',
    'Source information'=>'dc.description.source.en',
    'Notes'=>'dc.description.noqual.en',
    'Previous medical education'=>'dc.description.medprev.en',
    'Previous University education'=>'dc.description.univprev.en',
    'Address'=>'dc.description.address.en',
    'Thesis'=>'dc.description.thesis.en',
    'Salutation'=>'dc.contributor.authortitle.en',
    'Apprentice of Royal College of Surgeons'=>'dc.coverage.temporalarcs.en',
    'Diplomate of Royal College of Surgeons'=>'dc.coverage.temporaldrcs.en',
    'Fellow of Royal College of Surgeons'=>'dc.coverage.temporalfrcs.en',
    'Indian Medical Service'=>'dc.coverage.temporalims.en',
    'MD (Edin)'=>'dc.coverage.temporalmdedin.en',
    'British Navy'=>'dc.coverage.temporalnavy.en',
    'Royal Army Medical Corps'=>'dc.coverage.temporalramc.en',
    'Royal Medical Society'=>'dc.coverage.temporalrms.en',
    'Span of study'=>'dc.coverage.temporalstudyspan.en',
    'First year of study'=>'dc.coverage.temporalyear1.en',
    'Year 2'=>'dc.coverage.temporalyear2.en',
    'Year 3'=>'dc.coverage.temporalyear3.en',
    'Year 4'=>'dc.coverage.temporalyear4.en',
    'Year 5'=>'dc.coverage.temporalyear5.en',
    'Year 6'=>'dc.coverage.temporalyear6.en',
    'Year 7'=>'dc.coverage.temporalyear7.en',
    'Date of enrolment'=>'dc.date.enrolled.en',
    'Class'=>'dc.description.class.en',
    'Additional information'=>'dc.description.other.en',
    'Register no'=>'dc.identifier.register.en',
    'Annals'=>'dc.relation.ispartofannals.en',
    'Robb'=>'dc.relation.ispartofrobb.en',
    'Watt'=>'dc.relation.ispartofwatt.en',
    'Destination after study'=>'dc.coverage.spatial.en',
    'Subject'=>'dc.subject.en',
    'Date of birth'=>'dc.coverage.temporalbirth.en',
    'Date of death'=>'dc.coverage.temporaldeath.en'
);

// Static pages for collections
$config['skylight_static_pages'] = array('Students of Medicine, 1762-1826'=>'rosner',
    'First Matriculations, 1890-1899'=>'firstmat',
    'Students at New College, 1843-1943'=>'newcoll',
    'Extra Academical students, 1887-1922'=>'extraac',
    'Graduates in Veterinary Medicine, 1911-1955'=>'vetgrad',
    'Students of Medicine (sample of 205), 1833-1846'=>'medsample',
    'Awards to Women students, 1876-1894'=>'women',
    'Early Veterinary Graduates, 1825-1865'=>'earlyvet',
    'Female Medical Graduates 1896-1900'=>'femalegrad',
    'University of Edinburgh: Roll of Honour, WW1'=>'ww1roll'
    )
;

$config['skylight_date_filters'] = array();
//$config['skylight_date_filters'] = array('Date' => 'datetemporal_filter');
$config['skylight_filters'] = array('Collection' => 'collection_filter', 'Year' => 'datetemporal_filter');

$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title' => 'dc.title',
    'Subject' => 'dc.subject',
    'Type' => 'dc.type',
);

$config['skylight_recorddisplay'] = array(
    'Subject',
    'Description',
    'Birthplace',
    'Previous School Education',
    'Matriculation Number',
    'Gender',
    'Age',
    'Faculty',
    'Nationality',
    'First year of study',
    'Collection',
    'Date of award',
    'Award',
    'Source information',
    'Notes',
    'Previous medical education',
    'Previous University education',
    'Address',
    'Thesis',
    'Salutation',
    'Apprentice of Royal College of Surgeons',
    'Diplomate of Royal Colleg of Surgeons',
    'Fellow of Royal College of Surgeons',
    'Indian Medical Service',
    'MD (Edin)',
    'British Navy',
    'Royal Army Medical Corps',
    'Royal Medical Society',
    'Span of study',
    'Year 2',
    'Year 3',
    'Year 4',
    'Year 5',
    'Year 6',
    'Year 7',
    'Date of enrolment',
    'Class',
    'Additional information',
    'Register no',
    'Annals',
    'Robb',
    'Watt',
    'Destination after study',
    'Date of birth',
    'Date of death');

$config['skylight_searchresult_display'] = array('Title','Subject','Type','Bitstream', 'Thumbnail', 'Year', 'Collection');

$config['skylight_search_fields'] = array(
    'Collection' => 'dc.collection.en',
    'Year' => 'dc.coverage.temporal.en'
);
$config['skylight_default_sort'] = 'dc.title_sort+asc';

$config['skylight_related_fields'] = array('Subject' => 'dc.subject.en', 'Title' => 'dc.title.en');
$config['skylight_related_number'] = 10;

$config['skylight_sort_fields'] = array('Surname' => 'dc.title_sort'
);

$config['skylight_feed_fields'] = array('Title' => 'Title',
    'Subject' => 'Subject',
    'Identifier' => 'Identifier');

$config['skylight_results_per_page'] = 10;
$config['skylight_share_buttons'] = false;

// $config['skylight_homepage_recentitems'] = false;

// Set to the number of minutes to cache pages for. Set to false for no caching.
// This overrides the setting in skylight.php so is commented by default
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
$config['skylight_highlight_fields'] = 'dc.title.en,dc.subject.en,dc.description.en';

$config['skylight_homepage_recentitems'] = false;
$config['skylight_homepage_fullwidth'] = false;
?>