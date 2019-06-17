
<div class="page-header">
    <h2><?= t('Change role') ?></h2>
</div>

<form method="post" action="<?= $this->url->href('SkillMatrixController', 'changeRole', array('plugin' => 'SkillMatrix', 'userID'=>$userID)) ?>" autocomplete="off">
    <div class="task-form-container">
        <div class="task-form-main-column">
            <?= $this->form->csrf() ?>

            <?= $this->form->label(t('New role'),'New role') ?>
            <?= $this->form->select('roleIndex',$roleArray, array(),array(),array('multiple','size="4"'),'') ?>
            <br>
            <br>

        </div>
        <div class="task-form-secondary-column">

        </div>
        <div class="task-form-bottom">
            <input type="submit" value="<?= t('Change role') ?>" class="btn btn-blue"/>
        </div>
    </div>
</form>





