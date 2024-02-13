<?php

namespace App\Livewire\Pizza;

use App\Models\Pizza;
use App\Models\Topping;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class EditPizza extends Component
{
    public $pizza;
    public $toppings;
    public $pizzaName;
    public $oldPizzaName;
    public array $selectedToppings;
    public $currentToppings;
    public $isEdit;

    public $isSauceSelected;
    public $isCheeseSelected;

    //Use mount to find and initialize the pizza component
    public function mount ($id) {

        //Find the pizza by its id
        $this->pizza = Pizza::find($id);

        //Select all the toppings in the database
        $this->toppings = Topping::all();

        //Form status
        $this->isEdit = false;

        //Check if the pizza exist
        if ($this->pizza) {

            //Initialize pizzaName with the name of the pizza
            $this->pizzaName = $this->pizza->name;
            $this->oldPizzaName = $this->pizzaName;


            //store the current toppings of the pizza
            $this->currentToppings = $this->pizza->toppings;

            //Add toppings to the selectedToppings array
            $this->addToppings($this->currentToppings);

            //capture the sauce and cheese values
            $this->isSauceSelected = $this->pizza->sauce;
            $this->isCheeseSelected = $this->pizza->cheese;

        } else {
            //If the pizza doesn't exist
            Alert::error('404', 'Pizza not found');
            $this->redirect('/pizzas');
        }
    }

    //Form rules
    protected $rules=[
        'pizzaName' => ['required', 'regex:/^[a-zA-Z\s\'-]+$/']
    ];


    public function addToppings ($toppingArray): void
    {
        foreach ($toppingArray as $topping) {
            $this->selectedToppings [] = $topping->id;
        }
    }

    public function isFormEdit() {
        $this->isEdit = true;
    }

    public function goBack()
    {
        if ($this->isEdit) {
            $this->dispatch('show-confirm-modal');
        } else {
            redirect('/pizzas');
        }
    }

    public function savePizza () {
        // Validate the form data
        $this->validate();

        //Checks to see if the user changed the current name of the pizza.
        //If so, check if that name already exist in the database
        if (ucwords($this->pizzaName) != $this->oldPizzaName) {
            // Checks if pizza name already exists
            $existingPizza = Pizza::where('name', $this->pizzaName)->exists();
            if ($existingPizza) {
                session()->flash('name_error', 'That pizza already exists. Please create a different one.');
                return;
            }
        }


        //Save the pizza name
        $this->pizza->name = ucwords($this->pizzaName);

        // Convert the selected sauce and cheese values to boolean
        $selectedSauceValue = $this->isSauceSelected == 1 ? true : false;
        $selectedCheeseValue = $this->isCheeseSelected == 1 ? true : false;

        //save the sauce and cheese values
        $this->pizza->sauce = $selectedSauceValue;
        $this->pizza->cheese = $selectedCheeseValue;

        // First remove all the toppings from the pizza first to ensure data consistency
        $this->pizza->toppings()->detach();

        // Attach toppings to pizza
        foreach ($this->selectedToppings as $toppingId) {
            $topping = Topping::find($toppingId);
            $this->pizza->toppings()->attach($topping->id);
        }
        // Update the updated_at timestamp
        $this->pizza->updated_at = now();

        $this->pizza->save();

        Alert::success('Success', "Your pizza was saved");
        return redirect('/pizzas');
    }
    public function render()
    {
        return view('livewire.pizza.edit-pizza')->layout('components.layout');
    }
}
