<?php

namespace Database\Factories;

use App\Models\ItemImage;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemImageFactory extends Factory
{
    protected $model = ItemImage::class;

    public function definition(): array
    {
        return [
            'itemno' => Item::factory(),
            'image' => '/storage/products/'.$this->faker->unique()->lexify('img_????').'.jpg',
        ];
    }
}
