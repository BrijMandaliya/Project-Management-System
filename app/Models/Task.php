<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class Task extends Model
{
    use HasFactory;

    protected $table = "task_details";

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function posted_employee()
    {
        return $this->hasMany(Employee::class, 'id', 'task_posted_by');
    }


}
