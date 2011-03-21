<?php

//if (!$this->Session->check('Auth.Users')) {
//	echo $this->Form->create('User', array(
//		'url' => array(
//			'admin' => false,
//			'plugin' => 'users',
//			'controller' => 'users',
//			'action' => 'login'),
//		'id' => 'LoginForm'));
//	echo $this->Form->input('email', array(
//		'label' => __d('users', 'Email', true)));
//	echo $this->Form->input('password', array(
//		'label' => __d('users', 'Password', true),
//		'type' => 'password'));
//	echo $this->Form->end(__d('users', 'Login', true));
//}
//?>
<?php echo $this->element('webroot_for_ur'); ?>
<div class="ur-formPageLog span-24">
	
    <?php
    echo $this->Form->create('User', array(
        'url' => array(
            'admin' => false,
            'plugin' => 'users',
            'controller' => 'users',
            'action' => 'login'
        ),
        'id'=> 'ur-loginForm',
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        )
    ));
    ?>

    <div class="ur-inputFormWrap">
        <div class="ur-formWrapLabel">
            <?php echo $this->Form->label(__('Email', true)); ?>
        </div>
        <div class="ur-formWrapIn">
            <?php echo $form->input('email', array()); ?>	
        </div>
    </div>	

    <div class="ur-inputFormWrap">
        <div class="ur-formWrapLabel">
            <?php echo $form->label(__('Password', true)); ?>
        </div>
        <div class="ur-formWrapIn">
            <?php echo $form->input('password', array('type' => 'password')); ?>
        </div>
        <div class="ur-formWrapTip">
            <div style="margin-top: 5px;">
                <?php echo $html->link(__('Forgot?', true), array('admin' => false, 'action' => 'reset_password'), array('class' => '')); ?>
            </div>
        </div>
    </div>

    <div class="ur-inputFormWrap">
        <div class="ur-autoLogin" style="float:left;margin:0 0 0 175px;">
            <?php
            echo $form->input('remember_me', array('type' => 'checkbox',
                'label' => __('Remember Me', true),
                'div' => false)
            );
            ?>
        </div>
    </div>


    <div class="ur-formSubmitLog">			
        <span><?php echo $form->button(__('Submit', true), array('type' => 'submit', 'id' => 'logSubmit')); ?></span>
    </div>

    <?php echo $form->end(); ?>




    <div class="reg">
        <?php echo $html->link(__('SignUp now', true), array('plugin'=>'users','controller' => 'users', 'action' => 'reg')); ?>
    </div>

</div>