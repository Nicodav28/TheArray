<?php

namespace App\Models;

use Config\Database;
use PDO;

class EmployeesModel
{
    private $db;

    public function __construct()
    {
        // Use dependency injection to pass the database connection.
        $this->db = (new Database())->performConnection();
    }

    /**
     * Retrieve all employees from the database.
     *
     * @return array|false Array of employees or false if an error occurs.
     */
    public function index()
    {
        $statement = $this->db->prepare("SELECT * FROM employees");
        return $statement->execute() ? $statement->fetchAll() : false;
    }

    /**
     * Store a new employee record in the database.
     *
     * @param array $params Employee data to be stored.
     * 
     * @return bool True if the insertion is successful, false otherwise.
     */
    public function store(array $params)
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

        return $statement->execute();
    }

    /**
     * Retrieve an employee record by ID from the database.
     *
     * @param string $id Employee ID to retrieve.
     * 
     * @return array|false Employee data or false if not found or an error occurs.
     */
    public function show(string $id)
    {
        $statement = $this->db->prepare("SELECT * FROM employees WHERE id = :id");
        $statement->bindParam(':id', $id);

        return $statement->execute() ? $statement->fetch() : false;
    }

    /**
     * Update an existing employee record in the database.
     *
     * @param string $id     Employee ID to update.
     * @param array  $params Updated employee data.
     * 
     * @return bool True if the update is successful, false otherwise.
     */
    public function update(string $id, array $params)
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

        return $statement->execute();
    }

    /**
     * Delete an employee record from the database.
     *
     * @param string $id Employee ID to delete.
     * 
     * @return bool True if the deletion is successful, false otherwise.
     */
    public function delete(string $id)
    {
        $statement = $this->db->prepare("DELETE FROM employees WHERE id = :id");
        $statement->bindParam(':id', $id);

        return $statement->execute();
    }
}
