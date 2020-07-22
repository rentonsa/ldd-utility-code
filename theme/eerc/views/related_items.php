<div class="col-md-3 col-sm-3 hidden-xs" >

    <div class="sidebar-nav related-items">
        <ul class="list-group">
            <li class="list-group-item active">Related Items</li>

        <?php

        // if there are related items
        if(count($related_items) > 0) {

            $type_field = $this->skylight_utilities->getField('Type');
            $id_field = $this->skylight_utilities->getField('Identifier');

            foreach ($related_items as $index => $doc) {

                $strip_rec_title = strip_tags($doc[$title_field][0]);

                if(substr($strip_rec_title, -1) == ',') {
                    $strip_rec_title = substr($strip_rec_title, 0, strlen($strip_rec_title) - 1);
                }

            ?>
                <li class="list-group-item">
                    <a class="related-record" title="Link to related item: <?= $strip_rec_title ?>" href="./record/<?php echo $doc['id']?>/<?php echo $doc['types'][0]?>"><?= $strip_rec_title ?></a>
                    <?php
                    if (isset($doc["component_id"])) {
                        $component_id = $doc["component_id"];
                        echo'<div class="component_id">' . $component_id . '</div>';
                    } ?>
                    <?php
                    if (isset($doc["dates"])) {
                        echo $doc["dates"];
                    }?>
                </li>
            <?php }

        }
        // else there aren't any related items
        else { ?>

            <li class="list-group-item">None.</li>

        <?php }?>
    </ul>
</div>
</div>