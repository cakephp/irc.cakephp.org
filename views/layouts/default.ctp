<?php
/* SVN FILE: $Id$ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2005-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc.
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		<?php echo $title_for_layout;?> 
		<?php __('for CakeBot: the best friend of irc'); ?>
	</title>
	<meta name="robots" content="noindex, nofollow">
	<?php
		echo $html->charset();
		echo $html->meta('icon');

		echo $html->css(array('cakebot'));

		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1>
				<?php echo $html->link('CakeBot', '/', null, false, false);?>
			</h1>
		</div>
		<div id="main_nav">
			<ul class="navigation">
				<li>
					<?php $css_class = ($this->name == 'Channels') ? 'on' : null;?>
					<?php echo $html->link('Channels', array('controller' => 'channels', 'action' => 'index'), array('class'=>$css_class)); ?>
				</li>
				<li>
					<?php $css_class = ($this->name == 'Logs') ? 'on' : null;?>
					<?php echo $html->link('Logs', array('controller' => 'logs', 'action' => 'index'), array('class'=>$css_class)); ?>
				</li>
				<li>
					<?php $css_class = ($this->name == 'Tells') ? 'on' : null;?>
					<?php echo $html->link('Tells', array('controller' => 'tells', 'action' => 'index'), array('class'=>$css_class)); ?>
				</li>
			</ul>
		</div>
		<div id="secondary_nav">
			<ul class="navigation">
				<li><?php echo $html->link('About CakeBot', '/pages/about');?></li>
				<li><a href="http://cakephp.org/">About CakePHP</a></li>
				<li><a href="http://cakefoundation.org/pages/donations">Donate</a></li>
			</ul>
		</div>
		<div id="sites_nav">
			<ul class="navigation">
				<li class="current"><a href="http://cakephp.org/">CakePHP</a></li>
				<li><a href="http://api.cakephp.org/">API</a></li>
				<li><a href="http://book.cakephp.org/">Docs</a></li>
				<li><a href="http://bakery.cakephp.org/">Bakery</a></li>
				<li><a href="http://live.cakephp.org/">Live</a></li>
				<li><a href="http://cakeforge.org/">Forge</a></li>
				<li><a href="https://trac.cakephp.org/">Trac</a></li>
			</ul>
		</div>
		<?php 
			echo $this->element('search');
		?>
		<div id="content">
			<?php
				if ($session->check('Message.flash')):
						$session->flash();
				endif;
			?>

			<?php echo $content_for_layout;?>

		</div>
		<div id="footer">
			<?php echo $html->link(
							$html->image('cake.power.gif', array('alt'=> __("CakePHP: the rapid development php framework", true), 'border'=>"0")),
							'http://www.cakephp.org/',
							array('target'=>'_new'), null, false
						);
			?>
		</div>
	</div>
	<?php echo $cakeDebug?>
</body>
</html>
