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

    public function delete($id)
    {
        $statement = $this->db->prepare("DELETE FROM employees WHERE id = :id");
        $statement->bindParam(':id', $id);

        return ($statement->execute()) ? true : false;
    }

    public function update($params)
    {
        $sql = "UPDATE employees SET ";
        $updateFields = [];

        foreach ($params as $key => $value) {
            if ($value !== '' && in_array($key, ['name', 'surname', 'yo', 'date', 'comments'])) {
                $updateFields[] = "$key = :$key";
            }
        }

        if (empty($updateFields)) {
            return false;
        }

        $sql .= implode(", ", $updateFields);
        $sql .= " WHERE id = :id";

        $statement = $this->db->prepare($sql);

        $statement->bindParam(':id', $params['id']);

        foreach ($params as $key => $value) {
            if ($value !== '' && in_array($key, ['name', 'surname', 'yo', 'date', 'comments'])) {
                $statement->bindParam(":$key", $value);
            }
        }

        return ($statement->execute()) ? true : false;
    }
}
