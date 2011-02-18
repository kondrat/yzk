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
                    'yzk-clt',
                    '/users/css/ec-u'
                )
        );
        echo '<!--[if IE]>';
        echo $this->Html->css('ie');
        echo '<![endif]-->';



        echo $html->script(array(
            'jq/jquery-1.5.min',
            'plug/tipsy/javascripts/jquery.tipsy',
            'jq/jquery.tmpl.min',
            'plug/jquery.universalpaginate',
            'dev/file1',
            '/users/js/dev/reg',
            '/users/js/dev/func'
        ));

        
        echo $html->scriptBlock(
                'var path = "'. Configure::read('path').'";'
        );
        
        echo $scripts_for_layout;
        ?>
    </head>
    <body>
        <div class="container" style="position:relative;">
            <div class="lt-pageheader">
                <div style="position:absolute;">
                    <?php 
                        echo $this->Html->link($this->Html->image(
                                            'pic/logo.png'
                                    ), '/', array('escape' => false)); 
                    ?>
                </div>           
            </div>
        </div>
        
        <div class="container">

            <div>

                <?php echo $this->Session->flash(); ?>

                <?php echo $content_for_layout; ?>

            </div>

        </div>

        <div class="container" style="">
            <div class="lt-pagefooter"> 
                    <div class="span-22 prepend-1">
                        <div class="lt-footerNote">
                            <?php echo $html->link('www.yzk.zone4test.ru', array('controller' => 'companies', 'action' => 'index')); ?> &copy;<?php echo date('Y'); ?>
                        </div>
                    </div>        
            </div>
        </div>
        <?php //echo $this->element('sql_dump'); ?>
    </body>
</html>