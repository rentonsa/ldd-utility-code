
<?php $numrel = count($related_items);
if ($numrel > 0)
{?>
    <div id="stc-section6" class="col-xs-12 related inactive container-fluid">
        <h2 class="itemtitle hidden-sm hidden-xs">Related Instruments</h2>
        <h4 class="itemtitle hidden-md hidden-lg">Related Instruments</h4>
        <?php
        $numrel = count($related_items);
        // if there are related items
        if ($numrel > 0)
        {
            $type_field = $this->skylight_utilities->getField('Type');
            $i = 0;?>

            <div id="results-container">
            <div class="results-row">
            <!--<div id="centered-grid">
                <div class="grid" data-masonry='{ "itemSelector": ".grid-item", "columnWidth": 150 }'>-->
                <?php

                $link_uri_field = $this->skylight_utilities->getField("ImageURI");
                foreach ($related_items as $index => $doc)
                {

                    ?>
                    <div class="column related-col">
                        <div class="thumbnail-cont">
                        <?php

                        $needlink = true;

                        //TODO dcidentifieruri is a temporary location for the IIIF URIs
                        if (isset($doc[$link_uri_field])) {
                            foreach ($doc[$link_uri_field] as $linkURI) {
                                if (strpos($linkURI, 'luna') > 0 and $needlink == true) {

                                    $thumbnailLink = '<a href="./record/' . $doc['id'] . '" title="Read more about the ' . $doc[$title_field][0] . '" >';

                                    list($width, $height) = getimagesize($linkURI);
                                    $portrait = true;
                                    if ($width > $height) {
                                        $portrait = false;
                                    }
                                    if ($portrait) {
                                        $thumbnailLink .= '<img src = "' . $linkURI . '" class="record-thumbnail-portrait related-img" title="Read more about the ' . $doc[$title_field][0] . '" /></a>';
                                    } else {
                                        $thumbnailLink .= '<img src = "' . $linkURI . '" class="record-thumbnail-landscape related-img" title="Read more about the ' . $doc[$title_field][0] . '" /></a>';
                                    }

                                    echo $thumbnailLink;
                                    $needlink = false;

                                }
                            }
                        }
                        else
                        {?>
                            <div class="column related-col">
                                <div class="thumbnail-cont">
                                    <?php
                                        $thumbnailLink  =  '<a href="./record/'.$doc['id'].'" title="Read more about the ' . $doc[$title_field][0] . '"> No Image for this </a>';
                                        echo $thumbnailLink;
                                        $needlink = false;
                                    }
                                    ?>
                                    <p class="text-center hidden-xs reated-p">
                                        <?php echo $doc[$title_field][0]; ?>
                                    </p>
                                    <p class="text-center hidden-md hidden-sm hidden-lg reated-p">
                                        <small>
                                            <?php echo $doc[$title_field][0]; ?>
                                        </small>
                                    </p>
                                </div>
                            </div>
                        <?php
                        }?>
                        <script>
                            var $grid = $('.grid').imagesLoaded( function() {
                                // init Masonry after all images have loaded
                                $grid.masonry({
                                    // options...
                                });
                            });
                        </script>
                        </div>
                    </div>
                </div>
            </div>
    <?php
    } // else there aren't any related items
    else { ?>
        None.
        <div class="spacer"></div>
        <?php } ?>
    </div>
<?php } ?>