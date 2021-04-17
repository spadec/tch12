<?php
        
        include_once "classes/config.php";
        include_once "classes/safemysql.php";
        include_once "classes/models/user.php";
        include_once "classes/User.php";
        
        $db = new SafeMySQL($config);
        echo json_encode(array("status"=>"ok"), JSON_UNESCAPED_UNICODE);

?>