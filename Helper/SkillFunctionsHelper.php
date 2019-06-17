<?php

namespace Kanboard\Plugin\SkillMatrix\Helper;

use Kanboard\Core\Base;

/**
 * Class SkillFunctionsHelper
 *
 * @package Kanboard\Plugin\SkillMatrix
 * @author Jan Válka
 */
class SkillFunctionsHelper extends Base
{

    /**
     * Same as explode but keeps spaces within "str ings"
     *
     * @access protected
     * @param string   $string
     * @return array
     */
    protected function myExplode($string){
        $ignore = false;

        for ($i = 0;$i <strlen($string);$i++){

            if ($ignore == false && $string[$i] === '"'){
                $ignore = true;
            }elseif ($ignore == true && $string[$i] === '"'){
                $ignore = false;
            }

            if ($ignore == true && $string[$i] === " "){
                $string[$i] = '@';
            }
        }
        //return $string;
        $result = explode(' ',$string);
        foreach ($result as $key => $value){
            $result[$key] = str_replace('@',' ',$result[$key]);
            $result[$key] = str_replace('"','',$result[$key]);

        }
        return $result;

    }
    /**
     * Splits search query and gets wanted item
     *
     * @access protected
     * @param string   $item
     * @param string  $searchQuery
     * @return array
     */
    protected function getItems($item,$searchQuery){
        $result = array();
        $tmpArray = $this->myExplode($searchQuery);
        foreach ($tmpArray as $key => $row) {
            if (mb_stripos($row, $item.':') !== false) {
                $result[] = $row;
            }
        }
        //return $result;
        if ($result != null) {
            foreach ($result as $key => $row){
                $result[$key] = mb_substr($row, mb_stripos($row, ':')+1);
            }
        }
        return $result;
    }

    /**
     * Tests skills of user are within the searched values
     *
     * @access protected
     * @param array $skillEntries
     * @param array $conditions
     * @return bool
     */
    protected function testSkillValueCondition(array $skillEntries, array $conditions){

        //skill intersect has to be same length as conditions
        if (count($skillEntries)<count($conditions)){
            return false;
        }
        $cnt = 0;
        foreach ($skillEntries as $key => $row) {
            if ($conditions[$key] != null){
                $value='';
                $operator='';
                for ($i = 0;$i <strlen($conditions[$key]);$i++){
                    if(ctype_digit($conditions[$key][$i])){
                        $value.= $conditions[$key][$i];
                    }else{
                        $operator.= $conditions[$key][$i];
                    }
                }
                if ($operator == '>'){
                    if ($row > $value){
                        $cnt++;
                    }
                }
                if ($operator == '<'){

                    if ($row < $value){
                        $cnt++;
                    }
                }
                if ($operator == '>='){

                    if ($row >= $value){
                        $cnt++;
                    }
                }
                if ($operator == '<='){
                    if ($row <= $value){
                        $cnt++;
                    }
                }
                if ($operator == '='){
                    if ($row == $value){
                        $cnt++;
                    }
                }

            }
        }

        return $cnt == count($conditions);

}
    /**
     * Gets table head for users
     *
     * @access public
     * @return array    (name + names of all skills)
     */
    public function getTableHead()
    {
        $result = array();
        $result[t('name')] = t('Name of user');
        $query = $this->helper->skillDatabaseHelper->getSkillArray();
        foreach ($query as $key => $row) {
            $result[$row['name']] = $row['description'];
        }
        return $result;
    }


    /**
     * Gets table head for admin operations
     *
     * @access public
     * @param string   $mode
     * @return array
     */
    public function getAdminTableHead($mode)
    {
        $result = array();
        if ($mode == 'user') {
            $result[t('id')] = t('ID');
            $result[t('name')] = t('Name of user');
            $result[t('username')] = t('Username');
            $result[t('role')] = t('Role of user');
            $query = $this->helper->skillDatabaseHelper->getSkillArray();
            foreach ($query as $key => $row) {
                $result[$row['name']] = $row['description'];
            }
        }
        if ($mode == 'skill'){
            $result[t('id')] = t('ID');
            $result[t('name')] = t('Skill name');
            $result[t('description')] = t('Description');
            $result[t('delete')] = t('Delete skill');
        }
        if ($mode == 'tag'){
            $result[t('id')] = t('ID');
            $result[t('name')] = t('Tag name');
            $result[t('color')] = t('Color');
            $result[t('delete')] = t('Delete tag');

        }
        if ($mode == 'role'){
            $result[t('name')] = t('Role name');
            $result[t('skill rights')] = t('Editing skills rights');
            $result[t('tag rights')] = t('Editing tags rights');
            $result[t('delete')] = t('Delete role');

        }
        return $result;
    }

