<?php

/**
 * retriving data from api.direct.yandex.ru via ajax
 *
 * @author kondrat
 */
class setPriceComponent extends Object {

    /**
     *
     * @param sting $method
     * @param array $params
     * @return json 
     */
    
    var $modes = array(
                array(
                    "name" => "maxP",
                    //"func" => "$price/100*$x+$price",
                    "desc" => "Warranty + %s%%" //two % to print "%"leteral
                ),
                array(
                    "name" => "maxC",
                    //"func" => "$price+$x",
                    "desc" => "Warranty + %s cent"
                )
            );  
    function setPrice($method=NULL, $price=NULL, $x = NULL) {

        switch ($method) {
            case 'maxP':
                $resPrice = $price / 100 * $x + $price;
                break;
            case 'maxC':
                $resPrice = $price + $x;
                break;
            default :
                $resPrice = 0;
                break;
        }

        return $resPrice;
    }


}

?>
