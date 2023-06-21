<?php

namespace Database\Factories;

use App\Models\Cat;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatFactory extends Factory
{
    protected $model = Cat::class;

    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'branch_id' => Branch::factory(),
        ];
    }
}
