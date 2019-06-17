<?php

namespace Kanboard\Plugin\SkillMatrix\Helper;

use Kanboard\Core\Base;


/**
 * Class SkillDatabaseHelper
 *
 * @package Kanboard\Plugin\SkillMatrix
 * @author Jan Válka
 */
class SkillDatabaseHelper extends Base{

    /**
     * Get users role within SkillMatrix plugin
     *
     * @access public
     * @param  integer    $userID       User id
     * @return string
     */
    public function getSkillUserRole($userID){

        
        if ($this->db->table('users')->eq('id',$userID)->exists() == false){
            return null;
        }
        
        $roleID = $this->db->table('user_has_role')->eq('user_id',$userID)->findOneColumn('role_id');
        if ($roleID == null){
            if($this->db->table('users')->eq('id',$userID)->findOneColumn('role') == 'app-admin'){
                return 'app-admin';
            }else{
                return $this->db->table('sk_roles')->gt('id',1)->findOneColumn('name');
            }
        }else{
            return $this->db->table('sk_roles')->eq('id',$roleID)->findOneColumn('name');
        }

    }



    /**
     * Get users name
     *
     * @access public
     * @param  integer    $userID       User id
     * @return string
     */
    public function getSkillUserName($userID){

        return $this->db->table('users')->eq('id',$userID)->findOneColumn('name');

    }

    /**
     * Get array with names of all skills
     *
     * @access public
     * @return \PicoDb\Table
     */
    public function getSkillNameArray(){

        return $this->db->table('sk_skills')->findAllByColumn('name');

    }

    /**
     * Get array with names of all tags
     *
     * @access public
     * @return \PicoDb\Table
     */
    public function getTagNameArray(){

        return $this->db->table('sk_tags')->findAllByColumn('name');

    }

    /**
     * Get name of selected skill
     *
     * @access public
     * @param  integer    $skillID       skill ID
     * @return string
     */
    public function getSkillName($skillID){

        return $this->db->table('sk_skills')->eq('id',$skillID)->findOneColumn('name');

    }

    /**
     * Get name of selected tag
     *
     * @access public
     * @param  integer    $tagID       tag ID
     * @return string
     */
    public function getTagName($tagID){

        return $this->db->table('sk_tags')->eq('id',$tagID)->findOneColumn('name');

    }

    /**
     * Get id of selected tag
     *
     * @access public
     * @param  string    $tagName       tag name
     * @return integer
     */
    public function getTagID($tagName){

        return $this->db->table('sk_tags')->eq('name',$tagName)->findOneColumn('id');

    }

    /**
     * Get color of selected tag
     *
     * @access public
     * @param  integer    $tagID       tag ID
     * @return string
     */
    public function getTagColor($tagID){

        return $this->db->table('sk_tags')->eq('id',$tagID)->findOneColumn('color');

    }

    /**
     * Get array of skills with all attributes
     *
     * @access public
     * @return \PicoDb\Table
     */
    public function getSkillArray(){

        return $this->db->table('sk_skills')->findAll();

    }

    /**
     * Get array of tags with all attributes
     *
     * @access public
     * @return \PicoDb\Table
     */
    public function getTagArray(){

        return $this->db->table('sk_tags')->findAll();

    }

    /**
     * Get array of roles and their rights
     *
     * @access public
     * @return \PicoDb\Table
     */
    public function getRolesArray(){

        return $this->db->table('sk_roles')->findAll();

    }

    /**
     * Get array of attributes of wanted role
     *
     * @access public
     * @param  string    $roleName
     * @return \PicoDb\Table
     */
    public function getRoleAttributes($roleName){

        return $this->db->table('sk_roles')->eq('name',$roleName)->findOne();

    }

