    <h4>Related Items</h4>

    <ul class="related">

        <?php

        // if there are related items
        if(count($related_items) > 0) {

            $type_field = $this->skylight_utilities->getField('Type');

            foreach ($related_items as $index => $doc) {

                $type = 'Unknown';

                if(isset($doc[$type_field])) {
                    $type = "media-" . strtolower(str_replace(' ','-',$doc[$type_field][0]));
                }

                ?>

                <li<?php if($index == 0) { echo ' class="first"'; } elseif($index == sizeof($related_items) - 1) { echo ' class="last"'; } ?>>
                    <a class="related-record" href="./record/<?php echo $doc['id']?>" title="<?php echo $doc[$title_field][0]; ?>"><?php echo $doc[$title_field][0]; ?></a>

                </li>
            <?php }

        }
        // else there aren't any related items
        else { ?>

            <li>None.</li>

        <?php }?>
    </ul>