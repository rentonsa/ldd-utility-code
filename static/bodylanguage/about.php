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
        <h1 id="project-anchor">About The Project</h1>
        <p>
            Between July 2017 and July 2020, the Wellcome Research Resource-funded project &lsquo;Body Language: movement, dance and physical education in Scotland, 
            1890-1990&rsquo; has preserved, conserved, catalogued, made accessible and virtually united three archive collections held by the University of Edinburgh 
            Centre for Research Collections and Culture Perth and Kinross: Museums. The collaborative project is supported by Moray House School of Education, Margaret 
            Morris Movement International, and Scottish Gymnastics.&nbsp; The &lsquo;Body Language&rsquo; project features three interrelated archive collections which, 
            are the archives of Dunfermline College of Physical Education, Scottish Gymnastics, (both held at the University of Edinburgh), and the archives of Margaret 
            Morris Movement International (held at the Fergusson Gallery in Perth).&nbsp; The project aims to unlock these invaluable collections for the benefit of academic 
            scholars and the wider community, and aims to inspire and facilitate new and innovative interdisciplinary research in the medical humanities, social sciences and 
            other fields.&nbsp;</p>
        <p>
            Scotland produced a particularly close-knit network of innovators and pioneers whose distinctive approaches to movement, dance, physical education and sport are 
            exemplified by these collections.&nbsp; Spanning the 1890s to the 1990s, the collections highlights these important contributions from three perspectives; that of 
            an individual (Margaret Morris), an educational institution (Dunfermline College of Physical Education), and an amateur sports organisation (Scottish Gymnastics).&nbsp;
        </p>
        <p>
            Margaret Morris (1891-1980) established her own system for dance training, Margaret Morris Movement, which focuses on breathing techniques, posture and strength training 
            with co-ordinated movements.&nbsp; She also trained as a physiotherapist and demonstrated her technique to medical professionals.&nbsp; The archives also relate to the 
            organisation Margaret Morris Movement International (MMMI), which works with mentally and physically disabled persons using Margaret Morris Movement systems and techniques.
        </p>
        <p>
            Dunfermline College of Physical Education (DCPE) (1905-1986) was one of the first training colleges for women students of physical education and had an important influence 
            on developing the role of movement and the body in educational practice.
        </p>
        <p>
            Scottish Gymnastics (SG) (1890-present) was founded as a voluntary organisation representing a number of Scottish gymnastic and athletic clubs.&nbsp; Broadening its initial 
            focus from military fitness to general health and wellbeing, it was significant for promoting and supporting gymnastics in Scotland and abroad.&nbsp;
        </p>
        <p>
            Combined, the collections contain&hellip;.
        </p>
        <br />
        <h4>Working on the project were:</h4>
        <ul class="about-list">
            <li><strong>Clare Button</strong>, Project Archivist</li>
            <li><strong>Elaine MacGillivray</strong>, Project Archivist</li>
            <li><strong>Emily Hick</strong>, Conservator</li>
        </ul>
        <h4>They were supported by:</h4>
        <ul  class="about-list">
            <li><strong>Rachel Hosker</strong>, Archives Manager and Deputy Head of Special Collections, University of Edinburgh</li>
            <li><strong>Grant Buttars</strong>, University of Edinburgh Archivist, Archives and Technical Systems</li>
            <li><strong>Kirsty MacNab</strong>, University of Edinburgh Exhibitions Officer</li>
            <li><strong>Wendy Timmons</strong>, Programme Director: MSc Dance Science and Education, Moray House School of Education and Sport, University of Edinburgh</li>
            <li><strong>Professor John Ravenscroft</strong>, Chair of Childhood Visual Impairment, Moray House School of Education and Sport, University of Edinburgh</li>
            <li><strong>Dr Matthew L McDowell</strong>, Lecturer in Sport Policy, Management, and International Development, Moray House School of Education and Sport, University of Edinburgh</li>
            <li><strong>Tiffany Boyle</strong>, [Title]</li>
            <li><strong>Gillian Findlay</strong>, Head of Museums and Galleries, Culture Perth and Kinross</li>
            <li><strong>Rhona Rodger</strong>, Senior Officer, Collection Management, Culture Perth and Kinross</li>
            <li><strong>Amy Fairley</strong>, Collections Officer, Culture Perth and Kinross</li>
            <li>Staff at both the Centre for Research Collections, University of Edinburgh and at Culture Perth and Kinross</li>
        </ul>
        <br />
        <p>
            The project enlisted help from volunteers who helped on a wide range tasks ranging from conservation to cataloguing.
        </p>
        <p>
            The project has improved the physical condition of the collections considerably.&nbsp; Over&hellip;..items have been repaired and rehoused, with key items receiving 
            conservation treatment. The project has made a significant impact on the collections&rsquo; accessibility having catalogued over&hellip;.across all three collections.&nbsp; 
            It is now possible to search across all three collections using our <a class="para-link" href="./catelogue">online portal</a>.
        </p>
        <p>
            The project was generously funded by the Wellcome Trust&rsquo;s <br />
            <a class="para-link" href="https://wellcome.ac.uk/grant-funding/schemes/research-resources-awards-humanities-and-social-science">Research Resource Awards Scheme</a>.
        </p>
        <p>
            Between 2017 and 2020, project archivists Clare Button and Elaine MacGillivray collaborated with academic colleagues, practitioners and community groups to deliver a 
            range of presentations, workshops, collections familiarisation sessions and exhibitions across the United Kingdom.&nbsp;
        </p>
        <p>From July to October 2019, the University of Edinburgh Main Library Exhibition Gallery hosted the exhibition &lsquo;Body Language&rsquo;.&nbsp; This was curated by Project 
            Archivist Clare Button, and Archives Manager and Deputy Head of Special Collections, Rachel Hosker.&nbsp; The exhibition featured film, photographic images, textiles, 
            printed works and manuscripts from across the three project collections and offered a unique insight into the work and life of Scottish female pioneers in movement, dance 
            and physical education.&nbsp; The exhibition was generously funded by the <a class="para-link" href="https://wellcome.ac.uk/grant-funding/schemes/research-enrichment-public-engagement">Wellcome Research Enrichment Public Engagement Fund</a>.
        </p>
        <br />
        <h4>Project Report</h4>
        <p>Download the full project report here [insert link to PDF when available]</p>

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
        

        <div id="collection-anchor"></div>
        <h1>About The Collection</h1>
        <p> 
            Body Language: movement, dance and physical education in Scotland, 1890-1990’ preserved, conserved, catalogued, made accessible and virtually united three archive 
            collections held by the University of Edinburgh and Culture Perth and Kinross: Museums.  The archive collections include the archives of Dunfermline College of 
            Physical Education, and Scottish Gymnastics (University of Edinburgh), and the archives of Margaret Morris Movement International (Culture Perth and Kinross: Museums).  
        </p>

        <p class="quote"> 
            <q>
                TBC
            </q> 
        </p>
        <p class="quote-p">
            - Anonymous, Somewhere.
        </p>
        
        <p>View the <a class="para-link" href="https://exhibitions.ed.ac.uk/bodylanguage">exhibition here<div class="para-overlay"></div></a></p>
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