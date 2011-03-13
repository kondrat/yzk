<?php

/**
 * retriving data from api.direct.yandex.ru via ajax
 *
 * @author kondrat
 */
class getYnDataComponent extends Object {

    /**
     *
     * @param sting $method
     * @param array $params
     * @return json 
     */
    function getYnData($method=null, $params=array()) {
        // create a new cURL resource
        $ch = curl_init();

        //@todo add opportinity to add more certs per each user

        $path = Configure::read('pathToCerts');


        $url = "https://soap.direct.yandex.ru/json-api/v3/";

        //@todo sinitize this
        //$method = ''; //$this->data['method'];
        //$params = '';
        //request for yandex in json.
        $jsonReq = json_encode(
                array(
                    "method" => $method,
                    "param" => $params
                )
        );




            // set URL and other options
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_CAPATH, $path);
            curl_setopt($ch, CURLOPT_CAINFO, $path . "/cacert.pem");
            curl_setopt($ch, CURLOPT_SSLCERT, $path . "/cert.crt");
            curl_setopt($ch, CURLOPT_SSLKEY, $path . "/private.key");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonReq);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $contents = curl_exec($ch);

            if (curl_errno($ch) != 0) {
                //$contents["stat"] = 0;
                $contents["error"] = ('CURL_error: ' . curl_errno($ch) . ', ' . curl_error($ch));
                
            }

            // close the cURL resource and free the system resources
            curl_close($ch);
            
            return $contents;
    }


}

?>
