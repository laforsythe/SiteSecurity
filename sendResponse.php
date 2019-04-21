<?php

if(isset($_GET['website'])) {
    $site = $_GET['website'];

    if ($site !== '') {


        $site = str_replace('http://www.', '', $site);
        $site = str_replace('https://www.', '', $site);
        $site = str_replace('www.', '', $site);
        if ($site == "com"){
            exit();
        }

        $url = "http://www." . $site;
        $orignal_parse = parse_url($url, PHP_URL_HOST);
        $get = stream_context_create(array("ssl" => array("capture_peer_cert" => TRUE)));
        $read = stream_socket_client("ssl://" . $orignal_parse . ":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
        $cert = stream_context_get_params($read);
        $certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);
    //     print_r($certinfo['validTo_time_t']);


        if ($certinfo){

            $altNamesStr = $certinfo["extensions"]["subjectAltName"];
            $altNamesStr = str_replace('DNS:'.$site.',', '', $altNamesStr);
            $altNamesStr = str_replace('DNS:', ' ', $altNamesStr);


            $epoch = $certinfo['validFrom_time_t'];
            $dt = new DateTime("@$epoch");  
            $validFrom = $dt->format('m/d/Y');

            $epoch = $certinfo['validTo_time_t'];
            $dt = new DateTime("@$epoch");  
            $validTo = $dt->format('m/d/Y');

            echo '<h2>'.$site . ' is <b style="color:green;">secure!</b></h2><hr> 
                            <div class="statusBoxInfo">
                            <b>Certified in:</b> '. $certinfo["issuer"]["C"]. '<br>
                            <b>Certificate purchased from:</b> '. $certinfo["issuer"]["O"]. '<br>
                            <b>Also known by the Common Name:</b> '. $certinfo["issuer"]["CN"]. '<br>
                            <b>Valid</b> from '. $validFrom. ' to '. $validTo . '<br> 
                            <b>Alternate DNS names:</b> ' . $altNamesStr. '</div>';

        } else{
            echo '<h2>'.$site . ' is <b style="color:red;">not secure!</b></h2><hr>
                            Be wary of entering sensitive information on this site <br>
                            it may get stolen';
        }
    }
}

