<?php

App::import('Component', 'getYnData');

//        $worker= new GearmanWorker();
//        $worker->addServer("127.0.0.1");
//        $worker->addFunction("reverse", 'my_reverse_function');
//        while ($worker->work());
//        
//         function my_reverse_function($job){
//            return strrev($job->workload());
//        }

class WorkerShell extends Shell {

    var $uses = array('Campaign');

    function getTime() {
        $a = explode(' ', microtime());
        return(double) $a[0] + $a[1];
    }


 
   
    
    function main() {

  

  
 
//     /home/www/yzk.zone4test.ru/htdocs/app/vendors/cakeshell update_price -cli /usr/bin -console /home/www/yzk.zone4test.ru/htdocs/cake/console -app /home/www/yzk.zone4test.ru/htdocs/app   
        
        
        $k = 0;
        



        ini_set("max_execution_time", 500);

         $this->out("Worker\n");
         
         

        
        //CakeLog::write('campResume','total Campaigns: '.count($stoppedDbCampaigns).' Resumed: '.$resumed.', Resumed Error: '.$notResumed.' | '.$timeRes.' sek');
    }

}

?>
