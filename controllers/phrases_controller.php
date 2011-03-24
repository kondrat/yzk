<?php

App::import('Sanitize');

class PhrasesController extends AppController {

    var $name = 'Phrases';
    var $publicActions = array('savePhrMode','delPhr');
    var $helpers = array();
    var $components = array('setPrice');

//--------------------------------------------------------------------

    function beforeFilter() {

        //default title
        $this->set('title_for_layout', __('Phrases', true));
        //allowed actions
        //$this->Auth->allow('index', 'view');

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
        $this->set('title_for_layout', __('Phrases', true));

        $authUserId = $this->Auth->user('id');

        $phrases = $this->Phrase->find('all', array(
                    //'conditions' => array('agent_id' => $authUserId)
                    'contain'=>false
                        )
        );
        
        $this->set('phrases',$phrases);
        
        $this->set('menuType', 'regged');
    }

    

    /**
     *  retriving data from api.direct.yandex.ru via ajax
     * @param
     * 
     * @return type json
     * @access public
     */
    public function savePhrMode() {

        $content = array();
        $exsictedPhrase = array();
        
        if ($this->RequestHandler->isAjax()) {

            Configure::write('debug', 0);
            $this->autoLayout = false;
            $this->autoRender = FALSE;


            if (isset($this->data['mode']) && isset($this->data['modeX'])) { 
                //@todo sanitize this
                $this->data['Phrase']['banner_yn_id'] = $this->data['banId'];
                $this->data['Phrase']['campaing_yn_id'] = $this->data['campId'];
                $this->data['Phrase']['phrase_yn_id'] = $this->data['phrId'];
                $this->data['Phrase']['mode'] = $this->data['mode'];
                $this->data['Phrase']['mode_x'] = $this->data['modeX'];

                $exsictedPhrase = $this->Phrase->find('first',array(
                    'conditions'=>array('Phrase.phrase_yn_id'=>$this->data['Phrase']['phrase_yn_id']),
                    'contain'=>false
                ));
                
                if($exsictedPhrase != array()){
                    $this->data['Phrase']['id'] = $exsictedPhrase['Phrase']['id'];
                }
                
                $this->Phrase->create();
                if( $this->Phrase->save($this->data) ){
                    
                   $modes = $this->setPrice->modes; 
                   foreach ($modes as $k => $v){
                       if($this->data['Phrase']['mode'] == $v['name']){
                           $mode = sprintf($v['desc'],$this->data['Phrase']['mode_x'] );
                       }
                   }
                   $content['data']['mode'] = $mode;
                   
                } else {
                   $content['error'] = 'not saved'; 
                }
                
                
            }
        }

        $contents = json_encode($content);
        $this->header('Content-Type: application/json');
        return ($contents);
    }
    
    /**
     *
     * @return json
     */
    public function delPhr() {
        
        $content = array();
        
        if ($this->RequestHandler->isAjax()) {

            Configure::write('debug', 0);
            $this->autoLayout = false;
            $this->autoRender = FALSE;
            
            $phrToDel = array();
            
            $this->data['Phrase']['phrase_yn_id'] = $this->data['phrId'];
            
            $phrToDel = $this->Phrase->find('first',array(
                'conditions'=>array('Phrase.phrase_yn_id'=>$this->data['Phrase']['phrase_yn_id']),
                'contain'=>FALSE
            ));
            
            if($phrToDel != array()){
                
                if($this->Phrase->delete($phrToDel['Phrase']['id'])){
                    $content['data'] = 'ok';
                } else {
                    $content['error'] = 'Problem with deleting';
                }
                
            }
          
        }


        $contents = json_encode($content);
        $this->header('Content-Type: application/json');
        return ($contents);
    }

}

?>