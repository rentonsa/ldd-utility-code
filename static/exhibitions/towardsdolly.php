<div class="content" id="static-exhibition">
    <div class="content byEditor">

    <h1 alt="exhibition title">Towards Dolly: A Century of Animal Genetics in Edinburgh</h1>
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

        $record_title = 'Towards Dolly Introduction';
        $b_filename = base_url().'videos/0051018v-004.';
        $b_uri = $b_filename.'mp4';
        $b_seq = 0;
        $videoLink = "";

        if ($mp4ok == true) {
            $videoLink = '<div class="flowplayer"  title="' . $record_title . '">';
            $videoLink .= '<video id="video-' . $b_seq. '" title="' . $record_title . '" ';
            $videoLink .= 'controls preload="true" width="330" alt="exhibition video">';
            $videoLink .= '<source src="' . $b_uri.'" type="video/mp4" />Video loading...';
            $videoLink .= '</video>';
            $videoLink .= '</div>';
            echo $videoLink;

        }
        else
        {
            $videoLink = '<div class="flowplayer"  title="' . $record_title . '">';
            $videoLink .= '<video id="video-' . $b_seq. '" title="' . $record_title . '" ';
            $videoLink .= 'controls preload="true" width="330" alt="exhibition video">';
            $videoLink .= '<source src="' . $b_filename . 'webm" type="video/webm" />Video loading...';
            $videoLink .= '</video>';
            $videoLink .= '</div>';
            echo $videoLink;
        }

        ?>

        
        <div id="head-info">
            <h4 id="individual-exhibition-h" class="right-align-h" alt="exhibition details and location">31st July 2015 - 31st October 2015<br>Monday - Saturday, 10:00 - 17:00 <br>Exhibition Gallery<br>Main Library<br>George Square</h3>
        </div>
        <p id="individual-exhibition-p" class="right-align-p" alt="exhibition curator">
            Curated by: Clare Button (Project Archivist)
        </p>
        <br>
        <p id="individual-exhibition-p" class="right-align-p" alt="exhibition description">Edinburgh has played a vital role in the science which tells us who we are – genetics
        </p>
        <br>
        <p id="individual-exhibition-p" class="right-align-p" alt="exhibition description">Dolly the sheep is a scientific icon and a household name. However, she is also a single chapter in a wider story which spans a century. Pioneers at Edinburgh and Roslin have embedded concepts like genetic engineering and stem cell research in the public consciousness, stimulating debate and revolutionising science and medicine
        </p>
        <br>
        <p id="individual-exhibition-p" class="right-align-p" alt="exhibition description">This exhibition celebrates the individuals and institutions who made, and continue to make, extraordinary advances in animal and human health. It will take you on a journey ‘Towards Dolly’ and beyond</p>

        <a href="<?php echo base_url() ?>past#towardsdolly-anchor" alt="link back to full past exhibiton list" title="Link back to full past exhibiton list">
            <button id="exhibition-back" class="exhibit-button">
                <p>Back to full list</p>
            </button>
        </a>
        
        <div id="object-divider-1" class="divider" data-100-bottom-top="transform: translateY(0px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1"></div>


        <h4 class="object-h" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">Exhibition Clips</h4>
        <br>
        <div class="audio-content" data-100-bottom-top="transform: translateX(-75px); opacity: 0" data-center-top="transform: translateX(0px); opacity: 1">
        <p alt="list of audio clip sfrom the exhibition">These audio clips accompany specific objects in the exhibition.</p>
        <br>
       
        <?php

            $record_title = 'Social Science: \'The Old Time Gene\', sung by Institute of Animal Genetics staff, 1956';
            $b_filename = base_url().'videos/The_Old_Time_Gene';
            $b_uri = $b_filename . ".mp3";
            $b_seq = 0;
            $audioLink = "";

            $audioLink .= '<audio id="audio-' . $b_seq;
            $audioLink .= '" title="' . $record_title . '"';
            $audioLink .= ' controls preload="true" width="600" alt="audio clip">';
            $audioLink .= '<source src="' . $b_uri . '" type="audio/mpeg" />Audio loading...';
            $audioLink .= '</audio>';
            echo "<h4>Social Science: 'The Old Time Gene', sung by Institute of Animal Genetics staff, 1956</h4>" . $audioLink . "<br />";

            $record_title = 'New directions: F.A.E. Crew in conversation with Margaret Deacon, 1969';
            $b_filename = base_url().'videos/Crew';
            $b_uri = $b_filename . ".mp3";
            $b_seq = 0;
            $audioLink = "";

            $audioLink .= '<audio id="audio-' . $b_seq;
            $audioLink .= '" title="' . $record_title . '"';
            $audioLink .= ' controls preload="true" width="600" alt="audio clip">';
            $audioLink .= '<source src="' . $b_uri . '" type="audio/mpeg" />Audio loading...';
            $audioLink .= '</audio>';
            echo "<br /><h4>New directions: F.A.E. Crew in conversation with Margaret Deacon, 1969</h4>" . $audioLink . "<br />";

            $record_title = 'A Chemical Reaction: Charlotte Auerbach in conversation with Margaret Deacon, 1971';
            $b_filename = base_url().'videos/Auerbach_on_Robson_and_mustard_gas';
            $b_uri = $b_filename . ".mp3";
            $b_seq = 0;
            $audioLink = "";

            $audioLink .= '<audio id="audio-' . $b_seq;
            $audioLink .= '" title="' . $record_title . '"';
            $audioLink .= ' controls preload="true" width="600" alt="audio clip">';
            $audioLink .= '<source src="' . $b_uri . '" type="audio/mpeg" />Audio loading...';
            $audioLink .= '</audio>';
            echo "<br /><h4>A Chemical Reaction: Charlotte Auerbach in conversation with Margaret Deacon, 1971</h4>" . $audioLink . "<br />";

            $record_title = 'Dollymania: Sir Ian Wilmut and Grahame Bulfield in conversation, January 2015';
            $b_filename = base_url().'videos/Wilmut_Bulfield_on_Dollymania';
            $b_uri = $b_filename . ".mp3";
            $b_seq = 0;
            $audioLink = "";

            $audioLink .= '<audio id="audio-' . $b_seq;
            $audioLink .= '" title="' . $record_title . '"';
            $audioLink .= ' controls preload="true" width="600" alt="audio clip">';
            $audioLink .= '<source src="' . $b_uri . '" type="audio/mpeg" />Audio loading...';
            $audioLink .= '</audio>';
            echo "<br /><h4>Dollymania: Sir Ian Wilmut and Grahame Bulfield in conversation, January 2015</h4>" . $audioLink . "<br />";

        ?>
        </div>

        

    </div>
</div>