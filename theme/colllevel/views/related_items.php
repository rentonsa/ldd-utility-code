<div class="container related">
    <h4>Related Results</h4>
    <?php
    // if there are related items
    if(count($related_items) > 0) {
        foreach ($related_items as $index => $doc) {?>
            <div class="related-item">
                <a class="related-record" href="./record/<?php echo $doc['id']?>" title="<?php echo $doc[$title_field][0]; ?>"><?php echo $doc[$title_field][0]; ?></a>
            </div>
        <?php }
    }
    // else there aren't any related items
    else { ?>
        <div class="related-item">None.</div>
    <?php }?>
</div>