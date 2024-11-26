<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model',
        'service_tag',
        'processor_type',
        'memory_size',
        'storage_size',
        'graphics',
        // 'storage1_size',
        // 'storage2_size',
        // 'graphics_1',
        // 'graphics_2',
        'sound',
        'ethernet',
        'wireless',
        'display',
        'shipping_date',
        'status',
        'employee_no',
        'manufacturer_id',
        'device_type_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'shipping_date' => 'date',
        'employee_no' => 'integer',
        'manufacturer_id' => 'integer',
        'device_type_id' => 'integer',
        'storage_size' => 'array',
    ];

    // Accessor for CSV
    public function getStorageSizeAttribute($value)
    {
        return json_decode($value);
    }

    // // Mutator for CSV
    // public function setStorageSizeAttribute($value)
    // {
    //     $this->attributes['storage_size'] = is_array($value)
    //         ? json_encode(implode(',', $value))
    //         : json_encode($value);
    //     //     // Ensure value is always an array
    //     //     // $this->attributes['storage_size'] = is_array($value)
    //     //     //     ? json_encode($value)
    //     //     //     : json_encode([$value]);
    // }


    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_no');
    }

    public function manufacturer(): BelongsTo
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function deviceType(): BelongsTo
    {
        return $this->belongsTo(DeviceType::class);
    }
}