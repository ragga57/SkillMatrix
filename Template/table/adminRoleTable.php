<div id="table-container">
    <table id="table" class="is-hoverable">
        <thead>
        <?php foreach ($tableHead as $index => $row): ?>
            <td class="table-list-header"><strong><?= t(ucfirst($index))?></strong> <?= $this->skillFunctionsHelper->renderTooltip($row)?></td>
        <?php endforeach ?>
        </thead>
        <tr>
            <td>
               app-admin
            </td>
            <td>
                <?= t('Special admin privileges') ?>
            </td>
            <td>
                <?= t('Special admin privileges') ?>
            </td>
            <td>

            </td>
        </tr>
        <?php foreach ($roleArray as $index => $row): ?>
            <?php if ($row['id'] != '1'): ?>
            <tr>
                <td>
                    <?= $this->modal->small('edit',$row['name'],'SkillMatrixController','renameModal',array('plugin' => 'SkillMatrix', 'roleName' =>$row['name'], 'mode'=>'role'))?>
                </td>
                <td>
                    <?php if ($row['edit_all'] == '1'): ?>
                        <?= $this->modal->small('edit',t('Can edit skill values of anyone'),'SkillMatrixController','changeRoleRightsModal',array('plugin' => 'SkillMatrix', 'roleName' =>$row['name'],
                                                                                                                                                'mode' => 'skill',
                                                                                                                                                'currentValue'=> 'edit_all'))?>
                    <?php elseif ($row['edit_projectmates'] == '1'): ?>
                        <?= $this->modal->small('edit',t('Can edit skill values of projectmates'),'SkillMatrixController','changeRoleRightsModal',array('plugin' => 'SkillMatrix', 'roleName' =>$row['name'],
                                                                                                                                                'mode' => 'skill',
                                                                                                                                                'currentValue'=> 'edit_projectmates'))?>
                    <?php else: ?>
                        <?= $this->modal->small('edit',t('Can edit only himself'),'SkillMatrixController','changeRoleRightsModal',array('plugin' => 'SkillMatrix', 'roleName' =>$row['name'],
                                                                                                                                        'mode' => 'skill',
                                                                                                                                        'currentValue'=> 'edit_self'))?>
                    <?php endif ?>
                </td>
                <td>
                    <?php if ($row['add_tags'] == '1'): ?>
                        <?= $this->modal->small('edit',t('Can add tags'),'SkillMatrixController','changeRoleRightsModal',array('plugin' => 'SkillMatrix', 'roleName' =>$row['name'],
                                                                                                                                'mode' => 'tag',
                                                                                                                                'currentValue'=> 'add_tags'))?>
                    <?php elseif ($row['see_tags'] == '1'): ?>
                        <?= $this->modal->small('edit',t('Can only see tags'),'SkillMatrixController','changeRoleRightsModal',array('plugin' => 'SkillMatrix', 'roleName' =>$row['name'],
                                                                                                                                    'mode' => 'tag',
                                                                                                                                    'currentValue'=> 'see_tags'))?>
                    <?php else: ?>
                        <?= $this->modal->small('edit',t('Cannot see tags'),'SkillMatrixController','changeRoleRightsModal',array('plugin' => 'SkillMatrix', 'roleName' =>$row['name'],
                                                                                                                                  'mode' => 'tag',
                                                                                                                                  'currentValue'=> 'no_tags'))?>
                    <?php endif ?>
                </td>
                <td>
                    <?php if ($row['id'] != '2'): ?>
                        <?= $this->modal->mediumButton('trash',t('Delete role'),'SkillMatrixController','removeModal',array('plugin' => 'SkillMatrix','roleName' =>$row['name'],'mode' => 'role'))?>
                    <?php endif ?>
                </td>
            </tr>
            <?php endif ?>
        <?php endforeach ?>
    </table>
</div>







