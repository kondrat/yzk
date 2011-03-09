<?php

/*
 * 
 */
App::import('Model', 'Users.User');

class Client extends AppModel {

    public $name = 'Client';
    //@todo to create proper datasource
    // public $useDbConfig = 'yandex';
    
    


    public  $belongsTo = array(
        
            'User' => array(
                'className' => 'User',
                'foreignKey' => 'user_id'
            )
    );
    
    /**
     *
     * @param type $ynLog
     * @param type $email
     * @return type 
     */
    public function regclient($ynLog = null, $email = null) {
        

        
        $this->data['User']['group_id'] = '4';
        $this->data['User']['username'] = $ynLog;
        $this->data['User']['email'] = $email;
        //@todo password hash
        $this->data['User']['password'] = $this->User->generatePassword();
        

        $this->User->set($this->data);
        if($this->User->validates(array( 'fieldList'=>array('username','email') ) ) ) {
            
            $this->User->create();            
            if($this->User->save($this->data,false)){
                return TRUE;
            }           
            return FALSE;

        } else {
            $errors = $this->User->invalidFields();
            return $errors;
        }
        
        return FALSE;
    }
}

?>