    /**
     * Gets sorted array of users
     *
     * @access public
     * @param integer   $userID
     * @param array  $canEdit   array of userIDs that can be edited
     * @param array  $arrayToSort
     * @return array
     */
    public function getSortedUsersArray($userID,array $canEdit,array $arrayToSort)
    {

        $result = array();
        foreach ($arrayToSort as $key => $row) {
            if ($row['id'] == $userID) {
                $result[] = $row;
            }
        }

        if (sizeof($canEdit) > 1) {
            foreach ($arrayToSort as $key => $row) {
                if (in_array($row['id'], $canEdit) && $row['id'] != $userID) {
                    $result[] = $row;
                }
            }
        }

        $tmpArray = array_column($result,'id');

        foreach ($arrayToSort as $key => $row) {
            if (!in_array($key,$tmpArray)) {
                $result[] = $row;
            }
        }

        return $result ;
    }

    /**
     * Applies search query rules onto table head
     *
     * @access public
     * @param string   $searchQuery
     * @param array $tableHead
     * @param bool $admin
     * @return array
     */
    public function getFilteredTableHead($searchQuery,array $tableHead,$admin = false)
    {

        $result = array();
        if($admin){
            $result[t('id')] = t('ID');
            $result[t('name')] = t('Name of user');
            $result[t('username')] = t('Username');
            $result[t('role')] = t('Role of user');
        }else{
            $result[t('name')] = t('Name of user');
        }


        $skillsWanted = $this->getItems('skill',$searchQuery);

        if ($skillsWanted != null) {
            foreach ($skillsWanted as $key => $row){
                //right now i dont care about specific skill conditions
                if(mb_stripos($row,'>')!== false){
                    $skillsWanted[$key] = mb_substr($row,0,mb_stripos($row,'>'));
                }elseif (mb_stripos($row,'<')!== false){
                    $skillsWanted[$key] = mb_substr($row,0, mb_stripos($row,'<'));
                }elseif (mb_stripos($row,'=')!== false){
                    $skillsWanted[$key] = mb_substr($row,0, mb_stripos($row,'='));
                }
            }
            foreach ($tableHead as $key => $row) {
                $pos = array_search(strtolower($key),array_map('strtolower',$skillsWanted));
                if ($pos !== false) {
                    $result[$key] = $row;
                }
            }
            return $result;
        }else{
            return $tableHead;
        }
    }

    /**
     * Filters users by specific skill value
     *
     * @access public
     * @param string   $searchQuery
     * @param array $userSkillArray
     * @return array
     */
    public function getFilteredUsersBySkillValue($searchQuery,array $userSkillArray){

        if (mb_stripos($searchQuery,'>') == false && mb_stripos($searchQuery,'<') == false && mb_stripos($searchQuery,'=') == false){
            return $userSkillArray;
        }
        $result = array();
        $skillsArray = $this->getItems('skill',$searchQuery);
        $skillsWithCondition = array();
        foreach ($skillsArray as $key => $row) {
            if(mb_stripos($row,'>')!== false){
                $skillsWithCondition[mb_substr($row,0,mb_stripos($row,'>'))] = mb_substr($row,mb_stripos($row,'>'));
            }elseif (mb_stripos($row,'<')!== false){
                $skillsWithCondition[mb_substr($row,0,mb_stripos($row,'<'))] = mb_substr($row,mb_stripos($row,'<'));
            }elseif (mb_stripos($row,'=')!== false){
                $skillsWithCondition[mb_substr($row,0,mb_stripos($row,'='))] = mb_substr($row,mb_stripos($row,'='));
            }

        }
        if($skillsWithCondition != null){
            foreach ($userSkillArray as $key => $row) {
               $foundSkills = array_intersect_key($row, $skillsWithCondition);
               if ($this->testSkillValueCondition($foundSkills, $skillsWithCondition)){
                   $result[$key] = $row;
               }
            }

            return $result;
        }else{
            return $userSkillArray;
        }

    }




    /**
     * Applies search query rules onto array of users with skills
     *
     * @access public
     * @param string   $searchQuery
     * @param string   $username
     * @param array $userSkillArray
     * @return array
     */
    public function getFilteredUsersByName($searchQuery, $username, array $userSkillArray){

        $result = array();
        $usersWanted = $this->getItems('user',$searchQuery);
        $me = array_search('me',array_map('strtolower',$usersWanted));
        if ($me !== false){
            $usersWanted[$me] = $username;

        }
        if($usersWanted != null){
            foreach ($userSkillArray as $key => $row) {
                $pos = array_search(strtolower($row['name']),array_map('strtolower',$usersWanted));
                if ($pos !== false) {
                    $result[$key] = $row;
                }
                $pos = array_search(strtolower($row['username']),array_map('strtolower',$usersWanted));
                if ($pos !== false) {
                    $result[$key] = $row;
                }
            }
            return $result;
        }else{
            return $userSkillArray;
        }

    }

