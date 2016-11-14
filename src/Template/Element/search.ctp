<div id="site_search">
    <?= $this->Form->create('Search', ['id' => 'search']); ?>
    <?= $this->Form->input('q', ['label' => false]); ?>
    <?= $this->Form->button(__('Search {0}', $this->request->controller)); ?>
    <?= $this->Form->end(); ?>
</div>
