<?php

App::import('Component', 'getYnData');


class CheckDayLimShell extends Shell {

    var $uses = array('Campaign');

    function getTime() {
        $a = explode(' ', microtime());
        return(double) $a[0] + $a[1];
    }

    function main() {

        
        
        
        $Start = $this->getTime(); 
        


        ini_set("max_execution_time", 500);

        $getYnData = new getYnDataComponent();
        
        //Configure::load('vars');
        $pathToCerts = $this->args[0];//Configure::read('pathToCerts');


        $notStoppedDbCampaigns = array();
        $resCampaignsBalance = array();
        
        //getting campaigns from DB
        
        $notStoppedDbCampaigns = $this->Campaign->find('all', array(
                    'conditions' => array('Campaign.stoped' => 0),
                    'fields' => array('Campaign.campaign_yn_id', 'Campaign.id', 'Campaign.stoped','Campaign.rest_sum','Campaign.day_spend','Campaign.day_lim')
                        )
        );
        //print_r($notStoppedDbCampaigns);
        $notStoppedDbCampIds = Set::extract('/Campaign/campaign_yn_id',$notStoppedDbCampaigns);       
        //print_r($notStoppedDbCampIds);
        
 
        
        $resCampaignsBalance = json_decode($getYnData->getYnData($pathToCerts, 'GetBalance', $notStoppedDbCampIds), TRUE);       
        //print_r( $resCampaignsBalance);
        
        if( isset($resCampaignsBalance['data']) && $resCampaignsBalance['data'] != array() && $notStoppedDbCampaigns != array() ){
           
            foreach( $notStoppedDbCampaigns as $k => $v ){
                
                foreach ($resCampaignsBalance['data'] as $k2 => $v2 ){
                    
                    
                    
                    if( $v['Campaign']['campaign_yn_id'] == $v2['CampaignID'] ){
                       
                        $this->data['Campaign']['id'] = $v['Campaign']['id'];
                        
                        $rest = round($v2['Rest'],2);
                        
                        $this->data['Campaign']['rest_sum'] = $rest;
                        
                        $sendStep = $v['Campaign']['rest_sum'] - $rest;
                        
                        //if we add money, so the rest of money more then on previous step
                        if($sendStep > 0 && $v['Campaign']['rest_sum'] != 0 ){
                            
                            $daySpend = $sendStep + $v['Campaign']['day_spend'];
                            $this->data['Campaign']['day_spend'] = round($daySpend,2);
                            

                            
                            
                            
                            if ($daySpend > $v['Campaign']['day_lim'] && $v['Campaign']['day_lim'] != 0) {
                                //to add stop comaing here

                                $params = array(
                                    'CampaignID' => $v['Campaign']['campaign_yn_id']
                                );

                                $resStop = json_decode($getYnData->getYnData($pathToCerts, 'StopCampaign', $params), TRUE);
                                //print_r($resStop);
                                if( isset($resStop['data']) && $resStop['data'] == 1) {
                                    $this->data['Campaign']['stoped'] = 1;
                                    CakeLog::write('campStopped','Stopped Campaign ID: '.$v['Campaign']['campaign_yn_id']);
                                }        
                                
                            }
                            
                            
                            
                        }
                        
                         

                       
                        $this->Campaign->save($this->data);
                        unset($this->data['Campaign']);
                        break;
                        
                    }
                    
                }
                
                
            }
            
            
            
            
            
        }
        //check if error

        
       






  
        

        $End = $this->getTime();
        $timeRes = "Time taken = " . number_format(($End - $Start), 2);
        
        $this->out($timeRes . " secs\n");        
        $this->out("done at  ".date('d-m-Y:H.i.s')."\n");
        $this->out("-------------------------------------------------\n");
        
        CakeLog::write('campCheckDayLim',$timeRes.' sek');
    }

}

?>
