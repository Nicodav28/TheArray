<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function createEmployee(Request $request)
    {
        // Validate the request...
    }

    public function updateEmployee(Request $request, $id)
    {
        // Validate the request...
    }

    public function deleteEmployee($id)
    {
        // Delete the employee...
    }

    public function getEmployees()
    {
        $employees = [
            ['id' => 1, 'name' => 'John Doe'],
            ['id' => 2, 'name' => 'Jane Doe'],
            ['id' => 3, 'name' => 'Johnny Doe'],
            ['id' => 4, 'name' => 'Janie Doe'],
        ];

        return response()->json($employees);
    }

    public function getEmployee($id)
    {
        $employee = ['id' => $id, 'name' => 'John Doe'];

        return response()->json($employee);
    }
}
