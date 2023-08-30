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

    public function storeView()
    {
        $template = $this->twig->load('createEmployee.twig');
        echo $template->render();
    }
}
