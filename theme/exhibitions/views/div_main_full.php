<!-- GENERATES FULL SIZE BODY -->
<?php
    $current_url = trim( "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}", "http");
    $base_string = trim(base_url(), "https");

    if (strpos($current_url, 'accessibility') == true) {
        echo '<div id="skrollr-body" class="accessibility-body">
                <div class="body-text content" id="accessibility-body"> 
                <div class="col-main-full">';
                        if(isset($page_heading)) {
                            $page_title = $page_heading;
                        }
                        if(isset($message)) {
                            echo '<div class="message">' . $message . '</div>';
                        }
    }
    // CONDITION TO GENERATE FULL BODY DIV IF ON INDEX PAGE 
    elseif ($current_url !== $base_string) {
          echo '<div id="skrollr-body">
                <div class="body-text content" id="short-body"> 
                <div class="col-main-full">';
                        if(isset($page_heading)) {
                            $page_title = $page_heading;
                        }
                        if(isset($message)) {
                            echo '<div class="message">' . $message . '</div>';
                        }
    }
    
?>
