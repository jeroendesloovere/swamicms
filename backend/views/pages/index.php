<?php if(!defined('SWAMI')){die('External Access to File Denied');}?>

<?php
load::model('Block');

$block = new Block(BASE_URL,BASE_URL);
if(isAllowed('add')) $block->addBtn('add','admin/pages/add','page');
if(isAllowed('edit')) $block->addCustomBtn('add',url::get('admin/pages/add'),__('add {item}',array('{item}'=>___('user'))));

$data = array(
	array(
		'id'=>1,
		'title'=>'jeroen',
		'page'=>'daar',
		'content'=>'lager',
	),
	array(
		'id'=>2,
		'title'=>'maria',
		'page'=>'daar',
		'content'=>'test',
	),
	array(
		'id'=>3,
		'title'=>'charlotte',
		'page'=>'daar',
		'content'=>'test',
	),
	array(
		'id'=>4,
		'title'=>'Luc',
		'page'=>'daar',
		'content'=>'test',
	),
);

$table = new Table($data);
$table->setKeys('title','content');
$table->setSort('id asc');
$table->setLabel('created_on','meuh');
$table->addColumn('admin/pages/add/{id}/',NULL,'Pagina toevoegen');
$table->addBtn('title','admin/pages/edit/{id}/','edit');
$table->setReordering(true,'admin/pages/');

$table->setCheckboxes('{id}');
$table->addCheckboxBtn('delete','delete',"Pagina's verwijderen");


$block->addContent($table);
$block->parse();

?>

<div class="block">
	<div class="block-header">
    	<div class="block-header-left">
        	<a href="<?php echo BASE_URL;?>"><?php echo urldecode(BASE_URL);?></a>
        </div>
        <div class="block-header-right">
        	<?php if(isAllowed('add')):?>
        	<a class="btn positive" href="<?php echo url::get('admin/pages/add');?>" title=""><span class="icon add"></span><?php e__('add {item}',array('{item}'=>___('page')));?></a>
          <?php endif;?>
        </div>
    </div>
    <table id="pages" class="table hide-btn">
        <thead>
            <tr>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody class="oddEven" data-reorder="<?php echo url::get('admin/pages/reorder');?>">
		<?php foreach($pages as $key => $page):?>
        	<tr id="<?php echo $page->id;?>">
            	<td>
              		<a class="btn show-btn" href="<?php echo url::get('admin/pages/edit/'.$page->id.'');?>" title=""><span class="icon <?php echo ($key==0) ? 'home' : 'edit'; ?>"></span><?php echo $page->nav_name;?></a>
                	- <span id="url"><?php echo $page->url;?></span>
                <?php if(isAllowed('add')):?>
                	<a class="btn positive"><span class="icon add"></span><?php e__('add {item}',array('{item}'=>__('page')));?></a>
                	<a class="btn positive"><span class="icon add"></span><?php e__('add {item}',array('{item}'=>__('blogpage')));?></a>
                	<a class="btn"><span class="icon copy"></span><?php e__('make_copy');?></a>
                <?php endif;?>
				</td>
				<td>
				<?php if(isAllowed('delete')):?>
              		<a class="btn negative" href="" title=""><span class="icon delete"></span><?php e__('delete');?></a>
              		<?php endif;?>
              		<a class="btn" href="" title=""><span class="icon search empty"></span></a>
              	</td>
        	</tr>
        <?php endforeach;?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="block-footer"></div>
</div>
<div class="block">
	<div class="block-header">
    	<div class="block-header-left">
        	<a href="<?php echo BASE_URL;?>"><?php echo urldecode(BASE_URL);?></a>
        </div>
        <div class="block-header-right">
        	<?php if(isAllowed('add')):?>
        	<a class="btn positive" href="<?php echo url::get('admin/pages/add');?>" title=""><span class="icon add"></span><?php e__('add {item}',array('{item}'=>___('page')));?></a>
          <?php endif;?>
        </div>
    </div>
    <table id="pages" class="table hide-btn">
        <thead>
            <tr>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody class="oddEven" data-reorder="<?php echo url::get('admin/pages/reorder2');?>">
		<?php foreach($pages as $key => $page):?>
        	<tr id="<?php echo $page->id;?>">
            	<td>
              		<a class="btn show-btn" href="<?php echo url::get('admin/pages/edit/'.$page->id.'');?>" title=""><span class="icon <?php echo ($key==0) ? 'home' : 'edit'; ?>"></span><?php echo $page->nav_name;?></a>
                	- <span id="url"><?php echo $page->url;?></span>
                <?php if(isAllowed('add')):?>
                	<a class="btn positive"><span class="icon add"></span><?php e__('add {item}',array('{item}'=>__('page')));?></a>
                	<a class="btn positive"><span class="icon add"></span><?php e__('add {item}',array('{item}'=>__('blogpage')));?></a>
                	<a class="btn"><span class="icon copy"></span><?php e__('make_copy');?></a>
                <?php endif;?>
				</td>
				<td>
				<?php if(isAllowed('delete')):?>
              		<a class="btn negative" href="" title=""><span class="icon delete"></span><?php e__('delete');?></a>
              		<?php endif;?>
              		<a class="btn" href="" title=""><span class="icon search empty"></span></a>
              	</td>
        	</tr>
        <?php endforeach;?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <div class="block-footer"></div>
</div>