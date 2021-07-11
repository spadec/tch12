<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if (!empty($_COOKIE['sid'])) {
        // check session id in cookies
        session_id($_COOKIE['sid']);
        }
        session_start();
require_once '../classes/Auth.class.php'; 
if (User::isAuthorized()):
        include_once "../classes/config.php";
        include_once "../classes/safemysql.php";
        include_once "../classes/models/departments.php";
        include_once "../classes/Departments.php";

        $db = new SafeMySQL($config);
        $departments = new DepartmentModel($db);
        $OrgID = $_POST["OrgID"];
        $departmentsList = $departments->getDepartments($OrgID);
        echo json_encode($departmentsList, JSON_UNESCAPED_UNICODE);
else:
        echo json_encode(array("error"=>"auth fail"), JSON_UNESCAPED_UNICODE);  
endif;
?>