    <?php echo $this->Html->script(array('dev/file2')); ?>

    <script id="cmp-clientCompListHdTmpl" type="text/x-jquery-tmpl">
         <div  class="clt-clientHd  span-18">

            <div class="cmp-nameHd span-4"><?php __('Campaing'); ?></div>
            <div class="cmp-clicksHd span-2"><?php __('Clicks'); ?></div>
            <div class="cmp-showsHd span-2"><?php __('Shows'); ?></div>
            <div class="cmp-startdateHd span-2"><?php __('StartDate'); ?></div>
            <div class="cmp-sumHd span-1"><?php __('Sum'); ?></div>

        </div> 
            {{tmpl(data) "#cmp-clientCompListTmpl"}}
    </script>
    <script id="cmp-clientCompListTmpl" type="text/x-jquery-tmpl">
       
        <div  class="cmp-client  span-17">        
            <div class="cmp-name span-4">
            <?php echo $this->Html->link('${Name}', array(
                'plugin' => false,
                'controller' => 'campaigns','action' => 'campaign','client'=>$clientName,'campid' => '${CampaignID}','campname' => '${Name}'),
                    array('class'=>'cmp-campLnk')
            );
            ?>
            </div>
            <div class="cmp-clicks span-2">${Clicks}</div>
            <div class="cmp-shows span-2">${Shows}</div>
            <div class="cmp-startdate span-2">${StartDate}</div>
            <div class="cmp-sum span-1">${Sum}</div>
        </div>       
       
    </script>



        

 <script id="cmp-clientCompInfoHdTmpl" type="text/x-jquery-tmpl"> 
 
    <div class="clt-clientHd span-18">
        
        <div class="span-1"><?php echo $this->Form->checkbox('toMode', array('disabled' => 'disabled')); ?></div>
        
        <div class="cmp-titleHd span-12"><?php __('Title'); ?></div>

        <div class="cmp-phraseHd span-4"><?php __('Phrase'); ?></div>

    </div>
    {{tmpl(data) "#cmp-clientCompInfoTmpl"}}
</script>      
<script id="cmp-clientCompInfoTmpl" type="text/x-jquery-tmpl">  
    <div  class="cmp-client  span-18">
        <div class="span-1"><?php echo $this->Form->checkbox('toMode', array('id'=>'ch-${BannerID}' ,'disabled'=>'disabled'));?></div>
        <div class="cmp-title span-12">${Title}</div>
        <div class="cmp-text span-12">${Text}</div>

        <div class="cmp-phrase span-4 last">
            <?php
            echo $this->Html->link(__('Phrases', true), array(
                'plugin' => false,
                'controller' => 'campaigns', 'action' => 'banner', 'campid' => '${CampaignID}', 'bannid' => '${BannerID}'
                    ), array(
                        'class'=>'cmp-bannLnk'
                    )
            );
            ?>
        </div>
    </div>  
</script>



<script id="cmp-clientBannerHdTmpl" type="text/x-jquery-tmpl"> 

    <div class="span-18">
        <div id="cmp-setModeBtn" class="cmp-setModeBtn"><?php __('Set mode for all phrases'); ?></div>
        <div id="cmp-unSetModeBtn" class="cmp-unSetModeBtn"><?php __('UnSet mode for all phrases'); ?></div>
    </div>
    <div id="cmp-setModeWrp" class="cmp-setModeWrp span-18 hide"></div>

    <div  class="clt-clientHd  span-18">
        <div class="span-1"><?php echo $this->Form->checkbox('toMode', array('disabled' => 'disabled')); ?></div>
        <div class="cmp-phraseHd span-5"><?php __('Phrase'); ?></div>
        <div class="cmp-showsHd span-2"><?php __('Shows'); ?></div>
        <div class="cmp-priceHd span-2"><?php __('Price'); ?></div>
        <div class="cmp-minMaxPricesHd span-3"><?php __('Position price'); ?></div>
        <div class="cmp-modeHd span-3"><?php __('Mode'); ?></div>
        <div class="cmp-actionHd span-2 last"><?php __('Action'); ?></div>        
    </div>
    {{tmpl(data) "#cmp-clientBannerTmpl"}}
