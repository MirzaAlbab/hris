<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'employee_id',
        'salary',
        'allowances',
        'deductions',
        'net_salary',
        'pay_date'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
