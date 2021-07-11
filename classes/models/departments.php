<?php
class DepartmentModel{
    protected $db;
    function __construct($db){
        $this->db = $db;
    }
    public function getDepartments($OrgID){
        $sql = "SELECT id, name, parent_id From departments WHERE organization_id = ?i ORDER BY parent_id ASC";
        $result = $this->db->getAll($sql, $OrgID);
        if($result){
            return $result;
        }
        return false;
    }
    public function setDepartment($name,$parentID, $OrgID){
        $sql = "INSERT INTO `departments` SET name = ?s, organization_id = ?i,parent_id = ?i";
        $result = $this->db->query($sql,$name,$OrgID,$parentID);
        return $result;
    }
}