    /**
     * Get array of users and their skill values
     *
     * @access public
     * @return array
     */
    public function getUsersWithSkillValuesArray(){

        $query = $this->db->table('users')->join('user_has_skill', 'user_id', 'id')->findAll();
        $formattedQuery = array();

        foreach ($query as $index => $row) {

                $formattedQuery[$row['id']]['id'] = $row['id'];
                if ($this->getSkillUserName($row['id']) != null) {
                    $formattedQuery[$row['id']]['name'] = $this->getSkillUserName($row['id']);
                }else{
                    $formattedQuery[$row['id']]['name'] = '-';
                }
                $formattedQuery[$row['id']]['username'] = $row['username'];
                $formattedQuery[$row['id']]['role'] = $this->getSkillUserRole($row['id']);
                $formattedQuery[$row['id']][$this->getSkillName($row['skill_id'])] = $row['value'];

        }
        return $formattedQuery;
    }

    /**
     * Get array of users and tags they have
     *
     * @access public
     * @param  string $caseInsensitive default false
     * @return array
     */
    public function getUsersWithTagsArray($caseInsensitive = false){

        $query = $this->db->table('users')->join('user_has_tag', 'user_id', 'id')->findAll();
        $formattedQuery = array();

        if($caseInsensitive){
            foreach ($query as $index => $row) {
                if ($this->getSkillUserName($row['id']) != null) {
                        $formattedQuery[$row['id']][strtolower($this->getTagName($row['tag_id']))] = $this->getTagColor($row['tag_id']);
                }
            }
        }else {
            foreach ($query as $index => $row) {
                if ($this->getSkillUserName($row['id']) != null) {
                        $formattedQuery[$row['id']][$this->getTagName($row['tag_id'])] = $this->getTagColor($row['tag_id']);
                }
            }
        }
        return $formattedQuery;
    }

    /**
     * Get array of users that specific manager can change their skill values
     *
     * @access public
     * @param  integer $managerID
     * @return array
     */
    public function getUserArrayToManage($managerID){

        //get project this manager is part of
        $listOfProjects = $this->db->table('project_has_users')->eq('user_id',$managerID)->findAllByColumn('project_id');
        if ($listOfProjects == null){
            return $listOfProjects;
        }


        //get groups that work on those projects
        $listOfGroups = array();
        foreach ($listOfProjects as $index => $row) {
            $query = $this->db->table('project_has_groups')->eq('project_id',$row)->findAllByColumn('group_id');
            foreach ($query as $key => $value){
                $listOfGroups[] = $value;
            }

        }

        if ($listOfGroups == null){
            return $listOfGroups;
        }
        //get users that are in those groups
        $listOfUsers = array();
        foreach ($listOfGroups as $index => $row) {
            $query = $this->db->table('group_has_users')->eq('group_id',$row)->findAllByColumn('user_id');
            foreach ($query as $key => $value){
                $listOfUsers[] = $value;
            }
        }

        return $listOfUsers;

    }

    /**
     * Adds new skill to database
     *
     * @access public
     * @param  array $values
     */
    public function addNewSkill(array $values){

        return $this->db->table('sk_skills')->insert(array('name' =>$values['skillName'],'description' => $values['skillDescription']));

    }
    /**
     * Adds new tag to database
     *
     * @access public
     * @param  string $name
     * @param  string $color
     */
    public function addNewTag($name,$color){

        return $this->db->table('sk_tags')->insert(array('name' =>$name,'color' => $color));

    }

    /**
     * Adds new role to database
     *
     * @access public
     * @param  array $values
     */
    public function addNewRole(array $values){
        $keys = array_keys($values);
       // return $values[$keys[1]];

        return $this->db->table('sk_roles')->insert(array('name' =>$values['roleName'], $values[$keys[1]] => '1', $values[$keys[2]] => '1'));

    }
    /**
     * Removes specific skill from database
     *
     * @access public
     * @param  string $name
     */
    public function removeSkill($name){

        return $this->db->table('sk_skills')->eq('name',$name)->remove();

    }

    /**
     * Removes specific tag from database
     *
     * @access public
     * @param  string $name
     */
    public function removeTag($name){

        return $this->db->table('sk_tags')->eq('name',$name)->remove();

    }

