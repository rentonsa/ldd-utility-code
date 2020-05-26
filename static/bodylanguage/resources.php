<?php
    $mp4ok = false;
    // Use MP4 for all browsers other than Chrome
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == false)
    {
        $mp4ok = true;
    }
    //Microsoft Edge is calling itself Chrome, Mozilla and Safari, as well as Edge, so we need to deal with that.
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') == true)
    {
        $mp4ok = true;
    }
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') == false) {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == true) {
            $mp4ok = false;
        }
    }
?>
<div class="content">
    <div class="content byEditor">

        <div id="collection-search" class="other-search">
            <form action="./redirect/" method="post">
                <fieldset class="search">
                    <input type="text" name="q" value="<?php if (isset($searchbox_query)) echo urldecode($searchbox_query); ?>" id="q" />
                    <input type="submit" name="submit_search" class="btn" value="Search" id="submit_search" />
                    </fieldset>
            </form>
        </div>

        <p>
        </p>
        
        <!--<div id="project-anchor"></div>-->
            <h1 id="project-anchor">Resources</h1>
            <p> 
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                Cursus metus aliquam eleifend mi in nulla posuere sollicitudin aliquam. Condimentum mattis pellentesque id nibh tortor. 
                Id venenatis a condimentum vitae sapien. Semper auctor neque vitae tempus quam. Ut faucibus pulvinar elementum integer enim neque volutpat ac. 
                Tristique senectus et netus et. Rhoncus urna neque viverra justo nec ultrices. Nam at lectus urna duis convallis convallis. Lobortis feugiat vivamus at augue. 
                Vitae ultricies leo integer malesuada nunc vel risus commodo. Egestas egestas fringilla phasellus faucibus scelerisque eleifend.
            </p>
            <p> 
                Amet consectetur adipiscing elit pellentesque habitant morbi tristique. Blandit massa enim nec dui nunc mattis enim ut tellus. 
                Turpis egestas integer eget aliquet. Eget nullam non nisi est sit amet facilisis. Amet justo donec enim diam. 
                Pulvinar pellentesque habitant morbi tristique senectus et netus. Enim tortor at auctor urna. Et magnis dis parturient montes nascetur ridiculus. 
                In mollis nunc sed id semper risus in hendrerit. Suspendisse sed nisi lacus sed viverra tellus in hac. Fringilla urna porttitor rhoncus dolor purus. 
                Leo in vitae turpis massa sed elementum.
            </p>

            <p> Image / Video Content Below

            <div class="flowplayer" data-analytics="<?php echo $ga_code ?>"
                title="Introduction to Towards Dolly by Clare Button, Project Archivist">
                <video id="video-archives" title="Introduction to Towards Dolly by Clare Button, Project Archivist" controls preload="true">
                    <?php if ($mp4ok = true) {?>
                        <source src="<?php echo base_url(); ?>videos/Towards_Dolly_Wellcome_Trust_showreel.mp4" type="video/mp4"/>
                    <?php } else { ?>
                        <source src="<?php echo base_url(); ?>videos/Towards_Dolly_Wellcome_Trust_showreel.webm" type="video/webm"/>
                    <?php } ?>
                    Video loading...'
                </video>
            </div>
            </p>
        
        <p>Image / Video Content Below
            <div class="flowplayer" data-analytics="<?php echo $ga_code ?>"
                title="Towards Dolly Exhibition being installed, Video by Univeristy of Edinburgh Digital Imaging Unit">
                <video id="video-archives" title="Towards Dolly Exhibition being installed, Video by Univeristy of Edinburgh Digital Imaging Unit" controls preload="true">
                    <?php if ($mp4ok = true) {?>
                        <source src="<?php echo base_url(); ?>videos/0051021v-001.mp4" type="video/mp4"/>
                    <?php } else { ?>
                        <source src="<?php echo base_url(); ?>videos/0051021v-001.webm" type="video/webm"/>
                    <?php } ?>
                    Video loading...'
                </video>
            </div>
        </p>

    </div>
</div>