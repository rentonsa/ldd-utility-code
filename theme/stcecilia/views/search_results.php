<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
    <?php

    // Set up some variables to easily refer to particular fields you've configured
    // in $config['skylight_searchresult_display']

    $title_field = $this->skylight_utilities->getField('Title');
    $maker_field = $this->skylight_utilities->getField('Maker');
    $date_field = $this->skylight_utilities->getField('Date Made');
    $acc_field = $this->skylight_utilities->getField('Accession Number');
    $bitstream_field = $this->skylight_utilities->getField('Bitstream');
    $thumbnail_field = $this->skylight_utilities->getField('Thumbnail');
    $base_parameters = preg_replace("/[?&]sort_by=[_a-zA-Z+%20. ]+/","",$base_parameters);
    if($base_parameters == "") {
        $sort = '?sort_by=';
    }
    else {
        $sort = '&sort_by=';
    }
    ?>

    <div class="container-fluid">
        <div class="searchFoundRow">
            <span class="searchFound"><?php echo $rows ?> instruments found </span>
        </div>
        <div id="results-grid" class="grid">
            <div class="grid-sizer col-xs-3"></div>
            <?php
            $link_uri_field = $this->skylight_utilities->getField("ImageURI");

            $content = true;

            try{
                $content = @file_get_contents('https://images.is.ed.ac.uk/luna/images/favicon.ico',0,null,0,1); //todo move to config
            } catch (Exception $e) {
                // Handle exception
            }

            foreach ($docs as $index => $doc) {

                $bitstream_array = array();
                $thumbnailLink = "";
                $thumbnailImg = "";

                //TODO dcidentifieruri is a temporary location for the IIIF URIs
                if (isset($doc[$link_uri_field][0]))
                {
                    $linkURI = $doc[$link_uri_field][0];
                    //$linkURI = str_replace('/full/full/0/default.jpg','', $linkURI);

                    if (strpos($linkURI, 'luna') > 0 ) {
                        //change to stop LUNA erroring on redirect
                        $linkURI = str_replace('http://', 'https://', $linkURI);
                        if (false === $content) {
                            $thumbnailLink = 'href="./record/' . $doc['id'] . '" title = "' . $doc[$title_field][0] . '"';
                            $thumbnailImg = '<img class="img-responsive record-thumbnail-search" src="../theme/stcecilia/images/comingsoon.gif"  title="' . $doc[$title_field][0] . '" />';
                        }
                        else
                        {
                            $linkURI = str_replace('full/full', 'full/96,', $linkURI);
                            list($width, $height) = getimagesize($linkURI);
                            $portrait = true;
                            if ($width > $height)
                            {
                                $parms = '/180,';
                            }
                            else
                            {
                                $parms = '/,220';
                            }
                            $linkURI = str_replace('full/96,', 'full'.$parms, $linkURI);

                            $thumbnailLink = 'href="./record/' . $doc['id'] . '" title = "' . $doc[$title_field][0] . '"';
                            $thumbnailImg = '<img class="img-responsive record-thumbnail-search" src="' . $linkURI . '"  title="' . $doc[$title_field][0] . '" />';
                        }
                    }
                    else
                    {
                        $thumbnailLink  =  'href="./record/'.$doc['id'].'" title = "'. $doc[$title_field][0].'"';
                        $thumbnailImg = '<img class="img-responsive record-thumbnail-search" src="../theme/stcecilia/images/comingsoon1.gif"  title="' . $doc[$title_field][0] . '" />';
                    }
                }
                else
                {
                    $thumbnailLink  =  'href="./record/'.$doc['id'].'" title = "'. $doc[$title_field][0].'"';
                    $thumbnailImg = '<img class="img-responsive record-thumbnail-search" src="../theme/stcecilia/images/comingsoon.gif"  title="' . $doc[$title_field][0] . '" />';
                }

                ?>

                <div class="grid-item col-xs-6 col-sm-6 col-md-3 col-lg-3">
                    <a <?php echo $thumbnailLink; ?> >
                        <div class="grid-item-container">
                            <div class="grid-item-content box">

                                <?php echo $thumbnailImg; ?>

                                <figcaption>
                                    <span class="searchTitle"><?php echo $doc[$title_field][0]; ?></span><br>
                                    <span class="searchDate"><?php echo empty($doc[$maker_field][0]) ? "unknown" : $doc[$maker_field][0] ; ?></span><br>
                                    <span class="searchDate"><?php echo empty($doc[$date_field][0]) ? "unknown" : $doc[$date_field][0] ; ?></span><br>
                                    <span class="searchDate">Accession Number: <strong><?php echo empty($doc[$acc_field][0]) ? "unnumbered" : $doc[$acc_field][0] ; ?></strong></span>
                                </figcaption>
                            </div>
                        </div>
                    </a>
                </div>
            <?php }?>
        </div>
        <div class="row">
            <div class="centered text-center">
                <nav>
                    <ul class="pagination pagination-sm pagination-xs">
                        <?php
                        foreach ($paginationlinks as $pagelink)
                        {
                            echo $pagelink;
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<script>
    //init Masonry
    var $grid = $('.grid').masonry({
        itemSelector: '.grid-item',
        columnWidth: '.grid-sizer',
        percentPosition: true
    });
    // layout Masonry after each image loads
    $grid.imagesLoaded().progress( function() {
        $grid.masonry('layout');
    });
</script>