<?php if(!user::valid()) url::redirect('admin/login');?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>Swami CMS | <?php echo ucfirst(route::controller());?></title>   
     
    <link rel="stylesheet" href="<?php echo WEBROOT?>css/jquery-ui-1.8.12.custom.css"/>
    <link rel="stylesheet" href="<?php echo WEBROOT?>css/stylesheet.css"/>
<?php if(!empty($content_css['top'])):foreach($content_css['top'] as $css):?>
		<link rel="stylesheet" href="<?php echo $css;?>"/>
<?php endforeach;endif;?>
	<script src="<?php echo WEBROOT;?>js/libs/jquery-1.5.1.min.js"></script>
    <script src="<?php echo WEBROOT;?>js/libs/jquery-ui-1.8.12.custom.min.js"></script>
    <script src="<?php echo WEBROOT;?>js/libs/modernizr-1.7.min.js"></script>
<?php if(!empty($content_js['top'])):foreach($content_js['top'] as $js):?>
		<script src="<?php echo $js;?>"></script>
<?php endforeach;endif;?>
</head>
<body>

<?php if(count($content_dump)>0):?>
<div id="dump">
<?php foreach($content_dump as $dump):?>
<dl>
	<?php if(!empty($dump['name'])):?><dt>Naam:</dt><dd><?php echo $dump['name'];?></dd><?php endif;?>
	<dt>Method:</dt><dd>"<?php echo $dump['class'];?>/<?php echo $dump['method'];?>", rule <?php echo $dump['line'];?></dd>
	<dt>File:</dt><dd><?php echo $dump['file'];?></dd>
    <dt>Args:</dt><dd><?php echo print_r($dump['args']);?></dd>
</dl>
<br/><br/>

<?php endforeach;?>
</div>
<?php endif;?>

<?php if($notes = note::all()): ?><?php //print_r($notes);?>
	<p id="note" class="<?php echo $notes[0]['type']; ?>"><span><?php echo $notes[0]['content']; ?></span></p>
<?php endif; ?>

  <div id="wrapper">
  <div id="container">
    
    <header>
      <a id="siteTitle" href="<?php echo BASE_URL;?>">GD Ingooigem<span>Bekijk website</span></a>
      <div id="headerRight">
        <a class="btn" href="<?php echo url::get('admin/users/profile');?>" title=""><span class="icon edit"></span>Jeroen Desloovere<?php echo user::data('firstname'),' ',user::data('lastname');?></a>
        <div id="headerSeparator">|</div>
        <a class="btn" href="<?php echo url::get('admin/logout');?>" title="Logout" accesskey="0">Uitloggen</a>
        <form action="<?php echo url::get('admin/search');?>" method="post">
          <input name="siteSearch" type="text" placeholder="Zoeken naar" value="" />
          <button type="submit"><span class="icon-search"></span>Zoeken</button>
        </form>
      </div>
    </header>
    
    <div id="headerRule"></div>
    
		<nav>
    	<ul id="nav" class="nav-inline">
<?php $accesskey=1; foreach($content_nav as $key => $values):?>
<?php if($permissions = acl::get($key)): if(isAllowed('index')):?>
        <li class="nav-item<?php if($content_parent==$key) echo ' current';?>">
       		<a href="<?php echo url::get($values['index']);?>" title="<?php echo $key;?>" accesskey="<?php echo $accesskey;?>"><span class="icon-nav-<?php echo $key;?>"></span><?php e__($key);?></a>
            <?php if(count($values)>1):?>
            <div class="nav-item-arrow">>
              <ul>
				<?php foreach($values as $sub_key => $sub_values):?>
                <li class="nav-2-item"><a href="<?php echo url::get($sub_values);?>" title="<?php echo $key;?>"><?php e__($sub_key);?></a></li>
                <?php endforeach;?>
              </ul>
            </div>
            <?php endif;?>
        </li>
<?php endif; endif;?>
<?php $accesskey+=1; endforeach;?>
      	<li class="nav-item right"><a href="<?php echo BASE_URL;?>" title="" accesskey="<?php echo $accesskey; $accesskey+=1;?>"><span class="icon-nav-home"></span></a></li>
    	</ul>
    
<?php if(count($content_subnav)>1):?>
    	<ul id="subnav" class="nav-inline">
<?php foreach($content_subnav as $key => $url):?>
    		<li<?php if((route::controller()==$content_parent&&route::method()==$key)||(route::controller()==$key)) echo ' class="current"';?>><a href="<?php echo url::get($url);?>" title="<?php echo $key;?>"><?php e__($key);?></a></li>
<?php endforeach;?>
    	</ul>
<?php endif;?>
  	</nav>

    <ul id="breadcrumb" class="nav-inline">
      <li><a href="<?php echo url::get('admin/'.route::controller());?>" title="<?php echo ucfirst(route::controller());?>"><?php e__(route::controller());?></a></li>
      <?php if($method = route::method()):?>
      <li class="separator">></li>
      <li><?php e__($method);?></li>
      <?php endif;?>
      <?php if($content_breadcrumb):?>
      <li class="separator">></li>
      <li><?php echo $content_breadcrumb;?></li>
      <?php endif;?>
    </ul>
    
    <div id="content">
    <?php if(!empty($content_view)) load::view($content_view,$content_vars);?>
    </div>
      
  </div>
  </div>
  
<?php if(!empty($content_css['bottom'])):foreach($content_css['bottom'] as $css):?>
	<link rel="stylesheet" href="<?php echo $css;?>"/>
<?php endforeach; endif;?>
<?php if(!empty($content_js['bottom'])):foreach($content_js['bottom'] as $js):?>
	<script src="<?php echo $js;?>"></script>
<?php endforeach;endif;?>
	<script src="<?php echo WEBROOT;?>js/plugins.js"></script>
	<script src="<?php echo WEBROOT;?>js/script.js"></script>
<!--[if lt IE 7 ]>
  <script src="js/libs/dd_belatedpng.js"></script>
  <script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
<![endif]-->
</body>
</html>