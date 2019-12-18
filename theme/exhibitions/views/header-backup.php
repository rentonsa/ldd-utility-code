<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

        <base href="<?php echo base_url() . index_page(); if (index_page() !== '') { echo '/'; } if ($this->config->item('skylight_url_prefix') != "") { echo $this->config->item('skylight_url_prefix'); echo '/'; } ?>">

        <title><?php echo $page_title; ?></title>

        <link rel="pingback" href="<?php echo base_url() . index_page(); if (index_page() !== '') { echo '/'; } echo 'pingback'; ?>" />

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>University of Edinburgh Exhibitions </title>

        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Mobile viewport optimized: j.mp/bplateviewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/favicon.ico">
        <link rel="apple-touch-icon" href="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/apple-touch-icon.png">

        <!-- CSS: implied media="all" -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/css/style.css?v=2">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fancybox/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/flowplayer-7.0.4/skin/skin.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css">

        <!-- PARALLAX STYLES -->
        <!-- CSS FILES -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/css/parallax_styles.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/css/custom_styles.css">

        <!-- Uncomment if you are specifically targeting less enabled mobile browsers
        <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->

        <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects--> 
        <script src="<?php echo base_url()?>assets/modernizr/modernizr-1.7.min.js"></script>
        <script src="<?php echo base_url()?>assets/jquery-1.11.0/jquery-1.11.0.min.js"></script>
        <script src="<?php echo base_url()?>assets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js"></script>
        <script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url()?>assets/jquery-1.11.0/jcarousel/jquery.jcarousel.min.js"></script>
        <script src="http://www.google-analytics.com/analytics.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js"></script>
        <script src="https://cdn.rawgit.com/mejackreed/Leaflet-IIIF/master/leaflet-iiif.js"></script>
        <script src="<?php echo base_url()?>assets/openseadragon/openseadragon.min.js"></script>
        
        
        <!-- Google Analytics -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','<?php echo base_url()?>assets/google-analytics/analytics.js','ga');

            ga('create', '<?php echo $ga_code ?>', 'auto');
            ga('send', 'pageview');

        </script>
        <!-- End Google Analytics -->

        <script src="<?php echo base_url(); ?>assets/flowplayer-7.0.4/flowplayer.min.js"></script>

        <!-- global options -->
        <script>
            flowplayer.conf = {
                analytics: "<?php echo $ga_code ?>"
            };
        </script>

        <?php if (isset($solr)) { ?><link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
            <link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />

            <?php

            foreach($metafields as $label => $element) {
                $field = "";
                if(isset($recorddisplay[$label])) {
                    $field = $recorddisplay[$label];
                    if(isset($solr[$field])) {
                        $values = $solr[$field];
                        foreach($values as $value) {
                            ?>  <meta name="<?php echo $element; ?>" content="<?php echo $value; ?>"> <?php
                        }
                    }
                }
            }

        } ?>

    </head>

    <body>

    <div class="header"></div>

    <?php
    

    // Conditional to compare current and root url and serve up parallax styles accordingly
    $current_url = trim( "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}", "http");
    $base_string = trim(base_url(), "https");

    if ($current_url == $base_string) {
          
        echo 
        '
    <!-- PARALLAX WRAPPERS FOR BACKGROUND IMAGES -->
    <!-- Associated with the block before the gap appears -->

    <!-- Wrapper for head image -->
    <div
        id="head-wrapper"
        class="parallax-image-wrapper"
        data-anchor-target="#page-gap"
        data-bottom-top="transform:translateY(200%)"
        data-top-bottom="transform:translateY(0)"
        >
        <div
            class="parallax-image"
            style="background-image:url(' .  base_url() . 'theme/' . $this->config->item('skylight_theme') . '/images/background/library_entrance.jpg)"
            data-anchor-target="#page-gap"
            data-bottom-top="transform: translateY(-100%);"
            data-top-bottom="transform: translateY(50%);"
            >
        </div>
    </div>

    <!-- Wrapper for visit us image -->
    <div
        id="visit-block-wrapper"
        class="parallax-image-wrapper"
        data-anchor-target="#block-one + .gap"
        data-bottom-top="transform:translateY(200%)"
        data-top-bottom="transform:translateY(0)"
        >
        <div
            class="parallax-image"
            style="background-image:url(' .  base_url() . 'theme/' . $this->config->item('skylight_theme') . '/images/background/visit_us.png)"
            data-anchor-target="#block-one + .gap"
            data-bottom-top="transform: translateY(-80%);"
            data-top-bottom="transform: translateY(80%);"
            >
        </div>
    </div>

    <!-- Wrapper for exhibitions image -->
    <div
        id="exhibitions-block-wrapper"
        class="parallax-image-wrapper"
        data-anchor-target="#block-two + .gap"
        data-bottom-top="transform:translateY(200%)"
        data-top-bottom="transform:translateY(0)"
        >
        <div
            class="parallax-image"
            style="background-image:url(' .  base_url() . 'theme/' . $this->config->item('skylight_theme') . '/images/background/current_exhibition.jpg)"
            data-anchor-target="#block-two + .gap"
            data-bottom-top="transform: translateY(-80%);"
            data-top-bottom="transform: translateY(80%);"
            >
        </div>
    </div>

    <!--  Wrapper for events image -->
    <div
        id="events-block-wrapper"
        class="parallax-image-wrapper"
        data-anchor-target="#block-three + .gap"
        data-bottom-top="transform:translateY(200%)"
        data-top-bottom="transform:translateY(0)"
        >
        <div
            class="parallax-image"
            style="background-image:url(' .  base_url() . 'theme/' . $this->config->item('skylight_theme') . '/images/background/events.jpg)"
            data-anchor-target="#block-three + .gap"
            data-bottom-top="transform: translateY(-80%);"
            data-top-bottom="transform: translateY(80%);"
            >
        </div>
    </div>

    <div
        id="support-block-wrapper"
        class="parallax-image-wrapper"
        data-anchor-target="#block-four + .gap"
        data-bottom-top="transform:translateY(200%)"
        data-top-bottom="transform:translateY(0)"
        >
        <div
            class="parallax-image"
            style="background-image:url(' .  base_url() . 'theme/' . $this->config->item('skylight_theme') . '/images/background/support.jpg)"
            data-anchor-target="#block-four + .gap"
            data-bottom-top="transform: translateY(-80%);"
            data-top-bottom="transform: translateY(80%);"
            >
        </div>
    </div>'
        
        ;
    }
    else { echo '
        <div id="container">

            <div
                id="head-wrapper"
                class="parallax-image-wrapper"
                data-anchor-target="#page-gap"
                data-bottom-top="transform:translateY(200%)"
                data-top-bottom="transform:translateY(0)"
                >
                <div
                    class="parallax-image"
                    style="background-image:url(' .  base_url() . 'theme/' . $this->config->item('skylight_theme') . '/images/background/library_entrance.jpg)"
                    data-anchor-target="#page-gap"
                    data-bottom-top="transform: translateY(-100%);"
                    data-top-bottom="transform: translateY(50%);"
                    >
                </div>
            </div>
                <header id="page-gap" class="gap">

                <!-- MAIN UNIVERSITY LOGO -->
                <div id="non-index" class="logo-container">
                    <a href="' . base_url() . '">
                        <img src="' . base_url() . 'theme/' . $this->config->item('skylight_theme') . '/images/logos/uofe_logo.png" alt="University of Edinburgh Logo">
                    </a>
                </div>
                <!--<div id="collection-title">
                    <a href="http://www.ed.ac.uk" class="uoelogo" title="The University of Edinburgh Home" target="_blank"></a>
                    <a href="' . base_url() . '" class="exlogo" title="University of Edinburgh Exhibitions Home"></a>
                    <a href="' . base_url() . '" class="menulogo" title="University of Edinburgh Exhibitions Home"></a>
                </div>-->
                <div class="nav-search">
                    <div id="collection-search">
                        <form action="./redirect/" method="post">
                            <fieldset class="search">
                                <input type="text" name="q" value="'; 
                                if (isset($searchbox_query)){echo urldecode($searchbox_query);}
                                echo '" id="q" />
                                <a id="info-gap" href="https://exhibitions.ed.ac.uk/conectando">
                                    <button type="submit" id="submit_search" class="search-button">
                                        <p>Search</p>
                                    </button>
                                </a>
                                <!--<input type="submit" name="submit_search" class="btn" value="Search" id="submit_search" />-->
                            </fieldset>
                        </form>
                    </div>
                    <div class="nav-adv-search">
                        <div id="adv-search">
                            <a class="nav-link" href="./advanced">Advanced search</a>
                        </div>
                    </div>
		    <div class="nav-adv-search">
                        <div id="adv-search">
                            <a class="nav-link" href="./past">Past Exhibitions</a>
                        </div>
                    </div>
                    <div class="nav-adv-search">
                        <div id="adv-search">
                            <a class="nav-link" href="./search">View All Items</a>
                        </div>
                    </div>
                </div>

                <div class="block-title">
                    <h1  class="block-title-head">Library Exhibitions</h1>
                </div>
                </header>

                ';
}
        
