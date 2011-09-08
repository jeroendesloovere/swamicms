<?php if(!defined('SWAMI')){die('External Access to File Denied');}


// Frontend
// ----------------------------------------------------------
route::set('default_route','index'); // Default Route



// Examples
// ----------------------------------------------------------

//route::set('main/([a-zA-Z]+)/([a-zA-Z]+)',array('controller'=>'$1','function'=>'awesome','arguments'=>array('$2')));
//route::set('one/([a-zA-Z]+)/([a-zA-Z]+)','query/$1/$2' );
//route::set('sweet',array('controller'=>'test/sweet'));

/*
route::set('foo/bar/([a-zA-Z]+)', array(
  'controller'=>'main',
  'function'=>'tree',
  'arguments'=>array('$1')
));

*/