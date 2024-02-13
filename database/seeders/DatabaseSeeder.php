<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Pizza;
use App\Models\Topping;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Populating the DB

        $pizza1 = Pizza::factory()->create([
            'name' => 'Classic Pepperoni',
            'sauce' => true,
            'cheese' => true,
        ]);

        $pizza1->toppings()->attach(Topping::factory()->create(['name' => 'Pepperoni']));

        $pizza2 = Pizza::factory()->create([
            'name' => 'Mushroom Madness',
            'sauce' => true,
            'cheese' => true,
        ]);

        $pizza2->toppings()->attach(Topping::factory()->create(['name' => 'Mushrooms']));

        $pizza3 = Pizza::factory()->create([
            'name' => 'Sausage Pizza',
            'sauce' => true,
            'cheese' => true,
        ]);

        $pizza3->toppings()->attach(Topping::factory()->create(['name' => 'Sausage']));

        $pizza4 = Pizza::factory()->create([
            'name' => 'Veggie Delight',
            'sauce' => true,
            'cheese' => true,
        ]);

        $pizza4->toppings()->attach(Topping::factory()->create(['name' => 'Bell Peppers']));

        $pizza5 = Pizza::factory()->create([
            'name' => 'Hawaiian Paradise',
            'sauce' => true,
            'cheese' => true,
        ]);

        $pizza5->toppings()->attach(Topping::factory()->create(['name' => 'Pineapple']));
    }
}
