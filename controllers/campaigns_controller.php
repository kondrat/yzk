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
            
            //@todo sinitize this
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



    /*
      function view($id = null) {
      if (!$id) {
      $this->Session->setFlash(__('Invalid Item', true));
      $this->redirect(array('action' => 'index'));
      }
      $this->set('Item', $this->Item->read(null, $id));
      }

      function add() {
      if (!empty($this->data)) {
      $this->Item->create();
      if ($this->Item->save($this->data)) {
      $this->Session->setFlash(__('The Item has been saved', true));
      $this->redirect(array('action' => 'index'));
      } else {
      $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
      }
      }
      $users = $this->Item->User->find('list');
      $this->set(compact('users'));
      }

      function edit($id = null) {
      if (!$id && empty($this->data)) {
      $this->Session->setFlash(__('Invalid Item', true));
      $this->redirect(array('action' => 'index'));
      }
      if (!empty($this->data)) {
      if ($this->Item->save($this->data)) {
      $this->Session->setFlash(__('The Item has been saved', true));
      $this->redirect(array('action' => 'index'));
      } else {
      $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
      }
      }
      if (empty($this->data)) {
      $this->data = $this->Item->read(null, $id);
      }
      $users = $this->Item->User->find('list');
      $this->set(compact('users'));
      }

      function delete($id = null) {
      if (!$id) {
      $this->Session->setFlash(__('Invalid id for Item', true));
      $this->redirect(array('action' => 'index'));
      }
      if ($this->Item->delete($id)) {
      $this->Session->setFlash(__('Item deleted', true));
      $this->redirect(array('action' => 'index'));
      }
      $this->Session->setFlash(__('Item was not deleted', true));
      $this->redirect(array('action' => 'index'));
      }

      function admin_index() {
      $this->Item->recursive = 0;
      $this->set('Items', $this->paginate());
      }

      function admin_view($id = null) {
      if (!$id) {
      $this->Session->setFlash(__('Invalid Item', true));
      $this->redirect(array('action' => 'index'));
      }
      $this->set('Item', $this->Item->read(null, $id));
      }

      function admin_add() {
      if (!empty($this->data)) {
      $this->Item->create();
      if ($this->Item->save($this->data)) {
      $this->Session->setFlash(__('The Item has been saved', true));
      $this->redirect(array('action' => 'index'));
      } else {
      $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
      }
      }
      $users = $this->Item->User->find('list');
      $this->set(compact('users'));
      }

      function admin_edit($id = null) {
      if (!$id && empty($this->data)) {
      $this->Session->setFlash(__('Invalid Item', true));
      $this->redirect(array('action' => 'index'));
      }
      if (!empty($this->data)) {
      if ($this->Item->save($this->data)) {
      $this->Session->setFlash(__('The Item has been saved', true));
      $this->redirect(array('action' => 'index'));
      } else {
      $this->Session->setFlash(__('The Item could not be saved. Please, try again.', true));
      }
      }
      if (empty($this->data)) {
      $this->data = $this->Item->read(null, $id);
      }
      $users = $this->Item->User->find('list');
      $this->set(compact('users'));
      }

      function admin_delete($id = null) {
      if (!$id) {
      $this->Session->setFlash(__('Invalid id for Item', true));
      $this->redirect(array('action' => 'index'));
      }
      if ($this->Item->delete($id)) {
      $this->Session->setFlash(__('Item deleted', true));
      $this->redirect(array('action' => 'index'));
      }
      $this->Session->setFlash(__('Item was not deleted', true));
      $this->redirect(array('action' => 'index'));
      }
     */
}

?>
