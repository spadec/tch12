<?php
class DepartmentModel{
    protected $db;
    function __construct($db){
        $this->db = $db;
    }
    public function getDepartments($OrgID){
        $sql = "SELECT id, name From departments WHERE organization_id = ?i";
        $result = $this->db->getAll($sql, $OrgID);
        if($result){
            return $result;
        }
        return false;
    }
}