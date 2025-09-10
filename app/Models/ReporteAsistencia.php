<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class ReporteAsistencia extends Model
{
protected $fillable = [
'intern_id',
'tipo', // 'individual' o 'global'
'estado', // pendiente, en_proceso, listo, error
'correlation_id',
'resultado_url',
'detalle_error',
];
}