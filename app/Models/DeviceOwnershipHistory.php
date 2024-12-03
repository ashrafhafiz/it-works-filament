<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceOwnershipHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id',
        'employee_no',
        'assigned_date',
        'returned_date',
        'reason'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'device_id' => 'integer',
        'employee_no' => 'integer',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_no', 'employee_no');
    }
}