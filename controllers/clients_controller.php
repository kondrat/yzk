<?php

App::import('Sanitize');

class ClientsController extends AppController {

    var $name = 'Clients';
    var $publicActions = array('getYnClData', 'regYnCl', 'todel', 'certupload');
    var $helpers = array('Text','Time');
    var $components = array('Upload');

//--------------------------------------------------------------------

    function beforeFilter() {

        //default title
        $this->set('title_for_layout', __('Clients', true));
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
        $this->set('menuType', 'regged');



        
        if (file_exists(APP . 'certs/cert.crt')) {
             $fl = file(APP . 'certs/cert.crt');
            if (preg_match("/Not Before:/i", $fl[7], $matches)) {

                $posStr = strpos($fl[7], ":") + 1;
                $time = substr($fl[7], $posStr);
                $m = strtotime($time);
                //debug($m);
                //$this->result['notBefore'] = date('Y-m-d H:i:s', $m);
            }
            if (preg_match("/Not After :/i", $fl[8], $matches)) {

                $posStr = strpos($fl[8], ":") + 1;
                $time = substr($fl[8], $posStr);
                $m = $givenTimeNotAfter = strtotime($time);
                $certTimeLeft = ( $givenTimeNotAfter - time() ) / (60*60*24);
                //debug($certTimeLeft);

                    if ( $certTimeLeft < 14 && $certTimeLeft > 0){
                         $this->set('finishSoon', 'yes' );
                        
                    } else if( $certTimeLeft <= 0)  {
                       $this->set('finishSoon', 'ex' );
                    } else {
                        $this->set('finishSoon', null );
                    }

                 $this->set('notAfter', date('d F Y', $m) );
            }
        } else {
            $this->set('notAfter', null);
        }
        //debug($fl);
    }

    /**
     *  retriving data from api.direct.yandex.ru via ajax
     * @param
     * 
     * @return type json
     * @access public
     */
    public function getYnClData() {

        if ($this->RequestHandler->isAjax()) {

            Configure::write('debug', 0);
            $this->autoLayout = false;
            $this->autoRender = FALSE;

            $contents = array();
            $resAllClients = array();
            $existedClients = array();

            $pathToCerts = Configure::read('pathToCerts');

            $params = "";

            $resAllClients = json_decode($this->getYnData->getYnData($pathToCerts, 'GetClientsList', $params), TRUE);

            if (isset($resAllClients["data"]) && $resAllClients['data'] != array()) {



                $existedClients = $this->Client->find('all', array(
                    'conditions' => array('Client.agent_id' => $this->Auth->user('id')),
                    'fields' => array('ynname', 'pass', 'User.email'),
                    'contain' => false
                        ));

                if ($existedClients != array()) {


                    $newContens = $resAllClients; //json_decode($contents, TRUE);

                    foreach ($newContens['data'] as $k => $v) {

                        foreach ($existedClients as $val) {

                            if ($newContens['data'][$k]['Login'] == $val['Client']['ynname']) {

                                $newContens['data'][$k]['reg'] = 'yes';
                                $newContens['data'][$k]['pass'] = $val['Client']['pass'];
                                $newContens['data'][$k]['regemail'] = $val['User']['email'];
                                break;
                            } else {
                                $newContens['data'][$k]['reg'] = 'no';
                            }
                        }
                    }

                    $contents = json_encode($newContens);
                } else {
                    $contents = json_encode($resAllClients);
                }
            } else {
                //here we returning mistake from yandex
                if ($resAllClients) {
                    $contents = json_encode($resAllClients);
                } else {
                    $contents = json_encode(array('error' => __('No client\'s data from yandex', true)));
                }
            }




            $this->header('Content-Type: application/json');
            return ($contents);
        }
    }

    public function todel() {



        $this->set('clients', $resActiveClients);
        $this->set("campaignsId", $resAllCampaignsIdbatch10);
        $this->set("banners", $resAllBannersIDs);
        $this->set("bla", $resAllPhrases);

        //$this->set('campaigns',$resAllCampaigns);
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

            if (isset($this->data['ynLogin']) && isset($this->data['email'])) {

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
                                'port' => '465',
                                'timeout' => '30',
                                'host' => 'ssl://smtp.gmail.com',
                                'username' => 'quoondo@gmail.com',
                                'password' => 'Quoondo01',
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

    /**
     * certupload
     * 
     * @param
     * @return
     */
    public function certupload() {

        //debug($this->data);


        if (!empty($this->data) && $this->Auth->user('id') != null && $this->Auth->user('group_id') <= 4) {

            $file = array();

            // grab the file
            $file = $this->data['Client']['cert'];
            //debug($file);
            if ($file['error'] == 4) {
                $this->Session->setFlash(__('File wasn\'t uploaded', true));
            } else {
                // upload the zip archive using the upload component
                $result = $this->Upload->upload($file);

                if ($result == 1) {
                    // display error
                    $errors = $this->Upload->errors;
                    // piece together errors
                    if (is_array($errors)) {
                        $errors = implode(" ", $errors);
                    }

                    $this->Session->setFlash($errors);
                } else {
                    $this->Session->setFlash(__('Certificate was succesfully uploaded', true), 'default', array('class' => 'flok'));
                }
            }
        } else {
            $this->Session->setFlash(__('Mistake with uploading zip archive.', TRUE), 'default', array('class' => 'fler'));
        }

        $this->redirect(array('plugin' => null, 'controller' => 'clients', 'action' => 'index'), null, true);
    }

}

?>
