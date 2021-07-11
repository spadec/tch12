<?php
class EmployeModel{
    protected $db;
    function __construct($db){
        $this->db = $db;
    }
    public function setEmploye($arr){
        $sql = "INSERT INTO employees set name=?s,sorname=?s,thirdname=?s,position=?s,department_id=?i";
        $result = $this->db->query($sql,$arr['shortName'],$arr['sorname'],$arr['thirdname'],$arr['position'],$arr['department']);
        return $result;
    }
    public function getEmployeByDepID($depID){
        $sql = "SELECT * FROM employees WHERE department_id=?i";
        $result = $this->db->getAll($sql,$depID);
        if($result){
            return $result;
        }
        return false;
    }
    public function getEmployeByOrgID($orgID, $departmentID, $limit = 200){
        $qpart = "";
        if($departmentID){
            $qpart = $this->db->parse(" AND d.id=?i", $departmentID);
        }
        $sql = "SELECT s.*,d.name as dname FROM `employees` s Inner join `departments` d on s.department_id = d.id WHERE d.organization_id = ?i ?p LIMIT ?i";
        $result = $this->db->getAll($sql,$orgID, $qpart, $limit);
        if($result){
            return $result;
        }
        return false;
    }
    public function getEmployeBySearch($orgID, $searchStr, $departmentID, $limit = 200){
        return false;
    }
}