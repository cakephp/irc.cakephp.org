<?php /* SVN FILE: $Id$ */ ?>
<div id="site_search"><?php
$query = '';
$channel = 'cakephp';
if ($this->name == 'Logs') {
       if ($this->action == 'view' && isset($this->params['pass'][0])) {
	       $channel = $this->params['pass'][0];
       } elseif ($this->action == 'search') {
	       list($channel, $query) = $this->params['pass'];
       }
}
echo $form->create('Search', array('url' => '/search', 'id' => 'search'));
echo $form->inputs(array(
	'legend' => false,
	'query' => array('label' => false, 'div' => false, 'value' => $query, 'class' => 'query'),
	'channel' => array('type' => 'hidden', 'value' => $channel),
));
echo $form->submit(__('Search', true), array('div' => false, 'id' => 'search_submit_btn'));
echo $form->end();
?></div>