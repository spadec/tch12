<?php
//namespace Auth;
class UserModel {
    protected $db;
    function __construct($db){
        $this->db = $db;
    }
    public function GetUserData($userId){
        $sql = "SELECT e.name,e.sorname,e.thirdname,e.position,r.full_name as role,r.access_level,d.name as department,o.name as Org 
        FROM `users` u 
        INNER JOIN employees e on u.`employee_id`=e.id
        INNER JOIN roles r on u.`role_id`=r.id
        Inner Join departments d on e.department_id = d.id
        INNER JOIN organizations o on d.organization_id = o.id
        WHERE u.`id` = ?i";
        $result = $this->db->getRow($sql, $userId);
        if($result){
            return $result;
        }
        return false;
    }
}