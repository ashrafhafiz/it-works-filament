<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\User;
use App\Models\TextSms;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class TextMessageService
{
    public static function sendBulkSms(Collection $records, array $data)
    {
        $textMessages = collect([]);

        $records->map(function ($record) use ($data, $textMessages) {
            $textMessage = self::sendSms($record, $data);

            $textMessages->push($textMessage);
        });

        TextSms::insert($textMessages->toArray());
    }

    public static function sendSms(Employee $record, array $data)
    {
        $message = Str::replace('{name}', $record->name_en, $data['message']);

        // Implement your SMS sending logic here

        return [
            'message' => $message,
            'sent_from' => auth()?->id() ?? null,
            'status' => TextSms::STATUS['PENDING'],
            'response' => '',
            'sent_to' => $record->employee_no,
            'remarks' => $data['remarks'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
