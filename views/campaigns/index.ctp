<?php echo $this->Html->script(array('dev/file2')); ?>
    <script id="cmp-clientCompListTmpl" type="text/x-jquery-tmpl">
        
        {{if IsActive == 'Yes'}}
            
        <div  class="cmp-client  span-17">        
            <div class="cmp-name span-4">
            <?php echo $this->Html->link('${Name}', array(
                'plugin' => false,
                'controller' => 'campaigns', 'action' => 'campaign', 'campid' => '${CampaignID}', 'campname' => '${Name}','client'=>$clientName)
            );
            ?>
            </div>
            <div class="cmp-clicks span-2">${Clicks}</div>
            <div class="cmp-shows span-2">${Shows}</div>
            <div class="cmp-startdate span-2">${StartDate}</div>
            <div class="cmp-sum span-1">${Sum}</div>
        </div>
        {{/if}}
    </script>

<div class="span-17" style="background-color: #EEEEEE; margin-bottom: 5px;padding: 3px;">
    <div class="span-17"><?php echo $this->Html->link(__("clients",true),array('plugin'=>null,'controller'=>'clients','action'=>'index'));?>&nbsp;/&nbsp;<?php __('campagins'); ?>:</div>
    <div class="span-17"><?php __('Client');?>:&nbsp;<span style="font-style: italic;color: brown;"><?php echo $clientName;?></span></div>
</div>
    
<div id="cmp-clientCampListWrp" class="cmp-clientCampListWrp span-14 prepend-1" data-clname="<?php echo $clientName; ?>">
    <div class="clt-loader"><?php echo $this->Html->image('pic/clt-loader.gif'); ?></div>

    <div  class="clt-clientHd  span-17 hide">

        <div class="cmp-nameHd span-4"><?php __('Campaing'); ?></div>
        <div class="cmp-clicksHd span-2"><?php __('Clicks'); ?></div>
        <div class="cmp-showsHd span-2"><?php __('Shows'); ?></div>
        <div class="cmp-startdateHd span-2"><?php __('StartDate'); ?></div>
        <div class="cmp-sumHd span-1"><?php __('Sum'); ?></div>

    </div>    
    
</div>