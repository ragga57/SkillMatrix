<?php

use Kanboard\Plugin\SkillMatrix\Helper\SkillDatabaseHelper;
//use Kanboard\Plugin\SkillMatrix\Helper\SkillFunctionsHelper;

use Kanboard\Core\Plugin\Loader;

require_once 'tests/units/Base.php';

class SkillDatabaseHelperTest extends Base {
    
    public function setUp()
    {
        parent::setUp();
        $plugin = new Loader($this->container);
        $plugin->initializePlugin('SkillMatrix');
    }
    public function testGetUserRole(){
        $skillDatabaseHelper = new SkillDatabaseHelper($this->container);
        $this->assertSame('app-admin', $skillDatabaseHelper->getSkillUserRole(1));
        $this->assertSame(null, $skillDatabaseHelper->getSkillUserRole(2));
        $this->assertSame(null, $skillDatabaseHelper->getSkillUserRole(42));
    }
    public function testGetUserName(){
        $skillDatabaseHelper = new SkillDatabaseHelper($this->container);
        $this->assertSame(null, $skillDatabaseHelper->getSkillUserName(1));
        $this->assertSame(false, $skillDatabaseHelper->getSkillUserName(564));
    }
    public function testSkillGet(){
        $skillDatabaseHelper = new SkillDatabaseHelper($this->container);
        $this->assertSame(false, $skillDatabaseHelper->getSkillName(1));
        $this->assertSame(false, $skillDatabaseHelper->getSkillName(56));
        
    }
    public function testSkillInsertRemove(){
        $skillDatabaseHelper = new SkillDatabaseHelper($this->container);
        $skillDatabaseHelper->addNewSkill(array('skillName'=>'test', 'skillDescription'=>'testDesc'));
        $this->assertSame('test', $skillDatabaseHelper->getSkillName(1));
        $this->assertSame(false, $skillDatabaseHelper->getSkillName(2));
        $skillDatabaseHelper->addNewSkill(array('skillName'=>'test2', 'skillDescription'=>'testDesc2'));
        $this->assertSame('test2', $skillDatabaseHelper->getSkillName(2));
        $expectedArray = array(array('id'=>'1', 'name'=>'test','description'=>'testDesc'),
                               array('id'=>'2', 'name'=>'test2','description'=>'testDesc2'));
        $this->assertSame($expectedArray, $skillDatabaseHelper->getSkillArray());
        $skillDatabaseHelper->removeSkill('test2');
        $expectedArray = array('test');
        $this->assertSame($expectedArray, $skillDatabaseHelper->getSkillNameArray());
        $this->assertSame(false, $skillDatabaseHelper->getSkillName(2));
        $skillDatabaseHelper->addNewSkill(array('skillName'=>'test3', 'skillDescription'=>'testDesc3'));
        $this->assertSame('test3', $skillDatabaseHelper->getSkillName(2));
        $skillDatabaseHelper->removeSkill('test');
        $skillDatabaseHelper->removeSkill('test3');
        $this->assertSame(array(), $skillDatabaseHelper->getSkillNameArray());
  
    }
    public function testTagGet(){
        $skillDatabaseHelper = new SkillDatabaseHelper($this->container);
        $this->assertSame(false, $skillDatabaseHelper->getTagName(1));
        $this->assertSame(false, $skillDatabaseHelper->getTagName(5564));

    }

    public function testTagInsertRemove(){
        $skillDatabaseHelper = new SkillDatabaseHelper($this->container);
        $skillDatabaseHelper->addNewTag('tag1','Brown');
        $this->assertSame('tag1', $skillDatabaseHelper->getTagName(1));
        $this->assertSame(false, $skillDatabaseHelper->getTagName(2));
        $this->assertEquals(1, $skillDatabaseHelper->getTagID('tag1'));
        $this->assertSame('Brown', $skillDatabaseHelper->getTagColor(1));
        $this->assertSame(false, $skillDatabaseHelper->getTagColor(5646));
        $skillDatabaseHelper->addNewTag('tag2','Orange');
        $expectedArray = array(array('id'=>'1', 'name'=>'tag1','color'=>'Brown'),
                               array('id'=>'2', 'name'=>'tag2','color'=>'Orange'));
        $this->assertSame($expectedArray, $skillDatabaseHelper->getTagArray());
        $skillDatabaseHelper->addNewTag('tag1','Yellow');
        $this->assertSame('Brown', $skillDatabaseHelper->getTagColor(1));
        $skillDatabaseHelper->removeTag('tag1');
        $skillDatabaseHelper->removeTag('tag2');
        $this->assertSame(array(), $skillDatabaseHelper->getTagArray());

    }

