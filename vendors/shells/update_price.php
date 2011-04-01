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

        ini_set("max_execution_time", 300);

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
            $this->out("allDbPharses = array()");
            return;
        }



//        print_r($allDbPharses);
//        
//        $End = $this->getTime();
//        $this->out("Time taken = ".number_format(($End - $Start),2)." secs\n");
//        return;


        $resAllClients = json_decode($getYnData->getYnData($pathToCerts, 'GetClientsList'), TRUE);
        //$resAllPhrases = $resAllClients = $getYnData->getYnData('GetClientsList');


        if ($resAllClients == array() || !isset($resAllClients['data'])) {
            $this->out("resAllClients = array()");
            return;
        }


        //extractiong active clients only, not in archive
        $resActiveClients = array();
        foreach ($resAllClients['data'] as $k => $v) {
            if ($v['StatusArch'] == "No") {
                $resActiveClients[] = $v['Login'];
            }
        }

        //getting information about clients campaigns( filtered not archive);
        $params = array('Logins' => $resActiveClients, 'Filter' => array('StatusArchive' => array('No')));
        $resAllCampaigns = json_decode($getYnData->getYnData($pathToCerts, 'GetCampaignsListFilter', $params), TRUE);

        if ($resAllCampaigns == array() || !isset($resAllCampaigns['data'])) {
            $this->out("resAllCampaigns = array()");
            return;
        }



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
            $this->out("resAllBanners = array()");
            return;
        }
        //$this->out(count($resAllBanners));
        //and finaly we get bannersIds as one array. next we need to check if ammount less then 1000 (yandex.api restiction);
        $resAllBannersIDs = array();
        foreach ($resAllBanners as $k3 => $v3) {
            foreach ($v3 as $k4 => $v4) {
                $resAllBannersIDs[] = $v4['BannerID'];
                //$this->out($v4['BannerID']."\n");
            }
        }
        //$this->out( count($resAllBannersIDs )."\n");
        //getting information about phrases( filtered not archive);
        $params3 = array('BannerIDS' => $resAllBannersIDs, 'FieldsNames' => array('Price', 'Max', 'Min', 'PremiumMax', 'PremiumMin'), 'RequestPrices' => 'Yes');

        //$params3 = array('BannerIDS'=>array(4345227),'FieldsNames'=>array('Price','Max','Min','PremiumMax','PremiumMin' ),'RequestPrices'=>'Yes' );

        $resAllPhrases = json_decode($getYnData->getYnData($pathToCerts, 'GetBannerPhrasesFilter', $params3), TRUE);
        if (!isset($resAllPhrases['data'])) {
            return;
        }


        $Start = $this->getTime();

        $phraseToUpdate = array();
        
        foreach ($allDbPharses as $k5 => $v5) {


            $phraseToUpdate[$k5]['id'] = $v5['Phrase']['id'];
            $phraseToUpdate[$k5]['todel'] = $v5['Phrase']['id'];
            $phraseToUpdate[$k5]['ynPhraseId'] = $v5['Phrase']['phrase_yn_id'];

            foreach ($resAllPhrases['data'] as $k6 => $v6) {

                if ($v5['Phrase']['phrase_yn_id'] == $v6['PhraseID'] && $v5['Phrase']['campaing_yn_id'] == $v6['CampaignID'] && $v5['Phrase']['banner_yn_id'] == $v6['BannerID']) {

                    $phraseToUpdate[$k5]['id'] = $v5['Phrase']['id'];
                    $phraseToUpdate[$k5]['ynPhraseId'] = $v5['Phrase']['phrase_yn_id'];
                    $phraseToUpdate[$k5]['todel'] = 'notdel';                   
                    break;
                    
                }

            }
           
        }
        
        print_r($phraseToUpdate);
        
        $phraseToDel = array();
        //$phraseToDel = Set::extract('/todel', $phraseToUpdate);
        foreach ($phraseToUpdate as $v7){
            if($v7['todel'] != 'notdel'){
               $phraseToDel[] =  $v7['id'];
            }
        }
        
        
        //deleting all the phrases wich are not confirmed
        if( $phraseToDel!= array() ) {
            $this->Phrase->deleteAll( 
                    array('Phrase.id' => $phraseToDel)               
            );
        }
        
        
        
        //@todo Update price finaly. 1000 phrases per request

        $this->out('----------------------------------------' . "\n");

        $End = $this->getTime();
        $this->out("Time taken = " . number_format(($End - $Start), 2) . " secs\n");
        
    }

}

?>
