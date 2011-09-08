<?php if(!defined('SWAMI')){die('External Access to File Denied');}?>

<form action="<?php echo url::get('admin/users/save');?>" method="post">

<aside>
    
    <?php if(!isset($user->id)):?>
    <button name="add" class="btn positive" type="submit" accesskey="enter"><span class="icon save"></span><?php e__('add');?></button>
    <?php else:?>
    <button name="save" class="btn positive" type="submit" accesskey="enter"><span class="icon save"></span><?php e__('save');?></button>
    <?php endif;?>
    <button name="saveAndEdit" class="btn positive" type="submit"><span class="icon save"></span><?php e__('save_no_return');?></button>
    
    <a class="btn negative" href="<?php echo url::get('admin/users');?>"><span class="icon cancel"></span><?php e__('cancel');?></a>

</aside>

<section class="block">

    <div class="block-header">
        <div class="block-header-left"><?php e__('user');?></div>
		<?php if(isset($user->id)&&(user::id()!=$user->id)):?>
        <div class="block-header-right">
            <button name="delete" class="btn negative" type="submit" onClick="if(confirm('Zeker dat u wil verwijderen?')) return true; else return false;"><span class="icon delete"></span><?php e__('delete');?></button>
        </div>
        <?php endif;?>
    </div>

    <div class="block-content">
    	<?php if(isset($user->id)):?>
        <input name="user[id]" type="hidden" value="<?php echo $user->id;?>" />
        <?php endif;?>
        <label>Username:
            <input name="user[username]" type="text" value="<?php if(isset($user->username)) echo $user->username;?>" />
        </label>
        <br/>
        <label>E-mailadres:
            <input name="user[email]" type="text" value="<?php if(isset($user->email)) echo $user->email;?>" />
        </label>
        <br/>
        
        <label>Gebruikersrechten</label><br/>
        <?php foreach(user::$types as $type => $key):?>
        <label><input name="user[type]" type="radio" value="<?php echo $type;?>"<?php if($type==$user->type) echo ' checked="checked"';?> /> <?php echo ucfirst($type);?></label><br/>
        <?php endforeach;?>
        
        <br/>
        <?php if($user):?>
        <?php print_r($user);?>
        <?php endif;?>
    </div>
    
</section>
    
</form>