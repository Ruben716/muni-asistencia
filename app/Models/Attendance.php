<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['intern_id', 'date', 'check_in', 'check_out'];

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
