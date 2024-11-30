<?php

namespace App\Imports;

use App\Models\Sector;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DepartmentsImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return new Department([
            'sector_id'  => self::getSectorId($row['sector']),
            'name' => $row['department'],
            // 'created_by' => auth()->user()->id,
            // 'updated_by' => auth()->user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public static function getSectorId($name)
    {
        return Sector::where('name', $name)->get()->first()->id;
    }
}
