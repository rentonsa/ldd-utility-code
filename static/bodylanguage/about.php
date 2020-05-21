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
        <p>
        </p>
        <p>In all, 23 collections have been catalogued and preserved, with key items receiving conservation treatment.
            These collections include rare books, scientific papers, the archives of institutions such as Roslin
            Institute and the papers of pioneering scientists including Charlotte Auerbach, C.H. Waddington and Sir
            Ian Wilmut. Nine oral history recordings were also carried out with leading contemporary geneticists.
        </p>
        <p>Between October 2014 and May 2015, the project ‘Science on a Plate: the natural sciences through glass slides,
            1870-1930’ digitised nearly 3,500 historic glass slides which were catalogued as part of ‘Towards Dolly’.
            Depicting different animal breeds and scenes and people from around the world, this rich visual resource
            is now available to  <a href="http://images.is.ed.ac.uk/luna/servlet/UoEgal~6~6" title="Roslin Glass Slide online" target="_blank">view online</a>.
        </p>

        <p>These projects were generously funded by the Wellcome Trust's
            <a href="http://www.wellcome.ac.uk/Funding/Humanities-and-social-science/Funding-schemes/Research-resources-awards/index.htm" title="Wellcome Trust Research Resources" target="_blank">Research Resources scheme</a>.
            Watch the Project Archivist, Clare Button, talking about the collections in the Wellcome Trust's film about the scheme.

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

        <p>From July to October 2015, the University of Edinburgh Main Library Exhibition Gallery hosted the
            <a href="https://exhibitions.ed.ac.uk/towardsdolly" title="Toward's Dolly Exhibition online" target="_blank">exhibition</a>
            ‘Towards Dolly: a century of animal genetics in Edinburgh.’ This was curated by Project Archivist Clare Button
            and featured an array of archival, printed and visual collections, as well as Dolly the sheep herself, on
            loan courtesy of National Museums Scotland. Watch the Library and University Collections Digital Imaging
            Unit’s timelapse video of Dolly being installed in the exhibition gallery here:
        </p>
        <div class="flowplayer" data-analytics="<?php echo $ga_code ?>"
             title="Towards Dolly Exhibition being installed, Video by Univeristy of Edinburgh Digital Imaging Unit"">
            <video id="video-archives" title="Towards Dolly Exhibition being installed, Video by Univeristy of Edinburgh Digital Imaging Unit" controls preload="true">
                <?php if ($mp4ok = true) {?>
                    <source src="<?php echo base_url(); ?>videos/0051021v-001.mp4" type="video/mp4"/>
                <?php } else { ?>
                    <source src="<?php echo base_url(); ?>videos/0051021v-001.webm" type="video/webm"/>
                <?php } ?>
                Video loading...'
            </video>
        </div>

        <h1>Project report</h1>
        <p>Download the full project report <a href ="<?php echo base_url(); ?>videos/Towards Dolly complete final report.pdf" target="_blank">here</a> (9.3mb)</p>


        <h1>Contact Details</h1>
        <p>
            For further information  please contact:
        </p>
        <p><strong>Centre for Research Collections</strong><br />
            University of Edinburgh,<br />
            Main Library,<br />
            30 George Square,<br />
            Edinburgh,<br />
            EH8 9LJ<br />
            Email: <a class="email" href="mailto:is-crc@ed.ac.uk">is-crc@ed.ac.uk</a><br/>

    </div>
</div>