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
}