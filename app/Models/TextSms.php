<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TextSms extends Model
{
    use LogsActivity;

    protected $fillable = [
        'message',
        'response',
        'sent_to',
        'sent_from',
        'status',
        'remarks',
    ];

    const STATUS = [
        'PENDING' => 'Pending',
        'SUCCESS' => 'Success',
        'FAILED' => 'Failed'
    ];

    public function sentTo()
    {
        return $this->belongsTo(Employee::class, 'sent_to', 'employee_no');
    }

    public function sentFrom()
    {
        return $this->belongsTo(User::class, 'sent_from', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logAll()->useLogName(class_basename($this) . '_log');
    }
}
