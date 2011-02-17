<h3>My Clients</h3>

<script id="clt-clientListTmpl" type="text/x-jquery-tmpl">

    <div  class="clt-client  span-17">
        <div class="clt-login span-4"><?php echo $this->Html->link('${Login}',array("controller"=>"campaings","action"=>"index","client"=>'${Login}'));?></div>
        <div class="clt-fio span-4">${FIO}</div>
        <div class="clt-phone span-4">${Phone}</div>
        <div class="clt-discount span-1">${Discount}%</div>
    </div>

</script>

<div id="clt-clientListWrp" class="span-18"></div>