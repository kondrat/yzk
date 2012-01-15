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
            <div class="clt-discount span-2">${Discount}%</div>
            {{else}}
            <div class="clt-discount span-2">0%</div>
            {{/if}}
            {{if reg == 'no'}}
                <div class="clt-viewUsr clt-newCltReg span-1"><?php echo $this->Html->link(__('reg', true), array('plugin' => 'users', 'controller' => 'users', 'action' => 'regclient', "client" => '${Login}')); ?></div>
            {{else}}
                <div class="clt-viewUsr clt-cltDataEdit span-2"><?php __('view');?></div>
            {{/if}}

        </div>
    {{/if}}
</script>
<script id="clt-clientRegtTmpl" type="text/x-jquery-tmpl">
    <div  class="clt-cltRegWrp span-16">
        
        <div class="clt-clntDataWrp span-7">
            <div class="span-8"><?php __('Registation form for client');?>:&nbsp;<b>${FIO}</b></div>
            <div class="span-8 clt-ynLogReg"><?php __('Client\'s yandex login');?>:&nbsp;<b>${Login}</b></div>
            {{if reg == 'yes'}}
            <div class="span-8"><?php __('Registation email');?>:&nbsp;<b>${regemail}</b></div>
            <div class="span-8"><?php __('Current password');?>:&nbsp;<b>${pass}</b></div>                       
            {{/if}}
        </div>
        <div class="span-7">
            <div id="clt-regFormLoader" class="clt-loader hide"><?php echo $this->Html->image('pic/clt-loader.gif'); ?></div>
        </div>
        
        {{if reg == 'no'}}
        <div class="clt-sendEmWrp span-16">   
            <div class="span-1"><?php __('Email: ');?></div>
            <div class="span-6 last">
                <?php echo $this->Form->input('email',array('id'=>'clt-inputEmail','class'=>'clt-inputEmail','label'=>false,'div'=>false));?>
            </div>
            <div id="clt-cltRegBtn" class="clt-cltRegBtn"><?php __('Send');?></div>
            
        </div> 
        {{/if}}
        <div id="clt-closeFormBtn" class="clt-closeFormBtn"><?php __('Close');?></div>
    </div>
</script>

<div id="clt-navBarWrp" class="span-18 clt-navBarWrp">
    <div class="clt-navBar">
        <?php __('Clients list for agancy:'); ?>&nbsp;<span><?php echo $this->Session->read('Auth.User.email');?></span>
    </div>
    <div class="clt-loader"><?php echo $this->Html->image('pic/clt-loader.gif'); ?></div>
</div>


<div class="span-18">
    
    <div class="span-18">
        <div id="clt-notAfter">
            <?php if($notAfter == null):?>
                <span style="color: red; font-weight: bold;font-size: large;"><?php __('You haven\'t uploaded valid cerfificate yet');?></span>  
            <?php else: ?>
                <?php if($finishSoon == null):?>
                    <span style="color:blue;"><?php __('Your sertificate valid till: ');?><?php echo $notAfter;?></span>
                <?php elseif($finishSoon == 'ex'):?>
                    <span style="color:red;font-weight: bold;font-size: large;"><?php __('Your sertificate EXPIRED!!! ');?></span>
                <?php elseif ($finishSoon == 'yes'):?>
                   <span style="color:red;font-weight: bold;font-size: large;"><?php __('Your sertificate valid till: ');?><?php echo $notAfter;?></span> 
                <?php endif?>
              
            <?php endif ?>
        </div>
        <div id="clt-uploadBtn" class="clt-uploadBtn">
            <?php __('Upload sertificate (\'zip\' archaive)');?>
        </div>            
    </div>
    <div id="clt-uploadCert" class="span-18 hide">
        <?php echo $this->Form->create(null,array(
            'url'=>array('plugin'=>null,'controller'=>'clients','action'=>'certupload'),
            'type'=>'file'
        ));?>
        <?php echo $this->Form->input('cert',array('type' => 'file','label'=>false));?>
        <?php echo $this->Form->end('Submit');?>
    </div>
</div>

<div id="clt-clientListWrp" class="clt-clientListWrp span-17 prepend-1">
    
    
    
    <div  class="clt-clientHd  span-17 hide">
        
        <div class="clt-loginHd span-4"><?php __('Login'); ?></div>
        <div class="clt-fioHd span-4"><?php __('FIO'); ?></div>
        <div class="clt-phoneHd span-3"><?php __('Phone'); ?></div>
        <div class="clt-discountHd span-2"><?php __('Discount'); ?></div>
        <div class="clt-newCltRegHd span-2"><?php __('Reg Status') ?></div>
            
    </div>    
       
</div>
