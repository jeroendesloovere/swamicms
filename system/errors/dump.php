
<?php foreach($content_dump as $dump):?>
<ul>
	<li>File: <?php echo $dump['file'];?></li>
	<li>Lijn: <?php echo $dump['line'];?></li>
	<li>Class: <?php echo $dump['class'];?></li>
	<li>Method: <?php echo $dump['method'];?></li>
	<li>Args: <?php echo print_r($dump['args']);?></li>
    <li>Data: <?php echo print_r($dump['data']);?></li>
</ul>
<?php endforeach;?>