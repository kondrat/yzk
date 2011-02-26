<?php echo $this->element('webroot'); ?>
<div class="ur-formPageLog span-24">
	
    <?php
    echo $this->Form->create('User', array(
        'action' => 'login',
        'inputDefaults' => array(
            'label' => false,
            'div' => false
        )
    ));
    ?>

    <div class="inputFormWrap">
        <div class="formWrapLabel">
            <?php echo $this->Form->label(__('Email', true)); ?>
        </div>
        <div class="formWrapIn">
            <?php echo $form->input('username', array()); ?>	
        </div>
    </div>	

    <div class="inputFormWrap">
        <div class="formWrapLabel">
            <?php echo $form->label(__('Password', true)); ?>
        </div>
        <div class="formWrapIn">
            <?php echo $form->input('password', array('type' => 'password')); ?>
        </div>
        <div class="formWrapTip">
            <div style="margin-top: 5px;">
                <?php echo $html->link(__('Forgot?', true), array('admin' => false, 'action' => 'reset_password'), array('class' => '')); ?>
            </div>
        </div>
    </div>

    <div class="inputFormWrap">
        <div class="autoLogin" style="float:left;margin:0 0 0 175px;">
            <?php
            echo $form->input('remember_me', array('type' => 'checkbox',
                'label' => __('Remember Me', true),
                'div' => false)
            );
            ?>
        </div>
    </div>


    <div class="" style="float:left;margin:0 0 1.5em 175px;">			
        <span><?php echo $form->button(__('Submit', true), array('type' => 'submit', 'id' => 'logSubmit')); ?></span>
    </div>

    <?php echo $form->end(); ?>




    <div class="reg">
        <?php echo $html->link(__('SignUp now', true), array('controller' => 'users', 'action' => 'reg')); ?>
    </div>

</div>