    /**
     * Applies search query rules onto array of users with skills
     *
     * @access public
     * @param string   $searchQuery
     * @param array $userSkillArray
     * @return array
     */
    public function getFilteredUsersByID($searchQuery,array $userSkillArray){

        $result = array();
        $idWanted = $this->getItems('id',$searchQuery);


        if($idWanted != null){
            foreach ($userSkillArray as $key => $row) {
                $pos = array_search($row['id'],$idWanted);
                if ($pos !== false) {
                    $result[$key] = $row;
                }
            }
            return $result;
        }else{
            return $userSkillArray;
        }

    }


    /**
     * Applies search query rules onto array of users with skills
     *
     * @access public
     * @param string   $searchQuery
     * @param array $userSkillArray
     * @return array
     */
    public function getFilteredUsersByRole($searchQuery,array $userSkillArray){

        $result = array();
        $roleWanted = $this->getItems('role',$searchQuery);


        if($roleWanted != null){
            foreach ($userSkillArray as $key => $row) {
                $pos = array_search($row['role'],$roleWanted);
                if ($pos !== false) {
                    $result[$key] = $row;
                }
            }
            return $result;
        }else{
            return $userSkillArray;
        }

    }

    /**
     * Applies search query rules array of users with skills
     *
     * @access public
     * @param string   $searchQuery
     * @param array     $userSkillArray
     * @return array
     */
    public function getFilteredUsersByTag($searchQuery,array $userSkillArray){

        $result = array();
        $tagsWanted = $this->getItems('tag',$searchQuery);

        if($tagsWanted != null){
            $tmpArray = array();
            foreach ($userSkillArray as $key => $row){
                $tmpArray[$row['id']] = $row;
            }

            $userTagArray = $this->helper->skillDatabaseHelper->getUsersWithTagsArray(true);
            foreach ($userTagArray as $key => $row) {
                $cnt = 0;
                foreach ($tagsWanted as $index => $tag){
                    if ($row[strtolower($tag)] != null) {
                        $cnt++;
                    }

                }
                if ($cnt == count($tagsWanted)){
                    $result[$tmpArray[$key]['id']] = $tmpArray[$key];
                }
            }

            unset($result['']);
            return $result;
        }else{
            return $userSkillArray;
        }

    }

    /**
     * Applies search query rules onto array of skills
     *
     * @access public
     * @param string   $searchQuery
     * @param array     $skillArray
     * @param string   $item
     * @return array
     */
    public function getFilteredSkillsByItem($searchQuery,array $skillArray,$item){

        if ($item == ''){
            return $skillArray;
        }
        $result = array();
        $itemWanted = $this->getItems($item,$searchQuery);


        if($itemWanted != null){
            foreach ($skillArray as $key => $row) {
                $pos = array_search($row[$item],$itemWanted);
                if ($pos !== false) {
                    $result[$key] = $row;
                }
            }
            return $result;
        }else{
            return $skillArray;
        }

    }

    /**
     * Applies search query rules onto array of tags
     *
     * @access public
     * @param string   $searchQuery
     * @param array     $tagArray
     * @param string   $item
     * @return array
     */
    public function getFilteredTagsByItem($searchQuery,array $tagArray,$item){

        if ($item == ''){
            return $tagArray;
        }
        $result = array();
        $tagWanted = $this->getItems($item,$searchQuery);
        if($item == 'color'){
            foreach ($tagWanted as $key => $row){
                $tagWanted[$key] = str_replace(' ','_',$tagWanted[$key]);
                $tagWanted[$key] = strtolower($tagWanted[$key]);
            }
        }


        if($tagWanted != null){
            foreach ($tagArray as $key => $row) {
                $pos = array_search($row[$item],$tagWanted);
                if ($pos !== false) {
                    $result[$key] = $row;
                }
            }
            return $result;
        }else{
            return $tagArray;
        }

    }

    /**
     * Rendering tooltip in templates
     *
     * @access public
     * @param string   $text
     * @return string
     */
    public function renderTooltip($text){
        return '<span class="tooltip">
                    <i class="fa fa-info-circle"></i>
                    <script type="text/template">
                        <div class="markdown">'
                            .t($text).
                        '</div>
                    </script>
                </span>';
       // return $result;

    }
}