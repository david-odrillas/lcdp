<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'category_id' => Category::factory(),
          'name' => $this->faker->name(),
          'price' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 100),
          'url' => $this->faker->imageUrl()
        ];
    }
}
