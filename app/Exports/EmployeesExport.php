<?php

namespace App\Exports;

use App\Models\Employee;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeesExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    public function __construct(public Collection $records)
    {
        // $this->records = $records;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     return Employee::all();
    // }

    public function collection()
    {
        return $this->records;
    }

    /**
     * @param Employee $employee
     */
    public function map($employee): array
    {
        return [
            $employee->name_ar,
            $employee->name_en,
            $employee->email,
            $employee->status,
            $employee->company,
            $employee->job_title,
            $employee->national_id,
            $employee->employee_no,
            $employee->manager?->name_ar,
            $employee->location->name,
            $employee->sector->name,
            $employee->department->name,
            Date::dateTimeToExcel($employee->created_at),
            Date::dateTimeToExcel($employee->updated_at),
        ];
    }

    public function headings(): array
    {
        return [
            'name_ar',
            'name_en',
            'email',
            'status',
            'company',
            'job_title',
            'national_id',
            'employee_no',
            'manager',
            'location',
            'sector',
            'department',
            'created_at',
            'updated_at',
        ];
    }
}
