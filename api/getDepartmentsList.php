<?php
        
        include_once "../classes/config.php";
        include_once "../classes/safemysql.php";
        include_once "../classes/models/departments.php";
        include_once "../classes/Departments.php";

        $db = new SafeMySQL($config);
        $departments = new DepartmentModel($db);
        $OrgID = $_POST["OrgID"];
        $departmentsList = $departments->getDepartments($OrgID);
        echo json_encode($departmentsList, JSON_UNESCAPED_UNICODE);

?>