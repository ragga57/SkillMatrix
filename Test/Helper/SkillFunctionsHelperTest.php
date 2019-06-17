<?php

use Kanboard\Plugin\SkillMatrix\Helper\SkillDatabaseHelper;
use Kanboard\Plugin\SkillMatrix\Helper\SkillFunctionsHelper;

use Kanboard\Core\Plugin\Loader;

require_once 'tests/units/Base.php';

class SkillFunctionsHelperTest extends Base {
    
    public function setUp()
    {
        parent::setUp();
        $plugin = new Loader($this->container);
        $plugin->initializePlugin('SkillMatrix');
    }
    public function testGetTableHead(){
        $skillFunctionsHelper = new SkillFunctionsHelper($this->container);
        $skillDatabaseHelper = new SkillDatabaseHelper($this->container);
        $expectedResult = array('name'=> 'Name of user');
        $this->assertSame($expectedResult, $skillFunctionsHelper->getTableHead());
        $skillDatabaseHelper->addNewSkill(array('skillName'=>'test', 'skillDescription'=>'testDesc'));
        $expectedResult = array('name'=> 'Name of user',
                                'test'=> 'testDesc');
        $this->assertSame($expectedResult, $skillFunctionsHelper->getTableHead());
        $skillDatabaseHelper->removeSkill('test');
        $expectedResult = array('name'=> 'Name of user');
        $this->assertSame($expectedResult, $skillFunctionsHelper->getTableHead());
    }
    public function testGetAdminTableHead(){
        $skillFunctionsHelper = new SkillFunctionsHelper($this->container);
        $skillDatabaseHelper = new SkillDatabaseHelper($this->container);
        $expectedResult = array();
        $this->assertSame($expectedResult, $skillFunctionsHelper->getAdminTableHead('asdad'));
        $expectedResult = array('id'=>'ID',
                                'name'=>'Name of user',
                                'username'=>'Username',
                                'role'=>'Role of user');
        
        $this->assertSame($expectedResult, $skillFunctionsHelper->getAdminTableHead('user'));

        $expectedResult = array('id'=>'ID',
                                'name'=>'Skill name',
                                'description'=>'Description',
                                'delete'=>'Delete skill');
        
        $this->assertSame($expectedResult, $skillFunctionsHelper->getAdminTableHead('skill'));

        $expectedResult = array('id'=>'ID',
                                'name'=>'Tag name',
                                'color'=>'Color',
                                'delete'=>'Delete tag');

        $this->assertSame($expectedResult, $skillFunctionsHelper->getAdminTableHead('tag'));

        $expectedResult = array(
        'name'=>'Role name',
        'skill rights'=>'Editing skills rights',
        'tag rights'=>'Editing tags rights',
        'delete' => 'Delete role');

        $this->assertSame($expectedResult, $skillFunctionsHelper->getAdminTableHead('role'));

    }
}