<?php
// Use the request time to determine if the user is on a different time zone from the server, and if so,
// Determine to the nearest 1/2 hour what their offset is, and use that to display times
$offset = null;
if (env('REQUEST_TIME')) {
    $offset =  sprintf('%01.0f', ((env('REQUEST_TIME') - $this->Time->gmt()) / 1800)) * 2;
}
if (in_array($this->request->action, ['view', 'search'])) {
    $title = __('Logs for {0}', $channel);
} else {
    $title = __('Log message #{0}', $log->id);
}
if (!isset($highlight)) {
    $highlight = $wrap = false;
}
?>

<div class="logs index large-12 medium-12 columns content">
    <h3><?= $title ?></h3>

    <?php if (!empty($this->request->paging)) : ?>
        <?= $this->element('search') ?>
        <p><?= $this->Paginator->counter('Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total, starting on record {{start}}, ending on {{end}}') ?></p>
    <?php endif; ?>

    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <?php if (!empty($this->request->paging)) : ?>
                    <th scope="col" class="id"><?= $this->Paginator->sort('id', '#') ?></th>
                    <th scope="col" class="at"><nobr><?= $this->Paginator->sort('created', 'At') ?></nobr></th>
                    <th scope="col" class="username"><?= $this->Paginator->sort('username') ?></th>
                    <th scope="col" class="text"><?= $this->Paginator->sort('text') ?></th>
                    <!-- <th scope="col" class="actions"><?= __('Report') ?></th> -->
                <?php else: ?>
                    <th scope="col" class="id">#</th>
                    <th scope="col" class="at"><nobr><?= __('At') ?></nobr></th>
                    <th scope="col" class="username"><?= __('Username') ?></th>
                    <th scope="col" class="text"><?= __('Text') ?></th>
                    <!-- <th scope="col" class="actions"><?= __('Report') ?></th> -->
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $i => $log): ?>
                <?php
                    $text = str_replace('<a', '<a rel="nofollow"', $this->Text->autoLinkUrls(htmlentities($log->text)));
                    $username = $log->username;
                    $slack = false;
                    if (preg_match("/^&amp;lt;([a-z0-9][a-z0-9._-]*)&amp;gt; .*/", $text, $match)) {
                        $text = str_replace(sprintf('&amp;lt;%s&amp;gt;', $match[1]), sprintf('<%s>', $match[1]), $text);
                        $username = $match[1];
                        $slack = true;
                    }
                    $text = str_replace(
                        [
                            '&amp;acirc;&amp;euro;&amp;trade;',
                            '&#039;',
                            '&amp;quot;',
                            '&amp;amp;',
                            '-&amp;gt;',
                        ],
                        [
                            '\'',
                            '\'',
                            '"',
                            'and',
                            '->'
                        ],
                        $text
                    );
                    $class = null;
                    if ($i++ % 2 == 0) {
                        $class = ' class="altrow"';
                    }
                    if ($log->id == $highlight) {
                        $class = ' class="highlight"';
                    }
                ?>
            <tr<?= $class ?>>
                <td><?= $this->Html->link(
                    '#',
                    ['action' => 'link', $log->id, '#' => 'message' . ($log->id + 10)],
                    ['id' => 'message' . $log->id, 'title' => 'direct link to: ' . $text]
                ) ?></td>
                <td><?= $this->AppTime->niceShort($log->created) ?></td>
                <td><?= ($slack ? $this->Html->image('slack-2014.png', ['class' => 'slack-icon']) : '') . htmlentities($username) ?></td>
                <td class="log-text"><?= $text ?></td>
                <!--
                <td class="actions">
                    <?= $this->Form->postLink(__('Report'), ['action' => 'report', $log->id], ['confirm' => __('Are you sure you want to delete # {0}?', $log->id)]) ?>
                </td>
                -->
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (!empty($this->request->paging)) : ?>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
            </ul>
            <p><?= $this->Paginator->counter() ?></p>
        </div>
    <?php endif; ?>
</div>
