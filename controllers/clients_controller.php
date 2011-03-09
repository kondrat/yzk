<?php

App::import('Sanitize');

class ClientsController extends AppController {

    var $name = 'Clients';
    var $publicActions = array('getYnClData','regYnCl');
    var $helpers = array('Text');
    var $components = array();

//--------------------------------------------------------------------

    function beforeFilter() {

        //default title
        $this->set('title_for_layout', __('Companies', true));
        //allowed actions
        //$this->Auth->allow('index', 'view','getYnClData');

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
    public function index() {
        $this->set('title_for_layout', __('Clients', true));

        $authUserId = $this->Auth->user('id');
        
        $this->set('menuType','regged');
        
    }

    /**
     *  retriving data from api.direct.yandex.ru via ajax
     * @param
     * 
     * @return type json
     * @access public
     */
    public function getYnClData() {
        
        // create a new cURL resource
        $ch = curl_init();

        //@todo add opportinity to add more certs per each user
      
        $path = Configure::read('pathToCerts');
        
        $url = "https://soap.direct.yandex.ru/json-api/v3/";
         
        //@todo sinitize this
        $method = '';//$this->data['method'];
        $params = '';//array('am-borovikov');
        //request for yandex in json.
        $jsonReq = json_encode(
                array(
                    "method" => "GetClientsList",
                    //"param"=>$params 
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
            } else {
                
//                $existedClients = $this->Client->find('all',array(
//                    'conditions'=>array(),
//                    'fields'=>array(),
//                    'contain'=>false
//                ));
                
                
                $newContensTmp = array();
                $newContens = json_decode($contents,TRUE);
                foreach ($newContens['data'] as $k=>$v){
                    $newContens['data'][$k]['more'] = 'mumu';//$existedClients;           
                }  
                
                $contents = json_encode($newContens);
            }

            // close the cURL resource and free the system resources
            curl_close($ch);
            


            
            //$content = json_encode($content);
            $this->header('Content-Type: application/json');
            return ($contents);
        }
    }

    /**
     * regging new clien 
     * 
     * @param
     * @return type json
     * @access public
     */
    
    public function regYnCl(){
        
        $contents = array();
        
        if ($this->RequestHandler->isAjax()) {

            Configure::write('debug', 0);
            $this->autoLayout = FALSE;
            $this->autoRender = FALSE;
            
            if ($this->data['ynLogin'] && $this->data['email']) {
                $contents["stat"] = 0;
              
                
            } else {
                $contents["error"] = 'error';
                $contents = json_encode($contents);
            }          
            
            
            
            
            $this->header('Content-Type: application/json');
            return ($contents);           
        }
    }
 
}

?>
