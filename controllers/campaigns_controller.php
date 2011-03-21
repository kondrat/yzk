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
        $clientName = null;
        if (isset($this->params['named']['client']) && $this->params['named']['client'] !== null) {
            $clientName = $this->params['named']['client'];
        }
        $this->set('clientName', $clientName);
        $this->set('title_for_layout', __('Campaigns', true));
        $this->set('menuType', 'regged');

        $authUserId = $this->Auth->user('id');
    }

    /**
     *  retriving data from api.direct.yandex.ru via ajax
     * @param
     * 
     * @return type json
     * @access public
     */
    public function getYnCampList() {


        if ($this->RequestHandler->isAjax()) {

            Configure::write('debug', 0);
            $this->autoLayout = false;
            $this->autoRender = FALSE;
            
            //@todo sinitize this and remove decode - encode
            $params = array($this->data['clname']);
            
            $resAllCampaigns = json_decode($this->getYnData->getYnData('GetCampaignsList', $params), TRUE);  

 

            $content = json_encode( $resAllCampaigns );
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

        $authUserId = $this->Auth->user('id');
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
            
            $params = array('CampaignIDS'=>array($this->data['campid']));
            
            $resAllBanners = json_decode($this->getYnData->getYnData('GetBanners', $params), TRUE);          
            
            

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

        $authUserId = $this->Auth->user('id');
        


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
            $bannersID = array($this->data['bannid']);

            //getting information about phrases( filtered not archive);
            $params = array('BannerIDS' => $bannersID, 'FieldsNames' => array('Phrase', 'Shows', 'Price', 'Max', 'Min', 'PremiumMax', 'PremiumMin'), 'RequestPrices' => 'Yes');
            
            
            $resAllPhrases = json_decode($this->getYnData->getYnData('GetBannerPhrasesFilter', $params), TRUE);

            $this->loadModel('Phrase');
            $phrasesFromDb = $this->Phrase->find("all",
                    array(
                    //"conditions"=>array("agent_id" => $this->Auth->user('id') )
            ));
            
            $modes = $this->setPrice->modes;
            
            foreach ($resAllPhrases['data'] as $k => $v){
                
                foreach ($phrasesFromDb as $k2=>$v2){
                    if( $v["PhraseID"] == $v2['Phrase']['phrase_yn_id']){
                        foreach($modes as $vModes){
                           if($v2['Phrase']['mode'] == $vModes['name']) {
                              $resAllPhrases['data'][$k]['mode'] = sprintf($vModes['desc'], $v2['Phrase']['mode_x']);
                              break;
                           }
                           
                        }
                        
                        //$resAllPhrases['data'][$k]['modeX'] = $v2['Phrase']['mode_x'];
                        break;
                    }
                }
                
                
                
            }  
            
            
            


            $content = json_encode( $resAllPhrases);
            $this->header('Content-Type: application/json');
            return ($content);
        }
    }

}

?>
