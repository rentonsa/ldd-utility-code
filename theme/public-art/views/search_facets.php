<?php
if (isset($_GET['map'])){
  $type = 'map';
  }
/*
if ($type != 'map') { ?>

<div class="col-md-2 col-sm-2 col-xs-12 hidden-xs" >
<?php if (isset($facets)) {?>

        <div class="sidebar-nav">

        <?php foreach ($facets as $facet) {
        //end of quick hack
        $inactive_terms = array();
        $active_terms = array();

        ?>      <div style="margin-top:5px; display:block; clear:both; width: 200px;">
                <ul class="list-group">
                <li class="list-group-item active">
                    <a href="./browse/<?php echo $facet['name']; ?>">
                        <h4><?php echo $facet['name'] ?><h4>
                    </a>
                </li>


            <?php if(preg_match('/Date/',$base_search) && $facet['name'] == 'Date') {
                $fpattern =  '#\/'.$facet['name'].'.*\]#';
                $fremove = preg_replace($fpattern,'',$base_search, -1);

                $fpattern =  '#\/'.$facet['name'].'.*\%5D#';
                $fremove = preg_replace($fpattern,'',$fremove, -1);
                ?>

                <li class="list-group-item">
                    Clear <?php echo $facet['name']; ?> filters <a class="deselect" href='<?php echo $fremove;?>'></a>
                </li>
            <?php }
            $numterms = 0;
            foreach($facet['terms'] as $term) {

                if($term['active']) {
                    $active_terms[] = $term;
                } else {
                    $inactive_terms[] = $term;
                }
                $numterms++;
            }

            if(sizeof($active_terms) > 0) { ?>
                    <?php foreach($active_terms as $term) {
                        $pattern =  '#\/'.rawurlencode($facet['name']).':%22'.preg_quote($term['name'],-1).'%22#';
                        $remove = preg_replace($pattern,'',$base_search, -1);
                        ?><li class="list-group-item"><!--<span class="badge"><?php echo $term['count']; ?></span>-->
                        <?php echo $term['display_name'];?>
                            <a class="deselect" href='<?php echo $remove;?>'><i class="fa fa-close"></i>&nbsp;</a></li>
                        <?php
                    }

            }
             foreach($inactive_terms as $term) { ?>
                    <li class="list-group-item">
                        <!--<span class="badge"><?php echo $term['count']; ?></span>-->
                        <a href='<?php echo $base_search; ?>/<?php echo $facet['name']; ?>:"<?php echo $term['name']; ?>"<?php echo $base_parameters ?>'><span style="font-size:16px; display:block; width:200px;"><?php echo $term['display_name'];?></span>
                        </a>
                    </li>
                    <?php
                }

                foreach($facet['queries'] as $term) {
                    $pattern =  '#\/'.rawurlencode($facet['name']).'.*\]#';
                    $remove = preg_replace($pattern,'',$base_search, -1);

                    $pattern =  '#\/'.rawurlencode($facet['name']).'.*\%5D#';
                    $remove = preg_replace($pattern,'',$remove, -1);

                    if($term['count'] > 0) {
                        ?>
                        <li class="list-group-item">
                            <!--<span class="badge" ><?php echo $term['count'];?></span>-->
                            <a class="deselect" href='<?php echo $remove; ?>/<?php echo $facet['name']; ?>:<?php echo $term['name']; ?><?php if(isset($operator)) echo '?operator='.$operator; ?>'><h4><?php echo $term['display_name'];?></h4>
                            </a></li>
                        <?php
                    }
                }

                if(empty($facet['terms']) && empty($facet['queries'])) { ?>
                    <li class="list-group-item">No matches</li>
                <?php }
                else {
                    if($numterms == $this->config->item('skylight_results_per_page')) { ?>
                        <li class="list-group-item"><a href="./browse/<?php echo $facet['name']; ?>">More ...</a></li>
                    <?php }
                } ?>
        </ul></div>
        <?php } ?>

        </div>

<?php } ?>
</div>
<?php } */?>
