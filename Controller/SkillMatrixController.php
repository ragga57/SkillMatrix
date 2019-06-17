<?php

namespace Kanboard\Plugin\SkillMatrix\Controller;

use Kanboard\Controller\BaseController;


/**
 * Class SkillMatrixController
 *
 * @package Kanboard\Plugin\SkillMatrix\
 * @author Jan Válka
 */
class SkillMatrixController extends BaseController 
{

    /**
     * set of skill values
     *
     * @var array
     */
    const SKILL_VALUES_ARRAY = array('5','4','3','2','1');

    /**
     * Initial function, decides which mode redirect to
     *
     * @access public
     */
    public function load(){

        $user = $this->getUser();
        $role = $this->helper->skillDatabaseHelper->getSkillUserRole($user['id']);
        if ($role == "app-admin"){
            return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'adminUserSection', array('plugin' => 'SkillMatrix', 'title' => 'SkillMatrix')));
        }
        else{
            return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'userSection', array('plugin' => 'SkillMatrix', 'title' => 'SkillMatrix')));
        }

    }

    /**
     * Admins section where user related operations are located
     *
     * @access public
     */
    public function adminUserSection(){

        $values = $this->request->getValues();
        $searchQuery = $values['searchField'];

        $user = $this->getUser();

        $tableHead = $this->helper->skillFunctionsHelper->getAdminTableHead('user');
        $userSkillArray = $this->helper->skillDatabaseHelper->getUsersWithSkillValuesArray();
        $userTagArray = $this->helper->skillDatabaseHelper->getUsersWithTagsArray();
        $userSkillArray = $this->helper->skillFunctionsHelper->getSortedUsersArray($user['id'],array(),$userSkillArray);
        //search query
        if ($searchQuery != null){
            $tableHead = $this->helper->skillFunctionsHelper->getFilteredTableHead($searchQuery,$tableHead,true);
            $userSkillArray = $this->helper->skillFunctionsHelper->getFilteredUsersBySkillValue($searchQuery,$userSkillArray);
            $userSkillArray = $this->helper->skillFunctionsHelper->getFilteredUsersByName($searchQuery,$user['name'],$userSkillArray);
            $userSkillArray = $this->helper->skillFunctionsHelper->getFilteredUsersByID($searchQuery,$userSkillArray);
            $userSkillArray = $this->helper->skillFunctionsHelper->getFilteredUsersByRole($searchQuery,$userSkillArray);
            $userSkillArray = $this->helper->skillFunctionsHelper->getFilteredUsersByTag($searchQuery,$userSkillArray);

        }

        return $this->response->html($this->helper->layout->dashboard('SkillMatrix:view/adminsViewUser',
            array(
                'title' => 'SkillMatrix',
                'tableHead'=>$tableHead,
                'userSkillArray'=> $userSkillArray,
                'userTagArray'=> $userTagArray,
                'userID'=> $user['id'],
                'searchQuery'=> $searchQuery)));

    }

    /**
     * Admins section where skill related operations are located
     *
     * @access public
     */
    public function adminSkillSection(){

        $values = $this->request->getValues();
        $searchQuery = $values['searchField'];

        $user = $this->getUser();

        $tableHead = $this->helper->skillFunctionsHelper->getAdminTableHead('skill');
        $skillArray = $this->helper->skillDatabaseHelper->getSkillArray();

        //search query
        if ($searchQuery != null){
            $skillArray = $this->helper->skillFunctionsHelper->getFilteredSkillsByItem($searchQuery,$skillArray,'id');
            $skillArray = $this->helper->skillFunctionsHelper->getFilteredSkillsByItem($searchQuery,$skillArray,'name');
        }

        return $this->response->html($this->helper->layout->dashboard('SkillMatrix:view/adminsViewSkill',array(
            'title' => 'SkillMatrix',
            'tableHead' => $tableHead,
            'skillArray' => $skillArray,
            'userID'=> $user['id'],
            'searchQuery'=> $searchQuery)));
    }

    /**
     * Admins section where tag related operations are located
     *
     * @access public
     */
    public function adminTagSection(){

        $values = $this->request->getValues();
        $searchQuery = $values['searchField'];

        $user = $this->getUser();

        $tableHead = $this->helper->skillFunctionsHelper->getAdminTableHead('tag');
        $tagArray = $this->helper->skillDatabaseHelper->getTagArray();

        //search query
        if ($searchQuery != null){
            $tagArray = $this->helper->skillFunctionsHelper->getFilteredTagsByItem($searchQuery,$tagArray,'id');
            $tagArray = $this->helper->skillFunctionsHelper->getFilteredTagsByItem($searchQuery,$tagArray,'name');
            $tagArray = $this->helper->skillFunctionsHelper->getFilteredTagsByItem($searchQuery,$tagArray,'color');
        }

        return $this->response->html($this->helper->layout->dashboard('SkillMatrix:view/adminsViewTag',array(
            'title' => 'SkillMatrix',
            'tableHead' => $tableHead,
            'tagArray' => $tagArray,
            'tagColorArray' => $this->colorModel->getList(),
            'userID'=> $user['id'],
            'searchQuery'=> $searchQuery)));
    }

    /**
     * Admins section where tag related operations are located
     *
     * @access public
     */
    public function adminRoleSection(){

        $user = $this->getUser();

        return $this->response->html($this->helper->layout->dashboard('SkillMatrix:view/adminsViewRole',array(
            'title' => 'SkillMatrix',
            'tableHead' => $this->helper->skillFunctionsHelper->getAdminTableHead('role'),
            'roleArray' => $this->helper->skillDatabaseHelper->getRolesArray(),
            'userID'=> $user['id'])));

    }

    /**
     * Shows modal for changing role of specific user
     *
     * @access public
     */
    public function changeRoleModal(){

        return $this->response->html($this->helper->layout->app('SkillMatrix:modal/changeRoleModal', array(
            'userID' => $this->request->getStringParam('userID'),
            'roleArray' => array_column($this->helper->skillDatabaseHelper->getRolesArray(), 'name'))));

    }

    /**
     * Changes users role for SkillMatrix plugin
     *
     * @access public
     */
    public function changeRole(){

        $values = $this->request->getValues();
        $userID = $this->request->getStringParam('userID');
        //role
        $index = $values['roleIndex'];
        $role = array_column($this->helper->skillDatabaseHelper->getRolesArray(), 'name')[$index];
        $this->helper->skillDatabaseHelper->changeRole($userID,$role);

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'adminUserSection', array('plugin' => 'SkillMatrix')));

    }

    /**
     * Shows modal for changing rights of role
     *
     * @access public
     */
    public function changeRoleRightsModal(){

        return $this->response->html($this->helper->layout->app('SkillMatrix:modal/changeRoleRightsModal', array(
            'roleName' => $this->request->getStringParam('roleName'),
            'mode' => $this->request->getStringParam('mode'),
            'currentValue' => $this->request->getStringParam('currentValue'),
            'values' => $this->request->getValues()
            )));

    }

    /**
     * Changes rights of role
     *
     * @access public
     */
    public function changeRoleRights(){

        $values =  $this->request->getValues();
        $values['roleName'] = $this->request->getStringParam('roleName');
        $values['currentRight'] = $this->request->getStringParam('currentRight');
        $this->helper->skillDatabaseHelper->changeRoleRights($values);

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'adminRoleSection', array('plugin' => 'SkillMatrix')));

    }

    /**
     * Removes existing role entry from database
     *
     * @access public
     */
    public function removeRole(){

        $this->helper->skillDatabaseHelper->removeRole($this->request->getStringParam('roleName'));

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'adminRoleSection', array('plugin' => 'SkillMatrix')));

    }

    /**
     * Shows universal modal for renaming things
     *
     * @access public
     */
    public function renameModal(){

        $mode = $this->request->getStringParam('mode');

        if ($mode == 'skill'){

            return $this->response->html($this->helper->layout->app('SkillMatrix:modal/renameModal', array(
                'mode' => $mode,
                'skillID' => $this->request->getStringParam('skillID'),
                'skillName' => $this->request->getStringParam('skillName'))));

        }
        if ($mode == 'tag'){

            return $this->response->html($this->helper->layout->app('SkillMatrix:modal/renameModal', array(
                'mode' => $mode,
                'tagName' => $this->request->getStringParam('tagName'))));

        }
        if ($mode == 'role'){

            return $this->response->html($this->helper->layout->app('SkillMatrix:modal/renameModal', array(
                'mode' => $mode,
                'roleName' => $this->request->getStringParam('roleName'))));

        }
        return -1;

    }
    /**
     * Shows universal modal for removing things
     *
     * @access public
     */
    public function removeModal(){
        $mode = $this->request->getStringParam('mode');

        if ($mode == 'role'){
            return $this->response->html($this->helper->layout->app('SkillMatrix:modal/removeModal', array(
                'mode' => 'role',
                'roleName' => $this->request->getStringParam('roleName'))));

        }
        if ($mode == 'skill') {
            return $this->response->html($this->helper->layout->app('SkillMatrix:modal/removeModal', array(
                'mode' => 'skill',
                'skillName' => $this->request->getStringParam('skillName'))));
        }
        if ($mode == 'tagAdmin') {
            return $this->response->html($this->helper->layout->app('SkillMatrix:modal/removeModal', array(
                'mode' => 'tagAdmin',
                'tagName' => $this->request->getStringParam('tagName'))));
        }
        if ($mode == 'tagUser') {
            $userID = $this->request->getStringParam('userID');
            $tagName = $this->request->getStringParam('tagName');
            $userName = $this->helper->skillDatabaseHelper->getSkillUserName($userID);

            return $this->response->html($this->helper->layout->app('SkillMatrix:modal/removeModal', array('plugin' => 'SkillMatrix',
                'mode' => 'tagUser',
                'userID' => $userID,
                'userName'=>$userName,
                'tagName' => $tagName)));
        }
        return -1;
    }

    /**
     * Renames existing skill
     *
     * @access public
     */
    public function renameRole(){

        $values = $this->request->getValues();
        $oldName = $this->request->getStringParam('roleName');
        $newName = $values['newName'];
        $this->helper->skillDatabaseHelper->renameRole($oldName,$newName);

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'adminRoleSection', array('plugin' => 'SkillMatrix')));

    }

    /**
     * Adds new role to database
     *
     * @access public
     */
    public function addNewRole(){

        $values = $this->request->getValues();
        $this->helper->skillDatabaseHelper->addNewRole($values);

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'adminRoleSection', array('plugin' => 'SkillMatrix', 'title' => 'SkillMatrix')));

    }

    /**
     * Section for everyone that isn't admin
     *
     * @access public
     */
    public function userSection(){
        $values = $this->request->getValues();
        $searchQuery = $values['searchField'];

        //table head part
        $tableHead = $this->helper->skillFunctionsHelper->getTableHead();
        //user part
        $user = $this->getUser();
        $rights = $this->helper->skillDatabaseHelper->getRoleAttributes($this->helper->skillDatabaseHelper->getSkillUserRole($user['id']));
        //can edit
        if ($rights['edit_projectmates'] == 1){
            $canEdit = array($user['id']);
            $members = $this->helper->skillDatabaseHelper->getUserArrayToManage($user['id']);
            foreach ($members as $key => $value){
                $canEdit[] = $value;
            }
            $canEdit = array_unique($canEdit);
        }else{
            $canEdit = array($user['id']);
        }

        $userSkillArray = $this->helper->skillDatabaseHelper->getUsersWithSkillValuesArray();
        //sort, this user -> canEdit -> rest of users
        $userSkillArray = $this->helper->skillFunctionsHelper->getSortedUsersArray($user['id'],$canEdit,$userSkillArray);

        $userTagArray = $this->helper->skillDatabaseHelper->getUsersWithTagsArray();

        //search query
        if ($searchQuery != null){
            $tableHead = $this->helper->skillFunctionsHelper->getFilteredTableHead($searchQuery,$tableHead);
            $userSkillArray = $this->helper->skillFunctionsHelper->getFilteredUsersBySkillValue($searchQuery,$userSkillArray);
            $userSkillArray = $this->helper->skillFunctionsHelper->getFilteredUsersByName($searchQuery,$user['name'],$userSkillArray);

            if ($rights['no_tags'] != 1){
                $userSkillArray = $this->helper->skillFunctionsHelper->getFilteredUsersByTag($searchQuery,$userSkillArray);
            }

        }

        return $this->response->html($this->helper->layout->dashboard('SkillMatrix:view/userView',
            array(
                'title' => 'SkillMatrix',
                'tableHead'=>$tableHead,
                'userSkillArray'=> $userSkillArray,
                'userTagArray'=> $userTagArray,
                'canEdit' => $canEdit,
                'rights' => $rights,
                'userID'=> $user['id'],
                'searchQuery'=> $searchQuery)));
    }

    /**
     * Adds new skill to database
     *
     * @access public
     */
    public function addSkill(){

        $values = $this->request->getValues();
        $this->helper->skillDatabaseHelper->addNewSkill($values);

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'adminSkillSection', array('plugin' => 'SkillMatrix', 'title' => 'SkillMatrix')));

    }

    /**
     * Removes existing skill entry from database
     *
     * @access public
     */
    public function removeSkill(){

        $this->helper->skillDatabaseHelper->removeSkill($this->request->getStringParam('skillName'));

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'adminSkillSection', array('plugin' => 'SkillMatrix')));

    }

    /**
     * Renames existing skill
     *
     * @access public
     */
    public function renameSkill(){

        $values = $this->request->getValues();
        $oldName = $this->request->getStringParam('skillName');
        $newName = $values['newName'];
        $this->helper->skillDatabaseHelper->renameSkill($oldName,$newName);

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'adminSkillSection', array('plugin' => 'SkillMatrix')));

    }

    /**
     * Shows modal for changing description of specific skill
     *
     * @access public
     */
    public function changeDescriptionSkillModal(){

        return $this->response->html($this->helper->layout->app('SkillMatrix:modal/changeDescriptionSkillModal', array(
            'skillDescription' => $this->request->getStringParam('skillDescription'),
            'skillName' => $this->request->getStringParam('skillName'))));


    }

    /**
     * Changes description of selected skill
     *
     * @access public
     */
    public function changeDescriptionSkill(){
        $values = $this->request->getValues();
        $skillName = $this->request->getStringParam('skillName');
        $this->helper->skillDatabaseHelper->changeDescriptionSkill($skillName,$values['newDescription']);

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'adminSkillSection', array('plugin' => 'SkillMatrix')));

    }

    /**
     * Adds new tag to database
     *
     * @access public
     */
    public function addNewTag(){

        $values = $this->request->getValues();
        $index = $values['colorIndex'];
        $this->helper->skillDatabaseHelper->addNewTag($values['tagName'],$index);

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'adminTagSection', array('plugin' => 'SkillMatrix')));

    }

    /**
     * Removes existing tag entry from database
     *
     * @access public
     */
    public function removeTag(){

        $this->helper->skillDatabaseHelper->removeTag($this->request->getStringParam('tagName'));

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'adminTagSection', array('plugin' => 'SkillMatrix')));

    }

    /**
     * Renames existing tag
     *
     * @access public
     */
    public function renameTag(){

        $values = $this->request->getValues();
        $oldName = $this->request->getStringParam('tagName');
        $newName = $values['newName'];
        $this->helper->skillDatabaseHelper->renameTag($oldName,$newName);

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'adminTagSection', array('plugin' => 'SkillMatrix')));

    }

    /**
     * Shows modal for changing color of selected tag
     *
     * @access public
     */
    public function changeColorTagModal(){

        return $this->response->html($this->helper->layout->app('SkillMatrix:modal/changeColorTagModal', array(
            'tagName' => $this->request->getStringParam('tagName'),
            'tagColorArray' => $this->colorModel->getList())));

    }

    /**
     * Changes color of existing tag
     *
     * @access public
     */
    public function changeColorTag(){

        $values = $this->request->getValues();
        $color = $values['colorIndex'];
        $tagName = $this->request->getStringParam('tagName');
        $this->helper->skillDatabaseHelper->changeColorTag($tagName,$color);

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'adminTagSection', array('plugin' => 'SkillMatrix')));

    }

    /**
     * Shows modal for changing skill value of specific user
     *
     * @access public
     */
    public function editSkillValueModal(){

        return $this->response->html($this->helper->layout->app('SkillMatrix:modal/editSkillValueModal', array(
            'userID' => $this->request->getStringParam('userID'),
            'skillName' => $this->request->getStringParam('skillName'),
            'skillValuesArray' => self::SKILL_VALUES_ARRAY)));

    }

    /**
     * Updates skill value of selected user
     *
     * @access public
     */
    public function editSkillValue(){
        $userID = $this->request->getStringParam('userID');
        $skillName = $this->request->getStringParam('skillName');
        $values = $this->request->getValues();

        $index = $values['valueIndex'];
        $array = self::SKILL_VALUES_ARRAY;

        $this->helper->skillDatabaseHelper->editSkillValue($userID,$skillName,$array[$index]);

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'load', array('plugin' => 'SkillMatrix')));
    }

    /**
     * Shows modal adding tag to user
     *
     * @access public
     */
    public function addTagModal(){

        return $this->response->html($this->helper->layout->app('SkillMatrix:modal/assignTagModal', array(
            'userID' => $this->request->getStringParam('userID'),
            'tagArray' => $this->helper->skillDatabaseHelper->getTagNameArray(),
            'tagColorArray' => $this->colorModel->getList())));

    }

    /**
     * Adds existing tag to user
     *
     * @access public
     */
    public function assignTagExisting(){

        $values = $this->request->getValues();
        $userID = $this->request->getStringParam('userID');
        $array = $this->request->getStringParam('tagArray');
        $index = $values['tagIndex'];
        $this->helper->skillDatabaseHelper->assignTag($userID,$array[$index]);

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'load', array('plugin' => 'SkillMatrix')));

    }

    /**
     * Creates new tag and gives it to user
     *
     * @access public
     */
    public function assignTagNew(){


        $values = $this->request->getValues();
        $index = $values['colorIndex'];
        $userID = $this->request->getStringParam('userID');
        //create tag in database
        $this->helper->skillDatabaseHelper->addNewTag($values['tagName'],$index);
        //and give it to user
        $this->helper->skillDatabaseHelper->assignTag($userID,$values['tagName']);

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'load', array('plugin' => 'SkillMatrix')));

    }

    /**
     * Removes selected tag from user
     *
     * @access public
     */
    public function removeTagFromUser(){

        $userID = $this->request->getStringParam('userID');
        $tagName = $this->request->getStringParam('tagName');
        $this->helper->skillDatabaseHelper->removeTagFromUser($userID, $tagName);

        return $this->response->redirect($this->helper->url->to('SkillMatrixController', 'load', array('plugin' => 'SkillMatrix')));
    }

}