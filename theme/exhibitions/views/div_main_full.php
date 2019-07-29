
<?php
    $current_url = trim( "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}", "http");
    $base_string = trim(base_url(), "https");

    if ($current_url !== $base_string) {
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
