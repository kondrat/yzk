<?php

App::import('Component', 'getYnData');



//# create our client object
//$gmclient= new GearmanClient();
//
//# add the default server (localhost)
//$gmclient->addServer("127.0.0.1");
//
//# run reverse client in the background
//$job_handle = $gmclient->do("reverse", "this is a test");
//
//print $job_handle;
//
//if ($gmclient->returnCode() != GEARMAN_SUCCESS)
//{
//  echo "bad return code\n";
//  exit;
//} else {
//    echo "od";
//}


class ClientShell extends Shell {

    var $uses = array('Campaign');

    function getTime() {
        $a = explode(' ', microtime());
        return(double) $a[0] + $a[1];
    }

    
  
   
    
    function main() {
        Configure::load('vars');
        $pathToCerts = Configure::read('pathToCerts');
//  
//        $worker= new GearmanWorker();
//        $worker->addServer("127.0.0.1");
//        $worker->addFunction("reverse", "my_reverse_function");
//        while ($worker->work());
//        
//        function my_reverse_function($job){
//            return strrev($job->workload());
//        } 
        for ( $i = 0; $i <= 3; $i++){
            
            $Start = $this->getTime();

             for ($y = 0; $y >= 0; $y++) {

                $spend = $this->getTime();
                $curRes = number_format(($spend - $Start), 2);

                if ($curRes >= 2) {
                    $toExec = '/home/www/yzk.go/htdocs/app/vendors/cakeshell update_price '.$pathToCerts.' -cli /usr/bin -console /home/www/yzk.go/htdocs/cake/console -app /home/www/yzk.go/htdocs/app > /dev/null &';
                    exec($toExec);
                    break;
                }
                

            }
            
        }

        
//        for ( $i = 0; $i <= 3; $i++){
//            exec('/home/www/yzk.go/htdocs/app/vendors/cakeshell tt -cli /usr/bin -console /home/www/yzk.go/htdocs/cake/console -app /home/www/yzk.go/htdocs/app > /dev/null &');
//        }
        
       //exec('/home/www/yzk.go/htdocs/app/vendors/cakeshell tt -cli /usr/bin -console /home/www/yzk.go/htdocs/cake/console -app /home/www/yzk.go/htdocs/app > /dev/null &');       
        
        $k = 0;
        



        ini_set("max_execution_time", 500);

         $this->out("Client 111 \n");
         
         

        
        //CakeLog::write('campResume','total Campaigns: '.count($stoppedDbCampaigns).' Resumed: '.$resumed.', Resumed Error: '.$notResumed.' | '.$timeRes.' sek');
    }

}

?>