    public function testRoleInsertRemove(){
        $skillDatabaseHelper = new SkillDatabaseHelper($this->container);
        $this->assertSame(2, sizeof($skillDatabaseHelper->getRolesArray()));
        $insertedArray = array('roleName'=> 'testRole',
                                '1'=>'edit_all',
                                '2' => 'add_tags'
        );
        $skillDatabaseHelper->addNewRole($insertedArray);
        $this->assertSame(3, sizeof($skillDatabaseHelper->getRolesArray()));
        $skillDatabaseHelper->removeRole('testRole');
        $this->assertSame(2, sizeof($skillDatabaseHelper->getRolesArray()));


    }

    public function testEditSkillFunctions(){
        $skillDatabaseHelper = new SkillDatabaseHelper($this->container);
        $this->assertSame(0, sizeof($skillDatabaseHelper->getSkillNameArray()));
        $this->assertSame(array(), $skillDatabaseHelper->getSkillNameArray());
        $skillDatabaseHelper->addNewSkill(array('skillName'=>'test', 'skillDescription'=>'testDesc'));
        $this->assertSame('test', $skillDatabaseHelper->getSkillName(1));
        $skillDatabaseHelper->renameSkill('test', 'newName');
        $this->assertSame('newName', $skillDatabaseHelper->getSkillName(1));
        $skillDatabaseHelper->changeDescriptionSkill('newName', 'newDescription');
        $expectedArray = array(array('id'=>'1', 'name'=>'newName','description'=>'newDescription'));
        $this->assertSame($expectedArray, $skillDatabaseHelper->getSkillArray());
       
    }
    public function testEditTagFunctions(){
        $skillDatabaseHelper = new SkillDatabaseHelper($this->container);
        $this->assertSame(0, sizeof($skillDatabaseHelper->getTagArray()));
        $skillDatabaseHelper->addNewTag('tag1','Brown');
        $skillDatabaseHelper->addNewTag('tag2','Yellow');
        $this->assertSame(2, sizeof($skillDatabaseHelper->getTagArray()));
        $skillDatabaseHelper->renameTag('tag2','tag1');
        $this->assertSame('tag2', $skillDatabaseHelper->getTagName(2));
        $this->assertEquals(false, $skillDatabaseHelper->getTagID('tag3'));
        $skillDatabaseHelper->changeColorTag('tag2','Brown');
        $this->assertSame('Brown', $skillDatabaseHelper->getTagColor(2));
        $this->assertEquals(false, $skillDatabaseHelper->getTagID('notExistingTag'));
        $this->assertEquals(false, $skillDatabaseHelper->changeColorTag('notExistingTag','Brown'));

    }
    public function testChangeUserRole(){
        $skillDatabaseHelper = new SkillDatabaseHelper($this->container);
        $this->assertSame('app-admin', $skillDatabaseHelper->getSkillUserRole(1));
        $this->assertSame(false, $skillDatabaseHelper->changeRole(1,'notExistingRole'));
        $insertedArray = array('roleName'=> 'testRole',
                                '1'=>'edit_all',
                                '2' => 'add_tags'
        );
        $skillDatabaseHelper->addNewRole($insertedArray);
        $this->assertSame(true, $skillDatabaseHelper->changeRole(1,'testRole'));
        $this->assertSame('testRole', $skillDatabaseHelper->getSkillUserRole(1));
    }
    public function testRenameRole(){
        $skillDatabaseHelper = new SkillDatabaseHelper($this->container);
        $this->assertSame('app-admin', $skillDatabaseHelper->getSkillUserRole(1));
        $this->assertSame(false, $skillDatabaseHelper->renameRole('app-admin','app-admin'));
        $this->assertSame('app-admin', $skillDatabaseHelper->getSkillUserRole(1));
        $insertedArray = array('roleName'=> 'testRole',
                                '1'=>'edit_all',
                                '2' => 'add_tags'
        );
        $skillDatabaseHelper->addNewRole($insertedArray);
        $this->assertSame(true, $skillDatabaseHelper->changeRole(1,'testRole'));
        $this->assertSame(true, $skillDatabaseHelper->renameRole('testRole','newName'));
        $this->assertSame('newName', $skillDatabaseHelper->getSkillUserRole(1));

    }
}