<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Swami CMS | Login</title>
    <base href="<?php echo BASE_URL;?>" />
    
    <link rel="stylesheet" href="<?php echo url::get(APPLICATION.'/files/css/login.css');?>"/>
</head>

<body>

<div id="container">
<?php load::view($content_view,$content_vars);?>
</div>

</body>
</html>