<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\ItemType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'short_dis' => $this->faker->sentence(6),
            'long_dis' => $this->faker->paragraphs(2, true),
            'type' => ItemType::factory(),
            'inactive_status' => false,
            'content' => $this->faker->sentence(8),
            'benefits' => $this->faker->sentence(8),
            'trademark' => $this->faker->company(),
            'price' => $this->faker->randomFloat(2, 10, 9999),
            'created' => now(),
        ];
    }
}
