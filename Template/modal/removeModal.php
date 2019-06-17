<?php if ($mode == 'role'): ?>
    <div class="page-header">
        <h2><?= t('Delete role') ?></h2>
    </div>
    <p><?= t('Are you sure you want to remove role') ?>: <b> <?= $roleName ?></b> ?</p>
    <br>
    <?= $this->url->button('trash',t('Delete role'),'SkillMatrixController','removeRole',array('plugin' => 'SkillMatrix','roleName' =>$roleName),'btn btn-red')?>
<?php elseif ($mode == 'skill'): ?>
    <div class="page-header">
        <h2><?= t('Remove skill') ?></h2>
    </div>
    <p><?= t('Are you sure you want to remove skill') ?>: <b> <?= $skillName ?></b>?</p>
    <br>
    <?= $this->url->button('trash',t('Remove skill'),'SkillMatrixController','removeSkill',array('plugin' => 'SkillMatrix','skillName' =>$skillName),'btn btn-red')?>
<?php elseif ($mode == 'tagAdmin'): ?>
    <div class="page-header">
        <h2><?= t('Remove tag') ?></h2>
    </div>
    <p><?= t('Are you sure you want to remove tag') ?>: <b> <?= $tagName ?></b>?</p>
    <br>
    <?= $this->url->button('trash',t('Remove tag'),'SkillMatrixController','removeTag',array('plugin' => 'SkillMatrix','tagName' =>$tagName),'btn btn-red')?>
<?php elseif ($mode == 'tagUser'): ?>
    <div class="page-header">
        <h2><?= t('Remove tag') ?></h2>
    </div>
    <p><?= t('Are you sure you want to remove tag') ?>: <b> <?= $tagName ?></b> <?= t('from user') ?>: <b><?= $userName ?></b>?</p>
    <br>
    <?= $this->url->button('trash',t('Remove tag'),'SkillMatrixController','removeTagFromUser',array('plugin' => 'SkillMatrix','userID' =>$userID,'tagName' =>$tagName),'btn btn-red')?>
<?php endif ?>