<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'ip'=>'192.168.10.2',
            'latitude'=>'31.5204',
            'longitude'=>'74.3587',
            'verified'=>'1',
            'gender_id'=>'2',
            'religion_id'=>'3',
            'country_id'=>'3',
            'language_id'=>'3',
            'university'=>$this->faker->name(),
            'passion'=>$this->faker->name(),
            'dob'=>$this->faker->date('y-m-d'),
            'interested_in'=>'2',
            'password' => '$2y$10$NBPpPNK7cvbMd5EmtScQiuue5iEpJrhcGzgMv5FgGM0qxjPfv606e',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
