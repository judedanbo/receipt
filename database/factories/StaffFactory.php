<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Staff;

class StaffFactory extends Factory
{
    
    protected $model = Staff::class;

    public function definition(): array
    {
        return [
            'staff_number' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'title' => $this->faker->title(),
            'surname' => $this->faker->lastName(),
            'other_names' => $this->faker->firstName(),
            'email' => $this->faker->safeEmail(),
        ];
    }
}
