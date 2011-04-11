<?php

App::import('Sanitize');

class CampaignsController extends AppController {

    var $name = 'Campaigns';
    var $publicActions = array('getYnCampList','getYnCampInfo','getYnBanInfo');
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
                if($clientName != $this->params['named']['client']){
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
                                    'StatusArchive'=>array('No')
                                    
                                    )
                    );
                $content = $this->getYnData->getYnData($pathToCerts, 'GetCampaignsListFilter', $params);


            
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
            $params = array('CampaignIDS'=>array($this->data['campid']),
                            'Filter' => array(
                                'StatusArchive'=> array('No'),
                                'IsActive'=>array('Yes')
                            )
                );
            
            $resAllBanners = json_decode($this->getYnData->getYnData($pathToCerts,'GetBanners', $params), TRUE);          
            
            

            $content = json_encode( $resAllBanners );
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
            
            if(isset($this->data['bannid'])){
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
                foreach ($modes as $k3=>$v3){
                    foreach ($v3 as $k4=>$v4){
                      $modesSet[] = $v4;   
                    }  
                }
                
                
                $lowCtr['data'] = array();
                
                foreach ($resAllPhrases['data'] as $k => $v) {
                    //here we cutting off "stop words"
                    $pos = strpos($resAllPhrases['data'][$k]['Phrase'], '-');
                    if ($pos) {
                        $resAllPhrases['data'][$k]['Phrase'] = substr($resAllPhrases['data'][$k]['Phrase'], 0, $pos - 1);
                    }

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
                    
                    if($v['LowCTR'] == 'Yes'){
                        
                        $lowCtr['data'][] = $resAllPhrases['data'][$k];
                        unset($resAllPhrases['data'][$k]);
                    }
                    
                    
                }
            }
            
            
            
            $resAllPhrases['data'] = array_merge($resAllPhrases['data'], $lowCtr['data']);
            $content = json_encode($resAllPhrases);
            $this->header('Content-Type: application/json');
            return ($content);
        }
    }

}

?>
