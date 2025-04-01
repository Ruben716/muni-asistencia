<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lastname',
        'turno',
        'happy',
        'active',
        'espacialidad',
        'dni',
        'phone',
        'arrival_time',
        'departure_time',
        'start_date',
        'end_date',
        'institution',
    ];

    /**
     * Relación con el usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con asistencias.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
