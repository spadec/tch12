<?php
class EmployeModel{
    protected $db;
    function __construct($db){
        $this->db = $db;
    }
}