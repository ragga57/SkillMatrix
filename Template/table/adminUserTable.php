<div id="table-container">
    <table id="table" class="is-hoverable">
        <thead>
        <?php foreach ($tableHead as $index => $row): ?>
            <td class="table-list-header"><strong><?= t(ucfirst($index))?></strong> <?= $this->skillFunctionsHelper->renderTooltip($row)?></td>
        <?php endforeach ?>
        </thead>
        <?php foreach ($userSkillArray as $index => $user): ?>
            <tr>
                <?php foreach ($tableHead as $skill => $description): ?>
                    <td>
                        <!-- CAN EDIT VALUE-->
                        <?php if ($skill != 'name' && $skill != 'username' && $skill != 'role' && $skill != 'id'): ?>
                            <?php if ($user[$skill] != null): ?>
                                <?= $this->modal->small('edit',$user[$skill],'SkillMatrixController','editSkillValueModal',array('plugin' => 'SkillMatrix','userID' =>$user['id'] ,'skillName' =>$skill))?>
                            <?php else: ?>
                                <?= $this->modal->small('edit','-','SkillMatrixController','editSkillValueModal',array('plugin' => 'SkillMatrix','userID' =>$user['id'] ,'skillName' =>$skill))?>
                            <?php endif ?>
                            <!-- CANNOT EDIT VALUE-->
                        <?php elseif ($skill != 'role' ): ?>
                            <?php if ($skill == 'name'): ?>
                                <span class="showTagButton" data-row_id="<?= $index ?>"><a class="user-name"><i class="fa fa-fw fa-tags" aria-hidden="true"></i><?= $user[$skill]?></a></span>
                            <?php elseif (!empty($user[$skill])): ?>
                                <?= $user[$skill]?>
                            <?php else: ?>
                                <?= '-'?>
                            <?php endif ?>
                        <?php else: ?>
                            <?= $this->modal->small('wrench',$user[$skill],'SkillMatrixController','changeRoleModal',array('plugin' => 'SkillMatrix','userID' =>$user['id']))?>
                        <?php endif ?>

                    </td>
                <?php endforeach ?>
            </tr>
            <tr rowspan="2" id="<?= $index ?>" style="display: none;">
                <td class="is-light" style="border-right: none;">
                    <?= t('Tags')?>:
                    <br>
                    <br>
                    <?= $this->modal->mediumButton('plus',t('Add tag'),'SkillMatrixController','addTagModal',array('plugin' => 'SkillMatrix','userID' =>$user['id']))?>
                </td>
                <td class="is-light" colspan="100%" style="border-left: none;">
                    <?php foreach ($userTagArray[$user['id']] as $name => $color): ?>
                        <?php if ($color != null): ?>
                            <span class="tag is-medium task-board color-<?= $color ?>">
                                        <?= $name ?>
                                        <?= $this->modal->small('times-circle','','SkillMatrixController','removeModal',
                                            array('plugin' => 'SkillMatrix','userID' =>$user['id'],'tagName'=>$name,'mode' => 'tagUser'),'button delete is-small '.$color) ?>
                                    </span>
                        <?php endif ?>
                    <?php endforeach ?>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</div>







