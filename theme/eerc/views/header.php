<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <base href="<?php echo base_url() . index_page(); if (index_page() !== '') { echo '/'; } echo $this->config->item('skylight_url_prefix'); echo '/' ?>">
        <?php
            $strip_title = strip_tags($page_title);
            if(substr($strip_title, -2, 1) == ',') {
                $page_title = substr($strip_title, 0, strlen($strip_title) - 2) . substr($strip_title, -1);
            }

            $pt = trim(strip_tags($page_title));

            if($pt == "Resp") {
                $pt = "Regional Ethnology Scotland Archive Project";
            }
            else if($pt == "Using") {
                $pt = "Searching and Using the Collection";
            }
            else if($pt == "Overview") {
                $pt = "Browse the Collections";
            }
        ?>

        <title><?php echo $pt; ?></title>

        <link rel="pingback" href="<?php echo base_url() . index_page(); if (index_page() !== '') { echo '/'; } echo 'pingback'; ?>" />

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <meta name="description" content="The purpose of the Regional Ethnology of Scotland Project (RESP) is to enable communities across Scotland to work together to record information about their local life and society. This work is carried out on a regional basis by conducting fieldwork interviews. The RESP is managed by the European Ethnological Research Centre (EERC) at the University of Edinburgh. In conducting the RESP, the EERC works in partnership with individuals and organisations such as local authority library and archive services, voluntary organisations and schools.">
        <meta name="author" content="The European Ethnological Research Centre">
        <meta name="title" content="<?= $pt ?>">

        <!-- Mobile viewport optimized: j.mp/bplateviewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/favicon.ico">
        <link rel="apple-touch-icon" href="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/apple-touch-icon.png">

        <!-- CSS: implied media="all" -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fancybox/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/css/style.css?v=2">
        <link href="https://fonts.googleapis.com/css?family=Special+Elite" rel="stylesheet">

        <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
        <script src="<?php echo base_url()?>assets/modernizr/modernizr-1.7.min.js"></script>
        <script src="<?php echo base_url()?>assets/jquery-1.11.0/jquery-1.11.0.min.js"></script>
        <script src="<?php echo base_url()?>assets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js"></script>
        <script src="<?php echo base_url()?>assets/jquery-1.11.0/jcarousel/jquery.jcarousel.min.js"></script>
        <script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>

        <!-- Justified image gallery, https://github.com/nitinhayaran/Justified.js.git -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/css/jquery.justified.css">
        <script src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/js/jquery.justified.min.js"></script>

        <!-- A lightweight jQuery plugin for collapsing and expanding long blocks of text with "Read more" and "Close" links. https://github.com/jedfoster/Readmore.js -->
        <script src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/js/readmore.min.js"></script>

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
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="./" title="EERC Home Link">Home</a></li>
                        <li><a href="./overview" title="Browse the Collections Link">Browse the Collections</a></li>
                        <li><a href="./people" title="People Link">People</a></li>
                        <li><a href="./resp" title="Regional Ethnology Scotland Archive Project">RESP Archive Project</a></li>
                        <li><a href="./using" title="Searching and Using the Collection">Searching and Using the Collection</a></li>
                        <li><a href="./contact" title="Contact">Contact</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <header>
            <div class="container">

                <div class="header-normal">
                    <div><a href="./" class="eerc-logo" title="Regional Ethnology of Scotland Project homepage"></a></div>
                    <div id="collection-title"><a href="./" title="Regional Ethnology of Scotland Project homepage">Regional Ethnology<br>of Scotland Project</a>
                    </div>

                    <div id="collection-search">
                        <form action="./redirect/" method="post" class="navbar-form">
                            <div class="input-group search-box">
                                <input type="text" aria-label="Search" class="form-control" placeholder="Search" name="q" value="<?php if (isset($searchbox_query)) echo urldecode($searchbox_query); ?>" id="q" />
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default" name="submit_search" value="Search" id="submit_search"><i class="glyphicon glyphicon-search"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="container content">
