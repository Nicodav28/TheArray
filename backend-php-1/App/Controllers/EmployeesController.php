<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Models\EmployeesModel;
use App\Helpers\Validator;

class EmployeesController
{
    private $model;
    private $twig;
    private $validator;

    public function __construct()
    {
        $this->model = new EmployeesModel;
        $this->validator = new Validator;

        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader);
    }

    public function index()
    {
        $employees = $this->model->index();
        $this->renderView('index.twig', ['employees' => $employees]);
    }

    public function store()
    {
        $validationRules = [
            'nombres' => 'required',
            'apellidos' => 'required',
            'edad' => 'required|numeric',
            'fecha_ingreso' => 'date',
            'comentarios' => 'nullable|max:255',
        ];

        $this->validator->validate($_POST, $validationRules);

        if ($this->model->store($_POST)) {
            $this->redirect('/');
        } else {
            $this->renderView('index.twig', ['error_message' => 'Error al guardar el registro']);
        }
    }

    public function show($id)
    {
        $data = $this->model->show($id);
        echo json_encode($data);
    }

    public function delete($id)
    {
        $this->model->delete($id);
        $this->redirect('/');
    }

    public function update($id)
    {
        if ($this->model->update($id, $_POST)) {
            $this->redirect('/');
        } else {
            $this->renderView('index.twig', ['error_message' => 'Error al actualizar el registro']);
        }
    }

    private function renderView($view, $data = [])
    {
        $template = $this->twig->load($view);
        echo $template->render($data);
    }

    private function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}
