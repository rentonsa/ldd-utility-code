<?php

$config['skylight_appname'] = 'collections';
$config['skylight_url_prefix'] = 'collections';

$config['skylight_theme'] = 'collections';

$config['skylight_fullname'] = 'Library and University Collections';

$config['skylight_adminemail'] = 'lddt@mlist.is.ed.ac.uk';

$config['skylight_oaipmhcollection'] = 'hdl_10683_4';


// Container ID and the field used in solr index to store this ID. Used for restricting search/browse scope.
$config['skylight_container_id'] = '1';
$config['skylight_container_field'] = 'location.comm';

// Global CodeIgniter ENVIRONMENT variable is set in skylight/index.php
if (ENVIRONMENT == 'development') {
    $config['skylight_link_colls'] = array(
        3   => base_url() ."art/",
        11  => base_url() ."mimed/",
        1   => base_url() ."colllevel/",
        14  => base_url() ."calendars/",
        17  => "https://test.exhibitions.ed.ac.uk/",
        64  => base_url() ."public-art/",
        48  => base_url() ."iconics/",
        51  => base_url() ."iconicsdeepzoom/",
        50  => base_url() ."anatomy/",
        84  => base_url() ."stcecilias/",
        91  => base_url() ."speccoll/",
        49  => base_url() ."cockburn/"
    );

    $config['skylight_link_titles'] = array(
        3   => "Art Collection",
        11  => "MIMEd Collection",
        1   => "a collection",
        14  => "Calendars",
        17  => "Exhibitions",
        64  => "Public Art Collection",
        48  => "Iconics Collection",
        51  => "Iconics Collection",
        50  => "Anatomy Collection",
        84  => "St Cecilia's Hall",
        91  => "Archives, Rare Books & Manuscripts",
        49  => "Cockburn Collection"
    );
}
else{
    $config['skylight_link_colls'] = array(
        3   => base_url() ."art/",
        11  => base_url() ."mimed/",
        1   => base_url() ."colllevel/",
        14  => base_url() ."calendars/",
        17  => "https://exhibitions.ed.ac.uk/",
        67  => base_url() ."public-art/",
        30  => base_url() ."iconics/",
        49  => base_url() ."stcecilias/",
        69  => base_url() ."speccoll/"
    );

    $config['skylight_link_titles'] = array(
        3   => "Art Collection",
        11  => "MIMEd Collection",
        1   => "CLDs",
        14  => "Calendars",
        17  => "Exhibitions",
        67  => "Public Art Collection",
        30  => "Iconics Collection",
        49  => "St Cecilia's Hall"
    );
}

$config['skylight_fields'] = array('Title' => 'dc.title.en',
    'Author' => 'dc.contributor.author.en',
    'Subject' => 'dc.subject.en',
    'Type' => 'dc.type.en',
    'Abstract' => 'dc.description.abstract',
    'Date' => 'dc.date.issued_dt',
    'Date Coverage'=> 'dc.coverage.temporal.en',
    'Bitstream'=> 'dc.format.original.en',
    'Thumbnail'=> 'dc.format.thumbnail.en',
    'Description'=>'dc.description.en',
    'ImageUri' => 'dc.identifier.imageUri.en',
    'OwningCollection' => 'location.coll',
    'Score' => 'float'
);

// HM 14/09/2020
// Date filtering broken in Skylight upgrade so disabling
//$config['skylight_date_filters'] = array('Date' => 'dateIssued.year_sort');
$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('Author' => 'author_filter', 'Subject' => 'subject_filter', 'Type' => 'type_filter');
$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title' => 'dc.title.en',
    'Author' => 'dc.contributor.author',
    'Abstract' => 'dc.description.abstract',
    'Subject' => 'dc.subject.en',
    'Date' => 'dc.date.issued_dt',
    'Type' => 'dc.type.en',
    'Bitstream'=> 'dc.format.original',
    'Thumbnail'=> 'dc.format.thumbnail'
);

$config['skylight_recorddisplay'] = array('Title','Author','Subject','Type','Abstract');

$config['skylight_searchresult_display'] = array('Title','Author','Subject','Type','Abstract');

$config['skylight_search_fields'] = array('Keywords' => 'text',
    'Subject' => 'dc.subject.en',
    'Type' => 'dc.type.en',
    'Author' => 'dc.contributor.author'
);

$config['skylight_sort_fields'] = array('Title' => 'dc.title',
    'Date' => 'dc.date.issued_dt',
    'Author' => 'dc.contributor.author'
);

$config['skylight_feed_fields'] = array('Title' => 'Title',
    'Author' => 'Author',
    'Subject' => 'Subject',
    'Description' => 'Abstract',
    'Date' => 'Date');

$config['skylight_results_per_page'] = 40;
$config['skylight_share_buttons'] = false;

// $config['skylight_homepage_recentitems'] = false;

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
$config['skylight_homepage_recentitems'] =false;

?>