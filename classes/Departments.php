<?php
//namespace Auth;
class DepartmentsController {
    protected $db;
    protected $config;
    function __construct($db){
        $this->db = $db;
    }

}