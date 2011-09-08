<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?php //echo Seo::title();?></title>
    
    <link href="<?php echo WEBROOT;?>css/stylesheet.css" rel="stylesheet"/>
    
    <meta content="keywords" value="<?php //echo Seo::keywords();?>"/>
    <meta content="description" value="<?php //echo Seo::description();?>"/>
</head>
<body>


    <h1>Form module</h1>
    

<?php

load::library('eventListener');

class Boo
{
	public static function test($var)
	{
		echo "in ".__CLASS__."'s test functie met als var = ".$var;
	}
}

class Foo
{
	public static function test($var)
	{
		echo " -- ".__CLASS__."'s test functie met als var = ".$var;
	}
}
EventListener::add('page_update','Boo::test');
EventListener::add('page_update','Foo::test');

EventListener::rename('page_update','page_update');
print_r(EventListener::all());

EventListener::add('page_update','Foo::test');
EventListener::dispatch('page_update2');
EventListener::delete('hier');

/*

// Pages
page_add
page_update

// Seo
seo_changed


*/

/*
event::add('page_update','Boo::test');
event::add('page_update','Foo::test');
event::dispatch('page_update');
event::delete('hier');
*/



load::library('data');
load::library('clean');
load::library('url');
echo "<br/>";
echo clean::humanize('Jeroen_was_here');
echo "<br/>";
echo clean::slug('Relation between this & that is one, two & three');
echo "<br/>";
echo clean::camilize('Jeroen_was_here');
echo "<br/>";
echo clean::underscore('JeroenWasHere');
echo "<br/>";
echo clean::tablename('Jeroen_was_here');
echo "<br/>";
echo url::get('test','jeroen');
echo "<br/>";
echo url::get('admin/test/hier/');
echo "<br/>";
echo url::get('admin/pluginName/test///');
//echo url::redirect('admin');
echo "<br/>";
echo url::referrer();

echo "<br/>";

?>

<meta content="keywords" value="<?php echo clean::meta(array('<p>j\'eroen</p>T<test>test','hier','daar','waar'));?>" />
<?php

error_reporting(E_ALL|E_NOTICE);
echo clean::slug('Hier is &": 90% belgen $90 /ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º/   sdf   ');

echo "<br/>";
echo clean::meta(array('<p>j\'eroen</p>T<test>test','hier','daar','"test"waar'));

?> 
    
    
    
    
    
<?php
try
{
	
load::library('formInput');
$button = new Textinput('submit','test','submit');
echo $button->parse();

load::library('form');



$form = new form('pages');
if(!$form->submitted) // Change later to isValid()
{
	$form->addTextinput('firstName','Jeroen','Voornaam');
	$form->addTextinput('lastName','Desloovere','Familienaam');
	$form->addCheckbox('vis','Maak zichtbaar op de website?');
	
	$form->addMultipleCheckbox('vis2',array('blue'=>'blauw','geel'=>'Jaune','roze'=>'pink'),array('roze'));
		
	$text = new Textinput('language','en','maximum');
	$text->setAttribute('data-id','50');
	$text->setAttribute('data-name','50');
	$text->setAttribute('help','U moet een waarde invullen tussen 5 en 10');
	$form->add($text);
	
	$form->addHidden('lang','fr');
	$form->addButton('continue','Verzenden');
	
	echo $form->parse();
}
else { echo "form is gesubmit"; dump($_POST['form']); }

$form = new form('pages2');

if(!$form->submitted) // Change later to isValid()
{
	$form->addTextinput('firstname','Jeroen','Voornaam:');
	$form->addTextinput('lastname','Desloovere','Familienaam:');
	$form->addHidden('lang','fr');
	$form->addButton('continue','Verzenden');
	echo $form->parse();
}
else echo "form is gesubmit";
echo "below";

}
catch(Exception $e)
{
echo $e;
}
?>
<fieldset>
	<legend>Zonder form</legend>
<form action="" method="post">

	<input type="hidden" value="inputs_apart"/>
    
    <p>
    	<label>Selecteer jouw keuze:</label>
        <input type="checkbox">
    </p>
    <?php
	$inputs = new forminput();
	$inputs->addTextinput('firstname','Jeroen','Voornaam:');
	$inputs->addTextinput('lastname','Desloovere','Familienaam:');
	echo $inputs->parse();
	
	?>

    <button type="submit">Submit inputs</button>
</form>
</fieldset>

    
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


	<a href="<?php echo url::page('admin/user/logout');?>" title="Logout">Uitloggen</a>
	*/ ?>
</body>
</html>