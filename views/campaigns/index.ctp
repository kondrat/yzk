<?php if($clientName):?>
    <h4><?php echo '<span style="color:gray;font-size:large;">'.$clientName.'</span>'.__("'s companies",true);?> </h4>   
<?php else: ?>
    <h3><?php __('Client\'s companies');?> </h3>
<?php endif ?>
<?php echo $this->Html->script(array('dev/file2'));?>
<script id="cmp-clientCompListTmpl" type="text/x-jquery-tmpl">

    <div  class="cmp-client  span-17">
        <div class="cmp-name span-4">${Name}</div>
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

<div id="cmp-clientCampListWrp" class="cmp-clientCampListWrp span-14 prepend-1" data-clname="<?php echo $clientName;?>">
    <div class="clt-loader"><?php echo $this->Html->image('pic/clt-loader.gif');?></div>
</div>