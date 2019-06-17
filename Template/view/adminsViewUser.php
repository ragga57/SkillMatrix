<section class="sidebar-container" id="dashboard">
    <div class="sidebar-content">
        <div class="project-header">
            <div class="views">
                <ul>
                    <li class="active"><?= $this->url->icon('users',t('User section'), 'SkillMatrixController', 'adminUserSection', array('plugin' => 'SkillMatrix')) ?>
                    </li>
                    <li><?= $this->url->icon('graduation-cap',t('Skill section'), 'SkillMatrixController', 'adminSkillSection', array('plugin' => 'SkillMatrix')) ?>
                    </li>
                    <li><?= $this->url->icon('tags',t('Tag section'), 'SkillMatrixController', 'adminTagSection', array('plugin' => 'SkillMatrix')) ?>
                    </li>
                    <li><?= $this->url->icon('cubes',t('Role section'), 'SkillMatrixController', 'adminRoleSection', array('plugin' => 'SkillMatrix')) ?>
                    </li>
                </ul>
            </div>
        </div>
        <br>

        <?php //var_dump($userSkillArray) ?>
        <?php if ($this->helper->skillDatabaseHelper->getSkillUserRole($userID) == 'app-admin'): ?>
        <div>
            <form id="form-search" method="post" action="<?= $this->url->href('SkillMatrixController', 'adminUserSection', array('plugin' => 'SkillMatrix')) ?>" autocomplete="off">
                <?= $this->form->csrf() ?>
                <?= $this->form->text('searchField',$value, array(), array("value=\"$searchQuery\""),'input') ?>
                <input type="submit" value="<?= t('Search') ?>" class="btn btn-blue"/>
            </form>
        <br>
        <?= $this->render('SkillMatrix:table/adminUserTable', array(
            'plugin' => 'SkillMatrix',
            'tableHead' => $tableHead,
            'userSkillArray' => $userSkillArray,
            'userTagArray' => $userTagArray
        )) ?>
        </div>
        <?php endif ?>
    </div>
</section>






