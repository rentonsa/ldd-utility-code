
<div class="content">
    <?php

    $errors = false;
    $errorMessage = "";

    // check if we can get to solr
    if($error_message !== "") {
        $errors = true;
        $errorMessage = "Unable to connect to solr.";
    }

    ?>

    <?php if (!$errors) { ?>

        <h1>Everything is OK</h1>

    <?php } else { ?>

        <h1>There are problems</h1>

        <p><?php echo $errorMessage; ?></p>

    <?php } ?>
</div>