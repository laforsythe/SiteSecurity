<?php

if(isset($_GET['website'])) {
    $site = $_GET['website'];

    if ($site !== '') {

        /*
                $stream = stream_context_create (array("ssl" => array("capture_peer_cert" => true)));
                $read = fopen("https://www.".$site , "rb", false, $stream);
                $cont = stream_context_get_params($read);
                $var = ($cont["options"]["ssl"]["peer_certificate"]);
                $result = !is_null($var);
                $response = "";
                if ($result) {
                    $response = $site . " is secure!";
                } else{
                    $response = $site . " is not secure!";
                }
                echo $response;
            }
        */

        $site = str_replace('http://www.', '', $site);
        $site = str_replace('https://www.', '', $site);
        $site = str_replace('www.', '', $site);
        $site = str_replace('https://', '', $site);
        $site = str_replace('http://', '', $site);
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
            $dt = new DateTime("@$epoch");  // convert UNIX timestamp
            $validFrom = $dt->format('m/d/Y');

            $epoch = $certinfo['validTo_time_t'];
            $dt = new DateTime("@$epoch");  // convert UNIX timestamp
            $validTo = $dt->format('m/d/Y');

            echo '<h2><b style="color:green;">'.$site . '</b> has a security certificate installed and some pages may be secured.
                            <br>When submitting sensitive information, look for the lock item</h2><hr> 
                            <div class="statusBoxInfo">
                            <b>Certified in:</b> '. $certinfo["issuer"]["C"]. '<br>
                            <b>Certificate purchased from:</b> '. $certinfo["issuer"]["O"]. '<br>
                            <b>Also known by the Common Name:</b> '. $certinfo["issuer"]["CN"]. '<br>
                            <b>Valid:</b> from '. $validFrom. ' to '. $validTo . '<br> 
                            <b>Alternate DNS names:</b> ' . $altNamesStr. '</div>';

        } else{
            echo '<h2><b style="color:green;">'.$site . '</b> does not have a security certificate installed do not <br>
                            enter any sensitive information on the site anywhere!</h2><hr>
                            <div class="statusBoxInfo">
                            Be wary of entering sensitive information on this site <br>
                            it may get stolen </div>';
        }
    }
}


/*
 *
 * Array ( [name] => /C=US/ST=California/L=Mountain View/O=Google LLC/CN=www.google.com [subject] => Array ( [C] => US
 *  [ST] => California [L] => Mountain View [O] => Google LLC [CN] => www.google.com ) [hash] => 14dda233 [issuer]
 *  => Array ( [C] => US [O] => Google Trust Services [CN] => Google Internet Authority G3 )
 * [version] => 2 [serialNumber] => 9108818480836221711559663233636725789
 * [serialNumberHex] => 06DA4B6CAD3471E1D91BA403459F741D [validFrom] => 190326133823Z
 * [validTo] => 190618132400Z [validFrom_time_t] => 1553607503 [validTo_time_t] => 1560864240
 * [signatureTypeSN] => RSA-SHA256 [signatureTypeLN] => sha256WithRSAEncryption [signatureTypeNID] => 668
 * [purposes] => Array ( [1] => Array ( [0] => [1] => [2] => sslclient )
 * [2] => Array ( [0] => 1 [1] => [2] => sslserver ) [3] => Array ( [0] => [1] => [2] => nssslserver )
 *  [4] => Array ( [0] => [1] => [2] => smimesign ) [5] => Array ( [0] => [1] => [2] => smimeencrypt )
 * [6] => Array ( [0] => [1] => [2] => crlsign ) [7] => Array ( [0] => 1 [1] => 1 [2] => any )
 *  [8] => Array ( [0] => 1 [1] => [2] => ocsphelper ) [9] => Array ( [0] => [1] => [2] => timestampsign ) )
 * [extensions] => Array ( [extendedKeyUsage] => TLS Web Server Authentication
 * [keyUsage] => Digital Signature [subjectAltName] => DNS:www.google.com
 * [authorityInfoAccess] => CA Issuers - URI:http://pki.goog/gsr2/GTSGIAG3.crt OCSP - URI:http://ocsp.pki.goog/GTSGIAG3
 * [subjectKeyIdentifier] => 1F:0D:A6:EA:EA:2B:6E:96:1B:5C:99:B5:C3:3D:6F:5F:4B:0D:BE:9F [basicConstraints] => CA:FALSE
 *  [authorityKeyIdentifier] => keyid:77:C2:B8:50:9A:67:76:76:B1:2D:C2:86:D0:83:A0:7E:A6:7E:BA:4B
 * [certificatePolicies] => Policy: 1.3.6.1.4.1.11129.2.5.3 Policy: 2.23.140.1.2.2
 * [crlDistributionPoints] => Full Name: URI:http://crl.pki.goog/GTSGIAG3.crl ) )
 */
