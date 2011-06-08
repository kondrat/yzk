<?php

App::import('Sanitize');

class CampaignsController extends AppController {

    var $name = 'Campaigns';
    var $publicActions = array('getYnCampList', 'getYnCampInfo', 'getYnBanInfo','startStop','dayBud');
    var $helpers = array('Text');
    var $components = array('setPrice');

//--------------------------------------------------------------------

    function beforeFilter() {

        //default title
        $this->set('title_for_layout', __('Companies', true));
        //allowed actions
        $this->Auth->allow('index', 'campaign', 'banner');

        parent::beforeFilter();
        $this->Auth->autoRedirect = false;

        // swiching off Security component for ajax call

        if ($this->RequestHandler->isAjax() && in_array($this->action, $this->publicActions)) {
            $this->Security->validatePost = false;
        }

        $this->disableCache();
    }

    /**
     * @return type
     * 
     */
    function index() {

        $this->set('title_for_layout', __('Campaigns', true));
        $this->set('menuType', 'regged');

        $clientName = null;


        if (isset($this->params['named']['client']) && $this->params['named']['client'] !== null) {

            if ($this->Auth->user('group_id') == 4) {

                $clientName = $this->Auth->user('ynLogin');
                if ($clientName != $this->params['named']['client']) {
                    $this->redirect('/');
                }
            } else {
                $clientName = Sanitize::paranoid($this->params['named']['client'], array('-'));
            }
        } else {
            if ($this->Auth->user('group_id') == 4) {
                $clientName = $this->Auth->user('ynLogin');
            }
        }


        $this->set('clientName', $clientName);
        $this->set("modes", $this->setPrice->modes);
    }

    /**
     *  retriving given client's campaings from api.direct.yandex.ru via ajax
     * @param
     * 
     * @return json
     * @access public
     */
    public function getYnCampList() {

        $clientName = NULL;

        if ($this->RequestHandler->isAjax()) {

            Configure::write('debug', 0);
            $this->autoLayout = false;
            $this->autoRender = FALSE;

            $pathToCerts = Configure::read('pathToCerts');

            $clientName = Sanitize::paranoid($this->data['clname'], array('-'));



            if ($this->Auth->user('group_id') == 4) {
                $clientName = $this->Auth->user('ynLogin');
            } else {
                $clientName = Sanitize::paranoid($this->data['clname'], array('-'));
            }


            $params = array(
                'Logins' => array($clientName),
                'Filter' => array(
                    'StatusArchive' => array('No')
                )
            );
            $resAllCamp = json_decode($this->getYnData->getYnData($pathToCerts, 'GetCampaignsListFilter', $params), TRUE);

            function cmp($a, $b) {
                if ($a["CampaignID"] == $b["CampaignID"]) {
                    return 0;
                }
                return ($a["CampaignID"] < $b["CampaignID"]) ? -1 : 1;
            }

            usort($resAllCamp['data'], "cmp");
            
            //gettin info form DB about day budget Limit
            
            $campId = Set::extract('/data/CampaignID',$resAllCamp);
            $resAllCamp['campId'] = $campId;
            
            $camFromDb = $this->Campaign->find('all', array(
                        'conditions' => array('Campaign.campaign_yn_id' => $campId)
                            )
            );
            //$resAllCamp['test'] = $camFromDb;

            foreach ($resAllCamp['data'] as $k=>$v){
                $resAllCamp['data'][$k]['dayLim'] = 0;
                $resAllCamp['data'][$k]['daySpend'] = 0;
                $resAllCamp['data'][$k]['stoped'] = 0;
                
                foreach ($camFromDb as $k2=>$v2){
                    if($v2['Campaign']['campaign_yn_id'] == $resAllCamp['data'][$k]['CampaignID']){
                       $resAllCamp['data'][$k]['dayLim'] = $v2['Campaign']['day_lim'];
                       $resAllCamp['data'][$k]['daySpend'] = $v2['Campaign']['day_spend'];
                       $resAllCamp['data'][$k]['stoped'] = $v2['Campaign']['stoped'];
                       
                       break;
                    }
                }
            }
            
            
            $content = json_encode($resAllCamp);
            $this->header('Content-Type: application/json');
            return ($content);
        }
    }

    /**
     * show info aboud cirtain campaign
     * 
     * @return type html
     */
    public function campaign() {
//        $clientName = null;
//        if( isset($this->params['named']['client']) && $this->params['named']['client'] !== null ){
//            $clientName = $this->params['named']['client'];
//            
//        }
//        $this->set('clientName',$clientName);
        $this->set('title_for_layout', __('Campaign', true));
        $this->set('menuType', 'regged');

        //$authUserId = $this->Auth->user('id');
    }

