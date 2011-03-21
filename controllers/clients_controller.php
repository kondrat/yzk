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

        if ($this->RequestHandler->isAjax()) {

            Configure::write('debug', 0);
            $this->autoLayout = false;
            $this->autoRender = FALSE;


            $resAllClients = array();
            
            $params = "";
            
            $resAllClients = json_decode($this->getYnData->getYnData('GetClientsList', $params), TRUE);           
                            
                if( isset($resAllClients["data"]) && $resAllClients['data'] != array() ) {
                     $existedClients = $this->Client->find('all', array(
                                'conditions' => array('Client.agent_id'=> $this->Auth->user('id')),
                                'fields' => array('ynname'),
                                'contain' => false
                            ));
                    $existedClients = Set::extract('/Client/ynname', $existedClients);
                    
                    $newContens = $resAllClients;//json_decode($contents, TRUE);
                    
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
                } else {
                   $contents = json_encode($resAllClients);
                }

            $this->header('Content-Type: application/json');
            return ($contents);
        }
    }

    public function todel() {
        
        ini_set("max_execution_time", 300);
        
//        $reggedClients = $this->Client->find('all', array(
//                    'conditions' => array('Client.agent_id' => $this->Auth->user('id')),
//                    'fields' => array('ynname'),
//                    'contain' => false
//                ));
//
//        $results = Set::extract('/Client/ynname', $reggedClients);
//        $this->set('res', $results);
        
        //getting an information about clients;
        $resAllClients = array();
        $resAllClients = json_decode($this->getYnData->getYnData('GetClientsList'),TRUE);
        
        //extractiong active clients only
        $resActiveClients = array();
        foreach ($resAllClients['data'] as $k => $v){
            if($v['StatusArch'] == "No"){              
              $resActiveClients[] = $v['Login'];  
            }
        }
        
        //getting information about clients campaigns( filtered not archive);
        $params = array('Logins'=>$resActiveClients,'Filter'=>array('StatusArchive'=>array('No') ) );
        $resAllCampaigns = json_decode($this->getYnData->getYnData('GetCampaignsListFilter',$params),TRUE); 
        
        
 
        //this due to yandex restrictions to pass only 10 camaigns IDs we make array for the loop.
        $resAllCampaignsIdbatch10 = array();
        $i = 0;
        $j = 0;
        foreach ($resAllCampaigns['data'] as $k => $v){
            $resAllCampaignsIdbatch10[$j][$i] = $v['CampaignID'];
            $i++;
            if($i == 10){
                $j++;
                $i = 0;
            }
        }
        
        //getting information about banners.
        foreach ($resAllCampaignsIdbatch10 as $k2 => $v2){
            
            $params2 = array('CampaignIDS'=>$v2,'Filter'=>array('StatusArchive'=>array('No')));
            $tempBanners = json_decode($this->getYnData->getYnData('GetBanners',$params2),TRUE);
            $resAllBanners[] = $tempBanners['data'];
            unset($tempBanners);
        }
        //and finaly we get bannersIds as one array. next we need to check if ammount less then 1000 (yandex.api restiction);
        $resAllBannersIDs = array();
        foreach ($resAllBanners as $k3=>$v3){
            foreach ($v3 as $k4=>$v4) {
               $resAllBannersIDs[] = $v4['BannerID']; 
            } 
        }
        
        
        //getting information about phrases( filtered not archive);
        $params3 = array('BannerIDS'=>$resAllBannersIDs,'FieldsNames'=>array('Price','Max','Min','PremiumMax','PremiumMin' ),'RequestPrices'=>'Yes' );
        $resAllPhrases = json_decode($this->getYnData->getYnData('GetBannerPhrasesFilter',$params3),TRUE);         
        
        
        
        
        
        
        
        
        
        
        
        $this->set('clients',$resActiveClients);
        $this->set("campaignsId",$resAllCampaignsIdbatch10);
        $this->set("banners",$resAllBannersIDs);
        $this->set("bla",$resAllPhrases);
        
        //$this->set('campaigns',$resAllCampaigns);
    }
    public function todel2(){
        //ini_set("max_execution_time", 300);
        $this->action = 'todel';
        $resAllPhrases = 'hi';
//        $reggedClients = $this->Client->find('all', array(
//                    'conditions' => array('Client.agent_id' => $this->Auth->user('id')),
//                    'fields' => array('ynname'),
//                    'contain' => false
//                ));
//
//        $results = Set::extract('/Client/ynname', $reggedClients);
//        $this->set('res', $results);
 

      
        
       
       //$resAllPhrases = Set::extract("/BannerID",$tempArray);
       
       $resAllPhrases = array(9433451,16402247);
        
        $params3 = array('BannerIDS'=>$resAllPhrases,'FieldsNames'=>array('Price','Max','Min','PremiumMax','PremiumMin' ),'RequestPrices'=>'Yes' );
        $resAllPhrases = json_decode($this->getYnData->getYnData('GetBannerPhrasesFilter',$params3),TRUE); 
        
        $this->set("bla",$resAllPhrases);
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
                                'port'=>'465',
                                'timeout'=>'30',
                                'host' => 'ssl://smtp.gmail.com',
                                'username'=>'quoondo@gmail.com',
                                'password'=>'Quoondo01',
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
