<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskHistory extends Model
{
    use HasFactory;

    protected $table = "task_history";

    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class,'task_id');
    }
}
