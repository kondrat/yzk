<?php

App::import('Sanitize');

class ClientsController extends AppController {

    var $name = 'Clients';
    var $publicActions = array('getYnClData', 'regYnCl','todel');
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

        $t = $this->Client->find('all', array(
                    'conditions' => array('user_id' => $authUserId)
                        )
        );


        $this->set('menuType', 'regged');
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
        $method = ''; //$this->data['method'];
        $params = ''; //array('am-borovikov');
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

                $existedClients = $this->Client->find('all', array(
                            'conditions' => array('Client.agent_id'=> $this->Auth->user('id')),
                            'fields' => array('ynname'),
                            'contain' => false
                        ));
                $existedClients = Set::extract('/Client/ynname', $existedClients);
                
                //$newContensTmp = array();
                $newContens = json_decode($contents, TRUE);
                
                foreach ($newContens['data'] as $k => $v) {
                    
                    foreach ($existedClients as $val){
                        if($newContens['data'][$k]['Login'] == $val){
                            $newContens['data'][$k]['reg'] = 'yes'; 
                            break;
                        } else {
                            $newContens['data'][$k]['reg'] = 'no';
                        }
                    }
                    
                              
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

    public function todel(){
                        $existedClients = $this->Client->find('all', array(
                            'conditions' => array('Client.agent_id'=> $this->Auth->user('id')),
                            'fields' => array('ynname'),
                            'contain' => false
                        ));
                        
                $results = Set::extract('/Client/ynname', $existedClients);
                debug($results);
    }

        
    /**
     * regging new client 
     * 
     * @param
     * @return type json
     * @access public
     */
    public function regYnCl() {

        $contents = array();

        if ($this->RequestHandler->isAjax()) {

            Configure::write('debug', 0);
            $this->autoLayout = FALSE;
            $this->autoRender = FALSE;

            if ($this->data['ynLogin'] && $this->data['email']) {

                $userSavingRes = $this->Client->regclient($this->data['email']);

                if ($userSavingRes) {
                    //$contents = array('savedOne'=>'ok');
                    if (isset($userSavingRes['error'])) {
                        $contents["error"] = $userSavingRes;
                    } elseif (isset($userSavingRes['savedUserId'])) {
                        $this->data['Client']['ynname'] = Sanitize::paranoid($this->data['ynLogin'], array('-'));
                        $this->data['Client']['user_id'] = $userSavingRes['savedUserId'];
                        $this->data['Client']['agent_id'] = $this->Auth->user('id');
                        //@todo temp saving client's passwd in client table
                        $this->data['Client']['pass'] = $userSavingRes['savedUserPass'];
                        $this->Client->create();
                        if ($this->Client->save($this->data)) {



                            $this->Email->to = '4116457@mail.ru'; //$userSavingRes['savedUserEmail'];
                            $this->Email->subject = 'Welcome to our really cool thing';
                            $this->Email->replyTo = 'support@example.com';
                            $this->Email->template = 'simple_message';
                            $this->Email->sendAs = 'both';
                            
                            $this->Email->smtpOptions = array(
                                'port'=>'465',
                                'timeout'=>'30',
                                'host' => 'ssl://smtp.gmail.com',
                                'username'=>'alexey.kondratyev@gmail.com',
                                'password'=>'kt19_Zpg',
                            );
                            
                            $this->set('User', $userSavingRes);
                            
                            
                            $this->Email->delivery = 'smtp';
                     //add  $contents['notSendEmail'] if email not send correct      
                            $this->Email->send();
                        }
                        $contents = $userSavingRes;
                    }
                } else {
                    $contents["error"] = 'User not saved';
                }
            } else {
                $contents["error"] = 'error';
            }



            $contents = json_encode($contents);
            $this->header('Content-Type: application/json');
            return ($contents);
        }
    }

}

?>
