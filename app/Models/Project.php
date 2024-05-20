<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = "project_details";

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }
}
