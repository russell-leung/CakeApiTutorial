<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cocktail $cocktail
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $cocktail->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $cocktail->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Cocktails'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="cocktails form content">
            <?= $this->Form->create($cocktail) ?>
            <fieldset>
                <legend><?= __('Edit Cocktail') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('description');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
