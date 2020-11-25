<div class="container-fluid">

    <!-- Include custom sidebar --> 
    <?php include 'poa_sidebar.php'; ?> 
    <!-- Include custom sidebar -->

    <div id="poa_banner">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <!--<img class="img-responsive sch-logo" alt="Points of Arrival logo" src="<?php echo base_url(); ?>theme/pointsofarrival/images/site-logos/navbar-logo-b.png">-->
            <p class="index-para">
                <a href="https://media.ed.ac.uk/playlist/dedicated/143796462/0_b0sex7tl/0_5h16vc0r" title="External link to Points of Arrival video playlist">Points of Arrival</a> 
                is a series of five short films about Jewish migration to Scotland in the 19th and 20th centuries. 
                Each film tells the story of one person – in their own words and also through a contemporary narrator who shares a connection.
            </p>
            <br>
            <p class="index-para">
                The films are part of the work of the AHRC-funded project Jewish Lives, Scottish Spaces: Jewish Migration to Scotland, 1880-1950, 
                and they were produced by documentary film-maker Chris Leslie, whose artistry, imagination and respect for his subject brings alive each of these five histories.
            </p>
        </div>
        <div id="galleries" class="grid"<?php /* Prevent script from loading on homepage */ if($this->config->item('skylight_appname') != str_replace('/', '', $_SERVER['REQUEST_URI'])) { ?> data-masonry='{ "itemSelector": ".grid-item index-grid", "percentPosition": true, "columnWidth": .grid-sizer}'<?php } ?>>
            <div class="grid-sizer"></div>
            <a href="./introduction">
                <div id="galleryethst" class="grid-item index-grid">
                    <div class="gallery-title">
                        <img class="text-hover thht" id="thht-hov" src="<?php echo base_url()?>theme/pointsofarrival/images/site-text-overlays/howto-hover.png">
                        <img class="text-overlay thht" src="<?php echo base_url()?>theme/pointsofarrival/images/site-text-overlays/howto-overlay.png">
                    </div>
                    <div class="mob-title">
                        <img class="text-hover" src="<?php echo base_url()?>theme/pointsofarrival/images/site-text-overlays/howto-hover.png">
                    </div>
                </div>
            </a>
            <a href="./films">
                <div id="gallerykb" class="grid-item index-grid">
                    <div class="gallery-title">
                        <img class="text-hover" src="<?php echo base_url()?>theme/pointsofarrival/images/site-text-overlays/films-hover.png">
                        <img class="text-overlay" src="<?php echo base_url()?>theme/pointsofarrival/images/site-text-overlays/films-overlay.png">
                    </div>
                    <div class="mob-title">
                        <img class="text-hover" src="<?php echo base_url()?>theme/pointsofarrival/images/site-text-overlays/films-hover.png">
                    </div>
                </div>
            </a>
            <a href="./themes">
                <div id="gallerywespe" class="grid-item index-grid">
                    <div class="gallery-title">
                        <img class="text-hover thht" id="thht-hov" src="<?php echo base_url()?>theme/pointsofarrival/images/site-text-overlays/themes-hover.png">  
                        <img class="text-overlay thht" src="<?php echo base_url()?>theme/pointsofarrival/images/site-text-overlays/themes-overlay.png">  
                    </div>
                    <div class="mob-title">
                        <img class="text-hover" src="<?php echo base_url()?>theme/pointsofarrival/images/site-text-overlays/themes-hover.png">
                    </div>
                </div>
            </a>
            <a href="./resources">
                <div id="galleryethpe" class="grid-item index-grid">
                    <div class="gallery-title">
                        <img class="text-hover rsrc" id="rsrc-hov" src="<?php echo base_url()?>theme/pointsofarrival/images/site-text-overlays/resources-hover.png">
                        <img class="text-overlay rsrc" src="<?php echo base_url()?>theme/pointsofarrival/images/site-text-overlays/resources-overlay.png">
                    </div>
                    <div class="mob-title">
                        <img class="text-hover" src="<?php echo base_url()?>theme/pointsofarrival/images/site-text-overlays/resources-hover.png">
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="spacer"></div>
    <div class="clearfix"></div>
</div>
