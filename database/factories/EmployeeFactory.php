<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Location;
use App\Models\ReportTo;
use App\Models\Sector;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'company' => $this->faker->company(),
            'job_title' => $this->faker->word(),
            'class' => $this->faker->randomElement(["White Collars", "Blue Collars"]),
            'national_id' => $this->faker->word(),
            'employee_no' => $this->faker->word(),
            'report_to' => Employee::factory(),
            'location_id' => Location::factory(),
            'sector_id' => Sector::factory(),
            'department_id' => Department::factory(),
        ];
    }
}
