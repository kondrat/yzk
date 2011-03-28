<?php echo $this->Html->script(array('dev/file4'));?>
<script id="cmp-clientBannerTmpl" type="text/x-jquery-tmpl">

    <div  class="cmp-client  span-18">
        <div class="span-1"><?php echo $this->Form->checkbox('toMode');?></div>
        <div class="cmp-phrase span-8">${Phrase}</div>       

        <div class="cmp-shows span-2 last">${Shows}</div>
        <div class="cmp-price span-2 last">${Price}</div>
      
        <div class="span-3 cmp-string">
            {{if mode}}
                <span class="cmp-modeStr">${mode}</span>
            {{else}}
                <?php __("no mode set yet");?>
            {{/if}}
        </div>
        {{if mode}}
            <div class="span-1 cmp-edit"><?php __('eidt');?></div>       
            <div class="span-1 last cmp-delete"><?php __('del');?></div>
        {{else}}
            <div class="span-2 last cmp-edit"><?php __('create');?></div>
        {{/if}}
    </div>

</script>
<script id="cmp-modesTmpl" type="text/x-jquery-tmpl">
        <div class="cmp-modes">
            <?php
            if (isset($modes) && $modes != array()) {
                $modesOptions = array();
                foreach ($modes as $k => $v) {
                    $modesOptions[$v['name']] = sprintf($v['desc'], 'X');
                }
                echo $this->Form->input('mode', array(
                    'id'=>FALSE,
                    'default' => 'two',
                    'empty' => '(choose one)',
                    'options' => $modesOptions,
                    'label' => FALSE,
                    'div'=>FALSE
                        )
                );
            }
            ?>
            <span class="cmp-xspan">&nbsp;X&nbsp;=&nbsp;</span><input class="cmp-xinput" name="cmp-x" />&nbsp;
            <span class="cmp-save"><?php __('Save');?></span>
            <span class="cmp-close"><?php __('Close');?></span>

        </div>
</script>

<div class="span-17" style="background-color: #EEEEEE; margin-bottom: 5px;padding: 3px;">
    <div class="span-17">
        <?php echo $this->Html->link(__("clients",true),array('plugin'=>null,'controller'=>'clients','action'=>'index'));?>&nbsp;/&nbsp;
        <?php echo $this->Html->link(__("campaigns",true),array('plugin'=>null,'controller'=>'campaigns','action'=>'index','client'=>$this->params['named']['client']));?>&nbsp;/&nbsp;
        <?php echo $this->Html->link(__("banners",true),
                array('plugin'=>null,
                    'controller'=>'campaigns',
                    'action'=>'campaign',
                    'campid'=>$this->params['named']['campid'],
                    'campname'=>$this->params['named']['campname'],
                    'client'=>$this->params['named']['client'])
                );?>&nbsp;/&nbsp;
        <?php __('phrases'); ?>:
    </div>
    <div class="span-17">
        <?php __('Client');?>:&nbsp;<span style="font-style: italic;color: brown;"><?php echo $this->params['named']['client'];?></span>,
        <?php __('Campaign');?>:&nbsp;<span style="font-style: italic;color: brown;"><?php echo $this->params['named']['campname'];?></span>,
        <?php __('Banner');?>:&nbsp;<span style="font-style: italic;color: brown;"><?php echo $this->params['named']['banname'];?></span>
    </div>
</div

<div id="cmp-setModeBtn" class="cmp-setModeBtn span-17"><?php __('Set mode for all');?></div>
<div id="cmp-setModeWrp" class="cmp-setModeWrp span-17 hide"></div>

<div id="cmp-clientBannerWrp" class="cmp-clientBannerWrp span-18" data-bannid="<?php echo $this->params['named']['bannid'];?>">
    <div class="clt-loader"><?php echo $this->Html->image('pic/clt-loader.gif');?></div>
    
     <div  class="clt-clientHd  span-18 hide">
        <div class="span-1"><?php echo $this->Form->checkbox('toMode');?></div>
        <div class="cmp-phraseHd span-8"><?php __('Phrase'); ?></div>
        <div class="cmp-showsHd span-2"><?php __('Shows'); ?></div>
        <div class="cmp-priceHd span-2"><?php __('Price'); ?></div>
        <div class="cmp-modeHd span-3"><?php __('Mode'); ?></div>
        <div class="cmp-actionHd span-2 last"><?php __('Action'); ?></div>
        

    </div>   
    
</div>
