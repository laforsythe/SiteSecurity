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
        $url = "http://www." . $site;
        $orignal_parse = parse_url($url, PHP_URL_HOST);
        $get = stream_context_create(array("ssl" => array("capture_peer_cert" => TRUE)));
        $read = stream_socket_client("ssl://" . $orignal_parse . ":443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $get);
        $cert = stream_context_get_params($read);
        $certinfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);
        print_r($certinfo);


      /*  if ($certinfo){
            echo $site . ' is secure!';
        } else{
            echo $site . ' is not secure!';
        }  */
    }
}

