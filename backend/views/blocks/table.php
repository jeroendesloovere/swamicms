<?php if(!defined('SWAMI')){die('External Access to File Denied');}?>
<?php //print_r($btns);?>

<?php if($checkboxes):?>
<form action="<?php echo $checkboxes['url'];?>" method="post">
<?php endif;?>
    <table class="table<?php if($show_btns!==true) echo ' hide-btn';?>">
        <thead>
            <tr>
            	<?php if($reordering!==false):?>
                <td></td>
				<?php endif;?>
            	<?php if($checkboxes):?>
                <td class="col-checkbox"><input type="checkbox" /></td>
				<?php endif;?>
                
<?php for($i=0; $i<count($extra_columns['before']); $i+=1):?>
                <td></td>
                <?php endfor;?>
                
<?php foreach($labels as $item):?>
            	<td><?php echo $item;?></td>
        		<?php endforeach;?>
                
<?php for($i=0; $i<count($extra_columns['after']); $i+=1):?>
                <td></td>
                <?php endfor;?>
            </tr>
        </thead>
        
        <tbody<?php if($odd_even) echo ' class="oddEven"';?> <?php if($reordering!==false):?>data-reorder="<?php echo $reordering;?>"<?php endif;?>>
		<?php foreach($data as $row):?>
        	<tr>
            	<?php if($checkboxes):?>
                <td class="col-checkbox"><?php echo $checkboxes['input']->parse($row);?></td>
				<?php endif;?>
                
<?php for($i=0; $i<count($extra_columns['before']); $i+=1):?>
                <td class="col-extra"><?php echo $extra_columns['before'][$i]->parse($row);?></td>
                <?php endfor;?>
                
<?php for($i=0; $i<count($keys); $i+=1):?>
            	<?php if(isset($btns[$keys[$i]])):?>
            	<td><?php echo $btns[$keys[$i]]->parse($row);?></td>
            	<?php elseif(isset($row[$keys[$i]])):?>
            	<td><?php echo $row[$keys[$i]];?></td>
            	<?php endif;?>
                <?php endfor;?>
                
<?php for($i=0; $i<count($extra_columns['after']); $i+=1):?>
                <td class="col-extra"><?php echo $extra_columns['after'][$i]->parse($row);?></td>
                <?php endfor;?>
            </tr>
        <?php endforeach;?>
        </tbody>
        <?php if($checkboxes):?>
        <tfoot>
            <tr>
        		<td colspan="<?php echo $col_count;?>">
                <?php for($i=0; $i<count($checkboxes['btns']); $i+=1){ echo $checkboxes['btns'][$i]->parse();} ?>
                </td>
            </tr>
        </tfoot>
        <?php endif;?>
    </table>
<?php if($checkboxes):?>
</form>
<?php endif;?>