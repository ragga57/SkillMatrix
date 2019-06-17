
<div class="page-header">
    <h2><?= t('Change color') ?></h2>
</div>

<form method="post" action="<?= $this->url->href('SkillMatrixController', 'changeColorTag', array('plugin' => 'SkillMatrix', 'tagName'=>$tagName)) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <?= $this->form->label(t('New color'),'new color') ?>
    <?= $this->form->select('colorIndex', $tagColorArray, array(), array(), array(), 'color-picker') ?>
    <br>
    <br>
    <input type="submit" value="<?= t('Change') ?>" class="btn btn-blue"/>
</form>



