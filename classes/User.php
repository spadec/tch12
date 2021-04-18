<?php
//namespace Auth;
class UserController {
    protected $db;
    protected $config;
    function __construct($db){
        $this->db = $db;
    }
    public function SetUserData($userId){
        $userDB = new UserModel($this->db);
        $result = $userDB->GetUserData($userId);
        return array("name"=>$result["sorname"]." ".$result["name"]." ".$result["thirdname"]
                    ,"department"=>$result["department"]
                    ,"position"=>$result["position"]
                    ,"role"=>$result["role"]
                    ,"Org"=>$result["Org"]
                    ,"OrgID"=>$result["OrgID"]);
    }
}
?>