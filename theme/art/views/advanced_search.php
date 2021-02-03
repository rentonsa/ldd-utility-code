
<h3 class="adv-search">Advanced Search</h3>
<br/>

<?php if($formhidden) {
    // We're hiding the form in search results
    ?>
    <p class ="adv-search"><strong><a href="#" id="showform">Change Advanced Search options</a></strong></p>
<?php } ?>

<br/>
<div class="searchform" style="display:<?php echo $formhidden == true ? 'none' : 'block'; ?>">
    <p><strong>Hint: </strong> To match an exact phrase, try using quotation marks, eg. <em>"a search phrase"</em></p>
<?php    echo $form;
    ?>

</div>

<script>
    $("#showform").click(function() {
        $(".searchform").show();
        $(this).hide();
        $(".message").hide();
      <?php
        if(isset($saved_search)) {

        foreach($saved_search as $key => $val) {
            ?>
                $("input#<?php echo preg_replace('# #','_',$key,-1); ?>").val('<?php echo urldecode($val); ?>');
            <?php

        }
        } ?>

        return false;
    });
</script>
