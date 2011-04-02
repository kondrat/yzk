<?php

App::import('Component', 'getYnData');

class UpdatePriceShell extends Shell {

    var $uses = array('Phrase');

    function getTime() {
        $a = explode(' ', microtime());
        return(double) $a[0] + $a[1];
    }

    function main() {

        //$Start = $this->getTime(); 

        $this->out('result:' . "\n");

        ini_set("max_execution_time", 500);

        $getYnData = new getYnDataComponent();
        Configure::load('vars');
        $pathToCerts = Configure::read('pathToCerts');

        //getting an information about clients;
        $allDbPharses = array();

        $resAllClients = array();
        $resAllPhrases = array();
        $resAllBanners = array();


        $allDbPharses = $this->Phrase->find('all');

        if ($allDbPharses == array()) {
            //$this->out("allDbPharses = array()");
            return;
        }






        $resAllClients = json_decode($getYnData->getYnData($pathToCerts, 'GetClientsList'), TRUE);
        


        if ($resAllClients == array() || !isset($resAllClients['data'])) {
            $this->out("resAllClients = array()");
            return;
        }
        
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
                                    'IsActive' => array('Yes')
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
        $params3 = array('BannerIDS' => $resAllBannersIDs, 'FieldsNames' => array('Price', 'Max', 'Min', 'PremiumMax', 'PremiumMin'), 'RequestPrices' => 'Yes');

        //$params3 = array('BannerIDS'=>array(4345227),'FieldsNames'=>array('Price','Max','Min','PremiumMax','PremiumMin' ),'RequestPrices'=>'Yes' );

        $resAllPhrases = json_decode($getYnData->getYnData($pathToCerts, 'GetBannerPhrasesFilter', $params3), TRUE);
        if (!isset($resAllPhrases['data'])) {
            return;
        }

        $this->out("res All Phrases: ".count($resAllPhrases['data'])."\n");

        
        $Start = $this->getTime();

        $phraseToUpdate = array();

        
        foreach ($allDbPharses as $k5 => $v5) {


            $phraseToUpdate[$k5]['id'] = $v5['Phrase']['id'];
            $phraseToUpdate[$k5]['todel'] = 'yes';//$v5['Phrase']['id'];
            $phraseToUpdate[$k5]['ynPhraseId'] = $v5['Phrase']['phrase_yn_id'];

            foreach ($resAllPhrases['data'] as $k6 => $v6) {

                if ($v5['Phrase']['phrase_yn_id'] == $v6['PhraseID'] && $v5['Phrase']['campaing_yn_id'] == $v6['CampaignID'] && $v5['Phrase']['banner_yn_id'] == $v6['BannerID']) {

                    //$phraseToUpdate[$k5]['id'] = $v5['Phrase']['id'];
                    //$phraseToUpdate[$k5]['ynPhraseId'] = $v5['Phrase']['phrase_yn_id'];
                    $phraseToUpdate[$k5]['todel'] = 'notdel';                   
                    break;
                    
                }

            }
           
            
        }
  

        
        $this->out("Res phrase To Update: ".count($phraseToUpdate)."\n");
        
        $phraseToDel = array();
        $phraseFinal = array();
        
        foreach ($phraseToUpdate as $v7){
            if($v7['todel'] != 'notdel'){
               $phraseToDel[] =  $v7['id'];
            } else {
                $phraseFinal[] = $v7['ynPhraseId'];
            }
        }
        
        $this->out("Res phrase Final: ".count($phraseFinal)."\n");
        
        //deleting all the phrases wich are not confirmed
        if( $phraseToDel!= array() ) {
            $this->Phrase->deleteAll( 
                    array('Phrase.id' => $phraseToDel)               
            );
        }
        
  
        $phraseToUpdate1000 = array();
        $i = 0;
        $j = 0;
        foreach ($phraseFinal as $k8 => $v8) {
            $phraseToUpdate1000[$j][$i] = $v8['ynPhraseId'];
            $i++;
            if ($i == 1000) {
                $j++;
                $i = 0;
            }
        }       
        
        print_r($phraseToUpdate1000);
        
        
        //@todo Update price finaly. 1000 phrases per request

        $this->out('----------------------------------------' . "\n");

        $End = $this->getTime();
        $this->out("Time taken = " . number_format(($End - $Start), 2) . " secs\n");
        
    }

}

?>
