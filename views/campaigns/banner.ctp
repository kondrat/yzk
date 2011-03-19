<?php echo $this->Html->script(array('dev/file4'));?>
<h4>Campaign: </h4>


<script id="cmp-clientBannerTmpl" type="text/x-jquery-tmpl">

    <div  class="cmp-client  span-17">
        <div class="cmp-phrase span-8">${Phrase}</div>       

        <div class="cmp-shows span-2 last">${Shows}</div>

        <div class="cmp-modes hide">
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
            <?php //foreach ($modesOptions as $k => $v): ?>
                <div data-func="<?php //echo $k;?>"> <?php //echo $v; ?></div>
            <?php //endforeach; ?>
        </div>
      
        <div class="span-3 cmp-string">
            {{if mode}}
                <span class="cmp-modeStr">${mode}</span>
            {{else}}
                <?php __("no mode set yet");?>
            {{/if}}
        </div>
        {{if mode}}
            <div class="span-1 cmp-edit"><?php __('edit');?></div>       
            <div class="span-1 cmp-delete"><?php __('del');?></div>
        {{else}}
            <div class="span-1 cmp-edit"><?php __('crete');?></div>
        {{/if}}
    </div>

</script>






<div id="cmp-clientBannerWrp" class="cmp-clientBannerWrp span-14 prepend-1" data-bannid="<?php echo $this->params['named']['bannid'];?>">
    <div class="clt-loader"><?php echo $this->Html->image('pic/clt-loader.gif');?></div>
</div>
