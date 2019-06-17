<div class="page-header">
    <h2><?= t('Edit value') ?></h2>
</div>

<form method="post" action="<?= $this->url->href('SkillMatrixController', 'editSkillValue', array('plugin' => 'SkillMatrix', 'userID' => $userID, 'skillName' => $skillName)) ?>" autocomplete="off">
    <div class="task-form-container">
        <div class="task-form-main-column">
            <?= $this->form->csrf() ?>
            <?= $this->form->label(t('New value'),'new value') ?>
            <?= $this->form->select('valueIndex',$skillValuesArray,array(),array(),array('multiple','size="5"')) ?>
            <br>
            <br>
        </div>
        <div class="task-form-secondary-column">
            <?= $this->form->label(t('Values explanation'),'values explanation') ?>
            <ul>
                <li>5 - <?= t('Excellent')?></li>
                <li>4 - <?= t('Very good')?></li>
                <li>3 - <?= t('Average')?></li>
                <li>2 - <?= t('Below average')?></li>
                <li>1 - <?= t('Bad')?></li>
            </ul>
        </div>
        <div class="task-form-bottom">
            <input type="submit" value="<?= t('Update value') ?>" class="btn btn-blue"/>
        </div>
    </div>

</form>

