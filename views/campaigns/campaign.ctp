<?php echo $this->Html->script(array('dev/file3')); ?>
<h4>Campaign: <?php echo $this->params['named']['campname']; ?></h4>


<script id="cmp-clientCompInfoTmpl" type="text/x-jquery-tmpl">
    {{if IsActive == 'Yes'}}
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
        <div class="cmp-clicks span-2">${Clicks}</div>

        <div class="cmp-shows span-2">${Shows}</div>
        <div class="cmp-startdate span-2">${StartDate}</div>
        <div class="cmp-sum span-1">${Sum}</div>
    </div>
    {{/if}}
</script>






<div id="cmp-clientCampInfoWrp" class="cmp-clientCampInfoWrp span-14 prepend-1" data-campid="<?php echo $this->params['named']['campid'] ?>">
    <div class="clt-loader"><?php echo $this->Html->image('pic/clt-loader.gif'); ?></div>
</div>
