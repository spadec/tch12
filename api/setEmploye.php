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
    include_once "../classes/models/employe.php";
    $db = new SafeMySQL($config);
    $employe = new EmployeModel($db);
    $result = $employe->setEmploye($_POST);
    /*$name = $_POST['shortName'];
    $sorname = $_POST['sorname'];
    $thirdname = $_POST['thirdname'];
    $position = $_POST['position'];
    $dep = $_POST['department'];*/
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
else:
    echo json_encode(array("error"=>"auth fail"), JSON_UNESCAPED_UNICODE);  
endif;
?>