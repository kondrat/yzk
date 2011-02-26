<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php __('yzk.go:'); ?>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css(
                array(
                    'tipsy/stylesheets/tipsy',
                    'screen',
                    'yzk-lt',
                    'yzk-com',
                    'yzk-clt'
                )
        );
        echo '<!--[if IE]>';
        echo $this->Html->css('ie');
        echo '<![endif]-->';



        echo $this->Html->script(array(
            'jq/jquery-1.5.1.min',
            'plug/tipsy/javascripts/jquery.tipsy',
            'jq/jquery.tmpl.min',
            'plug/jquery.universalpaginate'
            
        ));


        echo $this->Html->scriptBlock(
                'var path = "' . Configure::read('path') . '";'
        );

        echo $scripts_for_layout;
        ?>
    </head>
    <body>
        <div class="container" style="position:relative;">
            <div class="lt-pageheader span-24">
                <div style="position:absolute;top:0;left:-138px;">
                    <?php
                    echo $this->Html->link($this->Html->image(
                                    'pic/logo.png'
                            ), '/', array('escape' => false));
                    ?>
                </div>
                <?php
                
                if (!isset($menuType) || !in_array($menuType, array('reg', 'login', 'index', 'regged'), true)) {
                    $menuType = 'default';
                }
                echo $this->element('pageHead/topMenu/top_menu', array('menuType' => $menuType));
                ?>
            </div>
        </div>

        <div class="container">



            <?php echo $this->Session->flash(); ?>

            <?php echo $content_for_layout; ?>



        </div>

        <div class="container" style="">
            <div class="lt-pagefooter"> 
                <div class="span-24s">
                    <div class="lt-footerNote">
                        <?php echo $html->link('yzk.go', array('controller' => 'companies', 'action' => 'index')); ?> &copy;<?php echo date('Y'); ?>
                    </div>
                </div>        
            </div>
        </div>
        <?php //echo $this->element('sql_dump');  ?>
    </body>
</html>