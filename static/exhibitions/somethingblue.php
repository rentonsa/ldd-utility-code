<div class="content">
    <div class="content byEditor">
        <a href ='./search/*:*/Exhibition:"something+blue|||Something+Blue"' id = "smallbanner-blue"></a>
        <div id="head-info">

            <h2 alt="exhibition title" alt="exhibition details and location">About the Exhibition</h2>
            <h3>Dates: 2nd April - 27th June 2015<br />
                Where: Exhibition Gallery, Main Library, George Square<br />
                Curated by: Emma Smith<br  alt="exhibition curator"/>
                <a href ='./search/*:*/Exhibition:"something+blue|||Something+Blue"'><i class="fa fa-search">&nbsp;</i>View Items</a></h3>
        </div>


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

        $record_title = 'Something Blue Introduction';
        $b_filename = base_url().'videos/0051014v-001.';
        $b_seq = 0;
        $videoLink = "";

        if ($mp4ok == true) {
            $videoLink = '<div class="flowplayer"  title="' . $record_title . '">';
            $videoLink .= '<video id="video-' . $b_seq. '" title="' . $record_title . '" ';
            $videoLink .= 'controls preload="true" width="660">';
            $videoLink .= '<source src="' . $b_filename . 'mp4" type="video/mp4" />Video loading...';
            $videoLink .= '</video>';
            $videoLink .= '</div>';
           echo $videoLink;

        }
        else
        {
            $videoLink = '<div class="flowplayer"  title="' . $record_title . '">';
            $videoLink .= '<video id="video-' . $b_seq. '" title="' . $record_title . '" ';
            $videoLink .= 'controls preload="true" width="660">';
            $videoLink .= '<source src="' . $b_filename . 'webm" type="video/webm" />Video loading...';
            $videoLink .= '</video>';
            $videoLink .= '</div>';
           echo $videoLink;
        }


?>
        <div class = "content">
        <p alt="exhibition description">
        Blue has delighted and captivated humanity for thousands of years. It is used to describe immeasurable concepts, such as the depth of the sea or the colour of the sky. Despite this, it only occurs in nature very rarely and is the most difficult natural pigment to obtain.
</p>
        <p alt="exhibition description">
        This exhibition in the Main Library Exhibition Gallery presents an exploration of the University’s Collections on the colour and concept of blue. From blue stockings and opals to lullabies and rhapsodies, this exhibition offers new opportunities for academic and abstract associations.
        </p>
        <p alt="exhibition description">
        “The blue colour is everlastingly appointed by the Deity to be a source of delight; and whether seen perpetually over your head, or crystallised once in a thousand years into a single and incomparable stone, your acknowledgment of its beauty is equally natural, simple, and instantaneous.”
        </p>
        <p alt="exhibition description">
        <i>John Ruskin (1819 - 1900)</i>
        </p>
        </div>

    </div>
</div>