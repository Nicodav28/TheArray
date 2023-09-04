package com.example.crud_java.controller;

import com.example.crud_java.entity.Employee;
import com.example.crud_java.service.EmployeeService;
import com.example.crud_java.helpers.HandleResponse;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Optional;
//import javax.validation.*;
import jakarta.validation.*;

import java.util.UUID;

@RestController
@RequestMapping(path = "api/")
public class EmployeeController {

    @Autowired
    private final EmployeeService employeeService;

    public EmployeeController(EmployeeService employeeService) {
        this.employeeService = employeeService;
    }

    @GetMapping("get")
    public ResponseEntity<Object> getAll() {
        List<Employee> employees = this.employeeService.getAllEmployees();
        if (employees.isEmpty()) {
            return HandleResponse.error("S404GES", "No hay empleados registrados.", HttpStatus.valueOf(404));
        }
        return HandleResponse.success("S200GES", employees, "Empleados obtenidos correctamente.", HttpStatus.valueOf(200));
    }

    @PostMapping("create")
    public ResponseEntity<Object> createEmployee(@Valid @RequestBody Employee employee) {
        UUID uuid = UUID.randomUUID();

        String id = uuid.toString();
        employee.setId(id);

        boolean execution = this.employeeService.saveOrUpdateEmployee(employee);
        if (execution) {
            return HandleResponse.success("S200CE", employee, "Empleado creado correctamente.", HttpStatus.valueOf(200));
        } else {
            return HandleResponse.error("S500CE", "Error interno del servidor.", HttpStatus.valueOf(500));
        }
    }

    @PutMapping("update/{id}")
    public ResponseEntity<Object> updateEmployee(@PathVariable String id, @Valid @RequestBody Employee employee) {
        employee.setId(id);
        boolean execution = this.employeeService.saveOrUpdateEmployee(employee);
        if (execution) {
            return HandleResponse.success("S200UE", employee, "Empleado actualizado correctamente.", HttpStatus.valueOf(200));
        } else {
            return HandleResponse.error("S500UE", "Error interno del servidor.", HttpStatus.valueOf(500));
        }
    }

    @DeleteMapping("delete/{id}")
    public ResponseEntity<Object> deleteEmployee(@PathVariable String id) {
        boolean execution = this.employeeService.deleteEmployeeById(id);
        if (execution) {
            return HandleResponse.success("S200DE", null, "Empleado eliminado correctamente.", HttpStatus.valueOf(200));
        } else {
            return HandleResponse.error("S500DE", "Error interno del servidor.", HttpStatus.valueOf(500));
        }
    }

    @GetMapping("get/{id}")
    public ResponseEntity<Object> getById(@PathVariable String id) {
        Optional<Employee> employee = this.employeeService.getEmployeeById(id);
        if (employee.isPresent()) {
            return HandleResponse.success("S200GE", employee.get(), "Empleado obtenido correctamente.", HttpStatus.valueOf(200));
        } else {
            return HandleResponse.error("S404GE", "Empleado no encontrado.", HttpStatus.valueOf(404));
        }
    }
}
