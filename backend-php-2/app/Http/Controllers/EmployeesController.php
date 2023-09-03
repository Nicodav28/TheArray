<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use Illuminate\Database\QueryException;
use App\Helpers\HandleResponse;

class EmployeesController extends Controller
{
    private HandleResponse $response;
    private array $validationRules;

    public function __construct(HandleResponse $response)
    {
        $this->response = $response;

        $this->validationRules = [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'edad' => 'required|numeric',
            'fecha_ingreso' => 'date',
            'comentarios' => 'nullable|max:255',
        ];
    }

    /**
     * Display a list of employees.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $employees = Employee::all(['*']);

            if ($employees->count() < 1) {
                return $this->response->error('S404GES', 'No hay empleados registrados.', 404);
            }

            return $this->response->success('S200GES', $employees, 'Empleados obtenidos correctamente.', 200);
        } catch (\Throwable $th) {
            return $this->response->error('S500GES', 'Error interno del servidor.', 500);
        }
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = $this->paramsValidate($request->all());

            if ($validator) {
                return $validator;
            }

            $employee = Employee::create([
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'edad' => $request->edad,
                'fecha_ingreso' => $request->fecha_ingreso,
                'comentarios' => $request->comentarios ?? null
            ]);

            return $this->response->success('S200CE', $employee, 'Empleado creado correctamente.', 200);
        } catch (QueryException $th) {
            return $this->response->error('S500CE', 'Error interno del servidor.', 500);
        }
    }

    /**
     * Update the specified employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id The id of the employee to update, the id must be a valid UUID v4.
     * @throws \Exception
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        try {
            $rules = [
                'nombres' => 'sometimes|string|max:255',
                'apellidos' => 'sometimes|string|max:255',
                'edad' => 'sometimes|numeric',
                'fecha_ingreso' => 'sometimes|date',
                'comentarios' => 'nullable|max:255'
            ];

            $validator = $this->paramsValidate($request->all(), $rules);
            $exists = $this->elementExists('id', $id);

            if ($validator || !$exists) {
                return $validator ? $this->response->error('S400UE', 'Request Invalida.', 400) :
                    $this->response->error('S400UE', 'Empleado no encontrado.', 404);
            }

            $update = Employee::where('id', '=', $id)->update($request->all());

            if ($update < 1) {
                throw new \Exception;
            }

            return $this->response->success('S200UE', $update, 'Empleado actualizado correctamente.', 200);
        } catch (\Throwable $th) {
            return $this->response->error('S500CE', 'Error interno del servidor.', 500);
        }
    }

    /**
     * Remove the specified employee from Data Base.
     *
     * @param  string  $id The id of the employee to delete, the id must be a valid UUID v4.
     * @throws \Exception
     * @return \Illuminate\Http\Response
     */
    public function delete(string $id)
    {
        try {
            $exists = $this->elementExists('id', $id);

            if (!$exists) {
                return $this->response->error('S404DE', 'Empleado no encontrado.', 404);
            }

            $delete = Employee::where('id', '=', $id)->delete();

            if ($delete < 1) {
                throw new \Exception;
            }

            return $this->response->success('S200DE', $delete, 'Empleado eliminado correctamente.', 200);
        } catch (\Throwable $th) {
            return $this->response->error('S500DE', 'Error interno del servidor.', 500);
        }
    }

    /**
     * Display the specified employee.
     *
     * @param  string  $id The id of the employee to perform the search, the id must be a valid UUID v4.
     * @throws \Exception
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        try {
            $employee = $this->elementExists('id', $id, true);

            if (!$employee) {
                return $this->response->error('S404GE', 'Empleado no encontrado.', 404);
            }

            return $this->response->success('S200GE', $employee, 'Empleado obtenido correctamente.', 200);
        } catch (\Throwable $th) {
            return $this->response->error('S500GE', 'Error interno del servidor.', 500);
        }
    }

    /**
     * Check if the request params are valid.
     *
     * @param  array $params The request params.
     * @param  array $rules The rules to validate the params.
     * @throws \Exception
     * @return \Illuminate\Http\Response | bool
     */
    private function paramsValidate(array $params, array | string $rules = '')
    {
        $rules = !empty($rules) ? $rules : $this->validationRules;

        $validator = Validator::make($params, $rules);

        if ($validator->fails()) {
            return $this->response->error('S404CE', 'Request Invalida.', 400);
        }

        return false;
    }

    /**
     * Check if the element exists in Data Base.
     *
     * @param  mixed $searchFilter The field with wich the search condition will be performed.
     * @param mixed $searchValue The value of the condition of the search.
     * @throws \Exception
     * @return \Illuminate\Http\Response | bool
     */
    private function elementExists($searchFilter, $searchValue, $data = false)
    {
        $query = Employee::where($searchFilter, $searchValue);

        if ($data) {
            return $query->exists() ? $query->get() : false;
        }

        return $query->exists();
    }
}
