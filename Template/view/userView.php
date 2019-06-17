<section class="sidebar-container" id="dashboard">
    <div class="sidebar-content">
        <div class="project-header">
            <form id="form-search" method="post" action="<?= $this->url->href('SkillMatrixController', 'userSection', array('plugin' => 'SkillMatrix')) ?>" autocomplete="off">
                <?= $this->form->csrf() ?>
                <?= $this->form->text('searchField',$value, array(), array("value=\"$searchQuery\""),'input') ?>
                <input type="submit" value="<?= t('Search') ?>" class="btn btn-blue"/>
            </form>

        </div>
        <br>
        <?php if ($rights['no_tags'] != 1 ): ?>
            <?= $this->render('SkillMatrix:table/resourceManagerTable', array(
                'plugin' => 'SkillMatrix',
                'tableHead' => $tableHead,
                'userSkillArray' => $userSkillArray,
                'userTagArray' => $userTagArray,
                'canEdit' => $canEdit,
                'rights' => $rights
            )) ?>
        <?php else: ?>
            <?= $this->render('SkillMatrix:table/userAndManagerTable', array(
                'plugin' => 'SkillMatrix',
                'tableHead' => $tableHead,
                'userSkillArray' => $userSkillArray,
                'canEdit' => $canEdit
            )) ?>
        <?php endif ?>
        <br>

    </div>
</section>






