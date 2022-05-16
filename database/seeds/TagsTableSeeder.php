<?php

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'Dell',
            'Hp',
            'Acer',
            'Lenovo',
            'Samsung',
            'Mac',
            'Sony',
            'Toshiba',
            'LG',
            'Playstation',
        ];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }
    }
}
