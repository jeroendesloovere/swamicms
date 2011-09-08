<?php if(!defined('SWAMI')){die('External Access to File Denied');}?>

<?php if($note = note::get('login_error')): ?>
	<p class="<?php echo $note['type']; ?>"><?php echo $note['content']; ?></p>
<?php endif; ?>

<?php if(!isset($password_forgotten)):?>
<form action="<?php echo url::get('admin/users/_login');?>" method="post">
	<?php if(!empty($prev_page)):?>
    <input name="prev_page" type="hidden" value="<?php echo $prev_page;?>"/>
    <?php endif;?>
	<label>Username: <input name="username" type="text" value="<?php echo session::get('user_email');?>" /></label>
	<label>Wachtwoord: <input name="password" type="password" value="<?php echo session::get('user_password');?>" /></label>
    <button>Inloggen</button>
    <a href="<?php echo url::get('admin/users/password_recovery');?>" title="Password forgotten">Password forgotten?</a>
</form>
<?php else:?>
<form action="<?php echo url::get('admin/users/_password_recovery');?>" method="post">
	<?php if(!empty($prev_page)):?>
    <input name="prev_page" type="hidden" value="<?php echo $prev_page;?>"/>
    <?php endif;?>
	<label>E-mailadres: <input name="email" type="text" value="<?php echo session::get('user_email');?>" /></label>
    <button>Wachtwoord opsturen</button>
    <a href="<?php echo url::get('admin/login');?>" title="Fill in password">Fill in password</a>
</form>
<?php endif;?>