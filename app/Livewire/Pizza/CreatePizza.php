<?php

namespace App\Livewire\Pizza;

use App\Models\Pizza;
use App\Models\Topping;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;


class CreatePizza extends Component
{
    //pizza properties
    public $pizzaName;
    public $isSauceSelected = 1;
    public $isCheeseSelected = 1;
    public array $selectedToppings = [];

    //Rules for the form
    protected $rules=[
        'pizzaName' => ['required', 'regex:/^[a-zA-Z\s\'-]+$/']
    ];

    public function savePizza() {
        // Validate the form data
        $this->validate();

        // Checks if pizza name already exists
        $existingPizza = Pizza::where('name', $this->pizzaName)->exists();
        if ($existingPizza) {
            session()->flash('name_error', 'That pizza already exists. Please choose a different name.');
            return;
        }

        // Convert the selected sauce and cheese values to boolean
        $selectedSauceValue = $this->isSauceSelected == 1 ? true : false;
        $selectedCheeseValue = $this->isCheeseSelected == 1 ? true : false;


        //Create the pizza
        $pizza = new Pizza;
        $pizza->name = $this->pizzaName;
        $pizza->sauce = $selectedSauceValue;
        $pizza->cheese = $selectedCheeseValue;
        $pizza->created_at = now();
        $pizza->save();


        // Attach toppings to pizza
        foreach ($this->selectedToppings as $toppingId) {
            $topping = Topping::find($toppingId);
            $pizza->toppings()->attach($topping->id);
        }

        //Alert and Return
        Alert::success('Success', "Your pizza \"$pizza->name\" was created");
        return redirect('/pizzas');
    }

    public function render()
    {
        $toppings = Topping::all();
        return view('livewire.pizza.create-pizza', compact('toppings'))->layout('components.layout');
    }
}
