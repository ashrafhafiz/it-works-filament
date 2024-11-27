<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TextSms extends Model
{
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
        return $this->belongsTo(Employee::class, 'sent_to');
    }

    public function sentFrom()
    {
        return $this->belongsTo(User::class, 'sent_from');
    }
}
