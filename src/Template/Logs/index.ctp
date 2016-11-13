<div class="logs index large-12 medium-12 columns content">
    <h3><?= __('Channels') ?></h3>
    <p>
        CakeBot is currently running in <?php echo count($channels); ?> channels, to view the channel click one of the following links.
    </p>
    <br />
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($channels as $channel): ?>
            <tr>
                <td><?= $this->Html->link($channel->name, [
                    'controller' => 'logs', 'action' => 'view', substr($channel->name, 1)
                ]) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
