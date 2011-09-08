<?php if(!defined('SWAMI')){die('External Access to File Denied');}?>

<div class="block">
	<div class="block-header">
    	<div class="block-header-left">
        	<?php if($title_url):?><a href="<?php echo $title_url;?>"><?php endif;?>
        	<?php echo $title;?>
        	<?php if($title_url):?></a><?php endif;?>
        </div>
        <div class="block-header-right">
        	<?php echo $btns;?>
        </div>
    </div>
    <?php if(isset($contents)) foreach($contents as $c) $c->parse(); ?>
    <div class="block-footer"></div>
</div>