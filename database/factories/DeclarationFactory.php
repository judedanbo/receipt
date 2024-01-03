<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Declaration;
use App\Models\Office;
use App\Models\Staff;
use App\Models\User;

class DeclarationFactory extends Factory
{
    
    protected $model = Declaration::class;

    public function definition(): array
    {
        return [
            'receipt_no' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'declared_date' => $this->faker->word(),
            'post' => $this->faker->word(),
            'schedule' => $this->faker->word(),
            'office_location' => $this->faker->word(),
            'address' => $this->faker->word(),
            'contact' => $this->faker->word(),
            'witness' => $this->faker->word(),
            'witness_occupation' => $this->faker->word(),
            'submitted_by' => $this->faker->word(),
            'submitted_by_contact' => $this->faker->word(),
            'qr_code' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'synced' => $this->faker->word(),
            'office_id' => Office::factory(),
            'user_id' => User::factory(),
            'old_received_by' => $this->faker->word(),
            'old_serial_no' => $this->faker->word(),
            'old_declaration_id' => $this->faker->word(),
            'staff_id' => Staff::factory(),
        ];
    }
}