    /**
     * retriving data from api.direct.yandex.ru via ajax
     * @param
     * 
     * @return type json
     * @access public
     */
    public function getYnCampInfo() {

        if ($this->RequestHandler->isAjax()) {

            Configure::write('debug', 0);
            $this->autoLayout = false;
            $this->autoRender = FALSE;

            $pathToCerts = Configure::read('pathToCerts');
            $params = array('CampaignIDS' => array($this->data['campid']),
                'Filter' => array(
                    'StatusArchive' => array('No'),
                    'IsActive' => array('Yes')
                )
            );

            $resAllBanners = json_decode($this->getYnData->getYnData($pathToCerts, 'GetBanners', $params), TRUE);

            //due to yandex sort is unpredictable


            function cmp($a, $b) {
                if ($a["BannerID"] == $b["BannerID"]) {
                    return 0;
                }
                return ($a["BannerID"] < $b["BannerID"]) ? -1 : 1;
            }

            usort($resAllBanners['data'], "cmp");





            $content = json_encode($resAllBanners);
            $this->header('Content-Type: application/json');
            return ($content);
        }
    }

    /**
     * show info aboud cirtain banner
     * 
     * @return type html
     */
    public function banner() {

        $this->set('title_for_layout', __('Banner', true));
        $this->set('menuType', 'regged');

        //$authUserId = $this->Auth->user('id');



        $this->set("modes", $this->setPrice->modes);
    }

    /**
     * retriving data from api.direct.yandex.ru via ajax
     * 
     * @param
     * 
     * @return type json
     * @access public
     */
    public function getYnBanInfo() {

        if ($this->RequestHandler->isAjax()) {

            Configure::write('debug', 0);
            $this->autoLayout = false;
            $this->autoRender = FALSE;



            $phrasesFromDb = array();
            $resAllPhrases = array();
            $modes = array();
            $bannid = null;
            $bannersID = array();

            if (isset($this->data['bannid'])) {
                $bannid = Sanitize::paranoid($this->data['bannid']);
                $bannersID = array($bannid);
            }

            //getting information about phrases( filtered not archive);
            $pathToCerts = Configure::read('pathToCerts');
            $params = array('BannerIDS' => $bannersID,
                //'FieldsNames' => array('Phrase', 'Shows', 'Price', 'Max', 'Min', 'PremiumMax', 'PremiumMin'),
                'RequestPrices' => 'Yes');


            $resAllPhrases = json_decode($this->getYnData->getYnData($pathToCerts, 'GetBannerPhrasesFilter', $params), TRUE);

            if (isset($resAllPhrases['data']) && $resAllPhrases['data'] != array()) {
                $this->loadModel('Phrase');
                $phrasesFromDb = $this->Phrase->find("all", array(
                                //"conditions"=>array("agent_id" => $this->Auth->user('id') )
                        ));

                $modes = $this->setPrice->modes;
                $modesSet = array();
                foreach ($modes as $k3 => $v3) {
                    foreach ($v3 as $k4 => $v4) {
                        $modesSet[] = $v4;
                    }
                }


                $lowCtr['data'] = array();
                $goodCtr['data'] = array();


                foreach ($resAllPhrases['data'] as $k => $v) {
                    //here we cutting off "stop words"
                    $pos = strpos($resAllPhrases['data'][$k]['Phrase'], '-');
                    if ($pos) {
                        $resAllPhrases['data'][$k]['Phrase'] = substr($resAllPhrases['data'][$k]['Phrase'], 0, $pos - 1);
                    }

                    //adding modes information 
                    foreach ($phrasesFromDb as $k2 => $v2) {
                        if ($v["PhraseID"] == $v2['Phrase']['phrase_yn_id']) {
                            foreach ($modesSet as $vModes) {
                                if ($v2['Phrase']['mode'] == $vModes['name']) {
                                    $resAllPhrases['data'][$k]['mode'] = sprintf($vModes['desc'], $v2['Phrase']['mode_x']);
                                    $resAllPhrases['data'][$k]['modeCode'] = $vModes['name'];
                                    $resAllPhrases['data'][$k]['modeX'] = $v2['Phrase']['mode_x'];
                                    break;
                                }
                            }
                            $resAllPhrases['data'][$k]['maxPrice'] = $v2['Phrase']['price'];

                            //$resAllPhrases['data'][$k]['modeX'] = $v2['Phrase']['mode_x'];
                            break;
                        }
                    }

                    if ($v['LowCTR'] == 'Yes') {

                        $lowCtr['data'][$v["PhraseID"]] = $resAllPhrases['data'][$k];
                        //unset($resAllPhrases['data'][$k]);
                    } else {
                        $goodCtr['data'][$v["PhraseID"]] = $resAllPhrases['data'][$k];
                    }
                }
            }
            //sort by the
            ksort($goodCtr['data']);

            $resAllPhrases['data'] = array_merge($goodCtr['data'], $lowCtr['data']);
            $content = json_encode($resAllPhrases);
            $this->header('Content-Type: application/json');
            return ($content);
        }
    }
    
