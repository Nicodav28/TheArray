<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Employee extends Model
{
    use HasFactory, UUID;

    protected $table = 'employees';
    protected $primaryKey = 'id';
    public $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'apellidos',
        'edad',
        'fecha_ingreso',
        'comentarios',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
