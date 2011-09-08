<?php if(!defined('SWAMI')){die('External Access to File Denied');}?>

<div class="block">
	<div class="block-header">
    	<div class="block-header-left"><?php e__('users');?></div>
      <div class="block-header-right">
      	<?php if(isAllowed('add')):?>
        <a class="btn positive" href="<?php echo url::get('admin/users/add');?>" title=""><span class="icon user"></span><?php e__('add {item}',array('{item}'=>___('user')));?></a>
        <?php endif;?>
      </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <td>E-mailadres</td>
                <td>Type</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
		<?php foreach($users as $user):?>
        	<tr>
            	<td>
              	<?php if(isAllowed('edit')):?><a class="btn" href="<?php echo url::get('admin/users/edit/'.$user->id.'');?>" title=""><span class="icon edit"></span><?php endif;?>
									<?php echo $user->email;?>
									<?php if(is_array($user->data)&&isset($user->data['firstname'])):?> - <?php echo $user->data['firstname'];?><?php endif;?>
                <?php if(isAllowed('edit')):?></a><?php endif;?>
              </td>
              <td><?php echo $user->type;?></td>
            	<td>
								<?php if(isAllowed('delete')):?>
              	<a class="btn negative" href="<?php echo url::get('admin/users/delete/'.$user->id.'');?>" title="" onClick="if(confirm('Delete user')) return true; else return false;"><span class="icon delete"></span><?php e__('delete');?></a>
                <?php endif;?>
              </td>
            </tr>
        <?php endforeach;?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="block-footer">
    
    </div>
</div>