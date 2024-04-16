<?php


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Provider\ja_JP\Person;
class SiswaAccountModelFactory extends Factory
{

    protected $model = \App\Models\SiswaAccountModel::class;
    /**
     * Define the model's default state.
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new Person($this->faker));
        return [
            'nama' => $this->faker->kanaName(), 
            'kelas' => "12 tkj " . random_int(1, 4), 
            'nomor_ujian' => random_int(10000, 10100), 
            'password' => base64_encode(random_int(10000, 200000)), 
            'blokir' => false
        ];
    }
}
