<h4>
    yzk.go: home page
</h4>
<?php if(!$this->Session->read('Auth.User.id')):?>
    <?php echo $this->element('login_toDel',array('plugin'=>'users'));?>
<?php else: ?>
    <?php echo $this->Html->link('LogOut',array('plugin'=>'users','controller'=>'users','action'=>'logout'));?>
<?php endif ?>