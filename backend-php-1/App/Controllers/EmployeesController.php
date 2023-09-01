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
        $this->model->store($_POST);

        header('Location: /');
    }

    public function show($id)
    {
        $data = $this->model->show($id);

        echo json_encode($data);
    }

    public function delete($id)
    {
        $this->model->delete($id);

        header('Location: /');
    }

    public function update($id)
    {
        $this->model->update($id, $_POST);

        header('Location: /');
    }
}
