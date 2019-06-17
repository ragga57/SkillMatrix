<section class="sidebar-container" id="dashboard">
    <div class="sidebar-content">
        <div class="project-header">
        <div class="views">
            <ul>
                <li><?= $this->url->icon('users',t('User section'), 'SkillMatrixController', 'adminUserSection', array('plugin' => 'SkillMatrix')) ?>
                </li>
                <li class="active"><?= $this->url->icon('graduation-cap',t('Skill section'), 'SkillMatrixController', 'adminSkillSection', array('plugin' => 'SkillMatrix')) ?>
                </li>
                <li><?= $this->url->icon('tags',t('Tag section'), 'SkillMatrixController', 'adminTagSection', array('plugin' => 'SkillMatrix')) ?>
                </li>
                <li><?= $this->url->icon('cubes',t('Role section'), 'SkillMatrixController', 'adminRoleSection', array('plugin' => 'SkillMatrix')) ?>
                </li>

            </ul>
        </div>
        </div>
        <br>

        <?php if ($this->helper->skillDatabaseHelper->getSkillUserRole($userID) == 'app-admin'): ?>
            <button id="showToggle" class="btn btn-blue"><i class="fa fa-fw fa-plus" aria-hidden="true"></i><?= t('Add new skill') ?></button>
        <div id="toggle-section" style="display: none">
            <h2><?= t('Add new skill') ?></h2>
            <form method="post" action="<?= $this->url->href('SkillMatrixController', 'addSkill', array('plugin' => 'SkillMatrix')) ?>" autocomplete="off">
                <?= $this->form->csrf() ?>

                <?= $this->form->label(t('Name'),'name') ?>
                <?= $this->form->text('skillName',$value, array(),array('required')) ?>

                <?= $this->form->label(t('Description'),'description') ?>
                <?= $this->form->textarea('skillDescription',$value, array(),array('required')) ?>
                <br>
                <br>
                <input type="submit" value="<?= t('Add') ?>" class="btn btn-blue"/>
            </form>
        </div>
        <div>
        <h2><?= t('Existing skills')?></h2>
            <form id="form-search" method="post" action="<?= $this->url->href('SkillMatrixController', 'adminSkillSection', array('plugin' => 'SkillMatrix')) ?>" autocomplete="off">
                <?= $this->form->csrf() ?>
                <?= $this->form->text('searchField',$value, array(), array("value=\"$searchQuery\""),'input') ?>
                <input type="submit" value="<?= t('Search') ?>" class="btn btn-blue"/>
            </form>
            <br>
        <?= $this->render('SkillMatrix:table/adminSkillTable', array(
            'plugin' => 'SkillMatrix',
            'tableHead' => $tableHead,
            'skillArray' => $skillArray
        )) ?>
        </div>
        <?php endif ?>
    </div>
</section>






