<?php

/*
 * Yandex DataSource
 * 
 */


$userAgent = "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.2.1) Gecko/20021204";

if (@function_exists("curl_init")) {

    // allways use curl if available for performance issues
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_URL, "http://translate.google.com/translate_a/t?");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_TIMEOUT, 4);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "client=t&sl=" . $from . "&tl=" . $to . "&text=" . $str);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //curl_setopt($ch, CURLOPT_STDERR, $fpEr); 

    if (!($contents = trim(@curl_exec($ch)))) {
        echo 'ploho';
        exit;
        //$this->debugRes("error","curl_exec failed");
    }
}

function get_https_file($url) {
    // create a new cURL resource
    $ch = curl_init();

    # !CHANGE THE PATH TO SSL CERTIFICATES!
    $path = "/home/www/yzk.go/htdocs/app/certs";

    // set URL and other options
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CAPATH, $path);
    curl_setopt($ch, CURLOPT_CAINFO, $path . "/cacert.pem");
    curl_setopt($ch, CURLOPT_SSLCERT, $path . "/cert.crt");
    curl_setopt($ch, CURLOPT_SSLKEY, $path . "/private.key");

    $result = curl_exec($ch);

    if (curl_errno($ch) != 0) {
        die('CURL_error: ' . curl_errno($ch) . ', ' . curl_error($ch));
    }

    // close the cURL resource and free the system resources
    curl_close($ch);

    return $result;
}

?>
