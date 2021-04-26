<?php
    include_once "../classes/config.php";
    include_once "../classes/safemysql.php";
    include_once "../classes/models/employe.php";

if($_POST){
    $db = new SafeMySQL($config);
    $employe = new EmployeModel($db);
    $result = $employe->setEmploye($_POST);
    /*$name = $_POST['shortName'];
    $sorname = $_POST['sorname'];
    $thirdname = $_POST['thirdname'];
    $position = $_POST['position'];
    $dep = $_POST['department'];*/
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}
else {
	echo json_encode($_POST, JSON_UNESCAPED_UNICODE);
}