    /**
     * Removes specific role from database
     *
     * @access public
     * @param  string $name
     */
    public function removeRole($name){

        return $this->db->table('sk_roles')->eq('name',$name)->remove();

    }
    /**
     * Removes specific tag from specific user
     *
     * @access public
     * @param  integer $userID
     * @param  string  $tagName
     */
    public function removeTagFromUser($userID,$tagName){

        $tagID = $this->getTagID($tagName);
        return $this->db->table('user_has_tag')->eq('user_id',$userID)->eq('tag_id',$tagID)->remove();


    }

    /**
     * Renames specific skill
     *
     * @access public
     * @param  string $oldName
     * @param  string  $newName
     */
    public function renameSkill($oldName, $newName){
        //name is unique so I dont have to check
        return $this->db->table('sk_skills')->eq('name', $oldName)->update(['name' => $newName]);

    }

    /**
     * Renames specific tag
     *
     * @access public
     * @param  string $oldName
     * @param  string  $newName
     */
    public function renameTag($oldName, $newName){
        //name is unique so I dont have to check
        return $this->db->table('sk_tags')->eq('name', $oldName)->update(['name' => $newName]);

    }

    /**
     * Renames specific role
     *
     * @access public
     * @param  string $oldName
     * @param  string  $newName
     */
    public function renameRole($oldName, $newName){
        //name is unique so I dont have to check
        if ($oldName == 'app-admin'){
            return false;
        }
        return $this->db->table('sk_roles')->eq('name', $oldName)->update(['name' => $newName]);

    }

    /**
     * Changes skill description
     *
     * @access public
     * @param  string $name
     * @param  string  $newDescription
     */
    public function changeDescriptionSkill($name, $newDescription){

        return $this->db->table('sk_skills')->eq('name', $name)->update(['description' => $newDescription]);

    }

    /**
     * Changes color of specific tag
     *
     * @access public
     * @param  string $name
     * @param  string  $newColor
     */
    public function changeColorTag($name, $newColor){

        if ($this->db->table('sk_tags')->eq('name',$name)->exists() == false){
            return false;
        }
        return $this->db->table('sk_tags')->eq('name', $name)->update(['color' => $newColor]);

    }

    /**
     * Changes role of specific user
     *
     * @access public
     * @param  integer $userID
     * @param  string  $newRole
     */
    public function changeRole($userID,$newRole){

        $currRoleID = $this->db->table('user_has_role')->eq('user_id',$userID)->findOneColumn('role_id');
        $newRoleID = $this->db->table('sk_roles')->eq('name',$newRole)->findOneColumn('id');

        if ($currRoleID == null){
            return $this->db->table('user_has_role')->insert(array('user_id' => $userID,'role_id' => $newRoleID));
        }else{
            return $this->db->table('user_has_role')->eq('user_id', $userID)->eq('role_id', $currRoleID)->update(array('role_id' => $newRoleID));
        }

    }


    /**
     * Changes role rights
     *
     * @access public
     * @param  array $values
     */
    public function changeRoleRights(array  $values){

        return $this->db->table('sk_roles')->eq('name',$values['roleName'])->update(array($values['currentRight'] => 0,$values['newRight'] => 1));

    }

    /**
     * Changes skill value of specific user
     *
     * @access public
     * @param  integer $userID
     * @param  string  $skillName
     * @param  integer $value
     */
    public function editSkillValue($userID, $skillName,$value){

        $skillID = $this->db->table('sk_skills')->eq('name',$skillName)->findOneColumn('id');

        if ($this->db->table('user_has_skill')->eq('user_id',$userID)->eq('skill_id',$skillID)->findAll() == null){
            return $this->db->table('user_has_skill')->insert(array('user_id' => $userID,'skill_id' => $skillID, 'value' => $value));
        }else{
            return $this->db->table('user_has_skill')->eq('user_id', $userID)->eq('skill_id', $skillID)->update(array('value' => $value));
        }


    }

    /**
     * Assigns tag to specific user
     *
     * @access public
     * @param  integer $userID
     * @param  string  $tagName`
     */
    public function assignTag($userID, $tagName){

        $tagID = $this->db->table('sk_tags')->eq('name',$tagName)->findOneColumn('id');

        return $this->db->table('user_has_tag')->insert(array('user_id' => $userID,'tag_id' => $tagID));


    }
    //end
}