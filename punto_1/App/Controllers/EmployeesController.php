<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\EmployeesModel;

class EmployeesController
{
    private $model;
    private $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader);

        $this->model = new EmployeesModel();
    }

    public function index()
    {
        $employees = $this->model->index();
        $template = $this->twig->load('index.twig');

        echo $template->render([
            'employees' => $employees,
        ]);
    }

    public function store()
    {
        $employeeRegister = $this->model->store($_POST);

        $template = $this->twig->load('index.twig');

        $response = $employeeRegister ?
            ['error' => false, 'mensaje' => 'Empleado registrado correctamente'] :
            ['error' => true, 'mensaje' => 'Error al registrar empleado'];

        echo $template->render($response);
    }

    public function delete()
    {
        $employeeDelete = $this->model->delete($_POST['id']);

        $template = $this->twig->load('index.twig');

        $response = $employeeDelete ?
            ['error' => false, 'mensaje' => 'Empleado eliminado correctamente'] :
            ['error' => true, 'mensaje' => 'Error al eliminar empleado'];

        echo $template->render($response);
    }

    public function update()
    {
        $employeeUpdate = $this->model->update($_POST);

        $template = $this->twig->load('index.twig');

        $response = $employeeUpdate ?
            ['error' => false, 'mensaje' => 'Empleado actualizado correctamente'] :
            ['error' => true, 'mensaje' => 'Error al actualizar empleado'];

        echo $template->render($response);
    }
}
