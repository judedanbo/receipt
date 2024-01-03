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
            'declared_date' => $this->faker->date(),
            'post' => $this->faker->jobTitle(),
            'schedule' => $this->faker->jobTitle(),
            'office_location' => $this->faker->city(),
            'address' => $this->faker->address(),
            'contact' => $this->faker->phoneNumber(),
            'witness' => $this->faker->name(),
            'witness_occupation' => $this->faker->jobTitle(),
            'submitted_by' => $this->faker->name(),
            'submitted_by_contact' => $this->faker->phoneNumber(),
            'qr_code' => $this->faker->regexify('[A-Za-z0-9]{25}'),
            'synced' => $this->faker->boolean(),
            'office_id' => Office::factory(),
            'user_id' => 1,
            'old_received_by' => $this->faker->name(),
            'old_serial_no' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'old_declaration_id' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'staff_id' => Staff::factory(),
        ];
    }
}
