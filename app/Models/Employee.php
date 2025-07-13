<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable =[
        'name',
        'email',
        'phone',
        'address',
        'status',
        'birth_date',
        'hire_date',
        'salary',
        'department_id',
        'role_id',
        'profile_picture',
    ];
}
