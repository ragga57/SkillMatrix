<div id="table-container">
    <table id="table" class="is-hoverable">
        <thead>
        <?php foreach ($tableHead as $index => $row): ?>
            <td class="table-list-header"><strong><?= t(ucfirst($index))?></strong><?= $this->skillFunctionsHelper->renderTooltip($row)?></td>
        <?php endforeach ?>
        </thead>
        <?php foreach ($skillArray as $index => $row): ?>
            <tr>
                <td>
                    <?= $row['id']?>
                </td>
                <td>
                    <?= $this->modal->small('edit',$row['name'],'SkillMatrixController','renameModal',array('plugin' => 'SkillMatrix', 'skillName' =>$row['name'],'mode'=>'skill'))?>
                </td>
                <td>
                    <?= $this->modal->small('edit',$row['description'],'SkillMatrixController','changeDescriptionSkillModal',array('plugin' => 'SkillMatrix','skillName' =>$row['name'],'skillDescription' =>$row['description']))?>
                </td>
                <td>
                    <?= $this->modal->mediumButton('trash',t('Delete skill'),'SkillMatrixController','removeModal',array('plugin' => 'SkillMatrix','skillName' =>$row['name'],'mode' => 'skill'))?>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</div>







