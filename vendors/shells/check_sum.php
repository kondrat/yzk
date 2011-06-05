<?php

App::import('Component', 'getYnData');


class CheckSumShell extends Shell {

    var $uses = array('Campaign');

    function getTime() {
        $a = explode(' ', microtime());
        return(double) $a[0] + $a[1];
    }

    function main() {

        
        
        
        $Start = $this->getTime(); 
        


        ini_set("max_execution_time", 500);

        $getYnData = new getYnDataComponent();
        
        Configure::load('vars');
        $pathToCerts = Configure::read('pathToCerts');


        $stoppedDbCampaigns = array();
        $stoppedYnCampaignIds = array();
        
        //getting phrases from DB
        
        $stoppedDbCampaigns = $this->Campaign->find('all',
                array('conditions'=>array('Campaign.stoped'=>1),
                        'fields'=>array('Campaign.campaign_yn_id','Campaign.id')
                    )
        );

        $stoppedYnCampaignIds = Set::extract('/Campaign/campaign_yn_id',$stoppedDbCampaigns);
        
 
            
        //$resAllCamp = json_decode($getYnData->getYnData($pathToCerts, 'ResumeCampaign', $params), TRUE);
        
        //print_r($resAllCamp);
        
        foreach( $stoppedDbCampaigns as $k => $v){
            
             $params = array(
                'CampaignID' => $v['Campaign']['campaign_yn_id']
            );
            $resResume = json_decode($getYnData->getYnData($pathToCerts, 'ResumeCampaign', $params), TRUE);
            if($resResume['data'] === 1){
                
                
                $this->data['Campaign']['stoped'] = 0;
                 $this->data['Campaign']['id'] = $v['Campaign']['id'];
                 
                 $this->Campaign->save($this->data);
            } 
            
        }
        
        
       






  
        

        $End = $this->getTime();
        $timeRes = "Time taken = " . number_format(($End - $Start), 2);
        $this->out($timeRes . " secs\n");
        
        $this->out("done at  ".date('d-m-Y:H.i.s')."\n");
        $this->out("-------------------------------------------------\n");
        
        CakeLog::write('campResume',count($stoppedDbCampaigns).' | '.$timeRes.' sek');
    }

}

?>
