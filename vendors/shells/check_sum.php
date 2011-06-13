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
        
        
        //getting campaigns from DB
        
        $stoppedDbCampaigns = $this->Campaign->find('all',
                array(
                        //'conditions'=>array('Campaign.stoped'=>1),
                        'fields'=>array('Campaign.campaign_yn_id','Campaign.id','Campaign.stoped')
                    )
        );

        
        
 
            
        
        
        $notResumed = 0;
        $resumed = 0;
        
        foreach( $stoppedDbCampaigns as $k => $v){
            
            $this->data['Campaign']['stoped'] = 0;
            
            if( $v['Campaign']['stoped'] == 1 ){
                
                $params = array(
                    'CampaignID' => $v['Campaign']['campaign_yn_id']
                );

                $resResume = json_decode($getYnData->getYnData($pathToCerts, 'ResumeCampaign', $params), TRUE);

                if( isset($resResume['data']) && $resResume['data'] != 1){                
                    $this->data['Campaign']['stoped'] = 1;
                    $notResumed++;
                } else if(isset($resResume['error_code'])){
                    $this->data['Campaign']['stoped'] = 1;
                    $notResumed++;
                    CakeLog::write('campResume','campaing: '.$v['Campaign']['campaign_yn_id'].' error code: '.$resResume['error_code']);
                } else {
                    $resumed++;
                }
                
                
            }
            
            
                 
            $this->data['Campaign']['id'] = $v['Campaign']['id'];            
            $this->data['Campaign']['day_spend'] = 0;
            $this->data['Campaign']['rest_sum'] = 0;
             
            $this->Campaign->save($this->data);
            
        }
        
        
       






  
        

        $End = $this->getTime();
        $timeRes = "Time taken = " . number_format(($End - $Start), 2);
        
        $this->out($timeRes . " secs\n");        
        $this->out("done at  ".date('d-m-Y:H.i.s')."\n");
        $this->out("-------------------------------------------------\n");
        
        CakeLog::write('campResume','total Campaigns: '.count($stoppedDbCampaigns).' Resumed: '.$resumed.', Resumed Error: '.$notResumed.' | '.$timeRes.' sek');
    }

}

?>
