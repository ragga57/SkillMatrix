<?php if ($mode == 'role'): ?>
    <div class="page-header">
        <h2><?= t('Rename role') ?></h2>
    </div>

    <form method="post" action="<?= $this->url->href('SkillMatrixController', 'renameRole', array('plugin' => 'SkillMatrix', 'roleName'=>$roleName)) ?>" autocomplete="off">
        <?= $this->form->csrf() ?>

        <?= $this->form->label(t('Current name'),'current name') ?>
        <?= $tagName?>
        <?= $this->form->label(t('New name'),'new name') ?>
        <?= $this->form->text('newName',$value, array(),array('required')) ?>
        <br>
        <br>
        <input type="submit" value="<?= t('Change tag') ?>" class="btn btn-blue"/>
    </form>
<?php elseif ($mode == 'skill'): ?>
    <div class="page-header">
        <h2><?= t('Rename skill') ?></h2>
    </div>

    <form method="post" action="<?= $this->url->href('SkillMatrixController', 'renameSkill', array('plugin' => 'SkillMatrix', 'skillName'=>$skillName)) ?>" autocomplete="off">
        <?= $this->form->csrf() ?>

        <?= $this->form->label(t('Current name'),'current name') ?>
        <?= $skillName?>
        <?= $this->form->label(t('New name'),'new name') ?>
        <?= $this->form->text('newName',$value, array(),array('required')) ?>
        <br>
        <br>
        <input type="submit" value="<?= t('Change skill') ?>" class="btn btn-blue"/>
    </form>
<?php elseif ($mode == 'tag'): ?>
    <div class="page-header">
        <h2><?= t('Rename tag') ?></h2>
    </div>

    <form method="post" action="<?= $this->url->href('SkillMatrixController', 'renameTag', array('plugin' => 'SkillMatrix', 'tagName'=>$tagName)) ?>" autocomplete="off">
        <?= $this->form->csrf() ?>

        <?= $this->form->label(t('Current name'),'current name') ?>
        <?= $tagName?>
        <?= $this->form->label(t('New name'),'new name') ?>
        <?= $this->form->text('newName',$value, array(),array('required')) ?>
        <br>
        <br>
        <input type="submit" value="<?= t('Change tag') ?>" class="btn btn-blue"/>
    </form>
<?php endif ?>