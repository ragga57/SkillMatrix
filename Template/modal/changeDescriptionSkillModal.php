<div class="page-header">
    <h2><?= t('Change description') ?></h2>
</div>

<form method="post" action="<?= $this->url->href('SkillMatrixController', 'changeDescriptionSkill', array('plugin' => 'SkillMatrix', 'skillName' =>$skillName)) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <?= $this->form->label(t('Current description'),'current description') ?>
    <p><?= $skillDescription ?></p>

    <?= $this->form->label(t('New description'),'new description') ?>
    <?= $this->form->textarea('newDescription',$value, array(),array('required')) ?>
    <br>
    <br>
    <input type="submit" value="<?= t('Change skill') ?>" class="btn btn-blue"/>
</form>
