<?php
//session_start();
//var_dump($_SESSION);
include '../../games/config/vars.php';
// connect to db
$error = '';
$link = new mysqli($dbserver, $username, $password, $database);
//@mysqli_select_db($database) ;#or die( "Unable to select database".$database);

?>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

    <head>
        <meta name="viewport" content="user-scalable=no" />
        <title>Special Collections UV Manifest Work</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <link href='http://fonts.googleapis.com/css?family="Comic Sans MS"' rel='stylesheet' type='text/css'>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <?php

        echo $_SESSION['stylesheet'];

        ?>
        <meta name="author" content="Library Digital Development" />
        <meta name="description" content=
        "Edinburgh University Library Crowd Sourcing" />
        <meta name="distribution" content="global" />
        <meta name="resource-type" content="document" />
        <meta http-equiv="Content-Type" content="text/html; charset=us-ascii" />
        <style>
            table, td {
                border: 1px solid;
                font-weight: bold;
            }
            td{
                padding:3px;
                vertical-align: middle;
            }
            .header
            {
                background-color: black;
                color: white;
            }
            html {
                font-size: 20px;
            }
            * {
                font-family: Arial;
                background-color: #ffffff;
                border-color: #ffffff;
            }
            h2 {
                margin-left: 20px;
                margin-right: 20px;
            }
            h3 {
                margin-left: 20px;
                margin-right: 20px;
            }
            .menutext {
                color: white;
            }
            p{
                margin-left: 20px;
            }
            a{
                margin-left: 20px;
            }
            h1 {
                font-size: 100px;
                font-weight: bold;
                letter-spacing: normal;
                display: block;
            }
            span {
                letter-spacing: normal;

            }
            .uvlogo
            { margin-left:25px; display: inline-block; width: 50px; height: 50px;  background: url(../../images/uv.png) no-repeat 0px 0px;}
            a:hover {
                text-decoration: none;
            }
            .heading {
                margin-bottom: 30px;
                max-height: 700px;
            }
            .heading-first {
                margin-bottom: 50px;
            }
            body {
                background-color: #ffffff;
            }
            div.container-fluid div.all {
                font-family: Arial;
            }
            div.central {
                background-color: #ffffff;
            }
            h1, h2, textarea, input, h3, span{
                background-color:#ffffff;
            }
            textarea, input
            {border-width: 1px;
             border-color: #333329;
             margin-left : 25px;}


            .lightheading{
                width:220px;
                height:220px;
            }
            img{
                vertical-align:middle;
                text-align:center;
            }
            /* iPhone 6 in portrait  */
            @media only screen
            and (min-device-width : 375px)
            and (max-device-width : 667px)
            and (orientation : portrait) {
                html {
                    padding-right: 1em;
                    padding-left: 1em;
                }
                h2 {
                    font-weight: bold;
                    font-size: 2rem;
                }
                .menutext {
                    font-size: 1.5rem;
                }
                input.btn {
                    width: 30rem;
                    height: 5rem;
                    font-size: 3em;
                }
                input.form-control.form-inline {
                    margin-bottom: 2rem;
                    height: 4rem;
                    font-size: 3em;
                }
                td.menu {
                    box-sizing: border-box;
                    padding-left: 2rem;
                    padding-right: 2rem;
                }
                a {
                    font-size: 1.3rem;
                }
                #footer a{
                    color: ;
                    font-size: 1.3rem;
                    padding-bottom: 2rem;
                }
                #footer div.uoe-logo img{
                    float: left;
                    width: 5rem;
                }
                #footer div.luc-logo img{
                    float: right;
                    width: 4rem;
                }
            }

        </style>
    </head>

    <body>
        <?php include_once("./../analyticstracking.php")?>

        <?php
            $image_block = '';
            if ($_POST['imageblock'] !== '')
            {
                $image_block = $_POST['imageblock'];
            }

            if ($_POST['shelfmark_for_check'] !== '')
            {
                $shelfmark_for_check = $_POST['shelfmark_for_check'];
            }

            if ($_POST['man_name'] !== '')
            {
                $man_name = $_POST['man_name'];
            }
            else
            {
                $man_name = 'User generated manifest';
            }

        ?>

        <div class="all container-fluid">
            <h1>IIIF URLs for Vernon</h1>
            <?php 
                $file_handle_out = fopen("vernon_iiif_md.xml", "w")or die("can't open outfile");
                    fwrite($file_handle_out,"<?xml version=\"1.0\" encoding=\"UTF-8\"?> \n");
                    fwrite($file_handle_out,"<recordset>\n");
            ?>
            <div class = "table">
                <table>
                    <tr class = "header">
                        <td class = "header">Image ID</td><td class = "header">Digital Filename</td><td class = "header">LUNA URL</td>
                    </tr>
                        <?php
                            if (isset($image_block)) {
                                $detail= 'user selection';
                                $image_array = preg_split('/\r\n|[\r\n]/', $image_block);
                                $manifestlist = array();
                                $imagecount = 0;
                            }
                            if (isset($image_array)) {
                                foreach ($image_array as $image) {
                                    $url = "https://images.is.ed.ac.uk/luna/servlet/as/fetchMediaSearch?fullData=true&bs=10000&q=Repro_Record_ID=" . $image;
                                    $json = file_get_contents($url);

                                    $jobj = json_decode($json, true);
                                    $identity = $jobj[0]['identity'];

                                    $get_ind_man_result = '';
                                    $row = '';
                                    $outpath = '';
                                    $get_man_sql = "select jpeg_path from orders.IMAGE where image_id = '" . $image . "' order by rand() limit 1;";
                                    if (isset($identity))
                                    {
                                        $luna_url = "https://images.is.ed.ac.uk/luna/servlet/detail/" . $identity;
                                        $digital_filename = "http://images.is.ed.ac.uk/luna/servlet/iiif/" . $identity . "/full/full/0/default.jpg";
                                    }
                                    else
                                    {
                                        $luna_url = "No URL for this ID";
                                        $digital_filename = "No URL for this ID";
                                    }
                                    echo "<tr><td>".$image."</td><td>".$digital_filename."</td><td>".$luna_url."</td></td></tr>";

                                    fwrite($file_handle_out, "<record>");

                                    $vernon_url = "http://vernonapi.is.ed.ac.uk/vcms-api/oecgi4.exe/datafiles/AV/?query=".$image."&fields=id,im_ref";

                                    $vernon_json = file_get_contents($vernon_url);

                                    $vernon_jobj = json_decode($vernon_json, true);
                                    
                                    $m = 0;

                                    $found = 0;
                                    $vernon_id = '';

                                    foreach ($vernon_jobj['_embedded']['records'] as $record)
                                    {

                                        $image_without_ext = substr($image, 0, strlen($image)-4);

                                        if (strpos($record['im_ref_group'][0]['im_ref'],$image_without_ext)>0)
                                        {
                                            if ($found == 0)
                                            {
                                                $vernon_id = $record['id'];
                                                $found = 1;
                                            } 
                                        }
                                        $m++;
                                    }
                                    fwrite($file_handle_out, "<id>".$vernon_id."</id>");
                                    fwrite($file_handle_out, "<im_ref>".$digital_filename."</im_ref>");
                                    fwrite($file_handle_out, "<luna_url>".$luna_url."</luna_url>");
                                    fwrite($file_handle_out, "</record>");



                                }
                                fwrite($file_handle_out,"</recordset>");
                            }
                        ?>
                </table>
            </div>
        </div>
    </body>
</html>
