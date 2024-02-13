<?php

namespace Tests\Feature\topping;

use App\Livewire\Topping\Toppings;
use App\Models\Topping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ToppingTest extends TestCase
{
    use RefreshDatabase;

    public function test_topping_component_exists()
    {
        //Act: Visit the page where component is
        $this->get('/toppings')
            //Assert that the component exist
            ->assertSeeLivewire(Toppings::class);
    }

    public function test_displaying_toppings ()
    {
        //Arrange: Create a topping to display
        $topping = Topping::factory()->create();

        //Act & Assert: Render the component and assert that the toppings are displayed
        Livewire::test(Toppings::class)
            ->assertSee($topping->name);
    }

    public function test_topping_creation()
    {

        //Arrange & Act: Go to the Topping component and set the values for the
            // 'newToppingName' field in the form then call the createTopping method
        Livewire::test(Toppings::class)
            ->set('newToppingName', 'New Topping')
            ->call('createTopping');

        // Assert that the topping is saved to the database
        $this->assertDatabaseHas('toppings', ['name' => 'New Topping']);
    }

    public function test_topping_name_validation()
    {
        //Arrange: Leave the topping name blank
        //Act: call the createTopping method
        //Assert: That the user gets an error saying that the field is required
        Livewire::test(Toppings::class)
            ->set('newToppingName', '')
            ->call('createTopping')
            ->assertHasErrors('newToppingName');
    }

    public function test_topping_regex_validation()
    {
        //Arrange: Set topping name to 123, violating regex rules
        //Act: call the createTopping method
        //Assert: That the user gets an error saying that the input is invalid
        Livewire::test(Toppings::class)
            ->set('newToppingName', '123')
            ->call('createTopping')
            ->assertHasErrors('newToppingName');
    }

    public function test_deleting_toppings() {
        //Arrange: Create a topping to delete
        $topping = Topping::factory()->create();

        //Act: call the topping components delete and deleteTopping method
        Livewire::test(Toppings::class)
            ->call('delete', $topping->id)
            ->call('deleteTopping');

        //Assert that the topping model does not exist in the database
        $this->assertModelMissing($topping);

        // Assert that the topping is no longer displayed by checking if it is missing in the database
        $this->assertDatabaseMissing('toppings', ['id' => $topping->id]);
    }

    public function test_duplicate_toppings()
    {
        //Arrange: Have an existing topping in DB
        $topping = Topping::factory()->create(['name' => 'Olives']);

        //Act: Create a new topping with the same name as the one above
        Livewire::test(Toppings::class)
            ->set('newToppingName', 'Olives')
            ->call('createTopping')
            //Assert: That the 'name_error' is being displayed
            ->assertSee('That topping already exists.');
    }
}
