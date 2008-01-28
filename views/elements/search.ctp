<?php $q = isset($q) ? $q : null;?>
<form action="<?php echo $html->url('/search');?>" method="get" id="search">
	<input name="q" value="<?php echo $q;?>" type="text" size="20"/>
	<input name="search" value="search" class="submit" type="submit">
</form>
