<?php

namespace Tests\Feature\Pizza;

use App\Livewire\Pizza\CreatePizza;
use App\Models\Pizza;
use App\Models\Topping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreatePizzaTest extends TestCase
{
    use RefreshDatabase;

    public function test_Pizza_component_exists()
    {

        //Act: Visit the page where component is
        $this->get('/pizzas/create')
            //Assert that the component exist
            ->assertSeeLivewire(CreatePizza::class);
    }

    public function test_pizza_creation()
    {
        //Arrange: create a topping to test the create pizza form
        $topping1 = Topping::factory()->create();
        $topping2 = Topping::factory()->create();

        //Act: set the values of the form and call the savePizza method
        Livewire::test(CreatePizza::class)
            ->set('pizzaName', 'New Pizza')
            ->set('isSauceSelected', 1)
            ->set('isCheeseSelected', 1)
            ->set('selectedToppings', [$topping1->id, $topping2->id])
            ->call('savePizza');

        // Assert that the pizza is saved to the database
        $this->assertDatabaseHas('pizzas', ['name' => 'New Pizza']);
    }

    public function test_pizza_name_validation()
    {
        //Arrange: Leave the pizza name blank
        //Act: call the savePizza method
        //Assert: An error is displayed, telling the user that the field is required
        Livewire::test(CreatePizza::class)
            ->set('pizzaName', '')
            ->call('savePizza')
            ->assertHasErrors('pizzaName');
    }

    public function test_pizza_regex_validation()
    {
        //Arrange: Set pizza to 123, violating regex rules
        //Act: call the savePizza method
        //Assert: An error is displayed, telling the user that their input is invalid
        Livewire::test(CreatePizza::class)
            ->set('pizzaName', '123')
            ->call('savePizza')
            ->assertHasErrors('pizzaName');
    }

    public function test_duplicate_pizzas()
    {
        //Arrange: Have an existing pizza in DB
        $pizza = Pizza::factory()->hasToppings(2)->create(['name' => 'My Go-to']);

        //Act: Create a new pizza with the same name as the one above
        Livewire::test(CreatePizza::class)
            ->set('pizzaName', 'My Go-to')
            ->call('savePizza')
            //Assert: That the 'name_error' is being displayed
            ->assertSee('That pizza already exists. Please choose a different name.');
    }


}
