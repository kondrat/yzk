<h3><?php __('Clients');?> </h3>
<?php echo $this->Html->script(array('dev/file1'));?>
<script id="clt-clientListTmpl" type="text/x-jquery-tmpl">

    <div  class="clt-client  span-12">
        <div class="clt-login span-4"><?php echo $this->Html->link('${Login}',array("controller"=>"campaigns","action"=>"index","client"=>'${Login}'));?></div>
        <div class="clt-fio span-4">${FIO}</div>
        {{if Phone}}
            <div class="clt-phone span-3">${Phone}</div>
        {{else}}
            <div class="clt-phone span-3">-</div>
        {{/if}}
        <div class="clt-discount span-1 last">${Discount}%</div>
    </div>

</script>

<div id="clt-clientListWrp" class="clt-clientListWrp span-14 prepend-1">
    <div class="clt-loader"><?php echo $this->Html->image('pic/clt-loader.gif');?></div>
</div>