<div id="table-container">
    <table id="table" class="is-hoverable">
        <thead>
        <?php foreach ($tableHead as $index => $row): ?>
            <td class="table-list-header"><strong><?= t(ucfirst($index))?></strong> <?= $this->skillFunctionsHelper->renderTooltip($row)?></td>
        <?php endforeach ?>
        </thead>
        <?php foreach ($tagArray as $index => $row): ?>
            <tr>
                <td>
                    <?= $row['id']?>
                </td>
                <td>
                    <?= $this->modal->small('edit',$row['name'],'SkillMatrixController','renameModal',array('plugin' => 'SkillMatrix', 'tagName' =>$row['name'],'mode'=>'tag'))?>
                </td>
                <td>
                    <span class="tag is-medium task-board color-<?= $this->helper->skillDatabaseHelper->getTagColor($row['id'])?>" style="padding-right: 12px">
                    <?= $this->modal->small('paint-brush',$tagColorArray[$row['color']],'SkillMatrixController','changeColorTagModal',
                        array('plugin' => 'SkillMatrix','tagName' =>$row['name']))?>
                    </span>
                </td>
                <td>
                    <?= $this->modal->mediumButton('trash',t('Delete tag'),'SkillMatrixController','removeModal',array('plugin' => 'SkillMatrix','tagName' =>$row['name'],'mode' => 'tagAdmin'))?>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</div>







