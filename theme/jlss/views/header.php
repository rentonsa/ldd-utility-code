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

        <title><?php echo strip_tags($page_title); ?></title>

        <link rel="pingback" href="<?php echo base_url() . index_page(); if (index_page() !== '') { echo '/'; } echo 'pingback'; ?>" />

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>University of Edinburgh <?php echo $this->config->item('skylight_fullname');?></title>

        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="title" content=<?php echo $page_title; ?>>

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
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/flowplayer-7.0.4/skin/skin.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/css/style.css?v=2">
        <link rel="stylesheet" href="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/css/picgallery.css">
 
        <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
        <script src="<?php echo base_url()?>assets/modernizr/modernizr-1.7.min.js"></script>
        <script src="<?php echo base_url()?>assets/jquery-1.11.0/jquery-1.11.0.min.js"></script>
        <script src="<?php echo base_url()?>assets/jquery-ui-1.10.4/ui/minified/jquery-ui.min.js"></script>
        <script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url()?>assets/jquery-1.11.0/jcarousel/jquery.jcarousel.min.js"></script>
        <script src="<?php echo base_url()?>assets/google-analytics/analytics.js"></script>
        <script src="<?php echo base_url()?>assets/openseadragon/openseadragon.min.js"></script>

        <!-- JavaScript for disabling right-click on page to protect images -->
        <script>
        var isNS = (navigator.appName == "Netscape") ? 1 : 0;

        if(navigator.appName == "Netscape") document.captureEvents(Event.MOUSEDOWN||Event.MOUSEUP);

        function mischandler(){
        return false;
        }

        function mousehandler(e){
        var myevent = (isNS) ? e : event;
        var eventbutton = (isNS) ? myevent.which : myevent.button;
        if((eventbutton==2)||(eventbutton==3)) return false;
        }
        document.oncontextmenu = mischandler;
        document.onmousedown = mousehandler;
        document.onmouseup = mousehandler;
        </script>

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
                        <li><a href="./" title="Scottish Jewish Archives Centre">Home</a></li>
                        <li><a href="./about" title="About Link">About</a></li>
                        <li><a href="https://www.sjac.org.uk/" title="SJAC Home Page" target="_blank">SJAC</a></li>
                        <li><a href="http://jewishmigrationtoscotland.is.ed.ac.uk/" title="JLSS Blog Link" target="_blank">JLSS Blog</a></li>
                        <!--<li><a href="./contact" title="Contact Details">Contact</a></li>-->
                        <li><a href="https://www.sjac.org.uk/about/donations/" title="Donate" target="_blank">Donate</a></li>
                        <li><a href="./feedback" title="Feedback Form">Feedback</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <header>
            <div class="container">

                <div class="header-normal">
                    <a href="<?php echo base_url() .'jlss'; ?>">
                        <div id="collection-title">Scottish Jewish Archives Centre <br>
                            <div id="collection-sub-title">Digital Collection </div>
                        </div>
                    </a>
                        
                    <div id="collection-logo">
                        <a href="<?php echo base_url() . 'jlss'; ?>">
                            <img src="<?php echo base_url(); ?>theme/<?php echo $this->config->item('skylight_theme'); ?>/images/sjac_logo.png" alt="Scottish Jewish Archives Logo" class="img-responsive pull-right img-circle">
                        </a>
                    </div>
                    
                </div>

                <div class="content-divider"><p>divider</p></div>
                
            </div>
        </header>

        <div class="container content">