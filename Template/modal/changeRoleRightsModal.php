
<div class="page-header">
    <h2><?= t('Change role rights') ?></h2>
</div>
<form method="post" action="<?= $this->url->href('SkillMatrixController', 'changeRoleRights', array('plugin' => 'SkillMatrix', 'roleName' => $roleName,
                                                                                                    'mode' => $mode, 'currentRight' => $currentValue)) ?>" autocomplete="off">

    <?= $this->form->csrf() ?>
    <?php if ($mode == 'skill'): ?>
        <?= $this->form->label(t('New skill values rights'),'editing values rights') ?>
        <?= $this->form->radios('newRight',array('edit_all' => t('Can edit skill values of anyone'),
            'edit_projectmates' => t('Can edit skill values of projectmates'),
            'edit_self' =>t('Can edit only himself')), array('newRight' => $currentValue)) ?>
    <?php elseif ($mode == 'tag'): ?>
        <?= $this->form->label(t('New editing tags rights'),'editing tags rights') ?>
        <?= $this->form->radios('newRight',array('add_tags' =>t('Can add tags'),
            'see_tags' =>t('Can only see tags'),
            'no_tags' =>t('Cannot see tags')), array('newRight' =>$currentValue )) ?>
    <?php endif ?>
    <br>
    <br>
    <input type="submit" value="<?= t('Change rights') ?>" class="btn btn-blue"/>
</form>

