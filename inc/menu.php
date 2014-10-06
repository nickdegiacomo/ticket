<ul id="menu">
	<li><a href="logout.php">Home page</a></li>
	<li<?if($page=='index.php'){?> class="selected"<?}?>><a href="index.php">My account</a></li>
	<?
	$dir = './brix/';
	if (is_dir($dir)) {
	    if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if(is_dir($dir.$file) && $file != '.' && $file != '..' && !is_child($file,$children)){
				$is_parent = is_parent($file,$parents);
				?><li<?if($page==$file.'.php'){?> class="<?if($is_parent){?>parent <?}?>selected"<?} else { if($is_parent){?> class="parent"<?} }?>>
					<a href="<?=$file?>.php"><?=ucfirst(str_replace('_',' ',$file))?></a><?
					if($is_parent){
						$pi = get_parent_index($file,$parents);
						$t = count($cement[$pi]);
						?><ul class="submenu"><?
						for($i=0;$i<$t;$i++){
							?><li><a href="<?=$cement[$pi][$i]?>.php"><?=ucfirst(str_replace('_',' ',$cement[$pi][$i]))?></a></li><?
						}
						?></ul><?
					}
				?></li><?
			} 
		}
		closedir($dh);
	    }
	}
	?>
</ul>
