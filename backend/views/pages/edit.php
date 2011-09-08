<?php if(!defined('SWAMI')){die('External Access to File Denied');}?>

<form action="<?php echo url::get('admin/users/save');?>" method="post">

<aside>
    <?php if(!isset($page->id)):?>
    <button name="add" class="btn positive" type="submit" accesskey="enter"><span class="icon save"></span><?php e__('add');?></button>
    <?php else:?>
    <button name="save" class="btn positive" type="submit" accesskey="enter"><span class="icon save"></span><?php e__('save');?></button>
    <?php endif;?>
    <button name="saveAndEdit" class="btn positive" type="submit"><span class="icon save"></span><?php e__('save_no_return');?></button>
    
    <?php if(isset($page->id)):?>
    <button name="delete" class="btn negative" type="submit" onClick="if(confirm('Zeker dat u wil verwijderen?')) return true; else return false;"><span class="icon delete"></span><?php e__('delete {item}',array('{item}'=>___('page')));?></button>
    <?php endif;?>
    
    <a class="btn negative" href="<?php echo url::get('admin/pages');?>"><span class="icon cancel"></span><?php e__('cancel');?></a>
		
    <h2><a href="<?php echo url::get('admin/pages');?>"><?php e__('pages');?></a></h2>
    <ul>
			<?php foreach($pages as $p):?>
      <li<?php if(isset($page->id)&&$p->id==$page->id) echo ' class="current"';?>><a href="<?php echo url::get('admin/pages/edit/'.$p->id);?>"><?php echo $p->nav_name;?></a></li>
      <?php endforeach;?>
    </ul>
</aside>

<section>

	<div class="block">
    <div class="block-header">
        <div class="block-header-left">
            Titel <input name="page[name]" type="text" value="<?php echo $page->name;?>" style="display:inline; width:350px;">
        </div>
    </div>

    <div class="block-content">
    		<?php if(isset($page->id)):?>
        <input name="page[id]" type="hidden" value="<?php echo $page->id;?>" />
        <?php endif;?>
        
        
        <?php if($page):?>
        <?php print_r($page);?>
        <?php endif;?>
    </div>
	</div>
  
	<div class="block">
    <div class="block-header">
        <div class="block-header-left">Inhoud</div>
        <div class="block-header-right">
            <span class="tabs">
              <a class="tab">inleiding</a>
              <a class="tab">tekst</a>
            </span>
            <span class="separator"></span>
            <a class="btn positive"><span class="icon add"></span>Inhoud toevoegen</a>
        </div>
    </div>

    <div class="block-content"></div>
	</div>
  
  <div id="tabs" class="block">
    <div class="block-header">
        <div class="block-header-left">Fotogalerijen</div>
        <div class="block-header-right">
        	<ul>
              <li><a href="#fragment-1"><span>One</span></a></li>
              <li><a href="#fragment-2"><span>Two</span></a></li>
              <li><a href="#fragment-3"><span>Three</span></a></li>
          </ul>
          <span class="separator"></span>
          <a class="btn positive"><span class="icon add"></span>Fotogalerij toevoegen</a>
        </div>
    </div>

    <div class="block-content">
        <div id="fragment-1">
            <p>First tab is active by default:</p>
            <pre><code>$('#example').tabs();</code></pre>
        </div>
        <div id="fragment-2">
        fragment 2
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
            
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
        </div>
        <div id="fragment-3">
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
        </div>
    </div>
	</div>
  
  
  <div class="block">
    <div class="block-header">
        <div class="block-header-left">Subpagina's</div>
        <div class="block-header-right">
        <?php if(isset($page->id)):?>
        	<a class="btn positive" href="<?php echo url::get('admin/pages/add/'.$page->id);?>"><span class="icon add"></span>Pagina toevoegen</a>
        <?php endif;?>
        </div>
    </div>

    <div class="block-content">
    </div>
	</div>


</section>

    
</form>
<script>
$(document).ready(function(){
	$("#tabs").tabs();
});
</script>