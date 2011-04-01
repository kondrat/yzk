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

        <div class="cmp-titleHd span-12"><?php __('Title'); ?></div>

        <div class="cmp-phraseHd span-4"><?php __('Phrase'); ?></div>

    </div>
    {{tmpl(data) "#cmp-clientCompInfoTmpl"}}
</script>      
<script id="cmp-clientCompInfoTmpl" type="text/x-jquery-tmpl">  
    <div  class="cmp-client  span-17">
        <div class="cmp-title span-12">${Title}</div>
        <div class="cmp-text span-12">${Text}</div>

        <div class="cmp-phrase span-4 last">
            <?php
            echo $this->Html->link(__('Phrases', true), array(
                'plugin' => false,
                'controller' => 'campaigns', 'action' => 'banner', 'campid' => '${CampaignID}', 'bannid' => '${BannerID}'
                    )
            );
            ?>
        </div>
    </div>  
</script>









        
<div id="cmp-navBar"class="span-18 cmp-navBar">
    <div class="span-18"><?php echo $this->Html->link(__("clients", true), array('plugin' => null, 'controller' => 'clients', 'action' => 'index')); ?>&nbsp;/&nbsp;
        <?php __('campagins'); ?>&nbsp;/&nbsp;
        <?php __('banners'); ?>&nbsp;/&nbsp;
        <?php __('phrases'); ?>
    </div>
    <div class="span-18"><?php __('Client'); ?>:&nbsp;<span style="font-style: italic;color: brown;"><?php echo $clientName; ?></span></div>
</div>













<div id="cmp-loaderWrp" class="cmp-loaderWrp span-18">
    <div class="clt-loader"><?php echo $this->Html->image('pic/clt-loader.gif'); ?></div> 
</div>


<div id="cmp-campResWrp" class="cmp-campResWrp span-17 prepend-1" data-clname="<?php echo $clientName; ?>"></div>