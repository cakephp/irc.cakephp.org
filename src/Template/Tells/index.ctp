<div class="tells index large-12 medium-12 columns content">
    <h3><?= __('Tells') ?></h3>
    <?= $this->element('search') ?>

    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" class="id"><?= $this->Paginator->sort('id', '#') ?></th>
                <th scope="col" class="keyword"><?= $this->Paginator->sort('keyword') ?></th>
                <th scope="col" class="text"><?= $this->Paginator->sort('message') ?></th>
                <th scope="col" class="at"><?= $this->Paginator->sort('created', 'At') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tells as $tell): ?>
            <tr>
                <td><?= $this->Html->link(
                    '#',
                    ['action' => 'link', $tell->id, '#' => 'message' . ($tell->id + 10)],
                    ['id' => 'message' . $tell->id, 'title' => 'direct link to: ' . h($tell->message)]
                ) ?></td>
                <td><?= h($tell->keyword) ?></td>
                <td class="log-text"><?= h($tell->message) ?></td>
                <td><?= h($tell->created) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
