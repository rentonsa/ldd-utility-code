<div>
<?php
$owning_coll = $this->skylight_utilities->getField('OwningCollection');
foreach ($docs as $index => $doc) {

    $owning_id = $doc[$owning_coll][0];
}
?>
</div>
