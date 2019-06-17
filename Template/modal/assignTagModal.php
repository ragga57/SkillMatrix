<div class="page-header">
    <div class="views">
        <ul>
            <li id="existingTagSectionTrigger" class="active"><a><i class="fa fa-fw fa-graduation-cap" aria-hidden="true"></i><?= t('Existing tag')?></a>
            </li>
            <li id="createNewTagSectionTrigger" ><a><i class="fa fa-fw fa-graduation-cap" aria-hidden="true"></i><?= t('Create new tag')?></a>
            </li>
        </ul>
    </div>
</div>

<div id="existingTag">
    <h2><?= t('Add tag') ?></h2>
    <form method="post" action="<?= $this->url->href('SkillMatrixController', 'assignTagExisting', array('plugin' => 'SkillMatrix', 'userID' => $userID,'tagArray' => $tagArray)) ?>" autocomplete="off">
        <?= $this->form->csrf() ?>
        <?= $this->form->label(t('Name'),'name') ?>
        <?= $this->form->select('tagIndex',$tagArray,array(),array(),array('multiple','size="5"')) ?>
        <br>
        <br>
        <input type="submit" value="<?= t('Add') ?>" class="btn btn-blue"/>

    </form>
</div>

<div id="createNewTag" style="display: none;">
    <h2><?= t('Create new tag') ?></h2>
    <form method="post" action="<?= $this->url->href('SkillMatrixController', 'assignTagNew', array('plugin' => 'SkillMatrix','userID' => $userID)) ?>" autocomplete="off">
        <?= $this->form->csrf() ?>

        <?= $this->form->label(t('Name'),'name') ?>
        <?= $this->form->text('tagName',$value, array(),array('required')) ?>

        <?= $this->form->label(t('Color'),'color') ?>
        <?= $this->form->select('colorIndex', $tagColorArray, array(), array(), array(), 'color-picker') ?>
        <br>
        <br>
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue"/>
    </form>
</div>

