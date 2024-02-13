<?php

namespace Tests\Feature\Pizza;

use App\Livewire\Pizza\Pizzas;
use App\Models\Pizza;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PizzaTest extends TestCase
{
    //This allows us to reset the DB after each test so that data
    //from a previous test does not interfere with the next test
    use RefreshDatabase;

    public function test_Pizza_component_exists()
    {
        //Act: Visit the page where component is
        $this->get('/pizzas')
            //Assert that the component exist
            ->assertSeeLivewire(Pizzas::class);
    }


    public function test_displaying_pizzas_with_their_toppings ()
    {
        //Arrange: Create a pizza with toppings using factory
            //Factory allows us to generate fake data
        $pizza = Pizza::factory()->hasToppings(3)->create();

        //Act & Assert: Render the component and assert that the pizza name and topping are displayed
        Livewire::test(Pizzas::class)
            ->assertSee($pizza->name)
            ->assertSee($pizza->toppings->pluck('name')->toArray());
    }


    public function test_deleting_pizzas() {
        //Arrange: Create a pizza with toppings
        $pizza = Pizza::factory()->hasToppings(3)->create();

        //Act: call the pizza component's delete and deletePizza method
        Livewire::test(Pizzas::class)
            ->call('delete', $pizza->id)
            ->call('deletePizza');

        //Assert that the pizza model does not exist in the database
        $this->assertModelMissing($pizza);

        // Assert that the pizza is no longer displayed by checking if it is missing in the database
        $this->assertDatabaseMissing('pizzas', ['id' => $pizza->id]);
    }
}
