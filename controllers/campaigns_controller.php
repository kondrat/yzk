<?php

App::import('Sanitize');

class CampaignsController extends AppController {

    var $name = 'Campaigns';
    var $publicActions = array('saveItem', 'status', 'delItem');
    var $helpers = array('Text');
    var $components = array();


//--------------------------------------------------------------------
    
    function beforeFilter() {

        //default title
        $this->set('title_for_layout', __('Companies', true));
        //allowed actions
        $this->Auth->allow('index', 'view');

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
        $this->set('title_for_layout', __('Main page', true));
        $this->set('menuType', 'index');
        $authUserId = $this->Auth->user('id');
        if ($authUserId) {
            $this->redirect(array('action' => 'todo'));
        }
    }

    /**
     *
     * @return type json
     */
    function todo() {

        $todos = array();
        $authUserId = $this->Auth->user('id');
        $pagItemCond = array();
        $userPrj = array();
        $curPrjId = null;





        if (isset($this->params['named']['prj']) && $this->params['named']['prj'] != null && $this->params['named']['prj'] !== 'all') {

            $curPrjId = $this->data['Project']['id'] = Sanitize::paranoid($this->params['named']['prj'], array('-'));
            //conditions for items pagination.
            $pagItemCond = array('Item.user_id' => $authUserId, 'Item.project_id' => $curPrjId, 'Item.status' =>0, 'Item.active' => 1);
            

        } else if (isset($this->params['named']['prj']) && $this->params['named']['prj'] === 'all') {
            //condition for paginatio all the projects that user has.
            $pagItemCond = array('Item.user_id' => $authUserId, 'Item.active' => 1);
        } else {

            //case when we just entered the page, or we are new user without project yet.
            $userPrj = $this->Item->Project->find('all', array(
                        'conditions' => array('Project.user_id' => $authUserId, 'Project.active' => 1),
                        'fields' => array('id', 'name'),
                        'order' => array('current' => 'DESC'),
                        'contain' => false)
            );
            //check if this user is new, or has current project he whorks on.																		
            if ($userPrj == array()) {
                $this->data['Project']['user_id'] = $authUserId;
                $this->data['Project']['name'] = __('Project 1', true);
                $this->data['Project']['current'] = time();
                $this->Item->Project->save($this->data);
                $userPrj[0] = $this->Item->Project->read();
            }
            $curPrjId = $userPrj[0]['Project']['id'];
            $pagItemCond = array('Item.user_id' => $authUserId, 'Item.project_id' => $curPrjId, 'Item.status' =>0, 'Item.active' => 1);
        }


        $this->paginate['conditions'] = $pagItemCond;
        $this->paginate['fields'] = array('Item.id', 'Item.item', 'Item.status', 'Item.task', 'Item.target', 'Item.created');
        $this->paginate['order'] = array('Item.created' => 'DESC');
        $this->paginate['contain'] = array('Tag'=>array(
            'fields' => array('Tag.name'),
            'order' => array('Tagged.created' => 'ASC'),
            'conditions' => array('Tag.identifier' => 'prj-'.$curPrjId)
        ));
        
//        $this->paginate['contain'] = array(
//            'Tag' => array('fields' => array('Tag.name'),
//                'order' => array('Tagged.created' => 'ASC'),
//                'conditions' => array('Tag.identifier' => 'prj-'.$curPrjId)
//            )
//        );


//        we are asked by universal pagiane query plugin
        if ($this->RequestHandler->isAjax() && isset($this->params['url']['startIndex']) && isset($this->params['url']['nbItemsByPage'])) {


            $this->paginate['limit'] = $this->params['url']['nbItemsByPage'];
            $this->paginate['page'] = $this->params['url']['startIndex'] / $this->params['url']['nbItemsByPage'] + 1;

            Configure::write('debug', 0);
            $this->autoLayout = false;
            $this->autoRender = FALSE;
            $todos = $this->paginate('Item');


            $contents["data"] = $this->_iterateItem($todos);
            $contents["nbTotalItems"] = $this->params["paging"]["Item"]["count"];



            $contents = json_encode($contents);
            $this->header('Content-Type: application/json');
            return ($contents);
            
        } else if ($this->RequestHandler->isAjax()) {
           
//            Configure::write('debug', 0);
//            $this->autoLayout = false;
//            $this->autoRender = FALSE;
//            $todos = $this->paginate('Item');

            $contents["stat"] = 0;
            $contents = json_encode($contents);
            $this->header('Content-Type: application/json');
            return ($contents);
        }





        $this->set('toM', $this->paginate('Item'));
        $this->set('menuType', 'todo');
        $this->set('userPrj', $userPrj);

        $tagCloudOld = //$this->TagCloudIteration->iterate(
                $this->Item->Tagged->find(
                        'cloud', array(
                    'conditions' => array('Tag.identifier' => 'prj-' . $curPrjId),
                    'fields' => 'Tag.*, Tagged.tag_id',
                    'limit' => 15,
                    'contain' => false)
                        //        )
        );
        
        $tagCloudOld = Set::extract($tagCloudOld,'{n}/Tag/id');
        
        $countTest = $this->Item->Tagged->find(
                'all',
                array(
                    'conditions'=>array('Tagged.tag_id' => $tagCloudOld),
                    'fields'=>array('Tag.id, Tag.name, COUNT(*) AS occurrence'),
                    'group' => 'Tag.id'
                )
            );
        
        foreach ($tagCloudOld as $singleTag) {
            
        }
        
        $tagCloud = $this->Item->Tagged->find(
                'cloud',
                array(
                    'conditions' => array('Tag.identifier' => 'prj-' . $curPrjId),
                    'fields'=>'Tag.*, Tagged.tag_id, COUNT(*) AS occurrence',
                    'limit' => 15,
                    'contain' => false
                    )
                );
        $this->set('tags', $tagCloud);
        $this->set('tagsOld', $tagCloudOld);
        $this->set('countTest', $countTest);
    }

    /**
     * iterating throught item data before sending to front end.
     * @param array $items The items we a iterating to prepere output.
     * 
     * @return type array
     * @access private
     */

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

}

?>
