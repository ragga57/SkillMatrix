<section class="sidebar-container" id="dashboard">
    <div class="sidebar-content">
        <div class="project-header">
        <div class="views">
            <ul>
                <li><?= $this->url->icon('users',t('User section'), 'SkillMatrixController', 'adminUserSection', array('plugin' => 'SkillMatrix')) ?>
                </li>
                <li><?= $this->url->icon('graduation-cap',t('Skill section'), 'SkillMatrixController', 'adminSkillSection', array('plugin' => 'SkillMatrix')) ?>
                </li>
                <li><?= $this->url->icon('tags',t('Tag section'), 'SkillMatrixController', 'adminTagSection', array('plugin' => 'SkillMatrix')) ?>
                </li>
                <li class="active"><?= $this->url->icon('cubes',t('Role section'), 'SkillMatrixController', 'adminRoleSection', array('plugin' => 'SkillMatrix')) ?>
                </li>

            </ul>
        </div>
        </div>
        <br>

        <?php if ($this->helper->skillDatabaseHelper->getSkillUserRole($userID) == 'app-admin'): ?>
            <button id="showToggle" class="btn btn-blue"><i class="fa fa-fw fa-plus" aria-hidden="true"></i><?= t('Add new role') ?></button>
        <div id="toggle-section" style="display: none">
            <h2><?= t('Add new role') ?></h2>
            <form method="post" action="<?= $this->url->href('SkillMatrixController', 'addNewRole', array('plugin' => 'SkillMatrix')) ?>" autocomplete="off">
                <?= $this->form->csrf() ?>

                <?= $this->form->label(t('Name'),'name') ?>
                <?= $this->form->text('roleName',$value, array(),array('required')) ?>

                <?= $this->form->label(t('Editing skill values rights'),'editing values rights') ?>
                <?= $this->form->radios('skillRights',array('edit_all' => t('Can edit skill values of anyone'),
                                                            'edit_projectmates' => t('Can edit skill values of projectmates'),
                                                            'edit_self' =>t('Can edit only himself')), array('skillRights' => 'edit_self')) ?>

                <?= $this->form->label(t('Editing tags rights'),'editing tags rights') ?>
                <?= $this->form->radios('tagRights',array('add_tags' =>t('Can add tags'),
                                                        'see_tags' =>t('Can only see tags'),
                                                        'no_tags' =>t('Cannot see tags')), array('tagRights' =>'no_tags' )) ?>
                <br>
                <br>
                <input type="submit" value="<?= t('Add') ?>" class="btn btn-blue"/>
            </form>
        </div>
            <h2><?= t('Existing roles')?></h2>
            <?= $this->render('SkillMatrix:table/adminRoleTable', array(
                'plugin' => 'SkillMatrix',
                'tableHead' => $tableHead,
                'roleArray' => $roleArray
            )) ?>

        <?php endif ?>
    </div>
</section>






