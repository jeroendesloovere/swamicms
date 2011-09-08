<?php 
load::model('seo');
Seo::addKeywords(array('hier','daar','jupla'));
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php echo Seo::title();?></title>
    
    <link href="frontend/files/css/stylesheet.css" rel="stylesheet"/>
    
    <meta content="keywords" value="<?php echo Seo::keywords();?>"/>
    <meta content="description" value="<?php echo Seo::description();?>"/>
</head>
<body>

<?php
load::library('client');
echo client::browser();
echo client::ip();
?>
    <h1>Swami CMS frontend</h1>
    <?php /*
    <?php print_r($pages);?>
    
    <?php echo load::model('page')->name();?><br/>
    <?php echo load::model('page')->nav_name();?><br/>
    <?php print_r(load::model('page')->parents());?><br/>
    <?php echo load::model('page')->url();?><br/>
    <br/>
    
    
   <?php foreach($pages as $seo):?>
    <h2><?php echo $seo->name;?></h2>
    <?php endforeach;?>


	<a href="<?php echo url::get('admin/user/logout');?>" title="Logout">Uitloggen</a>
	*/ ?>
</body>
</html>