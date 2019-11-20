<div class="container-fluid content">
    
    <!-- Search bar moved here to sit under "content divider" for front-end design -->
    <div class="header-search">
        <div id="collection-search">
            <form action="./redirect/" method="post" class="navbar-form">
                <div class="input-group search-box">
                    <input type="text" spellcheck="value" class="form-control" placeholder="Search" name="q" value="<?php if (isset($searchbox_query)) echo urldecode($searchbox_query); ?>" id="q" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default" name="submit_search" value="Search" id="submit_search" 
                                alt="submit search button" title="Click to submit search"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    <?php
    if(isset($page_heading)) {
        $page_title = $page_heading;
    }
    ?>

    <?php if(isset($message)) { ?>
    <div class="message"> <?php echo $message; ?> </div>
<?php } ?>