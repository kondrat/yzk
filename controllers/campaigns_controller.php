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
        // create a new cURL resource
        $ch = curl_init();

        //@todo add opportinity to add more certs per each user

        $path = Configure::read('pathToCerts');


        $url = "https://soap.direct.yandex.ru/json-api/v3/";

        //@todo sinitize this
        $method = ''; //$this->data['method'];
        $params = array($this->data['clname']);
        //request for yandex in json.
        $jsonReq = json_encode(
                array(
                    "method" => "GetCampaignsList",
                    "param" => $params
                )
        );

        if ($this->RequestHandler->isAjax()) {

            Configure::write('debug', 0);
            $this->autoLayout = false;
            $this->autoRender = FALSE;


            // set URL and other options
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_CAPATH, $path);
            curl_setopt($ch, CURLOPT_CAINFO, $path . "/cacert.pem");
            curl_setopt($ch, CURLOPT_SSLCERT, $path . "/cert.crt");
            curl_setopt($ch, CURLOPT_SSLKEY, $path . "/private.key");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonReq);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $contents = curl_exec($ch);

            if (curl_errno($ch) != 0) {
                //$contents["stat"] = 0;
                $contents["error"] = ('CURL_error: ' . curl_errno($ch) . ', ' . curl_error($ch));
                $contents = json_encode($contents);
            }

            // close the cURL resource and free the system resources
            curl_close($ch);


            //$content = json_encode($content);
            $this->header('Content-Type: application/json');
            return ($contents);
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

        
        // create a new cURL resource
        $ch = curl_init();

        $path = Configure::read('pathToCerts');


        $url = "https://soap.direct.yandex.ru/json-api/v3/";

        //@todo sinitize this
        $method = ''; //$this->data['method'];
        $params = array('CampaignIDS'=>array($this->data['campid']));
        //request for yandex in json.
        $jsonReq = json_encode(
                array(
                    "method" => "GetBanners",
                    "param" => $params
                )
        );

        if ($this->RequestHandler->isAjax()) {

            Configure::write('debug', 0);
            $this->autoLayout = false;
            $this->autoRender = FALSE;
            


            // set URL and other options
            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_CAPATH, $path);
            curl_setopt($ch, CURLOPT_CAINFO, $path . "/cacert.pem");
            curl_setopt($ch, CURLOPT_SSLCERT, $path . "/cert.crt");
            curl_setopt($ch, CURLOPT_SSLKEY, $path . "/private.key");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonReq);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $contents = curl_exec($ch);

            if (curl_errno($ch) != 0) {
                //$contents["stat"] = 0;
                $contents["error"] = ('CURL_error: ' . curl_errno($ch) . ', ' . curl_error($ch));
                $contents = json_encode($contents);
            }

            // close the cURL resource and free the system resources
            curl_close($ch);


            //$content = json_encode($content);
            $this->header('Content-Type: application/json');
            return ($contents);
        }
    }
    
    /**
     * show info aboud cirtain banner
     * 
     * @return type html
     */
    public function banner(){

        $this->set('title_for_layout', __('Banner', true));
        $this->set('menuType', 'regged');

        $authUserId = $this->Auth->user('id'); 


        $this->set("modes",$this->setPrice->modes);
        
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


          
            
            $bannersID = array($this->data['bannid']);

            //getting information about phrases( filtered not archive);
            $params = array('BannerIDS' => $bannersID, 'FieldsNames' => array('Phrase', 'Shows', 'Price', 'Max', 'Min', 'PremiumMax', 'PremiumMin'), 'RequestPrices' => 'Yes');
            $resAllPhrases = json_decode($this->getYnData->getYnData('GetBannerPhrasesFilter', $params), TRUE);


            
            
            


            $content = json_encode($resAllPhrases);
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
