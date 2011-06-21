<?php

App::import('Component', 'getYnData');


class TtShell extends Shell {

    var $uses = array('Campaign');

    function getTime() {
        $a = explode(' ', microtime());
        return(double) $a[0] + $a[1];
    }

    
    
    function getTest($xx) {
        $xx++;
        $Start = $this->getTime();
        $startAt = "Start at  " . date('d-m-Y:H.i.s');
        $this->out("Start at  " . date('d-m-Y:H.i.s') . "\n");
        for ($i = 0; $i >= 0; $i++) {

            $spend = $this->getTime();
            $curRes = number_format(($spend - $Start), 2);
            //$tR = "Current taken = " . $curRes;
            //$this->out($tR  . " secs\n");
            if ($curRes >= 20) {

                break;
            }
            
        }

        $End = $this->getTime();
        $timeRes = "Time taken = " . number_format(($End - $Start), 2);

        $this->out($timeRes . " secs\n");
        $this->out("done at  " . date('d-m-Y:H.i.s') . "\n");
        CakeLog::write('ttTest',$startAt.' | '.$timeRes ." secs, done at  ".date('d-m-Y:H.i.s')." | ".$this->args[0]."\n");
    }
    
    
    
    function main() {

        
        $k = 0;
        



        ini_set("max_execution_time", 500);

         $this->out('lets go');
         
         for($i=0;$i<=0;$i++){
             $this->getTest(&$k);
             $this->out("k: ".$k."--------------------------------------------\n");
             $this->out("--------------------------------------------\n");
         }
         
         
        
        //CakeLog::write('campResume','total Campaigns: '.count($stoppedDbCampaigns).' Resumed: '.$resumed.', Resumed Error: '.$notResumed.' | '.$timeRes.' sek');
    }

}

?>
