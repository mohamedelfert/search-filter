<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $categories = Category::all();

        foreach ($categories as $category) {
            for ($i = 1; $i <= 7; $i++) {
                $products = Product::create([
                    'title' => $category->name . '_' . $i,
                    'description' => $faker->paragraph(),
                    'price' => $faker->randomFloat(2, 100, 5500),
                    'image' => 'https://via.placeholder.com/720x520?text=' . str_replace(' ', '+', $category->name) . '+' . $i,
                    'category_id' => $category->id,
                ]);

                $tags = Tag::inRandomOrder()->take(4)->pluck('id')->toArray();

                $products->tags()->attach($tags);
            }
        }
    }
}
