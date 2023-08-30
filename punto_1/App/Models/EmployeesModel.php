<?php

namespace App\Models;

use Config\Database;

class EmployeesModel
{

    private $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->db = $this->db->performConnection();
    }

    public function index()
    {
        $statement = $this->db->prepare("SELECT * FROM employees");
        return ($statement->execute()) ? $statement->fetchAll() : false;
    }
}
