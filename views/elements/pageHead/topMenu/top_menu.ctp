<?php
if (!isset($menuType)) {
    $menuType = null;
}
?>
<div style="float:left;">
<?php switch ($menuType):
    case 'regged': ?>
        <div class="lt-topMenu">
            <?php //echo $html->link(__('Profile', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'profile'), array('onclick' => 'return false')); ?>
        </div>	 	
        <div class="lt-topMenu">
            <?php //echo $html->link(__('Settings', true), array('plugin' => 'users', 'controller' => 'details', 'action' => 'index'), array()); ?>
        </div>	 	
        <div class="lt-topMenu">
            <?php echo $html->link(__('LogOut now', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout')); ?>
        </div>
        <?php break; ?>
    
    <?php case 'settings';?>
         <div class="lt-topMenu">
            <?php echo $html->link(__('Home', true), '/', array()); ?>
        </div>   
         <div class="lt-topMenu">
            <?php echo $html->link(__('LogOut now', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'logout')); ?>
        </div>   
        <?php break; ?>
    <?php case 'reg': ?>
        <div class="lt-topMenu" style=""><?php __('Already on'); ?>&nbsp;yzk.go?</div>
        <div class="lt-topMenu">													
            <?php echo $html->link('<span>' . __('LogIn now', true) . '</span>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'), array('escape' => false)); ?>			
        </div>		
        <?php break; ?>
    <?php case 'login': ?>
        <div class="lt-topMenu">										
            <?php echo $html->link('<span>' . __('LogIn now', true) . '</span>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'), array('escape' => false)); ?>			
        </div>
        <div class="lt-topMenu">										
            <?php echo $html->link(__('SignUp now', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'reg')); ?>
        </div>		
        <?php break; ?>
    <?php case 'index': ?>

        <div id="logInNow" class="lt-topMenu">										
            <?php //echo $html->link('<span>'.__('LogIn now',true).'</span><span class="upDownSmallArrow"></span>', array('controller'=>'users','action'=>'login'),array('escape'=>false) );?>
            <?php echo $html->link('<span class="upDownArr">' . __('LogIn now', true) . '</span>', array('plugin' => 'users', 'controller' => 'users', 'action' => 'login'), array('escape' => false)); ?>			
        </div>
        <div class="lt-topMenu">										
            <?php echo $html->link(__('SignUp now', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'reg')); ?>
        </div>			
        <?php echo $this->element('pageHead/quickLogin/quick_login', array('cache' => false)); ?>


        <?php break; ?>
    <?php default: ?>
        <div><?php echo $this->Html->link($_SERVER['HTTP_HOST'],"/");?></div>
        <?php break; ?>


<?php endswitch ?>	

</div>

