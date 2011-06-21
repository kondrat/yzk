<?php

App::import('Component', 'getYnData');
App::import('Component','setPrice');

class UpdatePriceShell extends Shell {

    var $uses = array('Phrase');

    function getTime() {
        $a = explode(' ', microtime());
        return(double) $a[0] + $a[1];
    }

    function main() {

        
        
        
        $Start = $this->getTime(); 
        $startAt = "Start at  " . date('d-m-Y:H.i.s');
 
        
        //$this->out('result:' . "\n");

        ini_set("max_execution_time", 500);

        $getYnData = new getYnDataComponent();
        $setPrice = new setPriceComponent();
        
//        Configure::load('vars');
//        $pathToCerts = Configure::read('pathToCerts');
        $pathToCerts = $this->args[0];
        //getting an information about clients;
        $allDbPharses = array();

        $resAllClients = array();
        $resAllPhrases = array();
        $resAllBanners = array();


        
        //getting phrases from DB
        
        $allDbPharses = $this->Phrase->find('all');

        if ($allDbPharses == array()) {
            //$this->out("allDbPharses = array()");
            return;
        }






        $resAllClients = json_decode($getYnData->getYnData($pathToCerts, 'GetClientsList'), TRUE);
        


        if ($resAllClients == array() || !isset($resAllClients['data'])) {
            $this->out("resAllClients = array()");            
            //log this situation                      
            return;
        }
        
//        print_r($resAllClients['data']);
//        return;
        $this->out("Res All Clients Arch: ".count($resAllClients['data']."\n"));
        

        //extractiong active clients only, not in archive
        $resActiveClients = array();
        foreach ($resAllClients['data'] as $k => $v) {
            if ($v['StatusArch'] == "No") {
                $resActiveClients[] = $v['Login'];
            }
        }
        
        $this->out("Res All Clients NOT Arch: ".count($resActiveClients)."\n");

        
        //getting information about clients campaigns( filtered not archive);
        $params = array('Logins' => $resActiveClients, 'Filter' => array(
                'StatusArchive' => array('No'),
                'StatusShow' => array('Yes'),
                'IsActive' => array('Yes')
            )
        );
        
        $resAllCampaigns = json_decode($getYnData->getYnData($pathToCerts, 'GetCampaignsListFilter', $params), TRUE);

        if ($resAllCampaigns == array() || !isset($resAllCampaigns['data'])) {
            //$this->out("resAllCampaigns = array()");
            return;
        }

        
        $this->out("Res All Campaigns HERE: ".count($resAllCampaigns['data']));
        

        //this due to yandex restrictions to pass only 10 camaigns IDs we make array for the loop.
        $resAllCampaignsIdbatch10 = array();
        $i = 0;
        $j = 0;
        foreach ($resAllCampaigns['data'] as $k => $v) {
            $resAllCampaignsIdbatch10[$j][$i] = $v['CampaignID'];
            $i++;
            if ($i == 10) {
                $j++;
                $i = 0;
            }
        }

        //getting information about banners.
        foreach ($resAllCampaignsIdbatch10 as $k2 => $v2) {

            $params2 = array(
                'CampaignIDS' => $v2, 
                'Filter' => array('StatusArchive' => array('No'),
                                    'IsActive' => array('Yes'),
                                    'StatusShow' => array('Yes')
                    )
                );
            $tempBanners = json_decode($getYnData->getYnData($pathToCerts, 'GetBanners', $params2), TRUE);
            $resAllBanners[] = $tempBanners['data'];
            unset($tempBanners);
        }

        if ($resAllBanners == array()) {
            //$this->out("resAllBanners = array()");
            return;
        }
 
        
        
 
        
        //and finaly we get bannersIds as one array. next we need to check if ammount less then 1000 (yandex.api restiction);
        $resAllBannersIDs = array();
        foreach ($resAllBanners as $k3 => $v3) {
            foreach ($v3 as $k4 => $v4) {
                $resAllBannersIDs[] = $v4['BannerID'];
                //$this->out($v4['BannerID']."\n");
            }
        }
        
        $this->out("Res All Banners: ".count($resAllBannersIDs)."\n");
        
        
        
        
        //getting information about phrases( filtered not archive);
        $params3 = array('BannerIDS' => $resAllBannersIDs, 'FieldsNames' => array('Price', 'Max', 'Min', 'PremiumMax', 'PremiumMin','LowCTR'), 'RequestPrices' => 'Yes');

        $resAllPhrases = json_decode($getYnData->getYnData($pathToCerts, 'GetBannerPhrasesFilter', $params3), TRUE);
        if (!isset($resAllPhrases['data'])) {
            return;
        }

        $this->out("res All Phrases before: ".count($resAllPhrases['data'])."\n");

        foreach ($resAllPhrases['data'] as $k9 => $v9){
            if($resAllPhrases['data'][$k9]['LowCTR'] == 'Yes'){
                unset($resAllPhrases['data'][$k9]);
            }
        }
        
       $this->out("Res All Phra after: ".count($resAllPhrases['data'])."\n");
        
        
        //$Start = $this->getTime();

        $phraseToUpdate = array();

        
        foreach ($allDbPharses as $k5 => $v5) {

          
            foreach ($resAllPhrases['data'] as $k6 => $v6) {

                if ($v5['Phrase']['phrase_yn_id'] == $v6['PhraseID'] && $v5['Phrase']['campaing_yn_id'] == $v6['CampaignID'] && $v5['Phrase']['banner_yn_id'] == $v6['BannerID']&&$v6['LowCTR'] != 'Yes' ) {
                    
                    $mode = $v5['Phrase']['mode'];
                    $modeX = $v5['Phrase']['mode_x'];
                                        
                    $newPrice = $setPrice->setPrice( $mode,$modeX,$v6['Min'],$v6['Max'],$v6['PremiumMin'],$v6['PremiumMax'],$v5['Phrase']['price'] );
                    
                    if ($newPrice > 0) {
                        $phraseToUpdate[$k5]['CampaignID'] = $v5['Phrase']['campaing_yn_id'];
                        $phraseToUpdate[$k5]['BannerID'] = $v5['Phrase']['banner_yn_id'];
                        $phraseToUpdate[$k5]['PhraseID'] = $v5['Phrase']['phrase_yn_id'];
                        $phraseToUpdate[$k5]['Price'] = $newPrice;
                    }
                    
                    
                    break;
                    
                }

            }
           
            
        }
  
        //print_r($phraseToUpdate);
        
        $this->out("Res phrase To Update: ".count($phraseToUpdate)."\n");
        
        

        
 
        
//@todo
  
        $phraseToUpdate1000 = array();
        $i = 0;
        $j = 0;
        foreach ($phraseToUpdate as $k8 => $v8) {
            $phraseToUpdate1000[$j][$i]["CampaignID"] = $v8["CampaignID"];
            $phraseToUpdate1000[$j][$i]["BannerID"] = $v8["BannerID"];
            $phraseToUpdate1000[$j][$i]["PhraseID"] = $v8["PhraseID"];
            $phraseToUpdate1000[$j][$i]["Price"] = $v8["Price"];
            $i++;
            if ($i == 1000) {
                $j++;
                $i = 0;
            }
        }       
        
        //print_r($phraseToUpdate1000);
        //updating prices for all phrases ( filtered not archive);
        foreach ($phraseToUpdate1000 as $v9){
            
            
                
                $params4 = $v9;
                $resAllUpdatedPrices[] = json_decode($getYnData->getYnData($pathToCerts, 'UpdatePrices', $params4), TRUE);
                
            
        }
        
        $updatedResForLog = "updateOk";
        foreach ($resAllUpdatedPrices as $v10){
            if($v10 == 0){
                $updatedResForLog = "notUpdated";
                break;
            }
        }
        
        

        
        
        
        //@todo Update price finaly. 1000 phrases per request

        

        $End = $this->getTime();
        $timeRes = "Time taken = " . number_format(($End - $Start), 2);
        $this->out($timeRes . " secs\n");
        
        $this->out("done at  ".date('d-m-Y:H.i.s')."\n");
        $doneAt = "done at  ".date('d-m-Y:H.i.s');
        $this->out("-------------------------------------------------\n");
        
        CakeLog::write('updateRes',$startAt.' | '. $updatedResForLog.' | '.$timeRes.' sek, | '.$doneAt);
    }

}

?>
