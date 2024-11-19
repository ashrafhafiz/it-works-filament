<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\Mobile;

class MobileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Mobile::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'mobile_no' => $this->faker->phoneNumber(),
            'rate_plan' => $this->faker->randomElement(["Easy", "Flex", "Business"]),
            'bouquet_value' => $this->faker->randomElement([50, 75, 100, 150, 200, 300, 400]),
        ];
    }
}
