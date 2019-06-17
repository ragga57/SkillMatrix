<section class="sidebar-container" id="dashboard">
    <div class="sidebar-content">
        <div class="project-header">
            <div class="views">
                <ul>
                    <li><?= $this->url->icon('users',t('User section'), 'SkillMatrixController', 'adminUserSection', array('plugin' => 'SkillMatrix')) ?>
                    </li>
                    <li><?= $this->url->icon('graduation-cap',t('Skill section'), 'SkillMatrixController', 'adminSkillSection', array('plugin' => 'SkillMatrix')) ?>
                    </li>
                    <li class="active"><?= $this->url->icon('tags',t('Tag section'), 'SkillMatrixController', 'adminTagSection', array('plugin' => 'SkillMatrix')) ?>
                    </li>
                    <li><?= $this->url->icon('cubes',t('Role section'), 'SkillMatrixController', 'adminRoleSection', array('plugin' => 'SkillMatrix')) ?>
                    </li>
                </ul>
            </div>
        </div>
        <br>

        <?php if ($this->helper->skillDatabaseHelper->getSkillUserRole($userID) == 'app-admin'): ?>

            <button id="showToggle" class="btn btn-blue"><i class="fa fa-fw fa-plus" aria-hidden="true"></i><?= t('Add new tag') ?></button>
            <div id="toggle-section" style="display: none">
            <h2><?= t('Add new tag') ?></h2>
            <form method="post" action="<?= $this->url->href('SkillMatrixController', 'addNewTag', array('plugin' => 'SkillMatrix')) ?>" autocomplete="off">
                <?= $this->form->csrf() ?>

                <?= $this->form->label(t('Name'),'name') ?>
                <?= $this->form->text('tagName',$tagArray, array(),array('required')) ?>

                <?= $this->form->label(t('Color'),'color') ?>
                <?= $this->form->select('colorIndex', $tagColorArray, array(), array(), array(), 'color-picker') ?>

                <?php print_r($values)?>
                <br>
                <br>
                <input type="submit" value="<?= t('Save tag') ?>" class="btn btn-blue"/>
            </form>
        </div>
        <div>
            <h2><?= t('Existing tags')?></h2>

            <form id="form-search" method="post" action="<?= $this->url->href('SkillMatrixController', 'adminTagSection', array('plugin' => 'SkillMatrix')) ?>" autocomplete="off">
                <?= $this->form->csrf() ?>
                <?= $this->form->text('searchField',$value, array(), array("value=\"$searchQuery\""),'input') ?>
                <input type="submit" value="<?= t('Search') ?>" class="btn btn-blue"/>
            </form>
        <br>
        <?= $this->render('SkillMatrix:table/adminTagTable', array(
            'plugin' => 'SkillMatrix',
            'tableHead' => $tableHead,
            'tagArray' => $tagArray,
            'tagColorArray' => $tagColorArray
        )) ?>
        </div>
        <?php endif ?>
    </div>
</section>







