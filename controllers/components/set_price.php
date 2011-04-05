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
                    //two % to print "%"leteral
                    "desc" => __("Warranty + %s%%",true),
                    "priceType" => "max"
                ),
                array(
                    "name" => "maxC",
                    //"func" => "$price+$x",
                    "desc" => __("Warranty + %s cent",true),
                    "priceType" => "min"
                )
            );  
    function setPrice($method=NULL, $price=array(), $x= NULL) {

        switch ($method) {
            case 'maxP':
                $pr = $price[];
                $resPrice = $pr / 100 * $x + $pr;
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
