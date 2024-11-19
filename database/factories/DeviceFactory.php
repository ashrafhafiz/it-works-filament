<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Employee;
use App\Models\Manufacturer;

class DeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Device::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'model' => $this->faker->word(),
            'service_tag' => $this->faker->word(),
            'processor_type' => $this->faker->word(),
            'memory_size' => $this->faker->word(),
            'storage1_size' => $this->faker->word(),
            'storage2_size' => $this->faker->word(),
            'graphics_1' => $this->faker->word(),
            'graphics_2' => $this->faker->word(),
            'sound' => $this->faker->word(),
            'ethernet' => $this->faker->word(),
            'wireless' => $this->faker->word(),
            'display' => $this->faker->word(),
            'shipping_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(["active","ready","reserved","retired","repair"]),
            'employee_id' => Employee::factory(),
            'manufacturer_id' => Manufacturer::factory(),
            'device_type_id' => DeviceType::factory(),
        ];
    }
}
