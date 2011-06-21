<?php

App::import('Component', 'getYnData');




class MmShell extends Shell {

    var $uses = array('Campaign');

    function getTime() {
        $a = explode(' ', microtime());
        return(double) $a[0] + $a[1];
    }

    
  
   
    
    function main() {

//  
//        $worker= new GearmanWorker();
//        $worker->addServer("127.0.0.1");
//        $worker->addFunction("reverse", "my_reverse_function");
//        while ($worker->work());
//        
//        function my_reverse_function($job){
//            return strrev($job->workload());
//        } 
        
        
        
        $k = 0;
        



        ini_set("max_execution_time", 500);

         $this->out('MM');
         
         

        
        //CakeLog::write('campResume','total Campaigns: '.count($stoppedDbCampaigns).' Resumed: '.$resumed.', Resumed Error: '.$notResumed.' | '.$timeRes.' sek');
    }

}

?>
