<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cocktail[]|\Cake\Collection\CollectionInterface $cocktails
 */
?>
<div class="cocktails index content">
    <?= $this->Html->link(__('New Cocktail'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Cocktails') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cocktails as $cocktail): ?>
                <tr>
                    <td><?= $this->Number->format($cocktail->id) ?></td>
                    <td><?= h($cocktail->name) ?></td>
                    <td><?= h($cocktail->created) ?></td>
                    <td><?= h($cocktail->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $cocktail->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cocktail->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cocktail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cocktail->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
