<?php if($clientName):?>
    <h3><?php echo $clientName.__("'s companies",true);?> </h3>   
<?php else: ?>
    <h3><?php __('Client\'s companies');?> </h3>
<?php endif ?>
<?php echo $this->Html->script(array('dev/file2'));?>
<script id="clt-clientCompListTmpl" type="text/x-jquery-tmpl">

    <div  class="clt-client  span-17">
        <div class="clt-login span-4"><?php echo $this->Html->link('${Login}',array("controller"=>"campaings","action"=>"index","client"=>'${Login}'));?></div>
        <div class="clt-fio span-4">${FIO}</div>
        <div class="clt-phone span-4">${Phone}</div>
        <div class="clt-discount span-1">${Discount}%</div>
    </div>

</script>

<div id="clt-clientCampListWrp" class="span-18" data-clname="<?php echo $clientName;?>"></div>