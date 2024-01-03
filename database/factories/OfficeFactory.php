<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Office;

class OfficeFactory extends Factory
{
    
    protected $model = Office::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->regexify('[A-Za-z0-9]{4}'),
            'name' => $this->faker->name(),
        ];
    }
}
