package com.example.crud_java.entity;

import jakarta.persistence.*;
import jakarta.validation.constraints.*;
import lombok.Data;
import java.time.LocalDate;

// ...

@Data
@Entity
public class Employee {
    @Id
    private String id;

    @NotBlank(message = "El nombre es obligatorio")
    @Size(max = 255, message = "El nombre debe tener como máximo 255 caracteres")
    private String nombres;

    @NotBlank(message = "Los apellidos son obligatorios")
    @Size(max = 255, message = "Los apellidos deben tener como máximo 255 caracteres")
    private String apellidos;

    @NotNull(message = "La edad es obligatoria")
    private Integer edad;

    @NotNull(message = "La fecha de ingreso es obligatoria")
    @Past(message = "La fecha de ingreso debe ser en el pasado")
    private LocalDate fecha_ingreso;

    private String comentarios;
}
