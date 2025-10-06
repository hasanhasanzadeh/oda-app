<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'=>$this->faker->title,
            'url'=>$this->faker->url,
            'copy_right'=>$this->faker->text(150),
            'Content'=>$this->faker->text(500),
            'description'=>$this->faker->text(500),
            'address'=>$this->faker->address,
            'short_text'=>$this->faker->text(70),
            'tel'=>$this->faker->phoneNumber,
            'email'=>$this->faker->email,
        ];
    }
}
