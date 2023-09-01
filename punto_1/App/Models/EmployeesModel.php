<?php

namespace App\Models;

use Config\Database;
use PDO;

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

    public function store($params)
    {
        $statement = $this->db->prepare(
            "INSERT INTO employees (id, nombres, apellidos, edad, fecha_ingreso, comentarios) 
            VALUES (:id, :name, :surname, :yo, :date, :comments)"
        );

        $id = uniqid('', true);

        $statement->bindParam(':id', $id);
        $statement->bindParam(':name', $params['name']);
        $statement->bindParam(':surname', $params['surname']);
        $statement->bindParam(':yo', $params['yo']);
        $statement->bindParam(':date', $params['date']);
        $statement->bindParam(':comments', $params['comments']);

        return ($statement->execute()) ? true : false;
    }

    public function show($id)
    {
        $statement = $this->db->prepare("SELECT * FROM employees WHERE id = :id");
        $statement->bindParam(':id', $id);

        return ($statement->execute()) ? $statement->fetch() : false;
    }

    public function update($id, $params)
    {
        $statement = $this->db->prepare(
            "UPDATE employees
                SET nombres = :name, apellidos = :surname, edad = :yo, fecha_ingreso = :date, comentarios = :comments
                    WHERE id = :id"
        );

        $statement->bindParam(':id', $id);
        $statement->bindParam(':name', $params['nameUpd']);
        $statement->bindParam(':surname', $params['surnameUpd']);
        $statement->bindParam(':yo', $params['yoUpd']);
        $statement->bindParam(':date', $params['dateUpd']);
        $statement->bindParam(':comments', $params['commentsUpd']);


        return ($statement->execute()) ? true : false;
    }


    public function delete($id)
    {
        $statement = $this->db->prepare("DELETE FROM employees WHERE id = :id");
        $statement->bindParam(':id', $id);

        return ($statement->execute()) ? true : false;
    }
}
