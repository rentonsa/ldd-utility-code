<style>
    .plus-button {
        border: 2px solid lightgrey;
        background-color: #fff;
        font-size: 22px;
        height: 1.5em;
        width: 1.5em;
        border-radius: 999px;
        position: relative;
    }

    li.overview_list {
        list-style: none;
        margin: 0.5em;
    }

    .active_btn {
        font-weight: bold;
    }


</style>
<script>

    function toggleButton(btn, elementId) {

        if(btn.innerText === '+') {
            btn.innerText = '-';
            $(btn).parent().addClass('active_btn');
        }
        else {
            btn.innerText = '+';
            $(btn).parent().removeClass('active_btn');
        }

        $(elementId).toggle();

    }

</script>
<div class="col-md-9 col-sm-9 col-xs-12">
    <h1>Browse the Collections</h1>
    <p></p>

    <?php

    function request($url, $data = null, $post = true, $session = null)    {

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, $post);
        // Set connection timeout to 1 second
        //curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT_MS, 1000);

        if($data) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        }

        if($session) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-type: text/json', 'X-ArchivesSpace-Session: '. $session]);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function getTree() {
        //$url = $this->base_url . $this->solr_collection . "/select?";
        $base_url = 'http://lac-archives-live.is.ed.ac.uk:8089';

        // Login
        $result = request($base_url . "/users/admin/login", ['password' => 'Z"/)}4ck{Z[}73Q)']);
        $json_obj = json_decode($result, TRUE);

        log_message("debug", "Logged in to ArchivesSpace REST API.");

        $session = $json_obj['session'];

        $url = $base_url . '/repositories/15/resources/86984/tree';
        //$url = $base_url . '/repositories/15/archival_objects/164991';

        $result = request($url, null, false, $session);

        $json_obj = json_decode($result, TRUE);

        // Logout?

        return $json_obj;

    }

    function getArchivalObj($record_uri, $number_of_units=1) {
        $units = explode('/', $record_uri);
        $len_units = count($units);
        $return_string = '';

        for ($i = $len_units - $number_of_units; $i < $len_units ; $i++) {
            $return_string .= $units[$i];

            if($i != $len_units -1) {

                $return_string .= '/';
            }
        }
        return $return_string;

    }

    function cleanTitle($title) {
        if(substr($title, strlen($title)-3, 1) == ',') {
            return substr($title, 0, strlen($title)-3);
        }

        return $title;
    }

    function getChildren($branch, $branch_count = 0, $sub_branch_count = 0)    {
        $output = '';
        if ($branch['has_children']) {
            if(is_int($sub_branch_count))   {
                $output = '<ul id="ul_' . $branch_count . '_' . $sub_branch_count . '" style="display: none;">';
            }
            else {
                $output = '<ul id="ul_' . $branch_count . '">';
                $sub_branch_count = 0;
            }

            foreach ($branch['children'] as $sub_branch) {
                $sub_output = '';

                if ($sub_branch['has_children']) {
                    $output .= '<li class="overview_list"><button class="plus-button" onclick="toggleButton(this, \'#ul_' . $branch_count . '_' . $sub_branch_count . '\');">+</button>&nbsp;';
                    $sub_output = getChildren($sub_branch, $branch_count, $sub_branch_count);
                    $sub_branch_count++;
                }
                else {
                    $output .= '<li class="overview_list" style="list-style: square;">';

                }

                $output .= '<a href="record/' . getArchivalObj($sub_branch["record_uri"]) . '/archival_object">';
                $title = cleanTitle($sub_branch['title']);
                $output .= $title . ' <span style="font-size: smaller;">(';

                if(strpos($title, 'Interviews of') > -1) {
                    $output .= getArchivalObj($sub_branch['component_id'], 2);
                }
                else {
                    $output .= getArchivalObj($sub_branch['component_id']);
                }

                $output .=  ')</span></a></li>' . $sub_output;
                $branch_count++;

            }
            $output .= '</ul>';

        }

        return $output;
    }

    ?>
    <!--<ul>-->
        <?php
    foreach(getTree()['children'] as $index => $branch) {
        //print($index);
        /* <li class="overview_list" style="margin: 0.5em; font-size: 18px;"><button class="plus-button" onclick="toggleButton(this, '#ul_<?= $index ?>');">+</button>&nbsp;<?= cleanTitle($branch['title']) ?></li> */
        if($index == 0) { ?>
        <li class="overview_list" style="margin: 0.5em; font-size: 18px; font-weight: bold;"><button class="plus-button" onclick="toggleButton(this, '#ul_<?= $index ?>');">-</button>&nbsp;<?= cleanTitle($branch['title']) ?></li>
        <?= getChildren($branch, $index, null) ?>

        <?php  } //print($value['title'] . '<br/>');
        //print_r($key . '=' . $value . '<br/>');
    }

    ?>
    <!--</ul>-->
</div>