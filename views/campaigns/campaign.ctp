<?php echo $this->Html->script(array('dev/file3'));?>
<h4>Campaign: <?php echo $this->params['named']['campname'];?></h4>


<script id="cmp-clientCompInfoTmpl" type="text/x-jquery-tmpl">

    <div  class="cmp-client  span-17">
        <div class="cmp-title span-17">${Title}</div>
        <div class="cmp-text span-17">${Text}</div>
        
        <div class="cmp-phrase span-4">
            <?php 
                    echo  $this->Html->link(__('Phrases',true),
                        array(
                            'plugin'=>false,
                            'controller'=>'campaigns','action'=>'banner','campid'=>'${CampaignID}','bannid'=>'${BannerID}'
                            )
                    );
            ?>
        </div>
        <div class="cmp-clicks span-2">${Clicks}</div>
        {{if IsActive == 'Yes'}}
            <div class="cmp-isactiveYes span-1">${IsActive}</div>
        {{else}}
            <div class="cmp-isactiveNo span-1">${IsActive}</div>
        {{/if}}
        <div class="cmp-shows span-2">${Shows}</div>
        <div class="cmp-startdate span-2">${StartDate}</div>
        <div class="cmp-sum span-1">${Sum}</div>
    </div>

</script>






<div id="cmp-clientCampInfoWrp" class="cmp-clientCampInfoWrp span-14 prepend-1" data-campid="<?php echo $this->params['named']['campid']?>">
    <div class="clt-loader"><?php echo $this->Html->image('pic/clt-loader.gif');?></div>
</div>
