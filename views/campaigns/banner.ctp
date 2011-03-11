<?php echo $this->Html->script(array('dev/file4'));?>
<h4>Campaign: </h4>


<script id="cmp-clientBannerTmpl" type="text/x-jquery-tmpl">

    <div  class="cmp-client  span-17">
        <div class="cmp-phrase span-15">${Phrase}</div>       

        <div class="cmp-shows span-2 last">${Shows}</div>

    </div>

</script>






<div id="cmp-clientBannerWrp" class="cmp-clientBannerWrp span-14 prepend-1" data-bannid="<?php echo $this->params['named']['bannid'];?>">
    <div class="clt-loader"><?php echo $this->Html->image('pic/clt-loader.gif');?></div>
</div>
