<?php

namespace Tests\Feature\topping;

use App\Livewire\Topping\EditTopping;
use App\Models\Topping;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use RealRashid\SweetAlert\Facades\Alert;
use Tests\TestCase;

class EditToppingTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_topping_component_exist()
    {
        //Arrange: Create a topping and pass that into the URI
        $topping = Topping::factory()->create();

        //Act: Pass the id in the URI
        //Assert: That the component exist
        $this->get("/toppings/edit/{$topping->id}")
            ->assertSeeLivewire(EditTopping::class, ['id' => $topping->id]);
    }

    public function test_topping_id_exist() {
        //Arrange: Create a fake topping Id
        $fakeToppingId = 1;

        //Act: Pass the id in the URI
        //Assert:  That the user gets redirected back if topping does not exist
        $this->get("/toppings/edit/{$fakeToppingId}")
            ->assertRedirect('/toppings');
    }

    public function test_update_toppings()
    {
        //Arrange: Create a topping then update
        $topping = Topping::factory()->create();

        //Act: Call the updateTopping method with the updated data
        Livewire::test(EditTopping::class, ['id' => $topping->id])
            ->set('toppingName', 'New Name')
            ->call('updateTopping');

        //Assert: Check that the topping was updated in the database
        $this->assertDatabaseHas('toppings', [
            'id' => $topping->id,
            'name' => 'New Name',
        ]);
    }

    public function test_topping_name_validation()
    {
        //Arrange: Create a topping to pass in the URI
        $topping = Topping::factory()->create();

        //Act: set the topping name input blank and call the updateTopping method
        //Assert: An error is displayed, telling the user that the field is required
        Livewire::test(EditTopping::class, ['id' => $topping->id])
            ->set('toppingName', '')
            ->call('updateTopping')
            ->assertHasErrors('toppingName');
    }

    public function test_topping_regex_validation()
    {
        //Arrange: Create a topping to pass in the URI
        $topping = Topping::factory()->create();

        //Act: Set topping name to 123, violating regex rules and call the updateTopping method
        //Assert: An error is displayed, telling the user that their input is invalid
        Livewire::test(EditTopping::class, ['id' => $topping->id])
            ->set('toppingName', '123')
            ->call('updateTopping')
            ->assertHasErrors('toppingName');
    }

    public function test_duplicate_toppings()
    {
        //Arrange: Create two toppings to update
        $topping1 = Topping::factory()->create(['name' => 'Olives']);
        $topping2 = Topping::factory()->create(['name' => 'Bacon']);

        //Act: Create a new topping with the same name as the one above
        Livewire::test(EditTopping::class, ['id' => $topping2->id])
            ->set('toppingName', 'Olives')
            ->call('updateTopping')
            //Assert: That the 'name_error' is being displayed
            ->assertSee('That topping already exists.');
    }
}
