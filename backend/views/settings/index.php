<?php if(!defined('SWAMI')){die('External Access to File Denied');}?>

<?php if(isAllowed('edit')):?>

<form action="<?php echo url::get('admin/settings/save');?>" method="post">

<aside>
    
    <button name="save" class="btn positive" type="submit" accesskey="enter"><span class="icon save"></span><?php e__('save')?></button>
    <a class="btn negative" href="<?php echo url::get('admin/settings');?>"><span class="icon cancel"></span><?php e__('cancel')?></a>

</aside>

<section>

<?php else:?><div class="table"><?php endif;?>

<div class="block">
	<div class="block-header">
    	<div class="block-header-left">
        Instellingen
      </div>
      <div class="block-header-right"></div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <td style="text-align:right;padding-right:20px;"><?php e__('setting');?></td>
                <td><?php e__('value');?></td>
                <td style="min-width:40%;"><?php e__('help');?></td>
            </tr>
        </thead>
        <tbody>
        <tr>
        	<td style="text-align:right;padding-right:20px;"><?php e__('customer');?></td>
					<td><input type="text" value="GD Ingooigem"/></td>
					<td></td>
        </tr>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="block-footer"></div>
</div>

<br/><br/>
<div class="block">    
    <div class="block-header">
    	<div class="block-header-left">
        Backups
      </div>
      <div class="block-header-right"><a class="btn" href="<?php echo url::get('admin/settings/backup');?>"><span class="icon download"></span>Backup maken</a></div>
    </div>
    <table class="table oddEven">
    	<tr>
      	<td>Maart april 2011</td>
      </tr>
      <tr>
      	<td>Hoi test</td>
      </tr>
    </table>
    <div class="block-footer"></div>
</div>
    
<?php if(isAllowed('edit')):?>    
</section>
</form>
<?php else:?>
</div>
<?php endif;?>