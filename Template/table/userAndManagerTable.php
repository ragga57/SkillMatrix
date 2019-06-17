<div id="table-container">
    <table>
        <thead>
        <?php foreach ($tableHead as $index => $row): ?>
            <td class="table-list-header"><strong><?= t(ucfirst($index))?></strong><?= $this->skillFunctionsHelper->renderTooltip($row)?></td>
        <?php endforeach ?>
        </thead>
        <?php foreach ($userSkillArray as $index => $user): ?>
            <tr>
            <?php foreach ($tableHead as $skill => $description): ?>
                <td>
                    <!-- CAN EDIT VALUE-->
                    <?php if ((in_array($user['id'],$canEdit))&& $skill != 'name'): ?>
                        <?php if ($user[$skill] != null): ?>
                            <?= $this->modal->small('edit',$user[$skill],'SkillMatrixController','editSkillValueModal',array('plugin' => 'SkillMatrix','userID' =>$user['id'] ,'skillName' =>$skill))?>
                        <?php else: ?>
                            <?= $this->modal->small('edit','-','SkillMatrixController','editSkillValueModal',array('plugin' => 'SkillMatrix','userID' =>$user['id'] ,'skillName' =>$skill))?>
                        <?php endif ?>
                        <!-- CANNOT EDIT VALUE-->
                    <?php else: ?>
                        <?php if (!empty($user[$skill])): ?>
                            <?= $user[$skill]?>
                        <?php else: ?>
                            <?= '-'?>
                        <?php endif ?>
                    <?php endif ?>

                </td>
            <?php endforeach ?>

            </tr>
        <?php endforeach ?>
    </table>
</div>




