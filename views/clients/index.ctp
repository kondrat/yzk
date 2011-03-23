<h3><?php __('Clients'); ?> </h3>
<?php echo $this->Html->script(array('dev/file1')); ?>
<script id="clt-clientListTmpl" type="text/x-jquery-tmpl">

       {{if StatusArch == 'No'}}
        <div  class="clt-client  span-17">
          
            <div class="clt-login span-4"><?php echo $this->Html->link('${Login}', array("controller" => "campaigns", "action" => "index", "client" => '${Login}')); ?></div>
            <div class="clt-fio span-4">${FIO}</div>
            {{if Phone}}
            <div class="clt-phone span-3">${Phone}</div>
            {{else}}
            <div class="clt-phone span-3">-</div>
            {{/if}}
            {{if Discount}}
            <div class="clt-discount span-1">${Discount}%</div>
            {{else}}
            <div class="clt-discount span-1">0%</div>
            {{/if}}
            {{if reg == 'no'}}
                <div class="clt-newCltReg span-1"><?php echo $this->Html->link(__('reg', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'regclient', "client" => '${Login}')); ?></div>
            {{else}}
                <div class="clt-cltDataEdit span-2"><?php __('view');?></div>
            {{/if}}

        </div>
    {{/if}}
</script>
<script id="clt-clientRegtTmpl" type="text/x-jquery-tmpl">
    <div  class="clt-cltRegWrp span-14">
        
        <div class="span-14"><?php __('Registation form for client');?>:&nbsp;<b>${FIO}</b></div>
        <div class="span-14 clt-ynLogReg"><?php __('Client\'s yandex login');?>:&nbsp;<b>${Login}</b></div>
            
        <div class="span-1"><?php __('Email: ');?></div>
        <div class="span-4 last">
            <?php echo $this->Form->input('email',array('id'=>'clt-inputEmail','class'=>'clt-inputEmail','label'=>false,'div'=>false));?>
        </div>
        <div id="clt-cltRegBtn" class="clt-cltRegBtn"><?php __('Send');?></div>
        <div id="clt-closeFormBtn" class="clt-closeFormBtn"><?php __('Close');?></div>
             
    </div>
</script>

<div id="clt-clientListWrp" class="clt-clientListWrp span-14 prepend-1">
    <div class="clt-loader"><?php echo $this->Html->image('pic/clt-loader.gif'); ?></div>
</div>