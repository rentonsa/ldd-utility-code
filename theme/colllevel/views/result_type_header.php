
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
//echo $search_url;
        if (!empty($search_url))
{

if (strpos($search_url, 'Header:%22archives%22') > 0)
{ ?>

    <div class="results_header archives_header">
        <div class="col-sm-2 col-xs-12 col-md-2 col-lg-1"></div>
        <div class="col-sm-4 col-xs-12 col-md-5 col-lg-7 results_text">Archive and Manuscript collections contain documentary evidence for understanding
            a wide range of people, places, knowledge and learning. They contain a strong focus on Scottish culture
            and detail pioneering research, and literary,scientific and medical work through the University's own
            archive and Lothian Health Services Archive
            <div class="results_link">
                <h3 class="collection-link"><a href="http://archives.collections.ed.ac.uk" target="_blank">Search the Archive Collections <i class="fa fa-external-link">&nbsp;</i> </a></h3>
            </div>
        </div>

        <div class="col-sm-4 col-xs-12 col-md-3 col-lg-2 flowplayer" data-analytics="<?php echo $ga_code ?>"
             title="Introduction to Archives by Archives Manager, Rachel Hosker">
            <video id="video-archives" title="Introduction to Archives by Archives Manager, Rachel Hosker" controls preload="true">
                <?php if ($mp4ok == true) { ?>
                    <source src="<?php echo base_url(); ?>videos/0051011v-006.mp4" type="video/mp4"/>
                <?php } else { ?>
                    <source src="<?php echo base_url(); ?>videos/0051011v-006.webm" type="video/webm"/>
                <?php } ?>
                Video loading...'
            </video>
        </div>

        <div class="col-sm-2 col-xs-12 col-md-2 col-lg-2"></div>
    </div>


<?php } elseif (strpos($search_url, 'Header:%22museums%22') > 0) { ?>

    <div class="results_header museums_header">
        <div class="col-sm-2 col-xs-12 col-md-2 col-lg-1"></div>
        <div class="col-sm-4 col-xs-12 col-md-5 col-lg-7 results_text">Most collections support scholarly research, some tell the story of the
            University's past, some are used daily as teaching collections, while others, such as the Natural
            History Collections, are DNA libraries, while yet others glorify corporate spaces - they are all are
            part of the University’s rich cultural holdings.
        </div>

        <div class="col-sm-4 col-xs-12 col-md-3 col-lg-2 flowplayer" data-analytics="<?php echo $ga_code ?>"
             title="Introduction to Museums by Head of Museums, Jacky MacBeath">
            <video id="video-museums" title="Introduction to Museums by Head of Museums, Jacky MacBeath" controls preload="true">
                <?php if ($mp4ok == true)  { ?>
                    <source src="<?php echo base_url(); ?>videos/0051011v-004.mp4" type="video/mp4"/>
                <?php } else { ?>
                    <source src="<?php echo base_url(); ?>videos/0051011v-004.webm" type="video/webm"/>
                <?php } ?>
                Video loading...'
            </video>
        </div>
        <div class="col-sm-2 col-xs-12 col-md-2 col-lg-2"></div>
    </div>

<?php } elseif (strpos($search_url, 'Header:%22rarebooks%22') > 0) { ?>

    <div class="results_header rare_header">
        <div class="col-sm-2 col-xs-12 col-md-2 col-lg-1"></div>
        <div class="col-sm-4 col-xs-12 col-md-5 col-lg-7 results_text">We have about 400,000 rare books and manuscripts, many found nowhere else. Our
            earliest handwritten book is the 11th century Celtic Psalter; the earliest printed book is a woodblock
            Chinese commentary produced in 1440. The collection includes the libraries of Enlightenment economist
            Adam Smith and modern Scottish writer Hugh MacDiarmid.
        </div>

        <div class="col-sm-4 col-xs-12 col-md-3 col-lg-2 flowplayer" data-analytics="<?php echo $ga_code ?>"
             title="Introduction to Rare Books by Head of Special Collections, Joseph Marshall">
            <video id="video-rarebooks" title="Introduction to Rare Books by Head of Special Collections, Joseph Marshall" controls preload="true">
                <?php if ($mp4ok == true) { ?>
                    <source src="<?php echo base_url(); ?>videos/0051011v-005.mp4" type="video/mp4"/>
                <?php } else { ?>
                    <source src="<?php echo base_url(); ?>videos/0051011v-005.webm" type="video/webm"/>
                <?php }?>

                Video loading...'
            </video>
        </div>
        <div class="col-sm-2 col-xs-12 col-md-2 col-lg-2"></div>
    </div>

<?php } elseif (strpos($search_url, 'Header:%22art%22') > 0) { ?>

    <div class="results_header art_header">
        <div class="col-sm-2 col-xs-12 col-md-2 col-lg-1"></div>
        <div class="col-sm-4 col-xs-12 col-md-5 col-lg-7 results_text">The Art Collection contains over 5,000 items which reflect the history of the
            University, the city and Scotland and also supports world-leading research and teaching at Edinburgh. The
            collection comprises an astonishing range of objects, spanning two millennia and a multitude of artistic
            periods.
            <div class="results_link">
                <h3 class="collection-link"><a href="<?php echo base_url(); ?>art" target="_blank">View the items in the Art Collection <i class="fa fa-external-link">&nbsp;</i> </a></h3>
            </div>
        </div>

        <div class="col-sm-4 col-xs-12 col-md-3 col-lg-2 flowplayer" data-analytics="<?php echo $ga_code ?>"
             title="Introduction to the Art Collections by Curator Neil Lebeter">
            <video id="video-art" title="Introduction to the Art Collections by Curator Neil Lebeter" controls preload="true">
                <?php if ($mp4ok == true) { ?>
                    <source src="<?php echo base_url(); ?>videos/0051011v-001.mp4" type="video/mp4"/>
                <?php } else { ?>
                    <source src="<?php echo base_url(); ?>videos/0051011v-001.webm" type="video/webm"/>
                <?php } ?>
                Video loading...'
            </video>
        </div>
        <div class="col-sm-2 col-xs-12 col-md-2 col-lg-2"></div>
    </div>


<?php } elseif (strpos($search_url, 'Header:%22mimed%22') > 0) { ?>

    <div class="results_header mimed_header">
        <div class="col-sm-2 col-xs-12 col-md-2 col-lg-1"></div>
        <div class="col-sm-4 col-xs-12 col-md-5 col-lg-7 results_text">The Musical Instrument Collection contains over 5,500 items, covering the history of
            musical instruments from c1550 to the present day. Instruments of all types and traditions can be found,
            including some of the world’s most iconic, and much revered, examples of their type.
            <div class="results_link">
                <h3 class="collection-link"><a href="<?php echo base_url(); ?>mimed" target="_blank">View the items in the Musical Instrument Museums Edinburgh Collection <i class="fa fa-external-link">&nbsp;</i> </a></h3>
            </div>
        </div>

        <div class="col-sm-4 col-xs-12 col-md-3 col-lg-2 flowplayer" data-analytics="<?php echo $ga_code ?>"
             title="Introduction to MIMEd by MIMEd Pricipal Curator, Darryl Martin">
            <video id="video-mimed" title="Introduction to MIMEd by MIMEd Pricipal Curator, Darryl Martin" controls preload="true">
                <?php if ($mp4ok == true) { ?>
                    <source src="<?php echo base_url(); ?>videos/0051011v-002.mp4" type="video/mp4"/>
                <?php } else { ?>
                    <source src="<?php echo base_url(); ?>videos/0051011v-002.webm" type="video/webm"/>
                <?php } ?>
                Video loading...'
            </video>
        </div>
        <div class="col-sm-2 col-xs-12 col-md-2 col-lg-2"></div>
    </div>


<?php }
}
?>