</script>
<script id="cmp-clientBannerTmpl" type="text/x-jquery-tmpl">
    
    {{if Min }}
    
    <div  class="cmp-client  span-18">
        <div class="span-1"><?php echo $this->Form->checkbox('toMode', array('id'=>'ch-${PhraseID}' ,'disabled'=>'disabled'));?></div>
        <div class="cmp-phrase span-5">${Phrase}</div>       

        <div class="cmp-shows span-2 last">${Shows}</div>
        <div class="cmp-price span-2 last">${Price}</div>
        <div class="cmp-minMaxPrices span-3">
            
            <div class="cmp-minPr"><?php __('Min Guaranty:');?>&nbsp;${Min}</div>
            <div class="cmp-maxPr"><?php __('Max Guaranty:');?>&nbsp;${Max}</div>
            <div class="cmp-minPremPr"><?php __('Min Premium:');?>&nbsp;${PremiumMin}</div>
            <div class="cmp-maxPremPr"><?php __('Max Premium:');?>&nbsp;${PremiumMax}</div> 
                        
        </div>
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
        <div class="cmp-modesEditWrp span-18"></div>
    </div> 
    
    {{else}}
        
    <div  class="cmp-clientLowCtr  span-18">
        <div class="cmp-lowCtrFrst span-1">#</div>
        <div class="cmp-phrase span-5">${Phrase}</div>       

        <div class="cmp-shows span-2 last">${Shows}</div>
        <div class="cmp-price span-2 last">${Price}</div>                     
        <div class="cmp-lowCtr span-3"><?php __('Low CTR!');?></div>
                 
        <div class="span-3 cmp-string">
            {{if mode}}
                <span class="cmp-modeStr">${mode}</span>
            {{else}}
                <?php __("no mode set yet");?>
            {{/if}}
        </div>
        <div class="span-2 cmp-noedit">----</div>       
                         
    </div>
    {{/if}}
    
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













        
<div id="cmp-navBar"class="span-18 cmp-navBar">
    
    <div class="span-18">
        <div id="cmp-navBarCtrl" class="cmp-navBarCtrl">

            <?php if($this->Session->read('Auth.User.group_id') == 3):?> 
                <?php echo $this->Html->link(__("clients", true), array('plugin' => null, 'controller' => 'clients', 'action' => 'index')); ?>&nbsp;/&nbsp;
            <?php endif ?>
        
            <span id="cmp-navBarCam" class="cmp-navBarCam" data-cmpId="" data-cmpName=""><?php __('campagins'); ?></span>&nbsp;/&nbsp;
            <span id="cmp-navBarBan" class="cmp-navBarBan" data-bnId="" data-bnTtl="" data-banTxt=""><?php __('banners'); ?></span>&nbsp;/&nbsp;
            <span id="cmp-navBarPhr" class="cmp-navBarPhr"><?php __('phrases'); ?></span>
        </div>
        <div id="cmp-loaderWrp" class="cmp-loaderWrp span-5">
            <div class="clt-loader"><?php echo $this->Html->image('pic/clt-loader.gif'); ?></div> 
        </div>
    </div>
    
    <div class="span-18"><?php __('Client'); ?>:&nbsp;<span class="cmp-navBarData"><?php echo $clientName; ?></span></div>
    <div id="cmp-navBarCamName" class="span-18 hide"><?php __('Campaign'); ?>:&nbsp;<span class="cmp-navBarData"></span></div>
    <div id="cmp-navBarBnTlt" class="span-18 hide"><?php __('Title'); ?>:&nbsp;<span class="cmp-navBarData"></span></div>
    <div id="cmp-navBarBnTxt" class="span-18 hide"><?php __('Text'); ?>:&nbsp;<span class="cmp-navBarData"></span></div>
    
</div>





<div id="cmp-campResWrp" class="cmp-campResWrp span-18" data-clname="<?php echo $clientName; ?>"></div>