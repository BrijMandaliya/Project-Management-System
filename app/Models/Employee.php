<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table="employees";

    public function employee_permission()
    {
        return $this->hasMany(EmployeePermission::class);
    }

    public function employee_role()
    {
        return $this->belongsTo(Roles::class,'roles_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }


}
