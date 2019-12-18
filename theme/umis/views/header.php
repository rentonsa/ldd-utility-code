<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <base href="<?php echo base_url() . index_page(); if (index_page() !== '') { echo '/'; } if ($this->config->item('skylight_url_prefix') != "") { echo $this->config->item('skylight_url_prefix'); echo '/'; } ?>">

    <title><?php echo $page_title; ?></title>

    <link rel="pingback" href="<?php echo base_url() . index_page(); if (index_page() !== '') { echo '/'; } echo 'pingback'; ?>" />

    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
    Remove this if you use the .htaccess -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Coimbra Collections</title>

    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile viewport optimized: j.mp/bplateviewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/apple-touch-icon.png">

    <!-- CSS: implied media="all" -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/flowplayer-7.0.4/skin/skin.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/css/animate.css">

    <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA29rpRdgUXPQoVfAhO5KlO4cV55CMSMi0&callback=initMap" async defer></script>
    <script src="<?php echo base_url()?>assets/modernizr/modernizr-1.7.min.js"></script>
    <script src="<?php echo base_url()?>assets/jquery-1.11.0/jquery-1.11.0.min.js"></script>
    <script src="<?php echo base_url()?>assets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js"></script>
    <script src="<?php echo base_url()?>assets/jquery-1.11.0/jcarousel/jquery.jcarousel.min.js"></script>
    <script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/google-analytics/analytics.js"></script>

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

    <script>
        /* When the user clicks on the button,
         toggle between hiding and showing the dropdown content */
        function browse_types() {
            document.getElementById("types-dropdown").classList.toggle("show");
        }

        // Close the dropdown menu if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("types-dropdown");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>

    <script>
        /* When the user clicks on the button,
         toggle between hiding and showing the dropdown content */
        function browse_unis() {
            document.getElementById("unis-dropdown").classList.toggle("show");
        }

        // Close the dropdown menu if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("unis-dropdown");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
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
    <div id="loader">
        <img class="logo" src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/umis-logo.jpg">
        <h1>UMIS Virtual Exhibition</h1>
    </div>
    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="https://www.umis.ac.uk/" title="UMIS Website" alt-text="UMIS Website" target="_blank"></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li class="active dropdown"><a href="#">Home</a></li>
                    <li><a href="./about">About</a></li>
                    <li><a href="./top-picks">Our Top Picks</a></li>
                    <li><a href="./whats-on">What's On</a></li>
                    <li><button onclick="browse_unis()" class="dropbtn">Visit &#9660;</button>
                    <div id="unis-dropdown" class="dropdown-content">
                        <a href='./aberdeen'>University of Aberdeen</a>
                        <a href='./dundee'>University of Dundee</a>
                        <a href='./edinburgh'>University of Edinburgh</a>
                        <a href='./glasgow'>University of Glasgow</a>
                        <a href='./gsa'>Glasgow School of Art</a>
                        <a href='./heriot-watt'>Heriot-Watt University</a>
                        <a href='./rgu'>Robert Gordon University</a>
                        <a href='./stirling'>University of Stirling</a>
                        <a href='./st-andrews'>University of St Andrews</a>
                    </div>
                    </li>
                    <li><a href="./blog">Blog</a></li>
                    <li><a href="./contact">Contact</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">

                    <li>
                       <div class="dropdown">
                            <button onclick="browse_types()" class="dropbtn">Search Collections &#9660;</button>
                            <div id="types-dropdown" class="dropdown-content">
                                <a href='./search/subject:%22animals%22'>Animals</a>
                                <a href='./search/subject:%22architecture%22'>Architecture & Buildings</a>
                                <a href='./search/subject:%22books%22'>Books & Printing</a>
                                <a href='./search/subject:%22religion%22'>Church & Religion</a>
                                <a href='./search/subject:%22coins%22'>Coins & Medals</a>
                                <a href='./search/subject:%22design%22'>Design</a>
                                <a href='./search/subject:%22dinosaurs%22'>Dinosaurs</a>
                                <a href='./search/subject:%22earth%22'>The Earth</a>
                                <a href='./search/subject:%22history%22'>Local & Scottish History</a>
                                <a href='./search/subject:%22maps%22'>Maps & Plans</a>
                                <a href='./search/subject:%22medicine%22'>Medicine</a>
                                <a href='./search/subject:%22music%22'>Music</a>
                                <a href='./search/subject:%22paintings%22'>Paintings</a>
                                <a href='./search/subject:%22photography%22'>Photography & Film</a>
                                <a href='./search/subject:%22plants%22'>Plants & Herbs</a>
                                <a href='./search/subject:%22science%22'>Science & Scientific Instruments</a>
                                <a href='./search/subject:%22sculpture%22'>Statues & Sculpture</a>
                                <a href='./search/subject:%22teaching%22'>School & Teaching</a>
                                <a href='./search/subject:%22textiles%22'>Textiles & Embroidery</a>
                                <a href='./search/subject:%22cultures%22'>World Cultures</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/unimuseumsscot" target="_blank" alt-text="UMIS Facebook" title="UMIS Facebook"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li>
                        <a href="https://twitter.com/unimuseumsscot" target="_blank" alt-text="UMIS Twitter" title="UMIS Twitter"><i class="fa fa-twitter"></i></a>
                    </li>

                    <li class="search">
                        <form role="search" action="./redirect/" method="post">
                            <input id="uoe-search" type="text"
                                   placeholder="Search..." name="q"
                                   value="<?php if (isset($searchbox_query)) echo urldecode($searchbox_query); ?>"
                                   id="q"/><button type="submit" name="submit_search" value="Search">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