  /**
   * starts of stops campaigns
   * 
   * @param int
   * @return json
   * @access public
   */
    public function startStop(){
        
        $startStopFn = 'StopCampaign';
        
        if ($this->RequestHandler->isAjax()) {

            Configure::write('debug', 0);
            $this->autoLayout = false;
            $this->autoRender = FALSE;

            $pathToCerts = Configure::read('pathToCerts');

            $campaignId = Sanitize::paranoid($this->data['campId']);


            $params = array(
                'CampaignID' => $campaignId
            );
            if($this->data['statShow'] === 'No'){
                $startStopFn = 'ResumeCampaign';
            }
            
            
            $resAllCamp = json_decode($this->getYnData->getYnData($pathToCerts, $startStopFn, $params), TRUE);

            if (isset($resAllCamp['data']) && $resAllCamp['data'] == 1){
                $toggledCamId = array();
                $toggledCamId = $this->Campaign->find('first', array(
                    'conditions'=>array('Campaing.campaign_yn_id' => $campaignId)
                ));
                
                if($toggledCamId != array()){
                    
                    //i'm workign here. add logic for stoped campaings;
                    
                    
                }
                
                
            }   


            $content = json_encode($resAllCamp);
            $this->header('Content-Type: application/json');
            return ($content);
        }       
    }
    
    
    
  /**
   * sets and unsets max day budget
   * 
   * @param float
   * @return json
   * @access public
   */
    public function dayBud(){
        
        $dayBud = 0;
        $stoped = 0;
        $statusShow = 'Yes';
        
        $currentYnCamp = array();
        
        if ($this->RequestHandler->isAjax()) {

            Configure::write('debug', 0);
            $this->autoLayout = false;
            $this->autoRender = FALSE;

             $pathToCerts = Configure::read('pathToCerts');

            $dayBud = (double)$this->data['dbLim'];
            $campaignId = Sanitize::paranoid($this->data['campId']);

            $this->data['Campaign']['day_lim'] = $dayBud;
            $this->data['Campaign']['campaign_yn_id'] = $campaignId;
            
            $currentYnCamp = $this->Campaign->find('first',array(
                'conditions' => array('Campaign.campaign_yn_id'=> $campaignId )
            ));
            
            if($currentYnCamp != array()){
               $this->data['Campaign']['id'] = $currentYnCamp['Campaign']['id'];
            }
 
            //to check current day spend and start or stop campaign
            
                    $params = array(
                        'CampaignID' => $campaignId
                    );
                    
                    
            if( $dayBud > $currentYnCamp['Campaign']['day_spend'] && $dayBud != 0 || $dayBud == 0){
                
                if ($currentYnCamp['Campaign']['stoped'] == 1) {

                    $resAllCamp = json_decode($this->getYnData->getYnData($pathToCerts, 'ResumeCampaign', $params), TRUE);
                    
                    if(isset($resAllCamp['data']) && $resAllCamp['data'] == 1){
                        $this->data['Campaign']['stoped'] = 0;
                        $statusShow = 'Yes';
                    }
                    
                }
                
            } else {
                
                $resAllCamp = json_decode($this->getYnData->getYnData($pathToCerts, 'StopCampaign', $params), TRUE);

                if (isset($resAllCamp['data']) && $resAllCamp['data'] == 1) {
                    $this->data['Campaign']['stoped'] = 1;
                    $statusShow = 'No';
                    $stoped = 1;
                }
                
            }
            
            
            
            
            if($this->Campaign->save($this->data) ){
              $resAllCamp['dayLim'] = $dayBud;
              $resAllCamp['stoped'] = $stoped;
              $resAllCamp['StatusShow'] = $statusShow;

              
            } else {
               $resAllCamp['error'] = 'Not saved'; 
            }
            

                


            $content = json_encode($resAllCamp);
            $this->header('Content-Type: application/json');
            return ($content);
        }       
    }
    
    
}

?>
