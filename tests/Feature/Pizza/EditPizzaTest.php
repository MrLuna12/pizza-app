<?php

namespace Tests\Feature\Pizza;

use App\Livewire\Pizza\EditPizza;
use App\Models\Pizza;
use App\Models\Topping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EditPizzaTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_pizza_component_exist()
    {
        //Arrange: Create a pizza and pass that into the URI
        $pizza = Pizza::factory()->hasToppings(3)->create();

        //Act: Pass the id in the URI
        //Assert: That the component exist
        $this->get("/pizzas/edit/{$pizza->id}")
            ->assertSeeLivewire(EditPizza::class, ['id' => $pizza->id]);
    }

    public function test_pizza_id_exist() {
        //Arrange: Create a fake pizza Id
        $fakePizzaId = 1;

        //Act: Pass the id in the URI
        //Assert:  That the user gets redirected back if topping does not exist
        $this->get("/pizzas/edit/{$fakePizzaId}")
            ->assertRedirect('/pizzas');
    }

    public function test_update_pizza()
    {
        //Arrange: Create a pizza and its toppings to then update
        $pizza = Pizza::factory()->hasToppings(3)->create();
        $toppingToAdd = Topping::factory()->create();

        //Act: Call the savePizza method with the updated data
        Livewire::test(EditPizza::class, ['id' => $pizza->id])
            ->set('pizzaName', 'New Name')
            ->set('isSauceSelected', 0)
            ->set('isCheeseSelected', 0)
            ->set('selectedToppings', [$toppingToAdd->id])
            ->call('savePizza');

        //Assert: Check that the pizza was updated in the database
        $this->assertDatabaseHas('pizzas', [
            'id' => $pizza->id,
            'name' => 'New Name',
            'sauce' => 0,
            'cheese' => 0,
        ]);

        //Since we have a list of toppings, we need to iterate and check the DB
        foreach ($pizza->toppings as $topping) {
            $this->assertDatabaseHas('pizza_topping', [
                'pizza_id' => $pizza->id,
                'topping_id' => $toppingToAdd->id
            ]);
        }
    }

    public function test_updated_Pizza_name_validation()
    {
        //Arrange: Create a pizza to then update
        $pizza = Pizza::factory()->create();

        //Act: call the savePizza method with pizzaName left blank
        //Assert: An error is displayed, telling the user that the field is required
        Livewire::test(EditPizza::class, ['id' => $pizza->id])
            ->set('pizzaName', '')
            ->call('savePizza')
            ->assertHasErrors('pizzaName');
    }

    public function test_updated_pizza_regex_validation()
    {
        //Arrange: Create a pizza to then update
        $pizza = Pizza::factory()->create();

        //Act: call the savePizza method with pizzaName as 123
        //Assert: An error is displayed, telling the user that their input is invalid
        Livewire::test(EditPizza::class, ['id' => $pizza->id])
            ->set('pizzaName', '123')
            ->call('savePizza')
            ->assertHasErrors('pizzaName');
    }

    public function test_updated_pizza_for_duplicate_pizzas()
    {
        //Arrange: Have an existing pizza in DB and another to update
        $pizza1 = Pizza::factory()->create(['name' => 'My Go-to']);
        $pizza2 = Pizza::factory()->create(['name' => 'My Favorite']);

        //Act: Update $pizza2 with the same name as $pizza1
        Livewire::test(EditPizza::class, ['id' => $pizza2->id])
            ->set('pizzaName', 'My Go-to')
            ->call('savePizza')
            //Assert: That the 'name_error' is being displayed
            ->assertSee('That pizza already exists. Please create a different one.');
    }
}
